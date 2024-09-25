<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    session_start();
    include ("../../config.php");

    $eventID = $_GET['eventID'];

    $query = " SELECT * FROM events_tb WHERE eventID = '$eventID'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo $row['eventName'];
    } ?> | Xyz Events</title>

    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Cart container start -->
    <?php include ('Login/Cart/cart-container.php') ?>
    <!-- Cart container end -->

    <!-- Navigation Bar Starts -->
    <?php include ('../includes/header.php') ?>
    <!-- Navigation Bar End -->

    <?php
    $eventID = $_GET['eventID'];


    $query = " SELECT * FROM events_tb WHERE eventID = '$eventID'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='event-details'>";
        echo '<div style="background-image: url(\'../../eventImages/' . $row['eventImage'] . '\')" class="event-details-img">';
        echo "</div>";


        echo "<div class='event-details-info'>";
        echo "<h2>" . $row['eventName'] . "</h2><br> <h4>" . " Available seats:" . $row['eventCapacity'] . " | Date:" . $row['eventDate'] . "</h4><br><br>";
        echo "<h4>" . $row['eventDescription'] . "</h4>";
        echo "</div>";


        echo "<div class='show-tickets'>";
        echo "<div class='ticket-container'>";
        $query_tickets = "SELECT * FROM ticketprice WHERE eventID = '$eventID' AND ticketQuantity > 0";
        $result_tickets = mysqli_query($conn, $query_tickets);

        if (mysqli_num_rows($result_tickets)) {
            while ($ticket_details = mysqli_fetch_array($result_tickets)) {
                echo "<div class='ticket'>";
                echo "<div class='ticket-left'>";
                echo "<h2>" . $ticket_details['ticketName'] . "</h2>";
                echo "<h4>" . $ticket_details['ticketDescription'] . "</h4>";
                echo "</div>";
                echo "<div class='ticket-right'>";
                echo "<h2>" . $ticket_details['Price'] . "</h2>";
                echo "<a href='Login/Cart/cart.php?ticketID=" . $ticket_details['ticketID'] . "&eventID=" . $eventID . "'>add to cart</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<h1>No tickets available</h1>";
        }

        echo "</div>";
        echo "</div>";
        echo "</div>";

    }
    ?>

<?php include ('../includes/footer.php') ?>

    <script>
        const clickableDiv = document.getElementById("clickable-div");
        const cartContainer = document.getElementById("cart-container");
        function hideCart() {
            clickableDiv.style.display = "none";
            cartContainer.style.right = "-450px";
        }

        function showCart() {
            clickableDiv.style.display = "block";
            cartContainer.style.right = "0px";
        }
    </script>
</body>

</html>