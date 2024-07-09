<?php

include ("config.php");

if (isset($_POST["logIn"])) {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["pass"]) ? $_POST["pass"] : "";

    $sql = "SELECT * FROM ";

    $notfound = true;

    // Check for email in organizer table
    $sqlOrganizer = "SELECT * FROM organizer_tb WHERE organizerEmail = '$email' and organizerPassword = '$password'";
    $resultOrganizer = mysqli_query($conn, $sqlOrganizer);

    if (mysqli_num_rows($resultOrganizer) > 0) {
        $notfound = false;
        session_start();
        $row = $resultOrganizer->fetch_assoc();
        $_SESSION['email'] = $row['organizerEmail'];
        $_SESSION['organizerID'] = $row['organizerID'];
        header("Location: dashboard.php");
        exit();
    }

    // Check for email in attendee table (if email wasn't found in organizer table)
    if ($notfound) {
        $sqlAttendee = "SELECT * FROM attendee_tb WHERE attendeeEmail = '$email' and attendeePassword = '$password'";
        $resultAttendee = mysqli_query($conn, $sqlAttendee);

        if (mysqli_num_rows($resultAttendee) > 0) {
            $notfound = false;
            session_start();
            $row = $resultAttendee->fetch_assoc();
            $_SESSION['email'] = $row['attendeeEmail'];
            $_SESSION['userID'] = $row['attendeeID'];
            header("Location: index.php");
            exit();
        }
    }

    // Login failed
    session_start();
    $_SESSION['login_error'] = "Invalid email or password.";
    header("Location: login1.php"); // Redirect back to login page
    exit();
}
