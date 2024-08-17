<?php
    $ele_name=$_POST['election_name'];
    $connection=new mysqli('localhost','root','','vote');
    $sql="SELECT * from election where ElectionName='$ele_name' and ElectionStatus='upcoming' ";
    $result=$connection->query($sql);
    if($result->num_rows==1){
        echo 'Election already exists';
    }else{
        echo 'Election available';
    }
?>