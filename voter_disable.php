<?php
    $connection = new mysqli('localhost','root','','vote');
    if($connection->connect_errno!=0){
        die('Database Connection Error'.$connection->connect_error);
    }
    $vote_id=$_GET['id'];
    $sql="update voter
        set VoterStatus='inactive'
        where VoterID='$vote_id'
    ";
    $connection->query($sql);
    header('location:admin_voterlist.php');
?>