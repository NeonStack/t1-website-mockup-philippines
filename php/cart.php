<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
include('connection_db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T1 Merchandise - PH</title>
    <link rel="icon" href="../img/Red+Logo-tab.png">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/loading.css">
    <script src="../script/loading.js" defer></script>
    <script src="../script/cart.js" defer></script>
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
                <li><a href="cart.php" class="selected-nav"><i class="fa-sharp fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></a></li>
                <li><a href="profile.php"><i class="fa-solid fa-user"></i></a></li>

                <!-- LOGGED IN -->
            <?php else : ?>
                <li><a href="shop.php?category=All">Shop</a></li>
                <li><a href="orders.php?category=All%20Orders">Orders</a></li>
                <li><a href="cart.php" class="selected-nav"><i class="fa-sharp fa-solid fa-cart-shopping" title="My Cart"></i><span class="cart-count">
                            <?php
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
    <div class="page-title-cont">
        <h1 id="page-title">CART</h1>
    </div>
    <?php include('connection_db.php'); ?>
    <?php if (!$curr_user_id) : ?>
        <div class="cart-cont">
            <div class='empty-cont'>
                <p class='empty-cont-row1'>You are not currently signed-in</p>
                <div class='empty-cont-row2'>
                    <a class='suggestion-btn' href='signup.php'>Create an Account</a>
                    <a class='suggestion-btn' href='signin.php'>Sign In</a>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="cart-cont">
            <div class="cart-product-cont">
                <?php
                $grandTotal = 0;  // Initialize grand total

                // Fetch cart items along with product details
                $sql = "SELECT cart.cart_id, cart.quantity, product_list.* FROM cart 
                INNER JOIN product_list ON cart.product_id = product_list.product_id
                WHERE cart.user_id = $curr_user_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $productId = $row['product_id'];
                        $productName = $row['product_name'];
                        $productDescription = $row['product_description'];
                        $productImage = $row['product_image'];
                        $productPrice = $row['product_price'];
                        $quantity = $row['quantity'];

                        // Calculate total price for the product
                        $totalPrice = $productPrice * $quantity;

                        // Update grand total
                        $grandTotal += $totalPrice;

                        echo "
                    <div class='each-cart-product'>
                        <div class='prod-img-cont'>
                            <img src='../$productImage' alt='$productName' class='prod-img'>
                        </div>
                        <div class='prod-details-cont'>
                            <h3 class='prod-name'>$productName</h3>
                            <p class='prod-description'>$productDescription</p>
                            <hr>
                            <p class='prod-price'><strong>Price:</strong> &#8369;$productPrice</p>
                            <form action='update_cart.php' method='post'>
                                <div class='update-btn-cont'>
                                    <label for='quantity'><strong>Quantity:</strong></label>
                                    <input type='number' name='quantity' value='$quantity' min='1' max='99' class='quantity-input' onchange='updateCart(this)'>
                                    <input type='hidden' name='cart_id' value='{$row['cart_id']}'>
                                    <input type='submit' value='Update' style='display: none;' class='update-btn'>
                                </div>
                                <p class='total-price'><strong>Total:</strong> &#8369;$totalPrice</p>
                            </form>
                            <a href='remove_from_cart.php?cart_id={$row['cart_id']}' class='remove-from-cart'>Remove Item</a>
                        </div>
                    </div>
                ";
                    }
                } else {
                    echo "
                <div class='empty-cont'>
                    <p class='empty-cont-row1'>Your Cart is Empty</p>
                    <div class='empty-cont-row2'>
                        <a class='suggestion-btn' href='shop.php'>GO TO SHOP</a>
                        <a class='suggestion-btn' href='../index.php#featured-title'>GO TO FEATURED</a>
                    </div>
                </div>
                ";
                }
                ?>
            </div>
        <?php endif; ?>

        <?php if (!$curr_user_id) : ?>
            <div class="checkout-cont" style="display: none;">

            </div>
        <?php else : ?>
            <div class="checkout-cont">
                <!-- Add the form for checkout here -->
                <form action="checkout.php" method="post">
                    <p class="grand-total">Grand Total: &#8369;<?php echo $grandTotal; ?></p>
                    <?php
                    $sql = "SELECT cart.cart_id, cart.quantity, product_list.* FROM cart 
        INNER JOIN product_list ON cart.product_id = product_list.product_id
        WHERE cart.user_id = $curr_user_id";
                    $result = $conn->query($sql);
                    if (!$result->num_rows > 0) :
                    ?>
                        <input type="submit" class="checkout-btn" value="Checkout" style='display: none;'>
                    <?php else : ?>
                        <input type="submit" class="checkout-btn" value="Checkout">
                    <?php endif; ?>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <?php $conn->close(); ?>
    <?php include('footer.php'); ?>
</body>
</html>