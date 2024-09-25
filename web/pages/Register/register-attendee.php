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
                    <h1>Create an attendee account to explore amazing events.</h1>
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
                <div class="registration-link">
                    <h4>Do you have an account? <a href="/btec/web\pages\Login\login.php"> Log In</a>.</h4>
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

    <!-- Script section start -->
    <script src="/BTEC/web\js\password-validation.js"></script>
    <script src="/BTEC/web\js\available-email.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="app.js"></script> -->
    <!-- Script section end -->
</body>

</html>

<?php
include ("/BTEC/config.php");


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