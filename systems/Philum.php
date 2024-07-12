<?php

    namespace Philum;

    use \Philum\Dependencies\Hook AS DependenciesHook;
    use \Philum\App\Routes AS AppRoutes;
    use \Philum\Database\Database;

    class Philum {

        /**
         * @var DependenciesHook $dependenciesHook An instance of the Hook class for managing dependencies.
         */
        private DependenciesHook $dependenciesHook;
    
        /**
         * @var AppRoutes $applicationRoutes An instance of the AppRoutes class for managing application routes.
         */
        private AppRoutes $applicationRoutes;

        /**
         * @var Database $databaseConnection An instance of the database connection
         */
        private Database $databaseConnection;

        public function __construct(){
            $this->dependenciesHook = new DependenciesHook();
            $this->applicationRoutes = new AppRoutes();
        }

        /**
         * Run the application.
         * 
         * @return void
         */
        public function run(): void {
            $this->dependenciesHook->set();
            $this->applicationRoutes->set();
            $this->postSystem();
        }

        /**
         * Initialize after system dependencies has been set
         * 
         * @return void
         */
        private function postSystem(): void {
            $this->databaseConnection = new Database();
            $this->databaseConnection->connection();
        }

    }