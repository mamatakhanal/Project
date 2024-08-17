<?php
    require_once 'elestatus.php';
?>
<?php
    error_reporting(0);
    if(isset($_POST['btnSave'])){
        $err=[];
        $voter_id=rand(1,1000000);
        if(isset($_POST['voter_fname']) && !empty($_POST['voter_fname']) && trim($_POST['voter_fname']) ){
            $voter_fname=$_POST['voter_fname'];
            if(!preg_match('/^[A-Za-z]+$/',$voter_fname)){
                $err['voter_fname'] =  'Enter valid first name';
            }
        }else{
            $err['voter_fname']='Please enter your first name';
        }
        if(isset($_POST['voter_mname']) && !empty($_POST['voter_mname']) && trim($_POST['voter_mname']) ){
            $voter_mname=$_POST['voter_mname'];
            if(!preg_match('/^[A-Za-z]+$/',$voter_mname)){
                $err['voter_mname'] =  'Enter valid middle name';
            }
        }
        if(isset($_POST['voter_lname']) && !empty($_POST['voter_lname']) && trim($_POST['voter_lname']) ){
            $voter_lname=$_POST['voter_lname'];
            if(!preg_match('/^[A-Za-z]+$/',$voter_lname)){
                $err['voter_lname'] =  'Enter valid last name';
            }
        }else{
            $err['voter_lname']='Please enter your last name';
        }
        if(isset($_POST['voter_dob']) && !empty($_POST['voter_dob']) && trim($_POST['voter_dob']) ){
            $today=time();
            $today_format=date('Y-m-d',$today);
            $voter_dob=$_POST['voter_dob'];
            if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',$voter_dob)){
                $year = (date('Y') - date('Y',strtotime($voter_dob)));
                if($year<18){
                    $err['voter_dob']='Your age must be 18 or above';
                }
            }else{
                $err['voter_dob']='Enter valid date of birth';
            }
        }else{
            $err['voter_dob']='Please choose your date of birth';
        }
        if(isset($_POST['voter_gender'])){
            $voter_gender=$_POST['voter_gender'];
        }else{
            $err['voter_gender']='Please select your gender';
        }
        if(isset($_POST['voter_address']) && !empty($_POST['voter_address']) && trim($_POST['voter_address']) ){
            $voter_address=$_POST['voter_address'];
            if(!preg_match('/^[A-Za-z]+$/',$voter_address)){
                $err['voter_address'] =  'Enter valid address';
            }
        }else{
            $err['voter_address']='Please enter your address';
        }
        if(isset($_POST['voter_email']) && !empty($_POST['voter_email']) && trim($_POST['voter_email']) ){
            $voter_email=$_POST['voter_email'];
            if(!filter_var($voter_email,FILTER_VALIDATE_EMAIL)){
                $err['voter_email'] =  'Enter valid email';
            }
        }else{
            $err['voter_email']='Please enter your email';
        }
        if(isset($_POST['voter_username']) && !empty($_POST['voter_username']) && trim($_POST['voter_username']) ){
            $voter_username=$_POST['voter_username'];
            if(preg_match('/^[A-Za-z]+[0-9]*$/',$voter_username)){
                if(strlen($voter_username)<5){
                    $err['voter_username'] =  'At least 5 characters';
                }
            }else{
                $err['voter_username'] =  'Enter valid username';
            }
        }else{
            $err['voter_username']='Please choose your username';
        }
        if(isset($_POST['voter_password']) && !empty($_POST['voter_password']) && trim($_POST['voter_password']) ){
            $voter_password=$_POST['voter_password'];
            if(strlen($voter_password)<5){
                $err['voter_password'] =  'At least 5 characters';
            }
            $encrypted_password=md5($voter_password);
        }else{
            $err['voter_password']='Please choose your password';
        }
        if(count($err)==0){
            require_once 'connection.php';

            $sql="insert into voter(VoterID,FirstName,MiddleName,LastName,DateOfBirth,Gender,Address,Email,voter_username,voter_password,VoterStatus)
                values('$voter_id','$voter_fname','$voter_mname','$voter_lname','$voter_dob','$voter_gender','$voter_address','$voter_email','$voter_username','$encrypted_password','Inactive')
            ";
            $connection->query($sql);
            //print_r($connection);
            if($connection->affected_rows==1 && $connection->insert_id==0){
                $success='Registered successfully';
            }else{
                $error='Registration failed';
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <?php require_once 'link.php'; ?>

    <!-- CSS FOR LOGO -->
    <style>
        body{
            background-color:  #c5cbff  ;
        }
        label{
            width: 100%;
            display: inline-block;
        }
        span{
        color: red;
        }
        input,select{
        width: 80%;
        height: 30px;
        }
        div{
        margin-bottom: 20px;
        }
        input[type=radio],input[type=checkbox]{
        width: 3%;
        height: initial;
        }
        input[type=submit],input[type=reset]{
        width: 20%;
        height: 30px;
        color: white;
        border: none;
        background: #3a3;
        }
        input[type=reset]{
        background: #a33;
        }
        input[type=submit]:hover,input[type=reset]:hover{
        cursor: pointer;
        }
        form{
            position: relative;
            padding: 20px;
            width: 700px;
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
        .label-input input[type=email]{
            padding: 5px;
            border-radius: 5px;
            width: 300px;
        }
        .label-input input[type=password]{
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
    <?php require_once 'header.php'; ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <h1 style="text-align: center;">VOTER REGISTRATION FORM</h1>
        <p>Fill out the form below and we'll lookup your voter registration status. Remember, you can't vote unless you are registered.</p>
        
            <fieldset>
                <legend>Register</legend>
                <?php if(isset($error)) {?>
                    <p class="err_msg"><?php echo $error ?></p>
                <?php }?>
                <?php if(isset($success)) {?>
                    <p class="success_msg"><?php echo $success ?></p>
                <?php }?>
                <div class="label-input">
                    <label for="voter_fname">First Name</label>
                    <input type="text" name="voter_fname" id="voter_fname" value="<?php echo isset($voter_fname)?$voter_fname:'' ?>">
                    <?php if(isset($err['voter_fname'])) { ?>
                        <span class="err_message">
                            <?php echo $err['voter_fname'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="voter_mname">Middle Name</label>
                    <input type="text" name="voter_mname" id="voter_mname" value="<?php echo isset($voter_mname)?$voter_mname:'' ?>">
                    <?php if(isset($err['voter_mname'])) { ?>
                        <span class="err_message">
                            <?php echo $err['voter_mname'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="voter_lname">Last Name</label>
                    <input type="text" name="voter_lname" id="voter_lname" value="<?php echo isset($voter_lname)?$voter_lname:'' ?>">
                    <?php if(isset($err['voter_lname'])) { ?>
                        <span class="err_message">
                            <?php echo $err['voter_lname'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="voter_dob">Date of Birth</label>
                    <input type="text" name="voter_dob" id="voter_dob" placeholder="YYYY-MM-DD" value="<?php echo isset($voter_dob)?$voter_dob:'' ?>">
                    <?php if(isset($err['voter_dob'])) { ?>
                        <span class="err_message">
                            <?php echo $err['voter_dob'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="voter_gender">Gender</label>
                    Male<input type="radio" name="voter_gender" id="voter_gender" value="Male" <?php echo ($voter_gender== 'Male')?'checked':'' ?>>
                    Female<input type="radio" name="voter_gender" id="voter_gender" value="Female" <?php echo ($voter_gender== 'Female')?'checked':'' ?>>
                    Other<input type="radio" name="voter_gender" id="voter_gender" value="Other" <?php echo ($voter_gender== 'Other')?'checked':'' ?>>
                    <?php if(isset($err['voter_gender'])) { ?>
                        <span class="err_message">
                            <?php echo $err['voter_gender'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="voter_address">Address</label>
                    <input type="text" name="voter_address" id="voter_address" value="<?php echo isset($voter_address)?$voter_address:'' ?>">
                    <?php if(isset($err['voter_address'])) { ?>
                        <span class="err_message">
                            <?php echo $err['voter_address'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="voter_email">Email</label>
                    <input type="text" name="voter_email" id="voter_email" value="<?php echo isset($voter_email)?$voter_email:'' ?>">
                    <span id="umail"></span>
                    <?php if(isset($err['voter_email'])) { ?>
                        <span class="err_message"  id="umail">
                            <?php echo $err['voter_email'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="voter_username">Voter Username</label>
                    <input type="text" name="voter_username" id="voter_username" value="<?php echo isset($voter_username)?$voter_username:'' ?>" >
                    <span id="uname"></span>
                    <?php if(isset($err['voter_username'])) { ?>
                        <span class="err_message">
                            <?php echo $err['voter_username'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="voter_password">Choose Password</label>
                    <input type="password" name="voter_password" id="voter_password" value="<?php echo isset($voter_password)?$voter_password:'' ?>">
                    <?php if(isset($err['voter_password'])) { ?>
                        <span class="err_message">
                            <?php echo $err['voter_password'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="btn">
                    <button type="submit" name="btnSave" class="btnSave">Submit</button>
                    <button type="clear" name="btnClear" class="btnClear">Clear</button>
                </div>
            </fieldset>
        </form>

    <!--FOOTER START-->
    <?php require_once 'Footer.php'; ?>
    <!--FOOTER END-->

    <!-- JAVASCRIPT -->
    <script type="text/javascript" src="file/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#voter_email').keyup(function(){
                var umail=$(this).val();
                $.ajax({
                    url:'umail_check.php',
                    data:{'email':umail},
                    dataType:'text',
                    method:'post',
                    success:function(resp){
                        $('#umail').html(resp);
                        if(resp=='Email available'){
                            $('#umail').css({color:'green'})
                        }else{
                            $('#umail').css({color:'red'})
                        }
                    }
                });
            });                 
        });
        $(document).ready(function(){
            $('#voter_username').keyup(function(){
                var uname=$(this).val();
                $.ajax({
                    url:'uname_check.php',
                    data:{'username':uname},
                    dataType:'text',
                    method:'post',
                    success:function(resp){
                        $('#uname').html(resp);
                        if(resp=='Username available'){
                            $('#uname').css({color:'green'})
                        }else{
                            $('#uname').css({color:'red'})
                        }
                    }
                });
            });                 
        });
    </script>
</body>
</html>