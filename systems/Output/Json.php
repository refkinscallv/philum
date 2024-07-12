<?php

    namespace Philum\Output;

    class Json {

        /**
         * Render json format file
         * 
         * @param array $data
         * @param int $httpResponseCode
         */
        public function render(array $data = [], int $httpResponseCode = 200) {
            http_response_code($httpResponseCode);
            header("Content-Type: Application/JSON");
            
            echo json_encode($data, JSON_UNESCAPED_SLASHES);
        }

    }