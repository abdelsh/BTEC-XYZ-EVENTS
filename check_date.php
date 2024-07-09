<?php
ob_start();


include ("config.php");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$date = isset($data['date']) ? $data['date'] : '';
$isAvailable = true; // Flag to track email availability

// Check for email in organizer table
$sqlOrganizer = "SELECT * FROM events_tb WHERE eventDate = '$date'";
$result = mysqli_query($conn, $sqlOrganizer);

if (mysqli_num_rows($result) > 0) {
    $isAvailable = false;
    $emailTakenMessage = "This date is already taken.";
}

$data = array("date" => $date, "available" => $isAvailable,"message" => $isAvailable ? 'Date available.' : $emailTakenMessage);
header('Content-Type: application/json');
echo json_encode($data);
ob_end_flush();