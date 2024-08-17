<?php
    $uname=$_POST['username'];
    $connection=new mysqli('localhost','root','','vote');
    $sql="SELECT * from voter where voter_username='$uname'";
    $result=$connection->query($sql);
    if($result->num_rows==1){
        echo 'Username already taken';
    }else{
        echo 'Username available';
    }
?>