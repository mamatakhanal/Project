<?php
    require_once 'elestatus.php';
?>
<?php
    // error_reporting(0);
    $id=$_GET['id'];
    require_once 'connection.php';
    $sql="SELECT CandidateID,FirstName,MiddleName,LastName,Age,Gender,PartyAffiliation,CandidatePhoto,candidate.ElectionID,ElectionName from candidate inner join election on candidate.ElectionID=election.ElectionID where candidate.ElectionID='$id' and CandidateStatus='approved' ";
    $result =$connection->query($sql);
    $data=[];
    if($result-> num_rows>0){
        while($row=$result->fetch_assoc()){
            // print_r($row);
            array_push($data,$row);
        }
    }
    $sql_elename="SELECT ElectionName from election where ElectionID='$id'";
    $result_elename =$connection->query($sql_elename);
    $row_elename=$result_elename->fetch_assoc();
    $elename=$row_elename['ElectionName'];

    session_start();
    $_SESSION['eleid']=$_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates</title>
    <?php require_once 'link.php'; ?>
    <style>
        body{
            background-color: #e2e5ff;
        }
        .mini-nav{
            width: 80%;
            margin: auto;
            display: flex;
            justify-content: space-between;
        }
        .mini-nav h4{
            font-weight: lighter;
        }
        .heading{
            text-align: center;
        }
        hr{
            width: 40%;
            margin: auto;
            font-size: larger;
        }
        .container{
            height: 500px;
        }
        .candidates-container{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            place-items: center;
            padding: 15px 9%;
        }
        @media (max-width:800px) {
            .candidates-container{
                grid-template-columns: 1fr;
            }
        }
        .candidates{
            background-color:#c5cbff;
            border-radius: 20px;
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            display: grid;
            grid-template-columns: 150px 1fr;
            column-gap: 16px;
        }
        .col img{
            width:150px;
            height: 150px;
            border-radius: 100px;
        }
        .col p,h4{
            font-size: 14px;
            line-height: 7px;
        }
        .col a{
            font-size: 12px;
            font-weight: normal;
        }
        .col a:hover{
            text-decoration: underline;
            font-size: 12.5px;
        }
    </style>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <div class="mini-nav">
        <a href="election.php"><h4><i class='bx bx-chevron-left-circle'></i> Back to Election List</h4> </a>
        <?php
            $sql_cand ="SELECT COUNT(CandidateID) as cand_count FROM candidate where ElectionID=$id GROUP BY ElectionID;";
            $result_cand=$connection->query($sql_cand);
            $row_cand=[];
        ?>
        <?php if($result_cand->num_rows>0){?>
            <a href="Voting.php?err=1?id=<?php print_r($_SESSION['eleid']) ?>"><h4>Proceed to Vote <i class='bx bx-chevron-right-circle'></i></h4></a>
        <?php }?>
    </div>
    <p class="heading">CANDIDATES FOR <?php echo $elename ?></p>
    <hr>
    <div class="container">
        <div class="candidates-container">
            <?php if(count($data)>0){ ?>
                <?php foreach($data as $key=>$record){ ?>
                    <div class="candidates">
                        <div class="col">
                            <img src="img/<?php echo $record['CandidatePhoto'] ?>" alt="candidate-photo">
                        </div>
                        <div class="col">
                            <h4>Candidate No : <?php echo $record['CandidateID'] ?></h4>
                            <p>Name : <?php echo $record['FirstName']." ".$record['MiddleName']." ".$record['LastName'] ?></p>
                            <p>Age : <?php echo $record['Age'] ?></p>
                            <p>Gender : <?php echo $record['Gender'] ?></p>
                            <p>Affilated Party : <?php echo $record['PartyAffiliation'] ?></p>
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