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
    if(is_numeric($_GET['id'])){
        $id=$_GET['id'];
    }else{
        header('location:admin_listelection.php?msg=1');
    }
    require_once 'connection.php';
    $sql="SELECT CandidateID,FirstName,MiddleName,LastName,PartyAffiliation,election.ElectionName
    from candidate inner join election on candidate.ElectionID=election.ElectionID where candidate.ElectionID='$id'";
    $result =$connection->query($sql);
    
    $data=[];
    if($result-> num_rows>0){
        while($row=$result->fetch_assoc()){
            array_push($data,$row);
        }
    }else{
        $row=[];
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
        .election-list table{
            width: 900px;
        }
        .election-list table,tr,th,td{
            border-collapse: collapse;
            border: 1px solid #332c58;
            padding: 5px;
        }
        .election-list thead{
            background-color: #332c58;
            color: #e2e5ff;
        }
        .election-list tbody{
            background-color: #c5cbff;
            color: #22243e;
        }
        .action .view{
            background-color: #332c58;
            color: #e2e5ff;
            padding: 3px;
            border-radius: 5px;
        }
        .action .edit{
            color: #e2e5ff;
            background-color: green;
            padding: 3px;
            border-radius: 5px;
        }
        .action .delete{
            color: #e2e5ff;
            background-color: red;
            padding: 3px;
            border-radius: 5px;
        }
        .err_msg{
            background-color: red;
            color: #e2e5ff;
            width: 80%;
            margin: auto;
            text-align: center;
            padding: 10px;
        }
        .success_msg{
            background-color: green;
            color: #e2e5ff;
            width: 200px;
            margin: auto;
            text-align: center;
            padding: 10px;
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
            <a href="admin_listelection.php"><span>Back to Election list</span></a>
        </div>
        <div class="election-list">
            <?php if(isset($_GET['msg']) && $_GET['msg']==3) {?>
                <p class="err_msg">Unable to delete candidate</p>
            <?php }?>

            <?php if(isset($_GET['msg']) && $_GET['msg']==2) {?>
                <p class="success_msg">Candidate Deleted Successfully</p>
            <?php }?>
                <h3>Candidates for <?php echo $elename ?></h3>
                
                <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Candidate ID</th>
                        <th>Candidate Name</th>
                        <th>Party Affiliation</th>
                        <th>Election Name</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($data)>0){ ?>
                        <?php foreach($data as $key=>$record){ ?>    
                            <tr>
                                <td><?php echo $key+1 ?></td>
                                <td><?php echo $record['CandidateID'] ?></td>
                                <td><?php echo $record['FirstName']." ".$record['MiddleName']." ".$record['LastName'] ?></td>
                                <td><?php echo $record['PartyAffiliation'] ?></td>
                                <td><?php echo $record['ElectionName'] ?></td>
                                <!-- <td class="action">
                                    <a href="electionedit.php" class="edit">Edit</a> |
                                    <a href="admin_delete_electioncandidate.php" class="delete">Delete</a>
                                </td> -->
                            </tr>
                        <?php } ?>
                    <?php } else {?>
                        <tr>
                            <td colspan="6">No candidates found</td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>