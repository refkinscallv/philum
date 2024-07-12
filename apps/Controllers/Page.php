<?php

    namespace Philum\App\Controllers;

    use \Philum\BaseController;

    class Page extends BaseController {

        public function __construct() {
            parent::__construct();
        }

        public function notFound() {
            $this->outputView->render("error/page404");
        }

    }