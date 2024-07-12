<?php

    namespace Philum\HTTP;

    class Request {

        /**
         * @var string HTTP request method (GET, POST, etc.)
         */
        private string $method;

        /**
         * @var array Associative array of HTTP headers
         */
        private array $headers = [];

        /**
         * @var string Raw HTTP request body
         */
        private string $body;

        /**
         * @var array Associative array of query parameters
         */
        private array $queryParams;

        /**
         * @var string Request URI
         */
        private string $uri;

        /**
         * @var array Associative array of POST parameters
         */
        private array $postParams;

        /**
         * @var array Associative array of request parameters
         */
        private array $requestParams;

        /**
         * @var array Associative array of file upload parameters
         */
        private array $fileParams;

        public function __construct() {
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->headers = $this->getHeaders();
            $this->body = file_get_contents('php://input');
            $this->queryParams = $this->sanitize($_GET);
            $this->uri = $_SERVER['REQUEST_URI'];
            $this->postParams = $this->sanitize($_POST);
            $this->requestParams = $this->sanitize($_REQUEST);
            $this->fileParams = $_FILES;
        }

        /**
         * Get the HTTP request method.
         * 
         * @return string
         */
        public function getMethod() {
            return $this->method;
        }

        /**
         * Get all HTTP headers.
         */
        public function getHeaders() {
            if (empty($this->headers)) {
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $header = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                        $this->headers[$header] = $value;
                    }
                }
            }

            return $this->headers;
        }

        /**
         * Get the raw HTTP request body.
         */
        public function getBody() {
            return $this->body;
        }

        /**
         * Get all query parameters.
         */
        public function getQueryParams() {
            return $this->queryParams;
        }

        /**
         * Get all POST parameters.
         */
        public function getPostParams() {
            return $this->postParams;
        }

        /**
         * Get all request parameters.
         */
        public function getRequestParams() {
            return $this->requestParams;
        }

        /**
         * Get all file parameters.
         */
        public function getFileParams() {
            return $this->fileParams;
        }

        /**
         * Get a specific $_SERVER variable by key.
         * 
         * @param string $key
         */
        public function getServer($key) {
            return $this->sanitize($_SERVER[$key] ?? null);
        }

        /**
         * Get all $_SERVER variables.
         */
        public function getServers() {
            return array_map([$this, 'sanitize'], $_SERVER);
        }

        /**
         * Get the request URI.
         */
        public function getUri() {
            return $this->uri;
        }

        /**
         * Get a specific HTTP header by name.
         * 
         * @param string $header
         */
        public function getHeader($header) {
            $header = str_replace(' ', '-', ucwords(strtolower(str_replace('-', ' ', $header))));
            return $this->headers[$header] ?? null;
        }

        /**
         * Get a specific query parameter by key.
         * 
         * @param string $key
         */
        public function getQueryParam($key) {
            return $this->queryParams[$key] ?? null;
        }

        /**
         * Get a specific POST parameter by key.
         * 
         * @param string $key
         */
        public function getPostParam($key) {
            return $this->postParams[$key] ?? null;
        }

        /**
         * Get a specific request parameter by key.
         * 
         * @param string $key
         */
        public function getRequestParam($key) {
            return $this->requestParams[$key] ?? null;
        }

        /**
         * Get a specific file parameter by key.
         * 
         * @param string $key
         */
        public function getFileParam($key) {
            return $this->fileParams[$key] ?? null;
        }

        /**
         * Get the JSON-decoded request body.
         */
        public function getJsonBody() {
            $data = json_decode($this->body, true);
            return json_last_error() === JSON_ERROR_NONE ? $data : null;
        }

        /**
         * Sanitize input data to prevent XSS attacks.
         * 
         * @param mixed $data
         */
        public function sanitize($data) {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $data[$key] = $this->sanitize($value);
                }
            } else {
                $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            }

            return $data;
        }

        /**
         * Check if request method is GET
         */
        public function isGet() {
            return $this->getMethod() === 'GET';
        }

        /**
         * Check if request method is POST
         */
        public function isPost() {
            return $this->getMethod() === 'POST';
        }

        /**
         * Check if request method is PUT
         */
        public function isPut() {
            return $this->getMethod() === 'PUT';
        }

        /**
         * Check if request method is DELETE
         */
        public function isDelete() {
            return $this->getMethod() === 'DELETE';
        }

        /**
         * Check if request method is PATCH
         */
        public function isPatch() {
            return $this->getMethod() === 'PATCH';
        }
    }