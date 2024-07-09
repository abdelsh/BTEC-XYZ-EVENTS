<?php
session_start();
include ("config.php");

$organizerID = isset($_SESSION['organizerID']) ? $_SESSION['organizerID'] : '';
$eventname = isset($_POST['eventname']) ? $_POST['eventname'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$capacity = isset($_POST['capacity']) ? $_POST['capacity'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$filename = isset($_FILES['img']["name"]) ? $_FILES['img']["name"] : '';
$tempname = isset($_FILES['img']["tmp_name"]) ? $_FILES['img']["tmp_name"] : '';
$timestamp = date('YmdHis');
$newFilename = $timestamp . "_" . $filename;
$folder = "./eventImages/" . $newFilename;

// $folder = 
// For Inserting Data to Database
if (isset($_POST['submit'])) {
    if ($_POST['submit']) {
        $sql = "INSERT INTO events_tb (eventName,eventDescription,eventLocation,eventDate,eventType,eventImage,eventOrganizer)
    VALUES ('$eventname', '$description','$location','$date','$type','$newFilename', '$organizerID')";

        $result = mysqli_query($conn, $sql);

        move_uploaded_file($tempname, $folder);

        $version = 1;
        while (file_exists($folder)) {
            $newFilename = preg_replace('/\.[^.]+$/', ".$version." . '$1', $newFilename);
            $folder = "./eventImages/" . $newFilename;
            $version++;
        }

        // Check if the directory exists, create it if not
        if (!file_exists("./eventImages")) {
            mkdir("./eventImages", 0755, true); // Create directory with permissions
        }

        // Now let's move the uploaded image into the folder: image
        if (move_uploaded_file($newFilename, $folder)) {
            echo "<h3>  Image uploaded successfully!</h3>";
        } else {
            echo "<h3>  Failed to upload image!</h3>";
        }


        // Handle insert success or failure
        if ($result) {
            $eventId = mysqli_insert_id($conn);

            $ticketNames = $_POST['ticketName'];
            $ticketDescriptions = $_POST['ticketDescription'];
            $ticketPrices = $_POST['ticketPrice'];
            $ticketQuantity = $_POST['ticketQuantity'];

            // Validate input data (optional, loop and check each element)
            // ... (similar validation logic as before)

            // if ($validInput) {  // Proceed with saving if all inputs are valid
            $sql = "INSERT INTO ticketprice (eventID,ticketName,ticketDescription,price,ticketQuantity) VALUES ";
            $valueStrings = "";

            for ($i = 0; $i < count($ticketNames); $i++) {
                $name = mysqli_real_escape_string($conn, $ticketNames[$i]); // Escape user input
                $description = mysqli_real_escape_string($conn, $ticketDescriptions[$i]);
                $price = floatval($ticketPrices[$i]); // Convert to float for price
                $quantity = $ticketQuantity[$i];

                $valueStrings .= "('$eventId', '$name', '$description', '$price', '$quantity'),";

            }

            // Remove trailing comma from value strings
            $valueStrings = rtrim($valueStrings, ",");

            $sql .= $valueStrings;  // Append constructed value strings

            $result = mysqli_query($conn, $sql);


            $sql_ticketQuantity = "SELECT SUM(ticketQuantity) AS totalQuantity FROM ticketprice WHERE eventID = '$eventId'";
            $result_ticketQuantity = mysqli_query($conn, $sql_ticketQuantity);

            if ($result_ticketQuantity) {
                $row = mysqli_fetch_assoc($result_ticketQuantity);

                // Check if a row was returned (meaning there are tickets for the event)
                if ($row) {
                    $eventCapacity = $row["totalQuantity"];
                } else {
                    $eventCapacity = 0; // Set to 0 if no tickets found
                }
            } else {
                echo "Error fetching ticket quantities: " . mysqli_error($conn);
            }

            // Update event capacity (assuming you have an `events_tb` table)
            $sql_eventCapacity = "UPDATE events_tb SET eventCapacity = '$eventCapacity' WHERE eventID = '$eventId'";
            $result_eventCapacity = mysqli_query($conn, $sql_eventCapacity);

            if ($result_eventCapacity) {
                echo "Event capacity updated successfully!";
            } else {
                echo "Error updating event capacity: " . mysqli_error($conn);
            }

        } else {
            echo "<h1>Error creating event: " . mysqli_error($conn) . "</h1>";
        }

        header("location: dashboard.php");
        exit();
    }

}
?>