<?php
session_start();
include ("../../../config.php");

if (!isset($_SESSION["email"])) {
    header("login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account | Xyz Events</title>

    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../css/style.css">

</head>

<body>

    <!-- Cart container start -->
    <?php include ('Cart/cart-container.php') ?>
    <!-- Cart container end -->

    <!-- Navigation Bar Starts -->
    <?php include ('../../includes/header.php') ?>
    <!-- Navigation Bar End -->

    <main>
        <div class="separatorLine"></div>
        <h1 style="font-size: 1.5em; margin-left:150px;">Previous events:</h1>
        <div class="separatorLine"></div>
        <div class="eventCardsSection">
            <?php
            $attendeeID = $_SESSION["userID"];

            $sql_cart = "SELECT * FROM cart_tb WHERE attendeeID = '$attendeeID'";
            $result_cart = mysqli_query($conn, $sql_cart);
            while ($row_cart = mysqli_fetch_array($result_cart)) {
                $eventID = $row_cart['eventID'];
                $query = " SELECT * FROM events_tb WHERE eventID = '$eventID' AND eventDate < CURDATE()";
                $result = mysqli_query($conn, $query);

                if ($row = mysqli_fetch_assoc($result)) {
                    echo "<a class='cardIndexPage' href='event_details.php?eventID=" . $row['eventID'] . "'>";
                    echo "<div class='cardThumbnailSection'>";
                    echo "<img class='cardThumbnail' src='./eventImages/" . $row['eventImage'] . "'>";
                    echo "</div>";
                    echo "<div class='cardInfoSection'>";
                    echo "<h2>" . $row['eventName'] . "</h2>";
                    echo "<h4>" . $row['eventDescription'] . "</h4>";
                    echo "</div>";
                    echo "</a>";
                }
            }
            ?>
        </div>

        <div class="separatorLine"></div>
        <h1 style="font-size: 1.5em; margin-left:150px;">Upcoming events:</h1>
        <div class="separatorLine"></div>
        <div class="eventCardsSection">
            <?php
            $attendeeID = $_SESSION["userID"];

            $sql_cart = "SELECT * FROM cart_tb WHERE attendeeID = '$attendeeID'";
            $result_cart = mysqli_query($conn, $sql_cart);
            while ($row_cart = mysqli_fetch_array($result_cart)) {
                $eventID = $row_cart['eventID'];
                $query = " SELECT * FROM events_tb WHERE eventID = '$eventID' AND eventDate > CURDATE()";
                $result = mysqli_query($conn, $query);

                if ($row = mysqli_fetch_assoc($result)) {
                    echo "<a class='cardIndexPage' href='/BTEC/web/pages/event_details.php?eventID=" . $row['eventID'] . "'>";
                    echo "<div class='cardThumbnailSection'>";
                    echo "<img class='cardThumbnail' src='../../../eventImages/" . $row['eventImage'] . "'>";
                    echo "</div>";
                    echo "<div class='cardInfoSection'>";
                    echo "<h2>" . $row['eventName'] . "</h2>";
                    echo "<h4>" . $row['eventDescription'] . "</h4>";
                    echo "</div>";
                    echo "</a>";
                }
            }
            ?>
        </div>



        <?php include ('../../includes/footer.php') ?>


    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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