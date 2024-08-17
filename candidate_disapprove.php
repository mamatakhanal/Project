<?php
    $connection = new mysqli('localhost','root','','vote');
    if($connection->connect_errno!=0){
        die('Database Connection Error'.$connection->connect_error);
    }
    $cand_id=$_GET['id'];
    $sql="delete from candidate
        where CandidateID='$cand_id'
    ";
    $connection->query($sql);
    header('location:admin_candidateapprove.php');
?>