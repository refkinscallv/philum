<?php

    namespace Philum\Dependencies;

    use Philum\Dependencies\Dependencies;

    class Hook {

        /**
         * @var Dependencies $dependencies
         */
        private $dependencies;

        public function __construct() {
            $this->dependencies = new Dependencies();
        }
        
        /**
         * Set installed dependencies here
         */
        public function set() {
            $this->dependencies->dotenv();
            $this->dependencies->whoops();
        }

    }