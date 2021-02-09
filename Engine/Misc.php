<?php

    class Misc {

        public function __construct(){
            $this->db = Database::getInstance();
        }

        public static function generateUniqueID($length = 7){
            if (function_exists("random_bytes")) {
                $bytes = random_bytes(ceil($length / 2));
              } elseif (function_exists("openssl_random_pseudo_bytes")) {
                $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
              } else {
                throw new Exception("no cryptographically secure random function available");
              }
              return substr(bin2hex($bytes), 0, $length);
        }

        public static function getUserIpAddr() {
          if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
          } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
          } else {
            $ip = $_SERVER['REMOTE_ADDR'];
          }
          return $ip;
        }
    
    }
?>