<nav>
            <div class="leftSection">
                <div onclick="window.location.href='/BTEC/'" class="logoNav"></div>
            </div>
            <div class="middleSection">
                <ul>
                    <li><a href="/BTEC/">HOME</a></li>
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
                        echo "<li><a href='/BTEC/web\pages\Login\logout.php' class='btn btn-danger'>Logout</a></li>";
                        $email = $_SESSION["email"];
                        $query = mysqli_query($conn, "SELECT * FROM organizer_tb WHERE organizerEmail='$email'");

                        if ($query->num_rows > 0) {
                            echo "<li><a href='/BTEC/web/pages/Login/Dashboard/dashboard.php'>Dashboard</a></li>";
                        } else {
                            echo "<li><a href='/BTEC/web\pages\Login\profile.php'>PROFILE</a></li>";
                            echo "<li onclick='showCart()'>CART</li>";
                        }
                    } else {
                        // User is not logged in, show login/register options
                        echo '<li><a href="/BTEC/web\pages\Login\login.php" class="btn btn-primary">Login</a></li>';
                        echo '<li><a href="/BTEC/web\pages\Register\register.php" class="btn btn-success">Register</a></li>';
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
                <li><a href="/BTEC/">HOME</a></li> <br>
                <li><a href="">EVENTS</a></li> <br>
                <li><a href="">SERVICES</a></li> <br>
                <li><a href="">CONTACT US</a></li> <br>
                <?php
                if (isset($_SESSION["email"])) {
                    $email = $_SESSION["email"];
                    $query = mysqli_query($conn, "SELECT * FROM organizer_tb WHERE organizerEmail='$email'");

                    if ($query->num_rows > 0) {
                        echo "<li><a href='/BTEC/web\pages\Login\Dashboard\dashboard.php'>DASHBOARD</a></li><br>";
                    } else {
                        echo "<li><a href='/BTEC/web\pages\Login\profile.php'>PROFILE</a></li><br>";
                        echo "<li onclick='showCart()'>CART</li><br>";
                    }
                    echo "<li><a href='/BTEC/web\pages\Login\logout.php'>Logout</a></li><br>";
                } else {
                    echo '<li><a href="/BTEC/web\pages\Login\login.php" class="btn btn-primary">Login</a></li><br>';
                    echo '<li><a href="/BTEC/web\pages\Register\register.php" class="btn btn-success">Register</a></li>';
                } ?>
            </ul>

        </div>