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
    <link rel="stylesheet" href="../css/product.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/loading.css">
    <script src="../script/loading.js" defer></script>
    <script src="../script/product.js" defer></script>
    <script src="../script/profile_expand.js" defer></script>
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
    <?php
    include('connection_db.php');
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
        $sql = "SELECT * FROM product_list WHERE product_id = $productId";
        $result = $conn->query($sql);

        $ratingSql = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE product_id = $productId";
        $ratingResult = $conn->query($ratingSql);
        $ratingRow = $ratingResult->fetch_assoc();
        $averageRating = round($ratingRow["avg_rating"]);
        $reviewCount = $ratingRow["review_count"];

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $productName = $row["product_name"];
            $productDescription = $row["product_description"];
            $productImage = $row["product_image"];
            $productLink = $row["product_link"];
            $productPrice = $row["product_price"];
            $productId = $row["product_id"];
            $productCategory = $row["product_category"];
            echo "<form method='post' action='add_to_cart.php' class='product-form'>";
            echo "<div class='prod-cont'>";
            echo "<div class='prod-cont-col1'>";
            echo "<img src='../$productImage' alt='' class='prod-img'>";
            echo "</div>";
            echo "<div class='prod-cont-col2'>";
            echo "<h1 class='prod-name'>$productName</h1>";
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
            echo "<a class='review-count-text'>($reviewCount reviews)</a></h2>";
            echo "<h2 class='prod-category'>Category: $productCategory</h2>";
            echo "<h2 class='prod-description'>$productDescription</h2>";
            echo "<div class='price-cart-cont'>";
            echo "<h3 class='prod-price'>&#8369;$productPrice</h3>";
            echo "<div class='quantity-control'>";
            echo "<input type='hidden' name='user_id' value='$curr_user_id'>";
            echo "<input type='hidden' name='product_id' value='$productId'>";
            echo "<label for='quantity' id='label-quantity'>Qty: </label>";
            echo "<input type='number' name='quantity' value='1' min='1' max='99' class='quantity-input' required>";
            echo "</div>";
            echo "<input type='submit' name='add_to_cart' value='Add to Cart' id='add-to-cart-btn'>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</form>";
        } else {
            echo "Product not found";
        }
    } else {
        echo "Invalid product ID";
    }
    $conn->close();
    ?>
    <!-- test -->
    <h2 id="ratings-reviews-title">Ratings & Reviews</h2>
    <?php
    if (isset($_GET['id'])) {
        include('connection_db.php'); ?>

        <div class="reviews-ratings-cont">
        <?php
        $productId = $_GET['id'];

        $sql = "SELECT r.*, u.first_name, u.middle_name, u.last_name, u.image_path
            FROM reviews r
            INNER JOIN user_info u ON r.user_id = u.id
            WHERE r.product_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reviewText = $row['review_text'];
                $rating = $row['rating'];
                $firstName = $row['first_name'];
                $middleName = $row['middle_name'];
                $lastName = $row['last_name'];
                $created_at = $row['created_at'];
                $reviews_id = $row['reviews_id'];
                $image_path = $row['image_path'];

                // Output the review details as needed
                echo "<div class='reviews-text-cont' id=reviews-rating_$reviews_id>";
                echo "<h3 class='name-date-text'><img src='../$image_path' alt='profile_picture' id='user-profile-picture'> {$firstName} <span id='rate-date-created'>on " . date('M d, Y', strtotime($created_at)) . " &bull; " . date('g:i a', strtotime($created_at)) . "</span></h3>";
                echo "<p>Ratings: ";
                if ($rating == 5) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                    ";
                } elseif ($rating == 4) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;&#9733;&#9733;<span class='star-rating-grey'>&#9733;</span></span>
                    ";
                } elseif ($rating == 3) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;&#9733;<span class='star-rating-grey'>&#9733;&#9733;</span></span>
                    ";
                } elseif ($rating == 2) {
                    echo "
                    <span class='star-rating'>&#9733;&#9733;<span class='star-rating-grey'>&#9733;&#9733;&#9733;</span></span>
                    ";
                } elseif ($rating == 1) {
                    echo "
                    <span class='star-rating'>&#9733;<span class='star-rating-grey'>&#9733;&#9733;&#9733;&#9733;</span></span>
                    ";
                } else {
                    echo "
                    <span class='star-rating'><span class='star-rating-grey'>&#9733;&#9733;&#9733;&#9733;&#9733;</span></span>
                    ";
                }
                echo "</p>";
                echo "<a>{$reviewText}</a>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-reviews-text'>No reviews found for this product.</p>";
        }

        $stmt->close();
        $conn->close();
    }
        ?>
        </div>
        <?php include('footer.php'); ?>
</body>

</html>