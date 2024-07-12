<?php

    namespace Philum\Dependencies;

    use \Dotenv\Dotenv;
    use \Whoops\Run;
    use \Whoops\Handler\PrettyPageHandler;

    /**
     * Declare installed dependencies here
     */
    class Dependencies {

        public function dotenv() {
            Dotenv::createImmutable(str_replace("/", "\\", $_SERVER["DOCUMENT_ROOT"]))->load();
        }

        public function whoops() {
            if(isset($_SERVER["ENVIRONMENT"]) && $_SERVER["ENVIRONMENT"] === "development") {
                error_reporting(-1);
                
                $whoops = new Run;
                $prettyPageHandler = new PrettyPageHandler();

                $blacklistItem = [
                    "PHP_AUTH_PW",
                    "APP_NAME",
                    "BASE_URL",
                    "ENVIRONMENT",
                    "DB_HOST",
                    "DB_USER",
                    "DB_PASS",
                    "DB_NAME",
                    "DB_DRIVER",
                    "DB_PORT",
                    "DB_STATUS",
                    "CRYPT_SECRET_KEY",
                    "CRYPT_FILE",
                    "CRYPT_LIMIT_LINE",
                    "CRYPT_CIPHER_ALGO",
                    "CRYPT_STORAGE_METHOD",
                    "COOKIE_NAME",
                    "COOKIE_EXPIRE",
                    "COOKIE_FILE"
                ];

                foreach($blacklistItem as $item) {
                    $prettyPageHandler->hideSuperglobalKey("_SERVER", $item);
                    if($item !== "PHP_AUTH_PW"){
                       $prettyPageHandler->hideSuperglobalKey("_ENV", $item);
                    }
                }

                $whoops->pushHandler($prettyPageHandler);
                $whoops->register();
            } else {
                error_reporting(0);
            }
        }

    }