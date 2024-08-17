<?php
    require_once 'elestatus.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['admin_id'])){
        header('location:admin_login.php?err=1');
    }
?>
<?php
    error_reporting(0);
    if(is_numeric($_GET['id'])){
        $id=$_GET['id'];
    }else{
        header('location:admin_election_candidate.php');
    }
    require_once 'connection.php';
    $sql="DELETE FROM candidate where CandidateID='$id'";
    $result =$connection->query($sql);
    
    $data=[];
    if($connection-> affected_rows==1){
        header('location:admin_election_candidate.php?msg=2');
    }else{
        header('location:admin_election_candidate.php?msg=3');
    }
?>