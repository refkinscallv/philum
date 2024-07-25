<?php

    namespace Philum\Common;

    class Common {

        /**
         * Get the base URL with optional path appended.
         *
         * @param string $path
         */
        public function baseUrl(string $path = null) {
            return rtrim($_SERVER["BASE_URL"], "/") . "/" . ($path ? $path : "");
        }

        /**
         * Redirecting page
         * 
         * @param string $path
         */
        public function redirect($path = null) {
            header("location: ". $this->baseUrl($path));
        }

        /**
         * Get HTTP response status message based on code.
         *
         * @param int $code
         */
        public function httpResponse(int $code) {
            $status_messages = [
                100 => "Continue",
                101 => "Switching Protocols",
                102 => "Processing",
                200 => "OK",
                201 => "Created",
                202 => "Accepted",
                203 => "Non-Authoritative Information",
                204 => "No Content",
                205 => "Reset Content",
                206 => "Partial Content",
                207 => "Multi-Status",
                300 => "Multiple Choices",
                301 => "Moved Permanently",
                302 => "Found",
                303 => "See Other",
                304 => "Not Modified",
                305 => "Use Proxy",
                306 => "(Unused)",
                307 => "Temporary Redirect",
                308 => "Permanent Redirect",
                400 => "Bad Request",
                401 => "Unauthorized",
                402 => "Payment Required",
                403 => "Forbidden",
                404 => "Not Found",
                405 => "Method Not Allowed",
                406 => "Not Acceptable",
                407 => "Proxy Authentication Required",
                408 => "Request Timeout",
                409 => "Conflict",
                410 => "Gone",
                411 => "Length Required",
                412 => "Precondition Failed",
                413 => "Request Entity Too Large",
                414 => "Request-URI Too Long",
                415 => "Unsupported Media Type",
                416 => "Requested Range Not Satisfiable",
                417 => "Expectation Failed",
                418 => "I'm a teapot",
                419 => "Authentication Timeout",
                420 => "Enhance Your Calm",
                422 => "Unprocessable Entity",
                423 => "Locked",
                424 => "Failed Dependency",
                425 => "Unordered Collection",
                426 => "Upgrade Required",
                428 => "Precondition Required",
                429 => "Too Many Requests",
                431 => "Request Header Fields Too Large",
                444 => "No Response",
                449 => "Retry With",
                450 => "Blocked by Windows Parental Controls",
                451 => "Unavailable For Legal Reasons",
                494 => "Request Header Too Large",
                495 => "Cert Error",
                496 => "No Cert",
                497 => "HTTP to HTTPS",
                499 => "Client Closed Request",
                500 => "Internal Server Error",
                501 => "Not Implemented",
                502 => "Bad Gateway",
                503 => "Service Unavailable",
                504 => "Gateway Timeout",
                505 => "HTTP Version Not Supported",
                506 => "Variant Also Negotiates",
                507 => "Insufficient Storage",
                508 => "Loop Detected",
                509 => "Bandwidth Limit Exceeded",
                510 => "Not Extended",
                511 => "Network Authentication Required",
                598 => "Network read timeout error",
                599 => "Network connect timeout error",
            ];
        
            $status_message = $status_messages[$code] ?? "Unknown Error";
        
            return (object) [
                "code" => $code,
                "message" => $status_message
            ];
        }

        /**
         * Format a number into a short representation with suffix (K, M, B, T).
         *
         * @param int $number
         * @param int $precision Optional
         */
        public function numShort(int $number, int $precision = 1) {
            $abbreviations = ['', 'K', 'M', 'B', 'T'];
            $index = 0;

            while ($number >= 1000 && $index < count($abbreviations) - 1) {
                $number /= 1000;
                $index++;
            }

            $formatted_number = number_format($number, $precision);

            if ($precision > 0) {
                $formatted_number = rtrim($formatted_number, '0');
                $formatted_number = rtrim($formatted_number, '.');
            }

            return $formatted_number . $abbreviations[$index];
        }

        /**
         * Format a file size into a human-readable short representation.
         *
         * @param int $size
         */
        public function sizeShort(int $size) {
            $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $size > 0 ? floor(log($size, 1024)) : 0;

            return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
        }

        /**
         * Generate a unique file name in a given directory.
         *
         * @param string $path
         * @param string $filename
         */
        public function uniqueFile(string $path, string $filename) {
            $info = pathinfo($filename);
            $name = $info['filename'];
            $ext = $info['extension'] ?? '';
        
            $i = 1;
            do {
                $new_filename = $name . ($i === 1 ? '' : '-' . $i) . ($ext ? '.' . $ext : '');
                $i++;
            } while (file_exists($path . $new_filename));
        
            return $new_filename;
        }

        /**
         * Generate a random alphanumeric string of a specified length.
         *
         * @param int $length
         */
        public function generateRandomAlphanum(int $length) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $characters_length = strlen($characters);
            
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $characters_length - 1)];
            }

            return $randomString;
        }

    }