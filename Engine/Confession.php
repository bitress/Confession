<?php

     class Confession {

        private $db;
        
        public function __construct() {
            $this->db = Database::getInstance();
        }
        /**
         *  Insert confession into database
         *  @param string $message Confession Message
         *  @param string $title Confession Title
         *  @return boolean true
         **/

        public function postConfession($message, $title) {
            
            // Generated confession unique id
            $uniqueid = Misc::generateUniqueID();
                $sql = "INSERT INTO confessions (unique_id, title, message) VALUES (:u, :t, :m)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':m', $message, PDO::PARAM_STR);
            $stmt->bindParam(':t', $title, PDO::PARAM_STR);
            $stmt->bindParam(':u', $uniqueid, PDO::PARAM_STR);
                if($stmt->execute()){
                    return true;
                }
        }

        /**
         * Return all confession from the database
         *  @return array Array of user confessions
         **/

        public function getAllConfessions() {
            $sql = "SELECT * FROM confessions";
            $stmt = $this->db->query($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();

            if (!empty($res)) {
                return $res;
            }
            
        }
     }