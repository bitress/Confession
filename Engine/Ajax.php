<?php
include_once 'E.php';
    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
    switch ($action) {
        case 'postCFS':
            $con = new Confession;
                $con->postConfession($_POST['msg'], $_POST['t']);
            break;
        case 'upVote':
            $con = new Vote;
                $con->upVote($_POST['id'], $_POST['user']);
            break;
        case 'downVote':
            $con = new Vote;
                    $con->downVote($_POST['id'], $_POST['user']);
            break;   
        case 'delUpvote':
            $con = new Vote;
                $con->deleteUpvote($_POST['id'], $_POST['user']);
            break;        
        case 'delDownvote':
            $con = new Vote;
                 $con->deleteDownvote($_POST['id'], $_POST['user']);
            break;                
        default:
            # code...
            break;
    }
}
?>