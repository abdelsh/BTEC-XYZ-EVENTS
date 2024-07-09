<?php
session_start();

include ("config.php");

$ticketID = $_GET['ticketID'];
$eventID = $_GET['eventID'];

if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];

    $sql_getTicketQuantity = "SELECT * FROM ticketprice WHERE ticketID = '$ticketID'";
    $result_ticket = mysqli_query($conn, $sql_getTicketQuantity);
    $row_ticket = mysqli_fetch_assoc($result_ticket);

    $ticketQuantity = $row_ticket["ticketQuantity"];
    $ticketQuantity--;

    mysqli_query($conn,"UPDATE ticketprice SET ticketQuantity = '$ticketQuantity' WHERE ticketID = '$ticketID'");

    $sql_ticketQuantity = "SELECT SUM(ticketQuantity) AS totalQuantity FROM ticketprice WHERE eventID = '$eventID'";
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
    $sql_eventCapacity = "UPDATE events_tb SET eventCapacity = '$eventCapacity' WHERE eventID = '$eventID'";
    $result_eventCapacity = mysqli_query($conn, $sql_eventCapacity);

    $query = mysqli_query($conn, "SELECT * FROM attendee_tb WHERE attendeeEmail='$email'");

    if ($query->num_rows > 0) {
        $row = mysqli_fetch_array($query);
        $attendeeID = $row['attendeeID'];


        $sql_addItem = "INSERT INTO cart_tb (attendeeID,eventID,ticketID)
        VALUES ('$attendeeID', '$eventID', '$ticketID')";

        $result = mysqli_query($conn, $sql_addItem);

        header("location: event_details.php?eventID=$eventID");
        exit();

    } else {
        ?>
        <script>
            alert("You must be logged in with an attendee account.");
        </script>
        <?php
        header('location: index.php');
        exit();
    }

} else {
    ?>
    <script>
        alert("You must be logged in with an attendee account.");
    </script>
    <?php
    header('location: index.php');
    exit();
}
?>