<?php

    namespace Philum;

    use \Philum\Common\Common;
    use \Philum\Security\Crypto;
    use \Philum\Security\FormValidation;
    use \Philum\Storage\Cookie;

    class BaseServices {

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

        public function __construct() {
            $this->cookie = new Cookie();
            $this->common = new Common();
            $this->encryption = new Crypto();
            $this->formValidation = new FormValidation();
        }

    }