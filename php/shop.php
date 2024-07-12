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
    <link rel="icon" href="../img/Red+Logo-tab.png">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/shop.css">
    <link rel="stylesheet" href="../css/loading.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/loading.css">
    <script src="../script/loading.js" defer></script>
    <script src="../script/shop.js" defer></script>
    <script src="../script/profile_expand.js" defer></script>
    <script src="../script/loading.js" defer></script>
</head>

<body>
    <div class="loading-cont">
        <div id="loading-circle"></div>
        <div class="powered-cont">
            <div class="powered-cont-row1">PLEASE WAIT...</div>
            <div class="powered-cont-row2">POWERED BY: <span id="powered-t1">&nbsp;T1&nbsp;</span>|<span id="powered-olfu">&nbsp;OLFU QC CAMPUS</span></div>
        </div>
    </div>
    <nav>
        <a href="../index.php"><img src="../img/T1_Logo_White.png" alt="" id="t1-logo"></a>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <!-- NOT LOG IN -->
            <?php if (!$curr_user_id) : ?>
                <li><a href="signup.php">Sign-up</a></li>
                <li><a href="signin.php">Sign-in</a></li>
                <li><a href="shop.php?category=All" class="selected-nav">Shop</a></li>
                <li><a href="cart.php"><i class="fa-sharp fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></a></li>
                <li><a href="profile.php"><i class="fa-solid fa-user"></i></a></li>

                <!-- LOGGED IN -->
            <?php else : ?>
                <li><a href="shop.php?category=All" class="selected-nav">Shop</a></li>
                <li><a href="orders.php?category=All%20Orders">Orders</a></li>
                <li><a href="cart.php"><i class="fa-sharp fa-solid fa-cart-shopping" title="My Cart"></i><span class="cart-count">
                            <?php
                            include('connection_db.php');
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
                            ?></span></a></li>
                <li class="li-profile-link"><a onclick="expandProfile()" id="profile-link"><i class="fa-solid fa-user"></i><span class="li-user-name">&bull;
                            <?php
                            include('connection_db.php');
                            $sql = "SELECT first_name FROM user_info
                            WHERE id = $curr_user_id";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            echo $row['first_name'];
                            ?>
                        </span></a>
                    <ul class="expand-profile">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- class="selected-nav" -->
    <div class="selection-bar">
        <h4>CATEGORIES: </h4>
        <a href="?category=All" <?php if (isset($_GET['category'])) {
                                    $category = $_GET['category'];
                                    if ($category === 'All') {
                                        echo "class='selected-subnav'";
                                    }
                                } ?>>All</a>
        <h4 class="hrule">|</h4>
        <a href="?category=Apparel" <?php if (isset($_GET['category'])) {
                                        $category = $_GET['category'];
                                        if ($category === 'Apparel') {
                                            echo "class='selected-subnav'";
                                        }
                                    } ?>>Apparel</a>
        <h4 class="hrule">|</h4>
        <a href="?category=Uniform" <?php if (isset($_GET['category'])) {
                                        $category = $_GET['category'];
                                        if ($category === 'Uniform') {
                                            echo "class='selected-subnav'";
                                        }
                                    } ?>>Uniform</a>
        <h4 class="hrule">|</h4>
        <a href="?category=Accessories" <?php if (isset($_GET['category'])) {
                                            $category = $_GET['category'];
                                            if ($category === 'Accessories') {
                                                echo "class='selected-subnav'";
                                            }
                                        } ?>>Accessories</a>
        <h4 class="hrule">|</h4>
        <a href="?category=Collectibles" <?php if (isset($_GET['category'])) {
                                                $category = $_GET['category'];
                                                if ($category === 'Collectibles') {
                                                    echo "class='selected-subnav'";
                                                }
                                            } ?>>Collectibles</a>
    </div>
    <div class="product-container">
        <?php
        include('connection_db.php');
        if (isset($_GET['category'])) {
            $category = $_GET['category'];

            if ($category === 'All') {
                $sql = "SELECT product_name, product_description, product_image, product_link, product_price, product_id FROM product_list";
            } elseif ($category === 'Apparel') {
                $sql = "SELECT product_name, product_description, product_image, product_link, product_price, product_id FROM product_list WHERE product_category = 'apparel'";
            } elseif ($category === 'Uniform') {
                $sql = "SELECT product_name, product_description, product_image, product_link, product_price, product_id FROM product_list WHERE product_category = 'uniform'";
            } elseif ($category === 'Accessories') {
                $sql = "SELECT product_name, product_description, product_image, product_link, product_price, product_id FROM product_list WHERE product_category = 'accessories'";
            } elseif ($category === 'Collectibles') {
                $sql = "SELECT product_name, product_description, product_image, product_link, product_price, product_id FROM product_list WHERE product_category = 'collectibles'";
            }
        } else {
            $sql = "SELECT product_name, product_description, product_image, product_link, product_price, product_id FROM product_list";
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productName = $row["product_name"];
                $productDescription = $row["product_description"];
                $productImage = $row["product_image"];
                $productLink = $row["product_link"];
                $productPrice = $row["product_price"];
                $productId = $row["product_id"];

                // Fetch and calculate average rating
                $ratingSql = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE product_id = $productId";
                $ratingResult = $conn->query($ratingSql);
                $ratingRow = $ratingResult->fetch_assoc();
                $averageRating = round($ratingRow["avg_rating"]);
                $reviewCount = $ratingRow["review_count"];

                echo "<div class='each-product-container'>";
                echo "<img src='../$productImage' alt='' class='product-img'>";
                echo "<h1 class='product-title'>$productName</h1>";
                echo "<h2 class='product-rating'>";
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
                echo "<span class='review-count-text'>($reviewCount reviews)<span></h2>";
                echo "<h2 class='product-price'>&#8369;$productPrice</h2>";
                echo "<a href='product.php?id=$productId' class='product-buy-btn'>Buy now</a>";
                echo "</div>";
            }
        } else {
            echo "<h1 style='text-align: center; font-size: 2em; margin: auto;'>No products available for now<h1>";
        }
        $conn->close();
        ?>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>