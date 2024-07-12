<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T1 Merchandise - PH</title>
    <link rel="icon" href="img/Red+Logo-tab.png">
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/loading.css">
    <link rel="stylesheet" href="css/nav.css">
    <script src="script/loading.js" defer></script>
    <script src="script/index.js" defer></script>
</head>

<body>
    <nav>
        <div class="loading-cont">
            <div id="loading-circle"></div>
            <div class="powered-cont">
                <div class="powered-cont-row1">PLEASE WAIT...</div>
                <div class="powered-cont-row2">POWERED BY: <span id="powered-t1">&nbsp;T1&nbsp;</span>|<span id="powered-olfu">&nbsp;OLFU QC CAMPUS</span></div>
            </div>
        </div>
        <a href=""><img src="img/T1_Logo_White.png" alt="" id="t1-logo"></a>
        <ul>
            <li><a href="" class="selected-nav">Home</a></li>
            <!-- NOT LOG IN -->
            <?php if (!$curr_user_id) : ?>
                <li><a href="php/signup.php">Sign-up</a></li>
                <li><a href="php/signin.php">Sign-in</a></li>
                <li><a href="php/shop.php?category=All">Shop</a></li>
                <li><a href="php/cart.php"><i class="fa-sharp fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></a></li>
                <li><a href="php/profile.php"><i class="fa-solid fa-user"></i></a></li>

                <!-- LOGGED IN -->
            <?php else : ?>
                <li><a href="php/shop.php?category=All">Shop</a></li>
                <li><a href="php/orders.php?category=All%20Orders">Orders</a></li>
                <li><a href="php/cart.php"><i class="fa-sharp fa-solid fa-cart-shopping" title="My Cart"></i><span class="cart-count">
                            <?php
                            include('php/connection_db.php');
                            $sql = "SELECT SUM(quantity) AS cart_count FROM cart WHERE user_id = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $curr_user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($row = $result->fetch_assoc()) {
                                $cart_count = $row['cart_count'];
                                echo ($cart_count > 0) ? $cart_count : '0';
                            } else {
                                echo "Error";
                            }
                            $stmt->close();
                            $conn->close();
                            ?>
                        </span></a></li>
                <li class="li-profile-link"><a onclick="expandProfile()" id="profile-link"><i class="fa-solid fa-user"></i><span class="li-user-name">&bull;
                            <?php
                            include('php/connection_db.php');
                            $sql = "SELECT first_name FROM user_info
                            WHERE id = $curr_user_id";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            echo $row['first_name'];
                            ?>
                        </span></a>
                    <ul class="expand-profile">
                        <li><a href="php/profile.php">Profile</a></li>
                        <li><a href="php/logout.php">Logout</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="t1-home-cont">
        <div class="t1-home-text-cont">
            <h1 id="t1-home-text-cont-title"><span id="t1-home-text-cont-title-t1-shop">T1 PHILIPPINES!</span></h1>
            <p id="t1-home-text-cont-subtext">The T1 Shop has arrived in the Philippines. Discover exclusive apparel, team uniforms, collectibles, and accessories. Level up your style and show your T1 pride. Mabuhay Pilipinas!</p>
        </div>
        <div class="t1-home-bg-cont" id="t1-home-bg-cont">
            <h1 id="t1-home-bg-title">T1 PHILIPPINES</h1>
        </div>
    </div>

    <h1 id="featured-title"><span style="color: red;">T1</span> FEATURED PRODUCTS</h1>
    <?php
    include('php/connection_db.php');

    // Retrieve featured products
    $sql = "SELECT * FROM product_list ORDER BY avg_ratings DESC LIMIT 4;";
    $result = $conn->query($sql);

    // Display featured products in separate "feature" divs
    if ($result->num_rows > 0) {
        $counter = 0; // Initialize a counter

        while ($row = $result->fetch_assoc()) {
            $productName = $row["product_name"];
            $productDescription = $row["product_description"];
            $productImage = $row["product_image"];
            $productLink = $row["product_link"];
            $productId = $row["product_id"];
            $averageRating = $row["avg_ratings"];

            // Check if the counter is even or odd to determine column order
            $even = $counter % 2 == 0;

            // Display the information in separate "feature" divs with alternating columns
            echo "<div class='featured'>";
            if ($even) {
                echo "<div class='featured-col-1'>";
                echo "<img src='$productImage' alt='Product Image' id='featured-img'>";
                echo "</div>";
                echo "<div class='featured-col-2'>";
                echo "<h2>$productName</h2>";
                echo "<h2 class='product-rating'>Avg. Ratings:";
                if ($averageRating == 5) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                    ";
                } elseif ($averageRating == 4) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;&#9733;&#9733;<span class='star-rating-grey'>&#9733;</span></span>
                    ";
                } elseif ($averageRating == 3) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;&#9733;<span class='star-rating-grey'>&#9733;&#9733;</span></span>
                    ";
                } elseif ($averageRating == 2) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;<span class='star-rating-grey'>&#9733;&#9733;&#9733;</span></span>
                    ";
                } elseif ($averageRating == 1) {
                    echo "
                    <span class='star-rating'>&#9733;<span class='star-rating-grey'>&#9733;&#9733;&#9733;&#9733;</span></span>
                    ";
                } else {
                    echo "
                    <span class='star-rating'><span class='star-rating-grey'>&#9733;&#9733;&#9733;&#9733;&#9733;</span></span>
                    ";
                }
                echo "</h2>";
                echo "<p>$productDescription</p>";
                echo "<a href='php/product.php?id=$productId' id='see-btn'>See Details</a>";
            } else {
                echo "<div class='featured-col-2'>";
                echo "<h2>$productName</h2>";
                echo "<h2 class='product-rating'>Avg. Ratings:";
                if ($averageRating == 5) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                    ";
                } elseif ($averageRating == 4) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;&#9733;&#9733;<span class='star-rating-grey'>&#9733;</span></span>
                    ";
                } elseif ($averageRating == 3) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;&#9733;<span class='star-rating-grey'>&#9733;&#9733;</span></span>
                    ";
                } elseif ($averageRating == 2) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;<span class='star-rating-grey'>&#9733;&#9733;&#9733;</span></span>
                    ";
                } elseif ($averageRating == 1) {
                    echo "
                    <span class='star-rating'>&#9733;<span class='star-rating-grey'>&#9733;&#9733;&#9733;&#9733;</span></span>
                    ";
                } else {
                    echo "
                    <span class='star-rating'><span class='star-rating-grey'>&#9733;&#9733;&#9733;&#9733;&#9733;</span></span>
                    ";
                }
                echo "</h2>";
                echo "<p>$productDescription</p>";
                echo "<a href='php/product.php?id=$productId' id='see-btn'>See Details</a>";
                echo "</div>";
                echo "<div class='featured-col-1'>";
                echo "<img src='$productImage' alt='Product Image' id='featured-img'>";
            }
            echo "</div>";
            echo "</div>";

            // Increment the counter
            $counter++;
        }
    } else {
        echo "<h1 style='text-align: center; font-size: 2em; margin: auto;'>No featured products available for now<h1>";
    }
    $conn->close();
    ?>
    <?php if (!$curr_user_id) : ?>
        <div class="not-member-cont">
            <div class="not-member-cont-img-cont">
                <img src="img/t1-faker-zip-up.png" alt="" id='not-member-cont-img-cont-img'>
            </div>
            <div class="not-member-cont-text-cont">
                <h2 class="not-member-cont-text-cont-title">Not yet a member?</h2>
                <p>Unlock the full shopping experience by joining our community! Sign in or Sign up now to enjoy exclusive access to our products, order status, and seamless checkout process.</p>
                <div class="sign-in-sign-up-btn-cont">
                    <a href='php/signin.php' id='see-btn'>Sign in</a>
                    <a href='php/signup.php' id='see-btn'>Sign up</a>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="not-member-cont">
            <div class="not-member-cont-img-cont">
                <img src="img/guma-shop-now (2).png" alt="" id='not-member-cont-img-cont-img'>
            </div>
            <div class="not-member-cont-text-cont">
                <h2>Want to explore more?</h2>
                <p>Gear up like a pro! Explore our esports shop for stylish apparel, uniforms, collectibles, and accessories - your winning look starts here!</p>
                <div class="sign-in-sign-up-btn-cont">
                    <a href='php/shop.php' id='see-btn'>Shop now</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <footer>
        <div class="footer-column-container">
            <div class="footer-column">
                <p class="footer-title">Quick Links</p>
                <ul>
                    <li><a href="#t1-home-bg-cont">Home</a></li>
                    <?php if (!$curr_user_id) : ?>
                        <li><a href="php/signup.php">Sign-up</a></li>
                        <li><a href="php/signin.php">Sign-in</a></li>
                    <?php endif; ?>
                    <li><a href="php/profile.php">Profile</a></li>
                    <li><a href="php/shop.php">Shop</a></li>
                    <li><a href="php/cart.php">Cart</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <p class="footer-title">Information</p>
                <ul>
                    <li><a href="php/privacy-policy.php">Privacy Policy</a></li>
                    <li><a href="php/terms-of-service.php">Terms of Service</a></li>
                    <li><a href="php/faqs.php">FAQs</a></li>
                    <li><a href="php/customer-support.php">Customer Support</a></li>
                    <li><a href="about_me">About Me</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <p class="footer-title">Follow Us</p>
                <ul>
                    <li><a href="https://www.facebook.com/T1LoL/" target="_blank">Facebook<img src="img/facebook-logo-2019.svg" alt="" id="sponsor-logo"></a></li>
                    <li><a href="https://discord.com/invite/leagueoflegends" target="_blank">Discord<img src="img/discord.png" alt="" id="sponsor-logo"></a></li>
                    <li><a href="https://www.instagram.com/t1lol/?hl=en" target="_blank">Instagram<img src="img/instagram.png" alt="" id="sponsor-logo"></a></li>
                    <li><a href="https://twitter.com/T1LoL" target="_blank">Twitter<img src="img/x-logo-twitter-transparent-logo-download-3.png" alt="" id="sponsor-logo"></a></li>
                </ul>
            </div>
            <div class="footer-column">
                <p class="footer-title">Powered By</p>
                <ul>
                    <li><a href="https://www.fatima.edu.ph/" target="_blank">OLFU QC Campus<img src="img/OLFU_official_logo.png" id="sponsor-logo"></a></li>
                    <li><a href="https://www.mcdonalds.com.ph/" target="_blank">McDonald's<img src="img/McDonald's_Golden_Arches.png" id="sponsor-logo"></a></li>
                    <li><a href="https://www.sminvestments.com/" target="_blank">SM Investments Corporation<img src="img/sm-blue.png" id="sponsor-logo"></a></li>
                    <li><a href="https://smart.com.ph/" target="_blank">Smart Communications, Inc.<img src="img/smart.png" id="sponsor-logo"></a></li>
                    <li><a href="https://www.ayalaland.com.ph/" target="_blank">Ayala Land<img src="img/Ayalasymbol-removebg-preview.png" id="sponsor-logo"></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-column-container" id="copyright">
            <p>&copy; 2023 T1 and OLFU QC. All rights reserved. Unauthorized use or reproduction without written consent is prohibited. For inquiries, please <a href="mailto:pistol325325@gmail.com">contact us</a>.</p>

        </div>
    </footer>
</body>

</html>