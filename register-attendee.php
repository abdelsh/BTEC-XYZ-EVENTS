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
    <title>Create attendee account</title>

    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style.css">
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
        <!-- registration form start -->
        <div class="container-w-border">
            <div class="form-space">
                <div class="form-logo">
                    <img src="xyz events logo.png" alt="">
                </div>
                <div class="form-title">
                    <h1>Create as an attendee and explore amazing events.</h1>
                </div>

                <div class="form-section">
                    <form action="insert-attendee.php" method="POST">
                        <label for="name">Name</label> <br>
                        <input type="text" name="name" id="name" required> <br>
                        
                        <label for="phonenumber" required>Phone Number</label> <br>
                        <input type="number" name="phonenumber" id="phonenumber" required> <br>
                        
                        <label for="email">Email</label>
                        <span id="email-availability"></span> <br>
                        <input type="email" name="email" id="email" required> <br>
                        
                        <label for="pass">Password</label><span id="password-strength"></span><br>
                        <input type="password" name="pass" id="pass" required> <br>
                        <div class="login-btns">
                            <input class="submit-btn" type="submit" value="Register" name="submit" class="submit-btn" id="submit-btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- registration form end -->

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

    <!-- Script section start -->
    <script src="password-validation.js"></script>
    <script src="available-email.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="app.js"></script> -->
    <!-- Script section end -->
</body>

</html>

<?php
include ("config.php");


$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
$phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';

$isAvailable = true; // Flag to track email availability

// For Inserting Data to Database
if ($_POST['submit']) {

    $sql = "INSERT INTO attendee_tb (attendeeName,attendeeEmail,attendeePhoneNumber,attendeePassword)
        VALUES ('$name', '$email','$phonenumber','$pass')";

    $result = mysqli_query($conn, $sql);



    // In case I would like to transfer to another page I should add the if like this.

    if ($result == true) {
        header('Location: dashboard.php');
        exit();
    }
}

?>