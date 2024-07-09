<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    include ("config.php");

    $eventID = $_GET['eventID'];

    $query = " SELECT * FROM events_tb WHERE eventID = '$eventID'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo $row['eventName'];
    } ?> | Xyz Events</title>

    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Cart container start -->
    <div class="cart-container" id="cart-container">
        <div class="cart-items">
            <h1 style="
        border: 1px white solid;
        border-radius:15px;
        padding:15px 30px"><i class="fa-solid fa-cart-shopping"></i> Your cart!</h1>

            <?php
            session_start();
            include ("config.php");

            if (isset($_SESSION["email"])) {
                $email = $_SESSION["email"];
                $attendeeID = $_SESSION["userID"];

                $sql_cart_items = "SELECT * FROM cart_tb WHERE attendeeID = '$attendeeID'";
                $result_cart = mysqli_query($conn, $sql_cart_items);

                if (mysqli_num_rows($result_cart) > 0) {
                    while ($row_cart = mysqli_fetch_assoc($result_cart)) {
                        $eventID = $row_cart['eventID'];
                        $ticketID = $row_cart['ticketID'];

                        $sql_eventDetails = "SELECT * FROM events_tb WHERE eventID = '$eventID'";
                        $result_eventDetails = mysqli_query($conn, $sql_eventDetails);
                        $row_eventDetails = mysqli_fetch_assoc($result_eventDetails);

                        $sql_ticketsDetails = "SELECT * FROM ticketprice WHERE ticketID = '$ticketID'";
                        $result_ticketsDetails = mysqli_query($conn, $sql_ticketsDetails);
                        $row_ticketsDetails = mysqli_fetch_assoc($result_ticketsDetails);

                        echo "<div class='cart-item'>";
                        echo "<div class='cart-left'>";
                        echo "<h1><a href=''>" . $row_eventDetails['eventName'] . "</a></h1>";
                        echo "<h3>" . $row_ticketsDetails['ticketName'] . "</h3>";
                        echo "</div>";
                        echo "<div class='cart-right'>";
                        echo "<h1>" . $row_ticketsDetails['Price'] . "$</h1>";
                        echo "<a href='remove-from-cart.php?cartID=" . $row_cart['cartID'] . "'>remove from cart</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<h3>It seems to be empty.<br>Please add items to your cart.</h3>";
                }
            }
            ?>
        </div>
    </div>
    <div id="clickable-div" onclick="hideCart()"></div>
    <!-- Cart container end -->

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
                    <!-- <li><a href="login1.html">Log In</a></li>
                    <li><a href="register.php">Register</a></li> -->
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

    <?php
    $eventID = $_GET['eventID'];


    $query = " SELECT * FROM events_tb WHERE eventID = '$eventID'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='event-details'>";
        echo '<div style="background-image: url(\'./eventImages/' . $row['eventImage'] . '\')" class="event-details-img">';
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
                echo "<a href='cart.php?ticketID=" . $ticket_details['ticketID'] . "&eventID=" . $eventID . "'>add to cart</a>";
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