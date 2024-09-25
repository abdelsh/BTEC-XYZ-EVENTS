<?php
session_start();
include ('../../../../config.php');
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
    $query = mysqli_query($conn, "SELECT * FROM organizer_tb WHERE organizerEmail='$email'");

    if ($query->num_rows > 0) {
        $row = mysqli_fetch_array($query);
        $organizerID = $row['organizerID'];
    } else {
        header('location: /BTEC/');
        exit();
    }

} else {
    header('location: /BTEC/');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../../css/style.css">
</head>

<body>
    <!-- Navigation Bar Starts -->
    <?php include ('../../../includes/header.php') ?>
    <!-- Navigation Bar End -->

    <!-- Create event section Start -->
    <div class="create-event-section">
        <div class="create-event-container">
            <div class="create-event-form">
                <form action="insert-event.php" enctype="multipart/form-data" method="POST" autocomplete="off"
                    onsubmit="validateForm()">
                    <label for="">Insert the event image </label><br>
                    <span id="img-name-span"></span>
                    <input type="file" name="img" id="img-name" required><br>

                    <label for="">Event Name: </label>
                    <input type="text" name="eventname" required><br>

                    <label for="">Event Description: </label>
                    <textarea name="description" id="" required></textarea><br>

                    <label for="">Event Location: </label>
                    <input type="text" name="location" required><br>

                    <label for="">Event Date: </label>
                    <input type="date" name="date" id="date" required> <span id="date-span"></span><br>

                    <!-- <label for="">Event Capacity: </label>
                    <input type="text" name="capacity" required><br> -->

                    <label for="">Event Type: </label>
                    <input type="text" name="type" required><br>


                    <div id="ticket-options">
                        <h2>Add Ticket Options</h2>
                        <div class="ticket-option">
                            <label for="ticketName">Ticket Name:</label>
                            <input type="text" name="ticketName[]" id="ticketName" required>

                            <label for="ticketDescription">Ticket Description:</label>
                            <input type="text" name="ticketDescription[]" id="ticketDescription" min="0" required>

                            <label for="ticketPrice">Ticket Price:</label>
                            <input type="number" name="ticketPrice[]" id="ticketPrice" min="0" required>

                            <label for="ticketPrice">Ticket Quantity:</label>
                            <input type="number" name="ticketQuantity[]" id="ticketQuantity" min="0" required>
                        </div>
                    </div>
                    <button type="button" id="add-ticket-option">+</button>
                    <button type="button" id="remove-ticket-option">remove</button>

                    <div>
                        <input type="submit" value="Create" name="submit">
                        <input type="reset" value="Cancel">
                    </div>
                </form>
            </div>

        </div>

    </div>
    <!-- Create event section End -->

    <div class="eventCardsSection">

        <?php
        $query = "SELECT * FROM events_tb WHERE eventOrganizer = '$organizerID'";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            // echo "<img width='100px' src='./eventImages/".$row['eventImage']."'>";
        
            echo "<div class='cardIndexPage'>";
            echo "<div class='cardThumbnailSection'>";
            echo "<img class='cardThumbnail' src='../../../../eventImages/" . $row['eventImage'] . "'>";
            echo "</div>";


            echo "<div class='cardInfoSection'>";
            echo "<h2>" . $row['eventName'] . "</h2>";
            echo "<h4>" . $row['eventDescription'] . "</h4>";
            echo "</div>";


            echo "<div class='cardButtonsSection'>";
            echo "<a class='btnBuyTicket' href='manage-event.php?eventID=" . $row['eventID'] . "'>Manage</a>";
            echo "<a class='btnBuyTicket' href='delete-event.php?eventID=" . $row['eventID'] . "'>delete</a>";
            echo "</div>";
            echo "</div>";
        }
        ?>

    </div>



    <!-- Footer starts -->
    <?php include ('../../../includes/footer.php') ?>
    <!-- Footer ends -->

    <!-- Script Scetion Start -->
    <script src="../../../js/value-name.js"></script>
    <script src="../../../js/validate-form.js"></script>
    <script src="../../../js/available-date.js"></script>
    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("date").setAttribute('min', today);

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
            console.log("number of tickets: " + document.getElementById('ticket-options').childElementCount)
            // Append the new ticket option to the container
            document.getElementById('ticket-options').appendChild(newTicketOption);
        });

        document.getElementById("remove-ticket-option").addEventListener('click', function () {
            const ticketOptions = document.getElementById('ticket-options');
            if (ticketOptions.childElementCount > 2) {
                ticketOptions.removeChild(ticketOptions.lastChild);
            }

            console.log("number of tickets: " + ticketOptions.childElementCount)
        });
    </script>
    <!-- Script Scetion End -->


</body>

</html>