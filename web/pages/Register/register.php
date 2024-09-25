<?php
session_start();
if (isset($_SESSION["email"])) {

    header("location: /BTEC/");
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | XYZ Events</title>

    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <!-- Navigation Bar Starts -->
    <?php
    include("../..\includes\header.php");
    ?>
    <!-- Navigation Bar End -->

    <main>

        <!-- registration form start -->
        <div class="container-w-border">
            <div class="form-space">
                <div class="form-logo">
                    <img src="../../assets/xyz events logo.png" alt="">
                </div>
                <div class="form-title">
                    <h1>What type of account do you want to create?</h1>
                </div>

                <div class="form-section center-gap">
                    <form class="login-btns " action="register-business.php" method="GET">
                        <button class="submit-btn" type="submit">Register as company</button>
                    </form>
                    <form class="login-btns " action="register-attendee.php" method="GET">
                        <button class="submit-btn" type="submit">Register as attendee</button>
                    </form>
                </div>
                <div class="registration-link">
                    <h4>already have an account? <a href="login.php"> Log In here</a>.</h4>
                </div>
            </div>
        </div>
        <!-- registration form end -->

    </main>

    <!-- Footer starts -->
    <?php
    include('../..\includes\footer.php');
    ?>
    <!-- Footer ends -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="app.js"></script>
</body>

</html>