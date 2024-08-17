<?php
    try{
        $connection=new mysqli('localhost','root','');
        $sql="CREATE DATABASE if not exists vote";
        $connection->query($sql);
        echo "Database created successfully";
    }catch(Exception $e){
        die('Error: ' . $e->getMessage());
    }
?>