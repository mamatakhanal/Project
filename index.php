<?php
    require_once 'elestatus.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOTE</title>

<!-- GOOGLE FONTS -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- QUICKSAND -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

<!-- CSS LINK
    <link rel="stylesheet" href="grid.css">
 -->
<link rel="stylesheet" href="style.css">

<!-- BOX ICON -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>

    <!--Banner Start-->
    <div class="banner">
        <?php require_once 'header.php'; ?>
        <div class="banner-caption">
            <h1>The vote is the most powerful nonviolent tool we have.</h1>
            <p>Vote is a secure online voting platform that makes it easy to run  elections at a fraction of usual cost. When we vote, we take back our power to choose, to speak up, and to stand with those who support us and each other.</p>
        </div>
    </div>
    <!--Banner End-->

    
    <div class="container">

        <!--GRID CONTENTS BEGIN-->

        <h3>Your elections, Any device, Any location</h3>

        <div class="grid-container">
            <div class="grid-item">
                <img src="images/Key.png" alt="key">
                <p>SECURE VOTING</p>
            </div>
            <!-- <div class="grid-item">
                <img src="images/Mobile.png" alt="mobile">
                <p>MOBILE READY</p>
            </div> -->
            <div class="grid-item">
                <img src="images/count.png" alt="tally">
                <p>RESULTS TABULATION</p>
            </div>
        </div>

        <hr>

        <div class="grid-container">
            <div class="grid-item">
                <a href="voter_register.php">
                    <img src="images/register.png" alt="register">
                    <p>REGISTER</p>
                </a>
            </div>
            <div class="grid-item">
                <a href="election.php">
                    <img src="images/election.png" alt="election">
                    <p>ELECTIONS</p>
                </a>
            </div>
            <!-- <div class="grid-item">
                <a href="result.php">
                    <img src="images/Results.png" alt="results">
                    <p>RESULTS</p>
                </a>
            </div>         -->
        </div>
        <hr>
        <div class="grid-container">
            <div class="grid-item">
                <a href="https://youtu.be/6B5bIWUenBY" target="_blank">
                    <img src="images/HTR.png" alt="howtoregister">
                    <p>HOW TO REGISTER</p>
                </a>
            </div>
            <div class="grid-item">
                <a href="https://youtu.be/u32dJKtrfRM" target="_blank">
                    <img src="images/HTV.png" alt="howtovote">
                    <p>HOW TO VOTE</p>
                </a>
            </div>
            <!-- <div class="grid-item">
                <a href="#">
                    <img src="images/faqs.png" alt="faqs">
                    <p>FAQs</p>
                </a>
            </div> -->
        </div>
        <!--GRID CONTENTS END-->
    </div>   
    
    <!--LINKS AND ALL START-->
    <div class="additional-links">
        <div class="grid-col">
            <h4>Additional Links</h4>
            <ul>
                <li>FAQs</li>
                <li>Voting</li>
                <li>News</li>
                <li>Events</li>
                <li>Privacy</li>
            </ul>
            <a href="https://www.facebook.com/">
                <i class='bx bxl-facebook-circle'></i>
            </a>
            <a href="https://www.instagram.com">
                <i class='bx bxl-instagram'></i>
            </a>
            <a href="https://www.twitter.com">
                <i class='bx bxl-twitter'></i>
            </a>
            <a href="https://www.youtube.com">
                <i class='bx bxl-youtube'></i>
            </a>
        </div>
        <div class="grid-col">
            <h4>Contact Us</h4>
            <table>
                <tr>
                    <td><i class='bx bx-location-plus'></i></td>
                    <td>Bagbazar, Kathmandu</td>
                </tr>
                <tr>
                    <td><i class='bx bx-envelope'></td>
                    <td>pkmc@gmail.com</td>
                </tr>
                <tr>
                    <td><i class='bx bx-phone'></i></td>
                    <td>977-01-5321712<br>977-01-5343758</td>
                </tr>
                <tr>
                    <td><i class='bx bx-globe'> </i></td>
                    <td>www.pkcampus.edu.np</td>
                </tr>
            </table>
        </div>
    </div>
    <!--LINKS AND ALL END-->

    <!--FOOTER START-->
    <?php require_once 'Footer.php'; ?>
    <!--FOOTER END-->

</body>
</html>