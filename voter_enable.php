<?php
    $connection = new mysqli('localhost','root','','vote');
    if($connection->connect_errno!=0){
        die('Database Connection Error'.$connection->connect_error);
    }
    $voteapp_id=$_GET['id'];
    $sql="update voter
        set VoterStatus='active'
        where VoterID='$voteapp_id'
    ";
    $connection->query($sql);
    header('location:admin_voteapproval.php');
?>