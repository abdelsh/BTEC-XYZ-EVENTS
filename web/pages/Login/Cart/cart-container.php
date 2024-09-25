<div class="cart-container" id="cart-container">
        <div class="cart-items">
            <h1 style="
        border: 1px white solid;
        border-radius:15px;
        padding:15px 30px"><i class="fa-solid fa-cart-shopping"></i> Your cart!</h1>

            <?php
            // session_start();

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