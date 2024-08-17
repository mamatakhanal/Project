<?php
    $umail=$_POST['email'];
    $connection=new mysqli('localhost','root','','vote');
    $sql="SELECT * from voter where Email='$umail'";
    $result=$connection->query($sql);
    if($result->num_rows==1){
        echo 'Email already taken';
    }else{
        echo 'Email available';
    }
?>