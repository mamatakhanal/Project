<?php
    require_once 'elestatus.php';
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
        @media (max-width:800px) {
            .details-container{
                grid-template-columns: 1fr;
                height: auto;
            }
        }
        .grid-container{
            padding: 15px 20%;
        }
        .details-container{
            margin: 20px;
            background-color:#c5cbff;
            border-radius: 10px;
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.1);
            padding: 40px;
            display: grid;
            grid-template-columns: 300px 1fr;
            background-color: #c5cbff;
        }
        .col{
            padding: 20px;
        }
        .col img{
            height: 150px;
            border-radius: 100px;
        }
        .col p,h4{
            font-size: 14px;
        }
        .candidate-description{
            background-color: #e2e5ff;
            box-shadow: inset;
        }
        .candidate-description p{
            padding: 5px;
        }
    </style>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <div class="mini-nav">
        <a href="candidate.php"><h4><i class='bx bx-chevron-left-circle'></i> Back to Candidate List</h4> </a>
        <a href="Voting.php"><h4>Proceed to Vote <i class='bx bx-chevron-right-circle'></i></h4></a>
    </div>
    <p class="heading">DETAILS FOR CANDIDATE NO (c_no)</p>
    <hr>
    <div class="grid-container">
        <div class="details-container">
            <div class="col candidate-details">
                <img src="images/kag.jpg" alt="kagura">
                <h4>Candidate No : (c_no)</h4>
                <p>Name : (candidate_name)</p>
                <p>Age : (c_age)</p>
                <p>Gender : (c_gender)</p>
                <p>Affilated Party : (candidate_party)</p>
            </div>
            <div class="col candidate-description">
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Dolor porro sequi adipisci. Soluta iure voluptates 
                    architecto porro, cum autem laboriosam dicta maxime alias 
                    molestias enim possimus perspiciatis sed ipsam nostrum 
                    temporibus assumenda odio? In eos praesentium, repellat 
                    cum dicta reprehenderit.
                </p>
                <p>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                    Sapiente quaerat at illum perspiciatis laudantium nulla 
                    praesentium, necessitatibus voluptatibus labore beatae 
                    aliquam voluptas sint explicabo assumenda nihil odio 
                    ipsum commodi ut veniam rem! Perspiciatis numquam eveniet, 
                    cupiditate tenetur quisquam molestiae, excepturi in fugiat 
                    corporis odio eum doloremque dolore aliquam consequatur iusto.
                </p>
            </div>
        </div>
    </div>
    <div class="mini-nav">
        <a href="Candidate_details.php"><h4><i class='bx bx-chevron-left-circle'></i> Previous Candidate</h4> </a>
        <a href="Candidate_details.php"><h4>Next Candidate <i class='bx bx-chevron-right-circle'></i></h4></a>
    </div>

    <!--FOOTER START-->
    <?php require_once 'Footer.php'; ?>
    <!--FOOTER END-->

</body>
</html>