<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | XYZ EVENTS</title>

    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style.css">


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

        <div class="searchSection">
            <div class="searchLabels">
                <h1>See what is upcoming</h1>
                <h2>explore amazing events</h2>
            </div>

            <div class="search-in-btn">
                <input class="searchInput" type="text" placeholder="Search for a unique experience...">
                <label class="search" for=""><i class="fa-solid fa-magnifying-glass"></i></label>
            </div>
        </div>

        <div class="shortInfoSection">

            <div class="shortInfoBoxLeft">
                <h3><i class="fa-solid fa-heart"></i> Unique Events</h3>
                <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam distinctio commodi assumenda
                    quaerat exercitationem deleniti voluptate asperiores dolore architecto! Sapiente nihil adipisci
                    nostrum molestiae architecto perferendis quasi? Ullam, impedit. Dolorum?</h4>
            </div>
            <div class="shortInfoBoxMid">
                <h3><i class="fa-solid fa-star"></i> Unique Events</h3>
                <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam distinctio commodi assumenda
                    quaerat exercitationem deleniti voluptate asperiores dolore architecto! Sapiente nihil adipisci
                    nostrum molestiae architecto perferendis quasi? Ullam, impedit. Dolorum?</h4>
            </div>
            <div class="shortInfoBoxRight">
                <h3><i class="fa-solid fa-face-smile"></i> Unique Events</h3>
                <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam distinctio commodi assumenda
                    quaerat exercitationem deleniti voluptate asperiores dolore architecto! Sapiente nihil adipisci
                    nostrum molestiae architecto perferendis quasi? Ullam, impedit. Dolorum?</h4>
            </div>
        </div>

    </div>
    <!-- Navigation Bar End -->

    <main>
        <div class="separatorLine"></div>


        <!-- Start of Featured Section -->
        <div class="featuredInfoSection">

            <!-- Start Numbers Section -->
            <div class="featuredEventsNumber">
                <div class="featuredEventsNumberLeft">
                    <h4>ABOUT US</h4>
                    <h1>Clients Around the World</h1>
                    <div class="clientsNumberSection">
                        <div class="clientsNumbers">
                            <h1>7,200</h1>
                            <h3>Companies</h3>
                        </div>
                        <div class="clientsNumbers">
                            <h1>12.8m</h1>
                            <h3>Attendees</h3>
                        </div>
                        <div class="clientsNumbers">
                            <h1>21.4k</h1>
                            <h3>Events</h3>
                        </div>
                    </div>

                    <div class="featuredButtons">
                        <button>Get Started</button>
                    </div>
                </div>
                <div class="featuredEventsNumberRight">
                    <img src="multi-omics-data-analysis-interpretation-services.png" alt="">
                </div>
            </div>
            <!-- End Numbers Section -->

            <!-- Start Slider Section -->
            <div class="slider">
                <div class="slides">




                    <!-- Radio buttons start -->
                    <input type="radio" name="radio-btn" id="radio1">
                    <input type="radio" name="radio-btn" id="radio2">
                    <input type="radio" name="radio-btn" id="radio3">
                    <!-- Radio buttons end -->

                    <!-- Slides start -->
                    <div class="slide first">
                        <img src="graduation.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="conference.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="concert.jpg" alt="">
                    </div>
                    <!-- Slides end -->

                    <!-- automatic navigation start -->
                    <div class="navigation-auto">
                        <div class="auto-btn1"></div>
                        <div class="auto-btn2"></div>
                        <div class="auto-btn3"></div>
                    </div>
                    <!-- automatic navigation end -->

                </div>

                <!-- manual navigation start -->
                <div class="navigation-manual">
                    <label for="radio1" class="manual-btn"></label>
                    <label for="radio2" class="manual-btn"></label>
                    <label for="radio3" class="manual-btn"></label>

                </div>
                <!-- manual navigation end -->
            </div>
            <!-- End Slider Section -->




        </div>
        <div class="separatorLine"></div>


        <div class="separatorLine"></div>

        <div class="eventCardsSection">

            <?php
            include ("config.php");
            $query = " SELECT * FROM events_tb WHERE eventDate > CURDATE()";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<a class='cardIndexPage' href='event_details.php?eventID=" . $row['eventID'] . "'>";

                echo "<div class='cardThumbnailSection'>";
                echo "<img class='cardThumbnail' src='./eventImages/" . $row['eventImage'] . "'>";
                echo "</div>";


                echo "<div class='cardInfoSection'>";
                echo "<h2>" . $row['eventName'] . "</h2>";
                echo "<h4>" . $row['eventDescription'] . "</h4>";
                echo "</div>";


                echo "<div class='cardButtonsSection'>";
                echo "<button class='btnBuyTicket'>CHECK TICKETS</button>";
                echo "</div>";
                echo "</a>";
            }
            ?>

        </div>


        <div class="separatorLine"></div>



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

    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="automatic-slide.js"></script>
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