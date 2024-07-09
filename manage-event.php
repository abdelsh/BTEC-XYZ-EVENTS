<?php
session_start();
include ("config.php");

// Check if a session email exists, otherwise redirect to login
if (!isset($_SESSION["email"])) {
    header('location: index.php');
    exit();
}

// Validate event ID from GET parameter, handle potential errors
if (isset($_GET["eventID"])) {
    $event_id = intval($_GET["eventID"]); // Convert to integer for security

    // Check if event ID exists in database
    $query = "SELECT * FROM events_tb WHERE eventID = '$event_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 0) {
        // Event not found, handle error (e.g., display message, redirect)
        echo "<h1>Event not found!</h1>";
        exit();
    }
} else {
    // Missing event ID, handle error (e.g., display message, redirect)
    echo "<h1>Missing event ID!</h1>";
    exit();
}

// Extract original filename only if necessary (avoid extra query)
$originalFilename = "";
if (isset($_POST['update']) && $_POST['update']) { // Check for update submission
    $query = "SELECT eventImage FROM events_tb WHERE eventID = '$event_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result); // Use mysqli_fetch_assoc for efficiency
    if ($row) {
        $originalFilename = $row['eventImage'];
    }
}

// Handle form submission (update event)
if (isset($_POST['update']) && $_POST['update']) {
    $eventname = mysqli_real_escape_string($conn, $_POST['eventname']); // Escape user input
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $capacity = intval($_POST['capacity']); // Convert to integer for validation
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $filename = $_FILES['img']['name'];

    // Handle image upload (optional, conditional logic)
    $newFilename = "";
    $hasImageUpload = isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK; // Check for valid upload
    if ($hasImageUpload) {

        // Generate new filename with timestamp (optional)
        $timestamp = date('YmdHis'); // Generate current timestamp
        $newFilename = $timestamp . "_" . $filename;

        // Validate image type (optional)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']; // Adjust as needed
        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            echo "<h1>Invalid image type!</h1>";
            exit();
        }

        // Generate a unique filename if necessary (e.g., prevent overwrites)
        $version = 1;
        while (file_exists("./eventImages/" . $newFilename)) {
            $newFilename = preg_replace('/\.[^.]+$/', ".$version." . '$1', $newFilename);
            $version++;
        }

        // Create image directory if it doesn't exist
        if (!file_exists("./eventImages")) {
            mkdir("./eventImages", 0755, true); // Create directory with permissions
        }

        // Upload image and handle potential errors
        $uploadPath = "./eventImages/" . $newFilename;
        $uploadSuccessful = move_uploaded_file($_FILES['img']['tmp_name'], $uploadPath);
        if (!$uploadSuccessful) {
            echo "<h1>Image upload failed!</h1>";
            exit();
        }
    } else { // Use existing image if no upload
        $newFilename = $originalFilename; // Maintain existing filename
    }

    // Update event in database
    $sql = "UPDATE events_tb SET
          eventName = '$eventname',
          eventDescription = '$description',
          eventLocation = '$location',
          eventDate = '$date',
          eventCapacity = '$capacity',
          eventType = '$type',
          eventImage = '$newFilename'
        WHERE eventID = '$event_id'";

    $result = mysqli_query($conn, $sql);

    // Validate form submission and data (assuming all forms are submitted)
    if (isset($_POST['ticketId']) && isset($_POST['ticketName']) && isset($_POST['ticketDescription']) && isset($_POST['ticketPrice'])) {
        $ticketIds = $_POST['ticketId'];  // Array of ticket IDs
        $ticketNames = $_POST['ticketName'];  // Array of ticket names
        $ticketDescriptions = $_POST['ticketDescription'];  // Array of descriptions
        $ticketPrices = $_POST['ticketPrice'];  // Array of prices
        $ticketQuantity = $_POST['ticketQuantity'];

        $updatesSuccessful = true;  // Flag to track success


        // Loop through each ticket and update information
        for ($i = 0; $i < count($ticketIds); $i++) {
            $id = intval($ticketIds[$i]);
            $name = mysqli_real_escape_string($conn, $ticketNames[$i]);
            $description = mysqli_real_escape_string($conn, $ticketDescriptions[$i]);
            $price = floatval($ticketPrices[$i]);
            $quantity = $ticketQuantity[$i];

            $sql = "UPDATE ticketprice SET 
                ticketName = '$name',
                ticketDescription = '$description',
                Price = '$price',  
                ticketQuantity = '$quantity' WHERE ticketID = '$id'";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                $updatesSuccessful = false;
                break;  // Exit loop on first error
            }
        }

        
            $sql_ticketQuantity = "SELECT SUM(ticketQuantity) AS totalQuantity FROM ticketprice WHERE eventID = '$event_id'";
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
            $sql_eventCapacity = "UPDATE events_tb SET eventCapacity = '$eventCapacity' WHERE eventID = '$event_id'";
            $result_eventCapacity = mysqli_query($conn, $sql_eventCapacity);

            if ($result_eventCapacity) {
                echo "Event capacity updated successfully!";
            } else {
                echo "Error updating event capacity: " . mysqli_error($conn);
            }
        

    }

    // Handle update success or failure
    if ($result_eventCapacity) {
        header("location: dashboard.php");
        exit();
        // Optional: Redirect back to a relevant page (e.g., event details)
    } else {
        echo "<h1>Error updating event: " . mysqli_error($conn) . "</h1>";
    }

    // Close connection (optional, consider using mysqli_close() at script end)
    mysqli_close($conn);

    exit(); // Exit after update processing
} else {
    // Event details query (assuming you want to pre-fill the form)
    $query = "SELECT * FROM events_tb WHERE eventID = '$event_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}


if (isset($_POST['add-ticket']) && $_POST['add-ticket']) {
    $ticketName = $_POST['ticketName'];
    $ticketDescription = $_POST['ticketDescription'];
    $ticketPrice = $_POST['ticketPrice'];
    $ticketQuantity = $_POST['ticketQuantity'];


    // if ($validInput) {  // Proceed with saving if all inputs are valid
    $sql = "INSERT INTO ticketprice (eventID,ticketName,ticketDescription,price,ticketQuantity) VALUES ('$event_id', '$ticketName', '$ticketDescription', '$ticketPrice', '$ticketQuantity')";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql_ticketQuantity = "SELECT SUM(ticketQuantity) AS totalQuantity FROM ticketprice WHERE eventID = '$event_id'";
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
        $sql_eventCapacity = "UPDATE events_tb SET eventCapacity = '$eventCapacity' WHERE eventID = '$event_id'";
        $result_eventCapacity = mysqli_query($conn, $sql_eventCapacity);

        if ($result_eventCapacity) {
            echo "Event capacity updated successfully!";
        } else {
            echo "Error updating event capacity: " . mysqli_error($conn);
        }
    }

    header("location: manage-event.php?eventID=$event_id");
    exit();

}

