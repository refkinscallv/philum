<?php

    namespace Philum\App;

    use Philum\Router\Router AS SysRouter;

    class Routes {

        /**
         * @var SysRouter $route
         */
        private SysRouter $route;

        public function __construct() {
            $this->route = new SysRouter();
        }
        
        public function set() {
            /**
             * ----------------------------------------------------------
             * setMaintenance
             * Set maintenance controller while under maintenance
             * 
             * @param string | apps/Controllers/File/ | Class@Method
             * ----------------------------------------------------------
             */
            // $this->routes->setMaintenance("Page@maintenance");

            /**
             * ----------------------------------------------------------
             * setDefault
             * Set default controller for the application
             * 
             * @param string | apps/Controllers/File/ | Class@Method
             * @param boolean | Allowed paremeter or not
             * ----------------------------------------------------------
             */
            $this->route->setDefault("Welcome@index", false);

            /**
             * ----------------------------------------------------------
             * setNotFound
             * Set 404 page not found
             * 
             * @param string | apps/Controllers/File/ | Class@Method
             * ----------------------------------------------------------
             */
            $this->route->setNotFound("Page@notFound");

            /**
             * ----------------------------------------------------------
             * set
             * Set url path for the controller
             * 
             * @param string | URL path
             * @param string | apps/Controllers/File/ | Class@Method
             * @param boolean | Allowed paremeter or not
             * ----------------------------------------------------------
             */
            
            // $this->route->set("/about", "Page@about", true);
            
            $this->route->run();
        }

    }