<?php
    $connection = new mysqli('localhost','root','','vote');
    if($connection->connect_errno!=0){
        die('Database Connection Error'.$connection->connect_error);
    }
?>