<?php

    namespace Philum\Storage;

    use \Philum\Security\Crypto;

    class Cookie {

        /**
         * @var string $cookieName
         */
        protected string $cookieName;

        /**
         * @var int $cookieExpire
         */
        protected int $cookieExpire;

        /**
         * @var string $cookieFile
         */
        protected string $cookieFile;

        /**
         * @var Crypto $crypto;
         */
        protected Crypto $crypto;

        public function __construct() {
            $this->cookieName = $_SERVER["COOKIE_NAME"];
            $this->cookieExpire = $_SERVER["COOKIE_EXPIRE"];
            $this->cookieFile = $_SERVER["COOKIE_FILE"];
            $this->crypto = new Crypto();
        }

        /**
         * Retrieve all encrypted cookie data.
         */
        public function all() {
            if (!isset($_COOKIE[$this->cookieName])) {
                return [];
            }

            return $this->crypto->decrypt($_COOKIE[$this->cookieName], "array", $this->cookieFile);
        }

        /**
         * Get specific value from decrypted cookie data.
         *
         * @param string $value
         */
        public function get(string $value) {
            if (!$value) {
                return false;
            }

            $getCookie = $this->all();

            if (empty($getCookie) || !isset($getCookie[$value])) {
                return false;
            }

            return $getCookie[$value];
        }

        /**
         * Set encrypted cookie data.
         *
         * @param mixed $mixedParam
         * @param mixed $value
         */
        public function set($mixedParam, $value) {
            $getCookie = $this->all();

            if (is_null($mixedParam) && is_null($value)) {
                return false;
            }

            if (is_array($mixedParam)) {
                foreach ($mixedParam as $index => $val) {
                    $getCookie[$index] = $val;
                }
            } else {
                $getCookie[$mixedParam] = $value;
            }

            $setCookie = $this->crypto->encrypt($getCookie, "array", $this->cookieFile);
            $result = setcookie($this->cookieName, $setCookie, time() + ($this->cookieExpire * 60 * 60), "/");

            return $result;
        }

        /**
         * Unset encrypted cookie data.
         *
         * @param mixed $mixedParam
         */
        public function unset($mixedParam = null) {
            $getCookie = $this->all();

            if (is_null($mixedParam)) {
                return false;
            }

            if (is_array($mixedParam)) {
                foreach ($mixedParam as $index) {
                    unset($getCookie[$index]);
                }
            } else {
                unset($getCookie[$mixedParam]);
            }

            $setCookie = $this->crypto->encrypt($getCookie, "array", $this->cookieFile);
            $result = setcookie($this->cookieName, $setCookie, time() + ($this->cookieExpire * 60 * 60), "/");

            return $result;
        }

    }