<?php
include ("../../../config.php");


$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
$phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';

// For Inserting Data to Database
if ($_POST['submit']) {

    $sql = "INSERT INTO attendee_tb (attendeeName,attendeeEmail,attendeePhoneNumber,attendeePassword)
        VALUES ('$name', '$email','$phonenumber','$pass')";

    $result = mysqli_query($conn, $sql);



    // In case I would like to transfer to another page I should add the if like this.

    if ($result == true) {
        header('Location: /BTEC/');
        exit();
    }
}