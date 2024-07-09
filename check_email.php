<?php
ob_start();


include ("config.php");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$email = isset($data['email']) ? $data['email'] : '';
$isAvailable = true; // Flag to track email availability

// Check for email in organizer table
$sqlOrganizer = "SELECT * FROM organizer_tb WHERE organizerEmail = '$email'";
$resultOrganizer = mysqli_query($conn, $sqlOrganizer);

if (mysqli_num_rows($resultOrganizer) > 0) {
    $isAvailable = false;
    $emailTakenMessage = "This email is already registered as an organizer.";
}

// Check for email in attendee table (if email wasn't found in organizer table)
if ($isAvailable) {
    $sqlAttendee = "SELECT * FROM attendee_tb WHERE attendeeEmail = '$email'";
    $resultAttendee = mysqli_query($conn, $sqlAttendee);

    if (mysqli_num_rows($resultAttendee) > 0) {
        $isAvailable = false;
        $emailTakenMessage = "This email is already registered as an attendee.";
    }
}

$data = array("email" => $email, "available" => $isAvailable,"message" => $isAvailable ? 'Email available.' : $emailTakenMessage);
header('Content-Type: application/json');
echo json_encode($data);
ob_end_flush();