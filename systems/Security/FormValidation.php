<?php

    namespace Philum\Security;

    use \CG\FVSS\Fvss;

    class FormValidation {

        /**
         * @var Fvss $validator
         */
        private Fvss $validator;

        public function __construct() {
            $this->validator = new Fvss();
        }
        
        /**
         * Validation HTTP request data.
         * 
         * @param array $data
         */
        public function validate(array $data) {
            return $this->validator->validate($data);
        }

    }