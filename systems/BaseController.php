<?php

    namespace Philum;

    use \Philum\Common\Common;
    use \Philum\Security\Crypto;
    use \Philum\Security\FormValidation;
    use \Philum\Cookie\Cookie;
    use \Philum\Output\View;
    use \Philum\Output\Json;
    use \Philum\HTTP\Request;

    class BaseController {

        /**
         * @var Cookie $cookie
         */
        public Cookie $cookie;

        /**
         * @var Crypto $encryption
         */
        public Crypto $encryption;

        /**
         * @var FormValidation $formValidation
         */
        public FormValidation $formValidation;

        /**
         * @var Common $common
         */
        public Common $common;

        /**
         * @var Request $request
         */
        public Request $request;

        /**
         * @var View $outputView
         */
        public View $outputView;

        /**
         * @var Json $outputJson
         */
        public Json $outputJson;

        public function __construct() {
            $this->common = new Common();
            $this->encryption = new Crypto();
            $this->formValidation = new FormValidation();
            $this->request = new Request();
            $this->outputView = new View();
            $this->outputJson = new Json();
        }

    }