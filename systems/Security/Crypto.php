<?php

    namespace Philum\Security;

    class Crypto {

        /**
         * @var string $cryptSecretKey
         */
        protected string $cryptSecretKey;
        
        /**
         * @var string $cryptFile
         */
        protected string $cryptFile;
        
        /**
         * @var int $cryptLimitLine
         */
        protected int $cryptLimitLine;
        
        /**
         * @var string $cryptCipherAlgo
         */
        protected string $cryptCipherAlgo;

        /**
         * @var string $cryptStorageMethod
         */
        protected string $cryptStorageMethod;

        public function __construct() {
            $this->cryptSecretKey = $_SERVER["CRYPT_SECRET_KEY"];
            $this->cryptFile = $_SERVER["CRYPT_FILE"];
            $this->cryptLimitLine = (int)$_SERVER["CRYPT_LIMIT_LINE"];
            $this->cryptCipherAlgo = $_SERVER["CRYPT_CIPHER_ALGO"];
            $this->cryptStorageMethod = $_SERVER["CRYPT_STORAGE_METHOD"];
        }

        /**
         * Encrypt data.
         * 
         * @param mixed $data
         * @param string $type
         * @param string|null $file
         */
        public function encrypt($data, string $type = "string", string $file = null) {
            if (!$data) {
                return false;
            }

            if ($type === "array") {
                $data = @serialize($data);
            }

            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cryptCipherAlgo));
            $encryptedData = openssl_encrypt($data, $this->cryptCipherAlgo, $this->cryptSecretKey, 0, $iv);
            $base64Encoded = base64_encode($encryptedData . "::" . $iv);
            $md5hash = md5($base64Encoded);

            $this->translatingCrypto($base64Encoded . ":" . $md5hash, "w", $file);

            return $md5hash;
        }

        /**
         * Decrypt data.
         * 
         * @param mixed $data
         * @param string $type
         * @param string|null $file
         */
        public function decrypt($data, string $type = "string", string $file = null) {
            if (!$data) {
                return false;
            }

            $data = $this->translatingCrypto($data, "r", $file);

            list($encryptedData, $iv) = explode("::", base64_decode($data), 2) + [null, null];
            $decryptedData = openssl_decrypt($encryptedData, $this->cryptCipherAlgo, $this->cryptSecretKey, 0, $iv);

            if ($type === "array") {
                return @unserialize($decryptedData);
            } else {
                return $decryptedData;
            }
        }

        /**
         * Translate crypto data for writing or reading.
         * 
         * @param mixed $data
         * @param string $type
         * @param string $file
         */
        private function translatingCrypto($data, string $type, string $file) {
            $cryptoFile = fopen($_SERVER["DOCUMENT_ROOT"] . ($file ? $file : $this->cryptFile), $type === "w" ? "a" : "r");

            if ($type === "w") {
                fwrite($cryptoFile, $data . PHP_EOL);
                fclose($cryptoFile);

                return $this->writeFile($_SERVER["DOCUMENT_ROOT"] . ($file ? $file : $this->cryptFile), $this->cryptLimitLine);
            } else if ($type === "r") {
                return $this->readFile($_SERVER["DOCUMENT_ROOT"] . ($file ? $file : $this->cryptFile), $data);
            }

            return false;
        }

        /**
         * Write data to a file with a limit.
         * 
         * @param string $file
         * @param int $limit
         */
        private function writeFile(string $file, int $limit) {
            $fileContent = file($file);

            if (count($fileContent) > $limit) {
                $fileContent = array_slice($fileContent, -$limit);
                file_put_contents($file, implode("", $fileContent));
            }
        }

        /**
         * Read data from a file.
         * 
         * @param string $file
         * @param mixed $data
         */
        private function readFile(string $file, $data) {
            $fileContent = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($fileContent as $line) {
                $part = explode(":", $line);
                if (count($part) === 2 && $part[1] === $data) {
                    return $part[0];
                }
            }

            return false;
        }

    }