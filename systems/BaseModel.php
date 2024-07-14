<?php

    namespace Philum;

    use \Philum\Common\Common;
    use \Philum\Security\Crypto;
    use \Philum\Security\FormValidation;
    use \Philum\Cookie\Cookie;
    use \Philum\Database\MySQLi\MySQLi;

    class BaseModel {

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
         * @var MySQLi $dbMysqli
         */
        public MySQLi $dbMysqli;

        public function __construct() {
            $this->common = new Common();
            $this->encryption = new Crypto();
            $this->formValidation = new FormValidation();
            $this->dbMysqli = new MySQLi();
        }

    }