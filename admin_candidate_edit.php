<!-- <?php
    require_once 'elestatus.php';
?> -->
<?php
    session_start();
    if(!isset($_SESSION['admin_id'])){
        header('location:admin_login.php?err=1');
    }
?>
<?php
    error_reporting(0);
    $id=$_GET['id'];
    require_once 'connection.php';
    $sql="SELECT CandidateID,FirstName,MiddleName,LastName,PartyAffiliation,Age,Gender,ElectionID,CandidatePhoto
    from candidate where CandidateID='$id' ";
    $result =$connection->query($sql);
    $data=[];
    if($result-> num_rows==1){
        $row=$result->fetch_assoc();
    }else{
        $row=[];
    }
    $sql_eleid=" SELECT ElectionID,ElectionName from election where ElectionStatus='upcoming'";
    $ele_id=$connection->query($sql_eleid);
    // print_r($ele_id);
    $data1=[];
    if($ele_id-> num_rows>0){
        while($row1=$ele_id->fetch_assoc()){
            $elename=$row1['ElectionName'];
            array_push($data1,$row1);
        }
    }
    if(isset($_POST['btnSave'])){
        $err=[];
        if(isset($_POST['candidate_fname']) && !empty($_POST['candidate_fname']) && trim($_POST['candidate_fname']) ){
            $candidate_fname=$_POST['candidate_fname'];
            if(!preg_match('/^[A-Za-z]+$/',$candidate_fname)){
                $err['candidate_fname'] =  'Enter valid first name';
            }
        }else{
            $err['candidate_fname']='Please enter candidate first name';
        }
        if(isset($_POST['candidate_mname']) && !empty($_POST['candidate_mname']) && trim($_POST['candidate_mname']) ){
            $candidate_mname=$_POST['candidate_mname'];
            if(!preg_match('/^[A-Za-z]+$/',$candidate_mname)){
                $err['candidate_mname'] =  'Enter valid middle name';
            }
        }
        if(isset($_POST['candidate_lname']) && !empty($_POST['candidate_lname']) && trim($_POST['candidate_lname']) ){
            $candidate_lname=$_POST['candidate_lname'];
            if(!preg_match('/^[A-Za-z]+$/',$candidate_lname)){
                $err['candidate_lname'] =  'Enter valid last name';
            }
        }else{
            $err['candidate_lname']='Please enter candidate last name';
        }
        if(isset($_POST['candidate_age']) && !empty($_POST['candidate_age']) && trim($_POST['candidate_age']) ){
            $candidate_age=$_POST['candidate_age'];
            if(filter_var($candidate_age,FILTER_VALIDATE_INT)){
                if($candidate_age<18){
                    $err['candidate_age']='Age must be over 18';
                }
            }else{
                $err['candidate_age'] =  'Enter valid age';
            }
        }else{
            $err['candidate_age']='Please enter age';
        }
        if(isset($_POST['candidate_gender'])){
            $candidate_gender=$_POST['candidate_gender'];
        }else{
            $err['candidate_gender']='Please select candidate gender';
        }
        if(isset($_POST['party_aff']) && !empty($_POST['party_aff']) && trim($_POST['party_aff']) ){
            $party_aff=$_POST['party_aff'];
            if(!preg_match('/^[A-Za-z]+$/',$party_aff)){
                $err['party_aff'] =  'Enter valid party name';
            }
        }else{
            $err['party_aff']='Please enter party name';
        }
        if(isset($_POST['election_id']) && !empty($_POST['election_id']) && $_POST['election_id']!=0){
            $election_id=$_POST['election_id'];
        }else{
            $err['election_id']='Please select election id';
        }
        if(isset($_FILES['candidate_photo']['error']) && $_FILES['candidate_photo']['error']==0 ){
            if($_FILES['candidate_photo']['size']<1048576){
                $filetype=['image/png','image/jpeg','image/jpg'];
                if(in_array($_FILES['candidate_photo']['type'], $filetype)){
                    if(move_uploaded_file($_FILES['candidate_photo']['tmp_name'],'img/' . $_FILES['candidate_photo']['name'])){
                        $candidate_photo=$_FILES['candidate_photo']['name'];
                    }else{
                        $err['candidate_photo']= "File Upload Failed";
                    }
                }else{
                    $err['candidate_photo']= "File type doesnot match";
                }
            }else{
                $err['candidate_photo']= "File size cannot exceed 1MB";
            }
        }else{
            $err['candidate_photo']= "File cannot be uploaded";
        }
        if(count($err)==0){
            // require_once 'connection.php';
            $sql="UPDATE candidate SET FirstName ='$candidate_fname', MiddleName ='$candidate_mname', LastName ='$candidate_lname', PartyAffiliation='$party_aff',Age='$candidate_age',Gender='$candidate_gender',ElectionID='$election_id',CandidatePhoto='$candidate_photo'  where candidate.CandidateID='$id' ";
            $connection->query($sql);
            // print_r($connection);
            if($connection->affected_rows==1){
                echo '<script>
                    alert("Record Updated");
                    window.location.href="admin_candidatelist.php";
                </script>';
            }else{
                echo '<script>
                    alert("Unable to Update");
                    window.location.href="admin_candidatelist.php";
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
                <li>
                    <a href="admin_listelection.php">
                        <i class='bx bx-user'></i>
                        <span> Election </span>
                    </a>
                </li>
                <li class="active">
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
            <a href="admin_candidatelist.php"><span>View Candidate list</span></a>
            <a href="admin_candidateadd.php"><span>Add New Candidate</span></a>
            <a href="admin_candidateapprove.php"><span>Approve Candidate</span></a>
        </div>
        <div class="election-list">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Edit Candidate</legend>
                <?php if(isset($error)) {?>
                    <p class="err_msg"><?php echo $error ?></p>
                <?php }?>
                <?php if(isset($success)) {?>
                    <p class="success_msg"><?php echo $success ?></p>
                <?php }?>
                <div class="label-input">
                    <label for="candidate_fname">First Name</label>
                    <input type="text" name="candidate_fname" id="candidate_fname" value="<?php echo isset($row['FirstName'])?$row['FirstName']:'' ?>">
                    <?php if(isset($err['candidate_fname'])) { ?>
                        <span class="err_message">
                            <?php echo $err['candidate_fname'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="candidate_lname">Middle Name</label>
                    <input type="text" name="candidate_lname" id="candidate_lname" value="<?php echo isset($row['MiddleName'])?$row['MiddleName']:'' ?>">
                    <?php if(isset($err['candidate_lname'])) { ?>
                        <span class="err_message">
                            <?php echo $err['candidate_lname'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="candidate_lname">Last Name</label>
                    <input type="text" name="candidate_lname" id="candidate_lname" value="<?php echo isset($row['LastName'])?$row['LastName']:'' ?>">
                    <?php if(isset($err['candidate_lname'])) { ?>
                        <span class="err_message">
                            <?php echo $err['candidate_lname'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="candidate_age">Age</label>
                    <input type="text" name="candidate_age" id="candidate_age" value="<?php echo isset($row['Age'])?$row['Age']:'' ?>">
                    <?php if(isset($err['candidate_age'])) { ?>
                        <span class="err_message">
                            <?php echo $err['candidate_age'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="candidate_gender">Gender</label>
                    Male<input type="radio" name="candidate_gender" id="candidate_gender" value="Male" <?php echo ($row['Gender']== 'Male')?'checked':'' ?>>
                    Female<input type="radio" name="candidate_gender" id="candidate_gender" value="Female" <?php echo ($row['Gender']== 'Female')?'checked':'' ?>>
                    Other<input type="radio" name="candidate_gender" id="candidate_gender" value="Other" <?php echo ($row['Gender']== 'Other')?'checked':'' ?>>
                    <?php if(isset($err['candidate_gender'])) { ?>
                        <span class="err_message">
                            <?php echo $err['candidate_gender'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="party_aff">Party Affiliation</label>
                    <input type="text" name="party_aff" id="party_aff" value="<?php echo isset($row['PartyAffiliation'])?$row['PartyAffiliation']:'' ?>">
                    <?php if(isset($err['party_aff'])) { ?>
                        <span class="err_message">
                            <?php echo $err['party_aff'] ?>
                        </span>
                    <?php } ?>
                </div>
                <div class="label-input">
                    <label for="election_id">Election Name</label>
                    <select name="election_id" id="election_id" value="<?php echo isset($election_id)?$election_id:'' ?>">
                        <option value="0">Select one</option>
                        <?php foreach($data1 as $key=>$value){?>
                            <option value="<?php echo $value['ElectionID'] ?>" <?php echo $row['ElectionID']?'selected':'' ?>><?php echo $value['ElectionName'] ?></option>
                        <?php }?>
                    </select>   
                    <?php if(isset($err['election_id'])) { ?>
                        <span class="err_message">
                            <?php echo $err['election_id'] ?>
                        </span>
                    <?php } ?> 
                </div>
                <div class="label-input">
                    <label for="candidate_photo">Photo</label>
                    <?php if(!isset($candidate_photo)) { ?>
                        <img height="100px" src="img/<?php echo $row['CandidatePhoto'] ?>" alt="candidate_photo">
                    <?php }else{ ?>
                        <img height="100px" src="img/<?php echo $candidate_photo ?>" alt="candidate_photo">
                    <?php } ?>
                    <input type="file" name="candidate_photo" id="candidate_photo">
                    <?php if(isset($err['candidate_photo'])) { ?>
                        <span class="err_message">
                            <?php echo $err['candidate_photo'] ?>
                        </span>
                    <?php } ?>
                    <br>
                </div>
                <br>
                <br><br>
                <br>
                <div class="btn">
                    <button type="submit" name="btnSave" class="btnSave">Update</button>
                    <button type="clear" name="btnClear" class="btnClear">Clear</button>
                </div>
            </fieldset>
        </form>
        </div>
    </div>
</body>
</html>