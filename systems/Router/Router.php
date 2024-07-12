<?php

    namespace Philum\Router;

    use Philum\Router\RouterExecution;

    class Router {

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

        public function __construct() {
            $this->routesStorage = [];
            $this->routesDefault = [];
            $this->routesNotFound = [];
            $this->routesMaintenance = [];
        }

        /**
         * Set the maintenance route.
         * 
         * @param string|null $controller
         */
        public function setMaintenance(string $controller = null) {
            if ($controller) {
                $this->routesMaintenance[] = [
                    'controller' => $controller
                ];
            }
        }

        /**
         * Set the not found route.
         * 
         * @param string|null $controller
         */
        public function setNotFound(string $controller = null) {
            if ($controller) {
                $this->routesNotFound[] = [
                    'controller' => $controller
                ];
            }
        }

        /**
         * Set the default route.
         * 
         * @param string|null $controller
         * @param bool $param
         */
        public function setDefault(string $controller = null, bool $param = true) {
            if ($controller) {
                $this->routesDefault[] = [
                    'controller' => $controller,
                    'param' => $param
                ];
            }
        }

        /**
         * Set a route.
         * 
         * @param string $path
         * @param string $controller
         * @param bool $param
         */
        public function set(string $path, string $controller, bool $param = true) {
            $this->routesStorage[] = [
                'path' => $path,
                'controller' => $controller,
                'param' => $param
            ];
        }

        /**
         * Run the router.
         */
        public function run() {
            $routerExecution = new RouterExecution(
                $this->routesMaintenance,
                $this->routesNotFound, 
                $this->routesDefault, 
                $this->routesStorage
            );

            $routerExecution->run();
        }
        
    }