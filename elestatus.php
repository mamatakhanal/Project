<?php
    $connection = new mysqli('localhost','root','','vote');
    if($connection->connect_errno!=0){
        die('Database Connection Error'.$connection->connect_error);
    }
    $sql="update election
        set ElectionStatus=CASE
        when ElectionDate=CURRENT_DATE() then 'ongoing'
        when ElectionDate<CURRENT_DATE() then 'completed'
        else 'upcoming'
        end
    ";
    $connection->query($sql);
?>