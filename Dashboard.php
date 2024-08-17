<?php
    require_once 'elestatus.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['admin_id'])){
        header('location:admin_login.php?err=1');
    }
?>
<?php
    error_reporting(0);
    require_once 'connection.php';
    $sql1="SELECT COUNT(DISTINCT VoterID) as voters from voter where VoterStatus='active'";
    $result1 =$connection->query($sql1);
    $row1=[];
    if($result1->num_rows==0){
        $voters= 'NULL';
    }else{
        $row1=$result1->fetch_assoc();
        $voters= $row1['voters'];
    }
    $sql2="SELECT COUNT(DISTINCT ElectionID) as elections from election";
    $result2 =$connection->query($sql2);
    $row2=[];
    if($result2->num_rows==0){
        $elections= 'NULL';
    }else{
        $row2=$result2->fetch_assoc();
        $elections= $row2['elections'];
    }
    $sql3="SELECT COUNT(DISTINCT CandidateID) as candidates from candidate where CandidateStatus='approved'";
    $result3 =$connection->query($sql3);
    $row3=[];
    if($result3->num_rows==0){
        $candidates= 'NULL';
    }else{
        $row3=$result3->fetch_assoc();
        $candidates= $row3['candidates'];
    }
    $sql4="SELECT COUNT(DISTINCT VoterID) as voted_voters from vote";
    $result4 =$connection->query($sql4);
    $row4=[];
    if($result4->num_rows==0){
        $voted_voters= 'NULL';
    }else{
        $row4=$result4->fetch_assoc();
        $voted_voters= $row4['voted_voters'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php require_once 'link.php'; ?>
    <style>
        *{
            margin: 0;
            padding: 0;
            border:none;
            outline: none;
            box-sizing: border-box;
        }
        body{
            background-color: #e2e5ff;
        }
        .header{          
            background-color: #c5cbff;
            height: 12vh;
            width: 100%;
        }
        .logo{
            display: flex;
            padding-left: 35px;
        }
        .logo i {
           font-size: 30px;
           padding:  25px 5px ;   
        }
        .profile{
            padding-left: 1050px;
        }
        .sidebar{
            position:sticky ;
            width: 250px;
            height: 88vh;
            color:#fff;
            overflow:hidden;
            padding-left: 30px;
            transition: all 0.5s linear;
            background:#22243e;            
        }
        .menu{
            height: 88%;
            position: relative;
            list-style: none;
            padding: 0;
        }
        .menu li{
            padding: 1rem;
            margin: 8px 0;
            border-radius: 8px;
            transition: all 0.5s ease-in-out;
        }
        .menu li:hover ,
        .active{
            background: #332c58;
        }
        .menu a{
            color:#fff;
            font-size: 18px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap:1.5rem;
        }
        .menu a span{
            overflow:hidden;
        }
        .menu a i{
            font-size: 1.2rem;
        }
        .logout{
            position:absolute;
            width: 100%;
        }

        .main{
            position: absolute;
            top:75px;
            left: 300px;
        }
        .counts{
            padding: 35px 10px;
            display: grid;
            grid-template-columns: repeat(2, 400px);
            grid-gap:60px;
        }
        .counts .count{
            padding: 20px;
            border-radius: 10px;
        }
        .count h1,h3{
            text-align: center;
        }
        .count h1{
            font-size: 60px;
        }
        .count a,p{
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo"> 
            <i class='bx bx-slider'></i>
            <img src="images/finallogo.png" alt="logo" height="75px"></a>
            <div class="profile">
                <i class='bx bxs-user'></i>
            </div>
        </div>
    </div>
    
    <div class="sidebar">
            <div class="menu">
                <li class="active">
                    <a href="#">
                        <i class='bx bxs-dashboard'></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="admin_listelection.php">
                        <i class='bx bx-user'></i>
                        <span> Election </span>
                    </a>
                </li>
                <li>
                    <a href="admin_candidatelist.php">
                        <i class='bx bxs-user'></i>
                        <span> Candidates </span>
                    </a>
                </li>
                <li>
                    <a href="admin_voterlist.php">
                        <i class='bx bx-user'></i>
                        <span> Voters </span>
                    </a>
                </li>                        
                <li class="logout">
                    <a href="admin_logout.php">
                        <i class='bx bx-log-out-circle'></i>
                        <span> Logout </span>
                    </a>
                </li>
        </div>
    </div>
    <div class="main">
        <h1>Dashboard</h1>
        <div class="counts">
            <div class="count" style="background-color:#79CDFC">
                <h3> No of Voters</h3>
                <h1><?php echo $voters ?></h1>
                <a href="admin_voterlist.php"><p>More info <i class='bx bx-right-arrow-circle'></i></p></a>
            </div>
            <div class="count" style="background-color:#8EF592;" >
                <h3> No of positions</h3>
                <h1><?php echo $elections ?></h1>
                <a href="admin_listelection.php"><p>More info <i class='bx bx-right-arrow-circle'></i></p></a>
            </div>
            <div class="count" style="background-color:#E8BF8F;">
                <h3> No of Candidates</h3>
                <h1><?php echo $candidates ?></h1>
                <a href="admin_candidatelist.php"><p>More info <i class='bx bx-right-arrow-circle'></i></p></a>
            </div>
            <div class="count" style="background-color:#F37C7C;" >
                <h3>No. Voters Who Voted</h3>
                <h1><?php echo $voted_voters ?></h1>
            </div>
        </div>
    </div>
    

</body>
</html>