<?php
    require_once 'elestatus.php';
?>
<?php
    error_reporting(0);
    require_once 'connection.php';
    $sql="SELECT ElectionID,ElectionName,ElectionDate from election where ElectionStatus='upcoming' order by ElectionDate asc";
    $result =$connection->query($sql);
    $data=[];
    if($result-> num_rows>0){
        while($row=$result->fetch_assoc()){
            array_push($data,$row);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election</title>
    <?php require_once 'link.php';?>
    <style>
        body{
            background-color:#e2e5ff;
        }
        .election-type{
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 16px;
        }
        .election-details{
            padding: 30px 20px;
            place-self: left;
        }
        .election-details .election-status p{
            width: 85px;
            padding: 10px;
            background-color: #c5cbff;
            border-radius: 20px;
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.1);
        }
        .election-details .election-status p:hover{
            width: 85px;
            padding: 10px;
            background-color: #c5cbff;
            border-radius: 20px;
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.1);
        }
        .election-details a:hover,.election-details p:hover{
            transform: scaleY(1.05);
        }
        .election-list{
            text-align: center;
            height: auto;
            background-color: #c5cbff;
            border-radius: 20px;
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.1);
        }
        .election-list .ele-list{
            display: grid;
            grid-template-columns: 120px 1fr 120px;
            grid-template-rows: repeat(auto-fit,minmax(130px,1fr));
            grid-gap: 10px;
            padding: 0px 9%;
        }
        .ele-list .box{
            background-color: #e2e5ff;
            height: 120px;
            place-items: center;
        }
        .ele-list .date{
            border-radius: 100px;
            place-items: center;
        }
        @media (max-width:800px){
           .election-type{
                padding: 20px;
                font-size: smaller;
                grid-template-columns: 1fr;
            }
            .ele-list{
                grid-template-rows: 3fr;
            }
            .ele-list a,p{
                font-size: smaller;
            }
        }
    </style>
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container">
        <div class="election-type">
            <div class="election-details election-status">
                <h2>ELECTION TYPE</h2>
                <p><a href="endelection.php">ENDED</a></p>
                <p><a href="election.php">ONGOING</a></p>
                <p><a href="#">UPCOMING</a></p>
            </div>
            <div class="election-details election-list">
                <h2>Check out the previous elections</h2>
                
                
                <?php if(count($data)>0){ ?>
                    <?php foreach($data as $key=>$record){ ?>
                        <div class="ele-list">
                            <div class="box date">
                                <p style="font-size: 19px;padding-top:20%;"><?php echo $record['ElectionDate'] ?></p>
                            </div>
                            <div class="box ele-name">
                                <a href="upcandidate.php?id=<?php echo $record['ElectionID'] ?>"><h2 style="padding-top: 20px;"><?php echo $record['ElectionName'] ?></h2></a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else {?>
                    <h2>No upcoming elections</h2>
                <?php }?>
            </div>
        </div>
    </div>
    <!--FOOTER START-->
    <?php require_once 'Footer.php'; ?>
    <!--FOOTER END-->
</body>
</html>