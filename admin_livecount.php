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
    // error_reporting(0);
    $id=$_GET['id'];
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

    $sql2="SELECT Count(DISTINCT VoterID) as votes from vote where ElectionID='$id'";
    $result2=$connection->query($sql2);
    $row2=[];
    if($result2->num_rows==0){
        $vote_count= 'NULL';
    }else{
        $row2=$result2->fetch_assoc();
        // print_r($row2['votes']);
        $vote_count= $row2['votes'];
    }

    $sql_elename="SELECT ElectionName from election where ElectionID='$id'";
    $result_elename =$connection->query($sql_elename);
    $row_elename=$result_elename->fetch_assoc();
    $elename=$row_elename['ElectionName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates</title>
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
            left: 265px;
        }
        .main .mini-nav span{
            padding: 10px;
            border-radius: 10px;
            background-color: #c5cbff;
        }

        .election-list{
            padding: 20px;
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
            padding: 10px;
            text-align: center;
        }
        .count h1{
            font-size: 60px;
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
                <li>
                    <a href="Dashboard.php">
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
                <li class="active">
                    <a href="#">
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
                    <a href="#">
                        <i class='bx bx-log-out-circle'></i>
                        <span> <a href="admin_logout.php">Logout</a></span>
                    </a>
                </li>
        </div>
    </div>
    <div class="main">
        <div class="mini-nav">
            <a href="admin_listelection.php"><span>Back To Election list</span></a>
        </div>
        <h3 style="padding-top: 10px;text-align:center;">Live Count For <?php echo $elename ?></h3>
        <div class="counts">
            <div class="count" style="background-color:#79CDFC">
                <h3>Active Voters</h3>
                <h1><?php echo $voters ?></h1>
            </div>
            
            <div class="count" style="background-color:#F37C7C;" >
                <h3>Vote Count</h3>
                <h1><?php echo $vote_count ?></h1>
            </div>
        </div>
        </div>
    </div>
</body>
</html>