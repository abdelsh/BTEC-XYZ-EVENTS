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
    <title>Create business account</title>

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
                    <h1>Create an business account and start managing events</h1>
                </div>

                <div class="form-section">
                    <form action="register-business.php" method="POST">
                        <label for="name">Name</label> <br>
                        <input type="text" name="name" id="name"> <br>

                        <label for="phonenumber">Phone Number</label> <br>
                        <input type="number" name="phonenumber" id="phonenumber"> <br>

                        <label for="companyname">Company Name</label> <br>
                        <input type="text" name="companyname" id="companyname"> <br>

                        <label for="email">Email</label>
                        <span id="email-availability"></span> <br>
                        <input type="email" name="email" id="email"> <br>

                        <label for="pass">Password</label>
                        <span id="password-strength"></span> <br>
                        <input type="password" name="pass" id="pass"> <br> <br>

                        <div class="login-btns">
                            <input type="submit" value="Register"name="submit" class="submit-btn">
                            <!-- <button class="submit-btn" type="submit" >Log In</button> -->
                        </div>
                    </form>
                </div>
                <div class="registration-link">
                    <h4>still don't have an account? <a href="login.html"> Register here</a>.</h4>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="app.js"></script>
    <script src="password-validation.js"></script>
    <script src="available-email.js"></script>
</body>

</html>

<?php
include ("config.php");


// For Inserting Data to Database

if ($_POST['submit']) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
    $phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
    $companyname = isset($_POST['companyname']) ? $_POST['companyname'] : '';

    $sql = "INSERT INTO organizer_tb (organizerName,organizerEmail,organizerPhoneNumber,organizerPassword,organizerCompany)
    VALUES ('$name', '$email','$phonenumber','$pass','$companyname')";

$result = mysqli_query($conn, $sql);

//In case I would like to transfer to another page I should add the if like this.

// if($result == true){
//     echo "<p style='color:white'>Records Added to DB</p>";
//     echo "<br>";
// }else{
//     echo "<p style='color:white'>Faild</p>";
// }
}


?>