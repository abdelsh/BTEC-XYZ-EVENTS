<?php
session_start();
if (isset($_SESSION["email"])) {
    header("location: index.php");
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | XYZ Events</title>

    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>

</head>

<body>
    <!-- Navigation Bar Starts -->
    <div class="navigationBar">
        <nav>
            <div class="leftSection">
                <img onclick="window.location.href='index.php'" class="logoNav" src="xyz events logo.png" alt="">
            </div>
            <div class="middleSection">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="">EVENTS</a></li>
                    <li><a href="">SERVICES</a></li>
                    <li><a href="#foot">CONTACT US</a></li>
                </ul>
            </div>
            <div class="rightSection">
                <ul>
                    <li><a href="login.php" class="btn btn-primary">Login</a></li>
                    <li><a href="register.php" class="btn btn-success">Register</a></li>
                    <li><label for="showHiddenNav"><i class="fa-solid fa-bars"></i></label></li>
                </ul>
            </div>

        </nav>
        <input type="checkbox" name="hdnNav" id="showHiddenNav">
        <div class="hiddenNavBar">
            <ul>
                <li><a href="index.php">HOME</a></li> <br>
                <li><a href="">EVENTS</a></li> <br>
                <li><a href="">SERVICES</a></li> <br>
                <li><a href="">CONTACT US</a></li> <br>
                <li><a href="login.php" class="btn btn-primary">Login</a></li><br>
                <li><a href="register.php" class="btn btn-success">Register</a></li>
            </ul>
        </div>
    </div>
    <!-- Navigation Bar End -->

    <main>
        <!-- login form start -->
        <div class="container-w-border">
            <div class="form-space">
                <div class="form-logo">
                    <img src="xyz events logo.png" alt="">
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
                    <h4>still don't have an account? <a href="register.php"> Register here</a>.</h4>
                </div>
            </div>
        </div>
        <!-- login form end -->
    </main>


    <!-- Footer starts -->
    <footer id="foot">
        <div class="insideFooter">
            <div class="footerLeft">
                <img onclick="window.location.href='index.php'" src="xyz events logo.png" alt="">
            </div>

            <div class="footerMid">
                <h1>CONTACT</h1>
                <h4><i class="fa-solid fa-location-pin"></i> Amman, Jordan</h4>
                <h4><i class="fa-solid fa-phone"></i> phonenumber</h4>
                <h4><i class="fa-solid fa-envelope"></i> email</h4>
                <h4><i class="fa-regular fa-clock"></i> 9 am - 5pm</h4>
            </div>

            <div class="footerRight">
                <h1>ABOUT</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit quia praesentium dolores
                    ab, perspiciatis eum itaque repellendus tempore iure facere, possimus sunt quos accusantium ea
                    labore error deleniti dolor cumque?</p>
            </div>
        </div>

        <div class="copyright">
            <div class="left">
                <p>copyright © 2024 | xyz events by abdelsh</p>
            </div>

            <div class="right">
                <a href="index.php">Home</a>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
                <a href="">events</a>
            </div>


        </div>
    </footer>
    <!-- Footer ends -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="app.js"></script>
</body>

</html>