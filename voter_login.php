<?php
    require_once 'elestatus.php';
?>
<?php
    //error_reporting(0);
    if(isset($_COOKIE['voter_id'])){
        session_start();
        
        $_SESSION['voter_id']=$_COOKIE['voter_id'];
        $_SESSION['voter_username']=$_COOKIE['voter_username'];
        header('location:voting.php');
    }

    if(isset($_POST['btnLogin'])){
        $err=[];
        if(isset($_POST['voter_username']) && !empty($_POST['voter_username']) && trim($_POST['voter_username']) ){
            $voter_username=$_POST['voter_username'];
            if(!preg_match('/^[A-Za-z0-9]+$/',$voter_username)){
                $err['voter_username'] =  'Enter valid username';
            }
        }else{
            $err['voter_username']='Please enter username';
        }
        if(isset($_POST['voter_password']) && !empty($_POST['voter_password']) && trim($_POST['voter_password']) ){
            $voter_password=$_POST['voter_password'];
            $encrypted_password=md5($voter_password);
        }else{
            $err['voter_password']='Please enter password';
        }

        if(count($err)==0){
            require_once 'connection.php';
            $sql="SELECT VoterID,voter_username,VoterStatus FROM voter where voter_username='$voter_username' and voter_password='$encrypted_password'";
            $result = $connection->query($sql);
        }

        if($result->num_rows==1){
            $row = $result->fetch_assoc();
            if($row['VoterStatus']=='active'){
                session_start();
                $_SESSION['voter_id']=$row['VoterID'];
                $_SESSION['voter_username']=$row['voter_username'];
                $voter_id=$_SESSION['voter_id'];
                $id=$_SESSION['eleid'];
                $sql1="SELECT VoterID,ElectionID from vote where VoterID='$voter_id' and ElectionID='$id'";
                $result1=$connection->query($sql1);
                if($result1->num_rows==1){
                    $row1=$result1->fetch_assoc();
                    $a=$row1['VoterID'];
                    $b=$row1['ElectionID'];
                    if($a==$voter_id && $b==$id){
                        echo '<script>
                            alert("You cannot vote more than once");
                            window.location.href="voter_logout.php";
                        </script>';
                    }
                }else{
                    header('location:voting.php?id='.print_r($_SESSION['eleid']));
                }
            }else{
                echo '<script>
                        alert("You are yet to be approved");
                        window.location.href="voter_logout.php";
                    </script>';
            }
        }else{
            $err_msg="Credential doesnot match";
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <?php require_once 'link.php'; ?>

    <style>
        body{
            background-color: #e2e5ff;
        }
        form{
            display: grid;
            grid-template-columns: 1fr;
            place-items: center;
            height: 77vh;
        }
        fieldset{
            width: fit-content;
            background-color: #332c58;
            box-shadow: 0 10px 10px 0 #8a98b3;
            border-radius: 20px;
            color: #e2e5ff;
            padding: 20px;
            border: none;
        }
        h3{
            text-align: center;
        }
        .label-input{
            padding: 10px;
        }
        .label-input label{
            display: inline-block;
            width: 100px;
            padding: 5px;
        }
        .label-input input{
            height: 20px;
            width: 150px;
            background-color: #e2e5ff;
            border: none;
            border-radius:5px;
            padding: 5px;
            box-shadow:  2px 2px  0 0 #8a98b3 inset;
            font-family: "Quicksand", sans-serif;   
        }
        .checkbox{
            font-size: 12px;
            padding: 10px;
        }
        .button{
            text-align: center;
            padding: 10px;
        }
        .button button{
            padding: 5px;
            width: 50px;
            border-radius: 5px;
            background-color: #22243e;
            color: #e2e5ff;
            border: none;
            box-shadow: 1px 1px 0 0 #c5cbff;
        }
        .button button:hover{
            background-color: #c5cbff;
            color: #332c58;
            box-shadow: 2px 2px 0 0 #332c58 inset;
        }
        .err_message{
            color: red;
            font-size: 10px;
        }
        .err_msg{
            background-color: red;
            color: #e2e5ff;
            width: 80%;
            margin: auto;
            text-align: center;
            padding: 5px;
        }
        .not-reg{
            text-align: center;
        }
        .not-reg span{
            color: #c5cbff;
            font-size: 12px;
        }
        .not-reg a{
            color: #c5cbff;
            font-size: 12px;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <form action="" method="post" enctype="" >
        <fieldset>
            <h3>User Login</h3>
            <?php if(isset($err_msg)) { ?>
                <p class="err_msg"><?php echo $err_msg ?></p>
            <?php } ?>
            <?php if(isset($_GET['err']) && $_GET['err']==1) { ?>
                <p class="err_msg">Please login to continue</p>
            <?php } ?>
            <div class="label-input">
                <label for="voter_username">Username</label>
                <input type="text" name="voter_username" id="voter_username" value="<?php echo isset($voter_username)?$voter_username:'' ?>" >
                <?php if(isset($err['voter_username'])) { ?>
                    <span class="err_message">
                        <?php echo $err['voter_username'] ?>
                    </span>
                <?php } ?>
            </div>
            <div class="label-input">
                <label for="voter_password">Password</label>
                <input type="password" name="voter_password" id="voter_password" value="<?php echo isset($voter_password)?$voter_password:'' ?>">
                <?php if(isset($err['voter_password'])) { ?>
                    <span class="err_message">
                        <?php echo $err['voter_password'] ?>
                    </span>
                <?php } ?>
            </div>
    
            <div class="button">
                <button name="btnLogin">Login</button>
            </div>
            <div class="not-reg">
                <span>Not Registered?</span>
                <a href="voter_register.php"><span>Register Here</span></a>
            </div>
        </fieldset>
    </form>


    <!--FOOTER START-->
    <?php require_once 'Footer.php'; ?>
    <!--FOOTER END-->
</body>
</html>