<?php

    namespace Philum\Output;

    use \Philum\Common\Common;
    use \Philum\Security\Crypto;
    use \Philum\Cookie\Cookie;
    use \Philum\HTTP\Request;

    class View {

        /**
         * @var mixed $viewData
         */
        public array $viewData;

        /**
         * @var Cookie $cookie
         */
        public Cookie $cookie;

        /**
         * @var Crypto $encryption
         */
        public Crypto $encryption;

        /**
         * @var Common $common
         */
        public Common $common;

        /**
         * @var Request $request
         */
        public Request $request;

        public function __construct() {
            $this->viewData = [];
            $this->common = new Common();
            $this->encryption = new Crypto();
            $this->request = new Request();
            $this->outputView = $this;
        }

        /**
         * Render view file
         * 
         * @param string $file
         * @param array $data
         */
        public function render(string $file, array $data = []) {
            $this->viewData = $data;
            $viewData = array_merge([
                "viewData" => $this->viewData
            ], $data);

            extract($viewData);

            include $_SERVER["DOCUMENT_ROOT"] ."/apps/Views/". $file .".php";
        }

    }