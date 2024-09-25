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
    <title>Login | XYZ Events</title>

    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php
    include("../..\includes\header.php");
    ?>

    <main>
        <!-- login form start -->
        <div class="container-w-border">
            <div class="form-space">
                <div class="form-logo">
                    <img src="../../assets/xyz events logo.png" alt="">
                </div>
                <div class="form-title">
                    <h1>Welcome back to XYZ Events</h1>
                    <?php
                    // Include error message if login fails (from login-check.php)
                    if (isset($_SESSION['login_error'])) {
                        echo "<p style='color: red'>" . $_SESSION['login_error'] . "</p>";
                        unset($_SESSION['login_error']); // Clear error for next attempt
                    }
                    // session_abort();
                    session_destroy();
                    ?>
                </div>

                <div class="form-section">

                    <form action="login-check.php" method="POST">
                        <label for="lgn-email">Email</label> <br>
                        <input type="email" name="email" id="lgn-email"> <br>
                        <label for="lgn-pass">Password</label> <br>
                        <input type="password" name="pass" id="lgn-pass"><br>
                        <div class="login-btns">
                            <button class="submit-btn" type="submit" name="logIn">Log In</button>
                        </div>
                    </form>
                </div>
                <div class="registration-link">
                    <h4>still don't have an account? <a href="/BTEC/web\pages\Register\register.php"> Register here</a>.</h4>
                </div>
            </div>
        </div>
        <!-- login form end -->
    </main>


    <?php
    include('../..\includes\footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="app.js"></script>
</body>

</html>