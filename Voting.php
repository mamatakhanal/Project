<?php
    require_once 'elestatus.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['voter_id'])){
        header('location:voter_login.php?err=1');
    }
?>
<?php
    error_reporting(0);
    $id=$_SESSION['eleid'];
    $voter_id=$_SESSION['voter_id'];
    require_once 'connection.php';
    $sql="SELECT CandidateID,FirstName,MiddleName,LastName,PartyAffiliation,ElectionName,CandidatePhoto from candidate inner join election on candidate.ElectionID=election.ElectionID where candidate.ElectionID='$id' and CandidateStatus='approved' ";
    $result =$connection->query($sql);
    $data=[];
    if($result-> num_rows>0){
        while($row=$result->fetch_assoc()){
            $elename=$row['ElectionName'];
            array_push($data,$row);
        }
    }
    if(isset($_POST['submit'])){
        $err=[];
        if(isset($_POST['candidate'])){
            $vote=$_POST['candidate'];
        }else{
            $err['vote']="Please choose one candidate";
        }
        if(count($err)==0){
            $sql="INSERT INTO vote(VoterID,ElectionID,CandidateID) VALUES('$voter_id','$id','$vote')";
            $connection->query($sql);
            // print_r($connection);
            if($connection->affected_rows==1){
                echo '<script>
                    alert("Thank You for voting");
                    window.location.href="voter_logout.php";
                </script>';
            }else{
                echo '<script>
                    alert("Voting Failed");
                    window.location.href="voter_logout.php";
                </script>';
            }
        }
    }
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
            padding: 15px 9%; 
            height: 500px;   
        }
        .vote-container{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
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
            grid-template-columns: 100px 1fr;
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
        .buttons{
            padding: 20px 0;
            text-align: center;
            margin: auto;
        }
        button{
            font-family: "Quicksand", sans-serif;   
            padding: 10px;
            border-radius: 10px;
            border: none;
            width: 100px;
        }
        .con{
            background-color: green;
        }
        .not_con{
            background-color: red;
        }
    </style>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <div class="mini-nav">
        <a href="voter_logout.php"><h4><i class='bx bx-chevron-left-circle'></i> Back to Election List</h4> </a>
        <a href="voter_logout.php"><h4>Exit Voting Session <i class='bx bx-chevron-right-circle'></i></h4></a>
    </div>
    <p class="heading">VOTING FOR <?php echo $elename; ?></p>
    <hr>
    <p class="heading">Please select any one from the these candidates</p>
    <p style="color: red;text-align:center;font-size:16px;"><?php echo (isset($err['vote']))?$err['vote']:''; ?></p>
    <div class="container">
        <form action="#" method="post">        
            <div class="vote-container">
                <?php if(count($data)>0){ ?>
                    <?php foreach($data as $key=>$record){ ?>
                        <div class="vote-item">
                            <label for="<?php echo $record['CandidateID'] ?>">
                                <div class="candidates">
                                    <div class="col">
                                        <img src="img/<?php echo $record['CandidatePhoto'] ?>" alt="candidate_photo">
                                    </div>
                                    <div class="col">
                                        <h4>Candidate No : <?php echo $record['CandidateID'] ?></h4>
                                        <p>Name : <?php echo $record['FirstName']." ".$record['MiddleName']." ".$record['LastName'] ?></p>
                                        <p>Affilated Party : <?php echo $record['PartyAffiliation'] ?></p>
                                    </div>
                                </div>
                                <span>Vote for this candidate</span>
                            </label>
                            <input type="radio" name="candidate" id="<?php echo $record['CandidateID'] ?>" value="<?php echo $record['CandidateID'] ?>">
                        </div>
                    <?php } ?>
                <?php } else {?>
                    <h2>No candidates found</h2>
                <?php }?>
            </div>
            <div class="buttons">
                <button type="submit" name="submit" class="con">Confirm</button>
                <button type="clear" class="not_con">Clear</button>
            </div>
        </form>
    </div>  

    <!--FOOTER START-->
    <?php require_once 'Footer.php'; ?>
    <!--FOOTER END-->
</body>
</html>