// if (isset($_POST['cancel']) && $_POST['cancel']) {
//     header('location: dashboard.php');
//     exit(); 
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
                    <?php
                    if (isset($_SESSION["email"])) {
                        // User is logged in, show logout button
                        echo "<li><a href='logout.php' class='btn btn-danger'>Logout</a></li>";
                        $email = $_SESSION["email"];
                        $query = mysqli_query($conn, "SELECT * FROM organizer_tb WHERE organizerEmail='$email'");

                        if ($query->num_rows > 0) {
                            echo "<li><a href='dashboard.php'>Dashboard</a></li>";
                        } else {
                            echo "<li><a href='profile.php'>PROFILE</a></li>";
                            echo "<li onclick='showCart()'>CART</li>";
                        }
                    } else {
                        // User is not logged in, show login/register options
                        echo '<li><a href="login.php" class="btn btn-primary">Login</a></li>';
                        echo '<li><a href="register.php" class="btn btn-success">Register</a></li>';
                    } ?>
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
                <?php
                if (isset($_SESSION["email"])) {
                    $email = $_SESSION["email"];
                    $query = mysqli_query($conn, "SELECT * FROM organizer_tb WHERE organizerEmail='$email'");

                    if ($query->num_rows > 0) {
                        echo "<li><a href='dashboard.php'>DASHBOARD</a></li><br>";
                    } else {
                        echo "<li><a href='profile.php'>PROFILE</a></li><br>";
                        echo "<li onclick='showCart()'>CART</li><br>";
                    }
                    echo "<li><a href='logout.php'>Logout</a></li><br>";
                } else {
                    echo '<li><a href="login.php" class="btn btn-primary">Login</a></li><br>';
                    echo '<li><a href="register.php" class="btn btn-success">Register</a></li>';
                } ?>
            </ul>
        </div>
    </div>
    <!-- Navigation Bar End -->

    <!-- Create event section Start -->



    <div class="create-event-section">
        <div class="create-event-container">
            <div class="create-event-form">
                <form action="" enctype="multipart/form-data" method="POST">
                    <?php
                    // Display event details or form based on update logic (optional)
                    if (isset($_POST['update']) && !$_POST['update']) { // Update submitted, display success message
                        echo "<h1>Event updated successfully!</h1>";
                    } else if (isset($row)) { // Event details retrieved, display update form
                        echo "<label for=''>Insert the event image </label><br>";
                        echo "<span style='color: white' id='img-name-span'>" . preg_replace('/\d{14}_/', '', $row['eventImage']) . "</span>";
                        echo "<input type='file' name='img' id='img-name' required value='" . $row['eventImage'] . "'><br>";

                        echo "<label for=''>Event Name: </label>";
                        echo "<input type='text' name='eventname' required value='" . $row['eventName'] . "'><br>";

                        echo "<label for=''>Event Description: </label>";
                        echo "<textarea name='description' id='' required>" . $row['eventDescription'] . "</textarea><br>";

                        echo "<label for=''>Event Location: </label>";
                        echo "<input type='text' name='location' required value='" . $row['eventLocation'] . "'><br>";

                        echo "<label for=''>Event Date: </label>";
                        echo "<input type='date' name='date' required value='" . $row['eventDate'] . "'><br>";

                        echo "<input type='hidden' name='capacity' required value='" . $row['eventCapacity'] . "'><br>";

                        echo "<label for=''>Event Type: </label>";
                        echo "<input type='text' name='type' required value='" . $row['eventType'] . "'><br>";

                        echo "<div>";

                        echo "<div id='ticket-options'>";
                        echo "<h2>Add Ticket Options</h2>";

                        $tickets_result = mysqli_query($conn, "SELECT * FROM ticketprice WHERE eventID = '$event_id'");
                        while ($ticket_details = mysqli_fetch_array($tickets_result)) {
                            echo "<input type='hidden' name='ticketId[]' value='" . $ticket_details['ticketID'] . "' >";
                            echo "<div class='ticket-option'>";
                            echo "<label for='ticketName'>Ticket Name:</label>";
                            echo "<input type='text' name='ticketName[]' id='ticketName' value='" . $ticket_details['ticketName'] . "' required>";

                            echo "<label for='ticketPrice'>Ticket Price:</label>";
                            echo "<input type='number' name='ticketPrice[]' id='ticketPrice' value='" . $ticket_details['Price'] . "' min='0' required>";

                            echo "<label for='ticketDescription'>Ticket Description:</label>";
                            echo "<input type='text' name='ticketDescription[]' id='ticketDescription' value='" . $ticket_details['ticketDescription'] . "' required>";

                            echo "<label for='ticketPrice'>Ticket Quantity:</label>";
                            echo "<input type='number' name='ticketQuantity[]' id='ticketQuantity' value='" . $ticket_details['ticketQuantity'] . "' min='0' required>";

                            echo "</div>";
                        }
                        echo "</div>";
                        echo "<input type='submit' value='UPDATE' name='update'>";
                        echo "<input type='button' href='dashboard.php' value='Cancel' id='cancel'>";
                        echo "</div>";
                    } else {
                        // Event not found or other error condition (optional, display error message)
                        echo "<h1>Error: Event not found or other issue!</h1>";
                    }
                    ?>
                </form>
                <form action="manage-event.php?eventID=<?php echo $event_id; ?>" method="POST">
                    <div id="ticket-options">
                        <h2>Add Ticket Options</h2>
                        <h4>Please add each ticket separately.</h4>
                        <div class="ticket-option">
                            <label for="ticketName">Ticket Name:</label>
                            <input type="text" name="ticketName" id="ticketName" required>

                            <label for="ticketPrice">Ticket Price:</label>
                            <input type="number" name="ticketPrice" id="ticketPrice" min="0" required>

                            <label for="ticketDescription">Ticket Description:</label>
                            <input type="text" name="ticketDescription" id="ticketDescription" min="0" required>

                            <label for="ticketPrice">Ticket Quantity:</label>
                            <input type="number" name="ticketQuantity" id="ticketQuantity" min="0" required>
                        </div>
                    </div>
                    <div>
                        <input type="submit" value="Add Ticket" name="add-ticket">
                        <input type="reset" value="Cancel">
                    </div>
                </form>
            </div>
        </div>
    </div>
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

    <!-- Script Scetion Start -->
    <script src="value-name.js"></script>
    <script src="validate-form.js"></script>

    <!-- Script Scetion End -->


    <script type="text/javascript">
        document.getElementById("cancel").onclick = function () {
            location.href = "dashboard.php";
        };
    </script>
    <script>
        document.getElementById('add-ticket-option').addEventListener('click', function () {
            // Create a new ticket option element
            var newTicketOption = document.createElement('div');
            newTicketOption.classList.add('ticket-option');

            // Clone the existing ticket option content
            var existingOption = document.querySelector('.ticket-option');
            var newContent = existingOption.innerHTML;

            // Add the cloned content to the new ticket option
            newTicketOption.innerHTML = newContent;

            // Clear the values of the cloned input fields
            var inputs = newTicketOption.querySelectorAll('input');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }

            // Append the new ticket option to the container
            document.getElementById('ticket-options').appendChild(newTicketOption);
        });
    </script>

</body>

</html>