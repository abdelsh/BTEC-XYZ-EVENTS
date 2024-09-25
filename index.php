<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | XYZ EVENTS</title>

    <script src="https://kit.fontawesome.com/1111195a67.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="web\css\style.css?v=<?php echo time(); ?>">


</head>

<body>
    <!-- Cart container start -->
    <?php 
    session_start();
    include ('config.php');
    include ('web\pages\Login\Cart\cart-container.php'); ?>
    <!-- Cart container end -->

    <!-- Navigation Bar Starts -->
    <div class="navigationBar">
        <?php
        include ("web\includes\header.php");
        ?>

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
                    <img src="web\assets\multi-omics-data-analysis-interpretation-services.png" alt="">
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
                        <img src="web\assets\graduation.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="web\assets\conference.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="web\assets\concert.jpg" alt="">
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
                echo "<a class='cardIndexPage' href='web/pages/event_details.php?eventID=" . $row['eventID'] . "'>";

                echo "<div class='cardThumbnailSection'>";
                echo "<img class='cardThumbnail' src='./eventImages/" . $row['eventImage'] . "'>";
                echo "</div>";


                echo "<div class='cardInfoSection'>";
                echo "<h2 class='shortTitle'>" . $row['eventName'] . "</h2>";
                echo "<h4 class='shortDesc'>" . $row['eventDescription'] . "</h4>";
                echo "</div>";


                echo "<div class='cardButtonsSection'>";
                echo "<button class='btnBuyTicket'>CHECK TICKETS</button>";
                echo "</div>";
                echo "</a>";
            }
            ?>

        </div>


        <div class="separatorLine"></div>


<?php
include ('web\includes\footer.php');
?>

    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="web\js\automatic-slide.js"></script>
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
        <script src="web\js\text-length.js"></script>
</body>

</html>