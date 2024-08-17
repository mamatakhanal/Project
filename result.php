<?php
    require_once 'elestatus.php';
?>
<?php
    error_reporting(0);
    $id=$_GET['id'];
    require_once 'connection.php';
    $sql="SELECT CandidateID,FirstName,MiddleName,LastName,PartyAffiliation,ElectionName,CandidatePhoto from candidate inner join election on candidate.ElectionID=election.ElectionID where election.ElectionID='$id'  and CandidateStatus='approved' ";
    $result =$connection->query($sql);
    $data=[];
    if($result-> num_rows>0){
        while($row=$result->fetch_assoc()){
            $elename=$row['ElectionName'];
            array_push($data,$row);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <hr style="font-weight:bolder; width: 50%;padding:none; margin:auto;">
    <style>
        .container{
            padding: 15px 9%;  
            height: 500px;  
        }
        .vote-container{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .vote-item{
            border-radius: 20px;
            padding: 0px 20px;
            place-self: center;
        }
        .vote-item span{
            font-size: 12px;
            justify-self: center;
        }
        .candidates{
            background-color:#c5cbff;
            border-radius: 20px;
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: grid;
            grid-template-columns: 100px 1fr 100px;
            column-gap: 16px;
        }
        .col img{
            height: 100px;
            width: 100px;
            border-radius: 100px;
        }
        .col p,h4{
            font-size: 12px;
        }
        .col h2{
            text-align: center;
            font-size: 25px;
        }
        .mini-nav{
            width: 80%;
            margin: auto;
            display: flex;
            justify-content: space-between;
        }
        .mini-nav h4{
            font-size: 14px;
            font-weight: lighter;
        }
    </style>
    <?php require_once 'link.php'; ?>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <div class="mini-nav">
        <a href="endelection.php"><h4><i class='bx bx-chevron-left-circle'></i> Back to Election List</h4> </a>
        <a href="endcandidate.php?id=<?php echo $id ?>"><h4>View All Candidates <i class='bx bx-chevron-right-circle'></i></h4></a>
    </div>
    <h3 style="text-align: center;color:#332c58">RESULTS</h3>
    <div class="container">
        <div class="vote-container">
            <?php if(count($data)>0){ ?>
                <?php foreach($data as $key=>$record){ ?>
                    <div class="vote-item">
                        <div class="candidates">
                            <div class="col">
                                <img src="img/<?php echo $record['CandidatePhoto'] ?>" alt="candidate_photo">
                            </div>
                            <div class="col">
                                <h4>Candidate No : <?php echo $record['CandidateID'] ?></h4>
                                <p>Name : <?php echo $record['FirstName']." ".$record['MiddleName']." ".$record['LastName'] ?></p>
                                <p>Affilated Party : <?php echo $record['PartyAffiliation'] ?></p>
                            </div>
                            <div class="col">
                                <p style="text-align: center;">Vote Count</p>
                                <h2><?php
                                    $candidateid=$record['CandidateID']; 
                                    $sql1 ="SELECT COUNT(VoteID) as votecount FROM vote where CandidateID=$candidateid GROUP BY CandidateID order by votecount desc;";
                                    $result1=$connection->query($sql1);
                                    $row1=[];
                                    if($result1->num_rows==0){
                                        echo 'NULL';
                                    }else{
                                        $row1=$result1->fetch_assoc();
                                        echo $row1['votecount'];
                                    }
                                ?></h2>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else {?>
                <h2>No candidates found</h2>
            <?php }?>
        </div>
    </div>            
    <!--FOOTER START-->
    <?php require_once 'Footer.php'; ?>
    <!--FOOTER END-->   
</body>
</html>