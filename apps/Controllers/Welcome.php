<?php

    namespace Philum\App\Controllers;

    use \Philum\BaseController;

    class Welcome extends BaseController {

        public function __construct() {
            parent::__construct();
        }

        public function index() {
            $this->outputView->render("welcome", [
                "appLogo" => "https://philum.callvgroup.net/images/philum_logo.png",
                "appName" => "Philum",
                "appDesc" => "Traditional PHP Framework with MVC Architecture, Routing and Query Builder"
            ]);
        }

    }