<?php
include("../../../../config.php");

if(isset($_GET["cartID"])){
    $cartID = $_GET["cartID"];

    $row_cart = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM cart_tb WHERE cartID = '$cartID'"));
    $ticketID = $row_cart['ticketID'];

    $sql_getTicketQuantity = "SELECT * FROM ticketprice WHERE ticketID = '$ticketID'";
    $result_ticket = mysqli_query($conn, $sql_getTicketQuantity);
    $row_ticket = mysqli_fetch_assoc($result_ticket);
    $eventID = $row_ticket['eventID'];

    $ticketQuantity = $row_ticket["ticketQuantity"];
    $ticketQuantity++;

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

    $sql_eventCapacity = "UPDATE events_tb SET eventCapacity = '$eventCapacity' WHERE eventID = '$eventID'";
    $result_eventCapacity = mysqli_query($conn, $sql_eventCapacity);

    $sql = "DELETE FROM cart_tb WHERE cartID = '$cartID'";
    $result = mysqli_query($conn, $sql);

    header("location: /BTEC/");
    exit();
}
?>