<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
include('connection_db.php');
if (!$curr_user_id) {
    header("Location: signin.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T1 Merchandise - PH</title>
    <link rel="icon" href="../img/Red+Logo-tab.png">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/orders.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/loading.css">
    <script src="../script/loading.js" defer></script>
    <script src="../script/orders.js" defer></script>
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
                <li><a href="shop.php?category=All">Shop</a></li>
                <li><a href="cart.php"><i class="fa-sharp fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></a></li>
                <li><a href="profile.php"><i class="fa-solid fa-user"></i></a></li>

                <!-- LOGGED IN -->
            <?php else : ?>
                <li><a href="shop.php?category=All">Shop</a></li>
                <li><a href="orders.php?category=All%20Orders" class="selected-nav">Orders</a></li>
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
    <!-- SHOWING COUNT AT UNDERLINE SA CATEGORRIES -->
    <div class="selection-bar">
        <h4>SORT BY: </h4>
        <a href="?category=All Orders" <?php if (isset($_GET['category'])) {
                                            $category = $_GET['category'];
                                            if ($category === 'All Orders') {
                                                echo "class='selected-subnav'";
                                            }
                                        } ?>>All Orders <span class="orders-count">
                <?php
                include('connection_db.php');
                $sql = "SELECT COUNT(*) AS orders_count FROM orders WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $curr_user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $orders_count = $row['orders_count'];
                    echo ($orders_count > 0) ? $orders_count : '0';
                } else {
                    echo "Error";
                }
                $stmt->close();
                $conn->close();
                ?></span></a>
        <h4 class="hrule">|</h4>
        <a href="?category=Processing" <?php if (isset($_GET['category'])) {
                                            $category = $_GET['category'];
                                            if ($category === 'Processing') {
                                                echo "class='selected-subnav'";
                                            }
                                        } ?>>Processing <span class="orders-count">
                <?php
                include('connection_db.php');
                $sql = "SELECT COUNT(*) AS orders_count FROM orders WHERE user_id = ? AND status = 'Processing'";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $curr_user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $orders_count = $row['orders_count'];
                    echo ($orders_count > 0) ? $orders_count : '0';
                } else {
                    echo "Error";
                }
                $stmt->close();
                $conn->close();
                ?></span></a>
        <h4 class="hrule">|</h4>
        <a href="?category=Shipping" <?php if (isset($_GET['category'])) {
                                            $category = $_GET['category'];
                                            if ($category === 'Shipping') {
                                                echo "class='selected-subnav'";
                                            }
                                        } ?>>Shipping <span class="orders-count">
                <?php
                include('connection_db.php');
                $sql = "SELECT COUNT(*) AS orders_count FROM orders WHERE user_id = ? AND status = 'Shipping'";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $curr_user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $orders_count = $row['orders_count'];
                    echo ($orders_count > 0) ? $orders_count : '0';
                } else {
                    echo "Error";
                }
                $stmt->close();
                $conn->close();
                ?></span></a>
        <h4 class="hrule">|</h4>
        <a href="?category=Delivered" <?php if (isset($_GET['category'])) {
                                            $category = $_GET['category'];
                                            if ($category === 'Delivered') {
                                                echo "class='selected-subnav'";
                                            }
                                        } ?>>Delivered <span class="orders-count">
                <?php
                include('connection_db.php');
                $sql = "SELECT COUNT(*) AS orders_count FROM orders WHERE user_id = ? AND status = 'Delivered'";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $curr_user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $orders_count = $row['orders_count'];
                    echo ($orders_count > 0) ? $orders_count : '0';
                } else {
                    echo "Error";
                }
                $stmt->close();
                $conn->close();
                ?></span></a>
    </div>

    <!-- SHOWING ITEMS SORT BY -->
    <?php
    include('connection_db.php');
    if (isset($_GET['category'])) {
        if ($_GET['category'] == 'All Orders') {
            $user_id = $curr_user_id;
            $sql = "SELECT *
        FROM orders
        WHERE user_id = ?";
        } else if ($_GET['category'] == 'Processing') {
            $user_id = $curr_user_id;
            $sql = "SELECT *
        FROM orders
        WHERE user_id = ? AND status = 'Processing'";
        } else if ($_GET['category'] == 'Shipping') {
            $user_id = $curr_user_id;
            $sql = "SELECT *
        FROM orders
        WHERE user_id = ? AND status = 'Shipping'";
        } else if ($_GET['category'] == 'Delivered') {
            $user_id = $curr_user_id;
            $sql = "SELECT *
        FROM orders
        WHERE user_id = ? AND status = 'Delivered'";
        } else {
            $user_id = $curr_user_id;
            $sql = "SELECT * FROM orders WHERE user_id = ?";
        }
    } else {
        $user_id = $curr_user_id;
        $sql = "SELECT * FROM orders WHERE user_id = ?";
    }


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $order_id = $row['order_id'];
            $product_id = $row['product_id'];
            $order_date = date('Y-m-d', strtotime($row['order_date']));
            $expected_delivery_date = $row['expected_delivery_date'];
            $quantity = $row['quantity'];
            $total_price = $row['total_price'];
            $product_image = $row['product_image'];
            $product_name = $row['product_name'];
            $isRemovable = $row['isRemovable'];
            $order_status = $row['status'];
            $isRated = $row['isRated'];

            echo "
        <div class='each-order'>
            <div class='each-order-col1'>
            <img src='../$product_image' alt='$product_name' id='product-img'>
            </div>
            <div class='each-order-col2'>
            <p><strong>Product:</strong> $product_name</p>
            <p><strong>Order ID:</strong> $order_id</p>
            <p><strong>Date Ordered:</strong> $order_date</p>
            <p><strong>Expected Delivery Date:</strong> $expected_delivery_date</p>
            <p><strong>Quantity:</strong> $quantity</p>
            <p><strong>Total Price:</strong> &#8369;$total_price</p>
            </div>
            ";
            echo "<div class='each-order-col3'>";
            if ($isRemovable) {
                echo "<h4 class='order-status'>STATUS: $order_status</h4>";
                echo "<a href='remove_order.php?order_id=$order_id' class='remove-order'>Cancel Order</a>";
            } elseif ($order_status == 'Delivered') {
                echo "<h4 class='order-status'>STATUS: $order_status</h4>";
                if ($isRated) {
                    // FINdning reviews_id based on order_id
                    $stmtFindReviewId = $conn->prepare("SELECT reviews_id FROM reviews WHERE order_id = ?");
                    $stmtFindReviewId->bind_param("i", $order_id);
                    $stmtFindReviewId->execute();
                    $resultFindReviewId = $stmtFindReviewId->get_result();

                    if ($resultFindReviewId->num_rows > 0) {
                        $rowFindReviewId = $resultFindReviewId->fetch_assoc();
                        $reviews_id = $rowFindReviewId['reviews_id'];

                        echo "<a class='rate-order' href='product.php?id=$product_id#reviews-rating_$reviews_id' id='view-ratings-btn'>View your ratings</a>";
                    } else {
                        echo "<p class='error-message'>Error: Reviews ID not found</p>";
                    }

                    $stmtFindReviewId->close();
                } else {
                    echo "<a class='rate-order' href='orders.php?category=Delivered&toRate=$order_id'>Rate this product</a>";
                }
            } else {
                echo "<h4 class='order-status'>STATUS: $order_status</h4>";
                echo "<a class='remove-order' style='cursor: not-allowed;'>Cancellation not available now</a>";
            }

            echo "</div>";

            echo "</div>";
        }
    } else {
        echo "
        <div class='empty-cont'>
            <p class='empty-cont-row1'>No orders found</p>
            <div class='empty-cont-row2'>
                <a class='suggestion-btn' href='shop.php'>GO TO SHOP</a>
                <a class='suggestion-btn' href='../index.php#featured-title'>GO TO FEATURED</a>
            </div>
        </div>
        ";
    }

    $stmt->close();
    ?>




    <!-- RATING SECTION -->
    <?php if (isset($_GET['toRate'])) : ?>
        <?php
        include('connection_db.php');
        $sql = "SELECT * FROM orders WHERE order_id = ? AND status = 'Delivered' AND $curr_user_id = user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_GET['toRate']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $order_id = $row['order_id'];
            $user_id = $row['user_id'];
            $product_id = $row['product_id'];
            $order_date = $row['order_date'];
            $quantity = $row['quantity'];
            $total_price = $row['total_price'];
            $user_city = $row['user_city'];
            $user_postal_code = $row['user_postal_code'];
            $user_barangay = $row['user_barangay'];
            $user_street = $row['user_street'];
            $user_cell_number = $row['user_cell_number'];
            $user_email_address = $row['user_email_address'];
            $isRemovable = $row['isRemovable'];
            $status = $row['status'];
            $expected_delivery_date = $row['expected_delivery_date'];
            $product_name = $row['product_name'];
            $first_name = $row['first_name'];
            $middle_name = $row['middle_name'];
            $last_name = $row['last_name'];
            $product_image = $row['product_image'];
        ?>
            <div id="ratingModal" class="modal">
                <div class="modal-content">
                    <div class="modal-img-cont">
                        <img src="../<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>">
                    </div>
                    <div class="modal-text-cont">
                        <span class="close" onclick="closeRatingModal()">&times;</span>
                        <h2><?php echo $product_name; ?></h2>
                        <form method="post" action="submit_review.php">
                            <p>Write your review:</p>
                            <textarea name="comment_text" rows="4" placeholder="Write your review here..." required></textarea>
                            <div class="star-submit-cont">
                                <div class="star-cont">
                                    <p>Rate the product:</p>
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rate" value="5" checked required />
                                        <label for="star5" title="5 star rating">5 stars</label>
                                        <input type="radio" id="star4" name="rate" value="4" />
                                        <label for="star4" title="4 star rating">4 stars</label>
                                        <input type="radio" id="star3" name="rate" value="3" />
                                        <label for="star3" title="3 star rating">3 stars</label>
                                        <input type="radio" id="star2" name="rate" value="2" />
                                        <label for="star2" title="2 star rating">2 stars</label>
                                        <input type="radio" id="star1" name="rate" value="1" />
                                        <label for="star1" title="1 star rating">1 star</label>
                                    </div>
                                </div>
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                <button type="submit" id="submit-btn-ratings">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
        $stmt->close();
        ?>
    <?php endif; ?>
    <?php include('footer.php'); ?>
</body>

</html>