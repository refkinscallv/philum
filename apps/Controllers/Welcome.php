<?php

    namespace Philum\App\Controllers;

    use \Philum\BaseController;

    class Welcome extends BaseController {

        public function __construct() {
            parent::__construct();
        }

        public function index() {
            echo "Halo";
        }

    }