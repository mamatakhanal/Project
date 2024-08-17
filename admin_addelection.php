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
    if(isset($_POST['btnSave'])){
        $err=[];
        if(isset($_POST['election_name']) && !empty($_POST['election_name']) && trim($_POST['election_name']) ){
            $election_name=$_POST['election_name'];
            if(!preg_match('/^[A-Za-z\s]+$/',$election_name)){
                $err['election_name'] =  'Enter valid election name';
            }
        }else{
            $err['election_name']='Please enter election name';
        }
        if(isset($_POST['election_date']) && !empty($_POST['election_date']) && trim($_POST['election_date']) ){
            $today=time();
            $today_format=date('Y-m-d',$today);
            $election_date=$_POST['election_date'];
            if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',$election_date)){
                if($election_date<=$today_format){
                    $err['election_date']='Enter valid date';
                }
            }else{
                $err['election_date']='Enter valid date';
            }
        }else{
            $err['election_date']='Please enter election date';
        }
        $index_value=0;
        if(isset($_POST['election_type']) && !empty($_POST['election_type']) && $_POST['election_type']!=0){
            $election_type=$_POST['election_type'];
        }else{
            $err['election_type']='Please select election type';
        }
        // if($election_date<date('Y-m-d')){
        //     $election_status='completed';
        // }elseif($election_date==date('Y-m-d')){
        //     $election_status='ongoing';
        // }else{
        //     $election_status='upcoming';
        // }
        if(count($err)==0){
            require_once 'connection.php';

            $sql="insert into election(ElectionName,ElectionDate,ElectionType)
                values('$election_name','$election_date','$election_type')
            ";
            $connection->query($sql);
            
            // $sql1="update election.ElectionStatus
            //     set=case
            //     when $election_date>$today_format then 'upcoming'
            //     when $election_date<$today_format then 'completed'
            //     else 'ongoing'
            // ";
            // $connection->query($sql1);
            // print_r($connection);

            if($connection->affected_rows==1 && $connection->insert_id>0){
                $success='New election added successfully';
            }else{
                $error='Election addition failed';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election</title>
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
        .main-nav a:hover, .active{
            background: #332c58;
        }
        .main form{
            position: relative;
            padding: 20px;
            width: 750px;
            margin: auto;
        }
        form fieldset{
            border: 1px solid #332c58;
        }
        form .label-input{
            padding: 10px;
            font-size: 14px;
            height: 50px;
        }
        .label-input label{
            display: inline-block;
            width: 150px;
        }
        .label-input input[type=text]{
            padding: 5px;
            border-radius: 5px;
            width: 300px;
        }
        .label-input input[type=date]{
            padding: 5px;
            border-radius: 5px;
            width: 300px;
        }
        .label-input select{
            padding: 5px;
            border-radius: 5px;
            width: 300px;
        }
        .btn{
            text-align: center;
            padding: 10px;
        }
        .btnSave{
            background-color: green;
            padding: 10px;
            border-radius: 10px;
            color: #e2e5ff;
        }
        .btnClear{
            background-color: red;
            padding: 10px;
            border-radius: 10px;
            color: #e2e5ff;
        }
        .err_message{
            padding: 20px;
            color: red;
            font-size: 12px;
        }
        .err_msg{
            background-color: red;
            color: #e2e5ff;
            width: 80%;
            margin: auto;
            text-align: center;
            padding: 5px;
        }
        .success_msg{
            background-color: green;
            color: #e2e5ff;
            width: 80%;
            margin: auto;
            text-align: center;
            padding: 5px;
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
                <li class="active">
                    <a href="#">
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
                    <a href="#">
                        <i class='bx bx-log-out-circle'></i>
                        <span> <a href="admin_logout.php">Logout</a></span>
                    </a>
                </li>
        </div>
    </div>
    <div class="main">
        <div class="mini-nav">
            <a href="admin_listelection.php"><span>View Election list</span></a>
            <a href="#"><span class="active">Add New Election</span></a>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <fieldset>
                <legend>Add New Election</legend>
                <?php if(isset($error)) {?>
                    <p class="err_msg"><?php echo $error ?></p>
                <?php }?>
                <?php if(isset($success)) {?>
                    <p class="success_msg"><?php echo $success ?></p>
                <?php }?>
                <div class="label-input">
                    <label for="election_name">Election Name</label>
                    <input type="text" name="election_name" id="election_name" value="<?php echo isset($election_name)?$election_name:'' ?>">
                    <span id="check_election"></span>
                    <?php if(isset($err['election_name'])) { ?>
                        <span class="err_message">
                            <?php echo $err['election_name'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="election_date">Election Date</label>
                    <input type="text" name="election_date" id="election_date" placeholder="YYYY-MM-DD" value="<?php echo isset($election_date)?$election_date:'' ?>">
                    <?php if(isset($err['election_date'])) { ?>
                        <span class="err_message">
                            <?php echo $err['election_date'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="election_type">Election Type</label>
                    <select name="election_type" id="election_type" value="<?php echo isset($election_type)?$election_type:'' ?>">
                        <option value="0">Select one</option>
                        <option value="National">National</option>
                        <option value="Regional">Regional</option>
                        <option value="Local">Local</option>
                    </select> 
                    <?php if(isset($err['election_type'])) { ?>
                        <span class="err_message">
                            <?php echo $err['election_type'] ?>
                        </span>
                    <?php } ?>   
                </div>
                <div class="btn">
                    <button type="submit" name="btnSave" class="btnSave">Confirm</button>
                    <button type="clear" name="btnClear" class="btnClear">Clear</button>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- JAVASCRIPT -->
    <script type="text/javascript" src="file/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#election_name').keyup(function(){
                var check_election=$(this).val();
                $.ajax({
                    url:'election_check.php',
                    data:{'election_name':check_election},
                    dataType:'text',
                    method:'post',
                    success:function(resp){
                        $('#check_election').html(resp);
                        if(resp=='Election available'){
                            $('#check_election').css({color:'green'})
                        }else{
                            $('#check_election').css({color:'red'})
                        }
                    }
                });
            });                 
        });
    </script>
</body>
</html>