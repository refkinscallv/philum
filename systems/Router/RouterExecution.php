<?php

    namespace Philum\Router;

    class RouterExecution {

        /**
         * @var array $routesStorage Storage for all defined routes.
         */
        private array $routesStorage;

        /**
         * @var array $routesDefault Storage for default routes.
         */
        private array $routesDefault;

        /**
         * @var array $routesNotFound Storage for "not found" routes.
         */
        private array $routesNotFound;

        /**
         * @var array $routesMaintenance Storage for maintenance routes.
         */
        private array $routesMaintenance;

        public function __construct(array $routesMaintenance, array $routesNotFound, array $routesDefault, array $routesStorage) {
            $this->routesStorage = $routesStorage;
            $this->routesDefault = $routesDefault;
            $this->routesNotFound = $routesNotFound;
            $this->routesMaintenance = $routesMaintenance;
        }

        /**
         * Set the maintenance route and execute the corresponding controller.
         * 
         * @param callable $callback
         */
        private function setMaintenance(callable $callback) {
            $routeMatched = false;

            if (!empty($this->routesMaintenance)) {
                $routeMatched = true;
                $this->executeController($this->routesMaintenance[0]['controller']);
            }

            $callback($routeMatched);
        }

        /**
         * Set the not found route and execute the corresponding controller.
         * 
         * @param callable $callback
         */
        private function setNotFound(callable $callback) {
            $routeMatched = false;

            if (!empty($this->routesNotFound)) {
                $routeMatched = true;
                $this->executeController($this->routesNotFound[0]['controller']);
            }

            $callback($routeMatched);
        }

        /**
         * Set the default controller route.
         */
        private function setDefaultController() {
            if (empty($this->routesDefault)) {
                $this->notFound();
            }

            $route = $this->routesDefault[0];
            $this->executeController($route['controller'], $this->getUriParams($route['param']), $route['param']);
        }

        /**
         * Set the controller based on the current URI.
         * 
         * @param callable $callback
         */
        private function setController(callable $callback) {
            $routeMatched = false;

            foreach ($this->routesStorage as $route) {
                $routePath = $route['path'];

                if (strpos($_SERVER['REQUEST_URI'], $routePath) === 0 || $_SERVER["REQUEST_URI"] === $routePath) {
                    $routeMatched = true;
                    $this->executeController(
                        $route['controller'],
                        $this->getUriParams($route['param'], $routePath), 
                        $route['param']
                    );
                    return;
                }
            }

            $callback($routeMatched);
        }

        /**
         * Execute the specified controller.
         * 
         * @param string $controller
         * @param array $params
         */
        private function executeController(string $controller, array $params = [], bool $paramStatus = true) {
            [$class, $method] = explode('@', $controller);

            $fullClassName = "Philum\\App\\Controllers\\" . str_replace('/', '\\', $class);

            if (!class_exists($fullClassName) || !method_exists($fullClassName, $method)) {
                $this->notFound();
            }

            $controllerInstance = new $fullClassName();
            $reflectionMethod = new \ReflectionMethod($controllerInstance, $method);
            $totalParams = $reflectionMethod->getNumberOfParameters();

            if (($totalParams >= 0 && count($params) == 0) || count($params) <= $totalParams) {
                if ($reflectionMethod->getNumberOfParameters() > 0) {
                    $reflectionParams = $reflectionMethod->getParameters();
                    $methodParams = [];

                    foreach ($reflectionParams as $key => $param) {
                        $paramName = $param->getName();
                        $methodParams[$paramName] = $params[$key] ?? null;
                    }
                    
                    if (!$paramStatus && count($params) > 0) {
                        $this->notFound();
                    }

                    $reflectionMethod->invokeArgs($controllerInstance, $methodParams);
                } else {
                    $reflectionMethod->invoke($controllerInstance);
                }
            } else {
                $this->notFound();
            }
        }

        /**
         * Get URI parameters.
         * 
         * @param bool $routeParam
         * @param string $routePath
         */
        private function getUriParams(bool $routeParam, string $routePath = '') {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $cleanUri = rtrim(str_replace($routePath, '', $uri), '/');

            return array_values(array_filter(explode('/', $cleanUri)));
        }

        /**
         * Handle not found error.
         */
        private function notFound() {
            http_response_code(404);
            $this->setNotFound(function ($routeMatched) {
                if (!$routeMatched) {
                    echo '<h1>Page Not Found</h1>';
                }
            });
            die();
        }

        /**
         * Run the router execution process.
         */
        public function run() {
            $this->setMaintenance(function ($maintenance) {
                if (!$maintenance) {
                    $this->setController(function ($routeMatched) {
                        if (!$routeMatched) {
                            $this->setDefaultController();
                        }
                    });
                }
            });
        }
        
    }