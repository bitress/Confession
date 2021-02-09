<?php

    class Vote {

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Insert vote to database
     * @param int $cfs_id ID of the confession
     * @param int $user Id or Ip address of the user who upvoted the confession
     * @param string $type Type of vote
     * @return boolean TRUE if user not yet upvoted, FALSE otherwise throw an alert on page
    **/
    public function upVote($cfs_id, $user, $type = 'upvote') {

        //Get user ip address
        $ip = Misc::getUserIpAddr();

        // Check if user upvoted
        if($this->checkUserIfVoted($user, $cfs_id)){
             echo "no";
         } else {
            
            $query = "INSERT INTO vote (confession_id, user_id, type, ip) VALUES (:c, :u, :t, :i)";
            //Insert vote into the database with confession id, user id and vote type
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':c', $cfs_id, PDO::PARAM_INT);
            $stmt->bindParam(':u', $user, PDO::PARAM_STR);
            $stmt->bindParam(':t', $type, PDO::PARAM_STR);
            $stmt->bindParam(':i', $ip, PDO::PARAM_STR);
            if ($stmt->execute()) {
                //Update total upvotes in database
                $this->updateUpvote($cfs_id);
                }
        }
    }
    

    /**
     * Insert vote to database
     * @param int $cfs_id ID of the confession
     * @param int $user Id or Ip address of the user who upvoted the confession
     * @param string $type Type of vote
     * @return boolean TRUE if user not yet dwonvoted, FALSE otherwise throw an alert on page
    **/
    public function downVote($cfs_id, $user, $type = 'downvote') {

        //Get user ip address
        $ip = Misc::getUserIpAddr();

        // Check if user downvoted
            if($this->checkUserIfVoted($user, $cfs_id)){
                echo "no";
             } else {
           
        $query = "INSERT INTO vote (confession_id, user_id, type, ip) VALUES (:c, :u, :t, :i)";
        //Insert vote into the database with confession id, user id and vote type
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':c', $cfs_id, PDO::PARAM_INT);
        $stmt->bindParam(':u', $user, PDO::PARAM_STR);
        $stmt->bindParam(':t', $type, PDO::PARAM_STR);
        $stmt->bindParam(':i', $ip, PDO::PARAM_STR);
        if ($stmt->execute()) {
            //Update total downvotes in database
            $this->updateDownvote($cfs_id);

            }
        }
    }
    
    /**
     * Update total upvote in database
     * @param int $confession_id Id of the confession that will be incremented
     * @return boolean TRUE
     */
    private function updateUpvote($confession_id){
        // SQL query
        $query = "UPDATE confessions SET upvote = upvote + 1 WHERE id = :c";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':c', $confession_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }

    }

    /**
     * Update total downvote in database
     * @param int $confession_id Id of the confession that will be incremented
     * @return boolean TRUE
     */
    private function updateDownvote($confession_id){

        $query = "UPDATE confessions SET downvote = downvote + 1 WHERE id = :c";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':c', $confession_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }
    }


    /**
     * Remove downvote
     * @param int $cfs_id Confession ID
     * @param int $user User's ID
     * @return boolean TRUE if downvoted successfully
     */
    public function deleteDownvote($cfs_id, $user) {

    $query = "DELETE FROM vote WHERE user_id = :u AND confession_id = :c";

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':u', $user, PDO::PARAM_INT);
    $stmt->bindParam(':c', $cfs_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            
            //Update confession downvotes
            $query = "UPDATE confessions SET downvote = downvote - 1 WHERE id = :i";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':i', $cfs_id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return true;
                }

        }
    }

     /**
     * Remove upvote
     * @param int $cfs_id Confession ID
     * @param int $user User's ID
     * @return boolean TRUE if upvoted successfully
     */
    public function deleteUpvote($cfs_id, $user) {

        $query = "DELETE FROM vote WHERE user_id = :u AND confession_id = :c";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':u', $user, PDO::PARAM_INT);
        $stmt->bindParam(':c', $cfs_id, PDO::PARAM_INT);
         if ($stmt->execute()) {
                
            //Update confession downvotes
            $query = "UPDATE confessions SET upvote = upvote - 1 WHERE id = :i";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':i', $cfs_id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return true;
                }

            }
    }

    /**
     * Check if user voted
     * @param int $user Id of the user
     * @param $cfs_id String ID of the confession
     * @return boolean TRUE if user didnt voted yet, OTHERWISE FALSE
     */

    public function checkUserIfVoted($user, $cfs_id) {

        $query = "SELECT * FROM vote WHERE user_id = :u AND confession_id = :c";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":c", $cfs_id, PDO::PARAM_STR);
        $stmt->bindParam(":u", $user, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
    }


     /**
     * Check if user downvoted or not
     * @param int $user_id Id of the user who will downvote
     * @param int $confession_id Id of the the confession that will be downvoted
     * @param string $type Type of vote
     * @return boolean TRUE if user not yet downvoted, FALSE otherwise
     */

    public function isUserDownvoted($user_id, $confession_id, $type = 'downvote') {
        $stmt = $this->db->prepare("SELECT * FROM vote WHERE user_id = :u AND type = :t AND confession_id = :c");
        $stmt->bindParam(':u', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':c', $confession_id, PDO::PARAM_INT);
        $stmt->bindParam(':t', $type, PDO::PARAM_STR);
        $stmt->execute();
            if($stmt->rowCount() > 0){
                return true;
            }

    }

    
     /**
     * Check if user upvoted or not
     * @param int $user_id Id of the user who will upvote
     * @param int $confession_id Id of the the confession that will be upvoted
     * @param string $type Type of vote
     * @return boolean TRUE if user not yet upvoted, FALSE otherwise
     */

    public function isUserUpvoted($user_id, $confession_id, $type = 'upvote') {
        $stmt = $this->db->prepare("SELECT * FROM vote WHERE user_id = :u AND type = :t AND confession_id = :c");
        $stmt->bindParam(':u', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':c', $confession_id, PDO::PARAM_INT);
        $stmt->bindParam(':t', $type, PDO::PARAM_STR);
        $stmt->execute();
            if($stmt->rowCount() > 0){
                return true;
            }
    }
  
}
