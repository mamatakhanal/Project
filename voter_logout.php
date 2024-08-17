<?php
    session_start();
    session_destroy();
    setcookie('voter_id',false,time()-2*24*60*60);
    setcookie('voter_username',false,time()-2*24*60*60);
    header('location:election.php');
?>