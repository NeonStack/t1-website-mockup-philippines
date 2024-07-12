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
    <link rel="stylesheet" href="../css/faqs.css">
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
    <div class="main-container">
        <h1 class="main-title">T1 Shop Philippines FAQs</h1>

        <hr>

        <div class="section">
            <h2>1. How do I create an account on T1 Shop Philippines?</h2>
            <p>To create an account, simply navigate to the "Sign-Up" page by clicking on the corresponding link in the navigation bar. Fill out the required information, ensuring that all fields are completed accurately. Don't forget to check the hCaptcha to successfully complete the sign-up process.</p>
        </div>

        <div class="section">
            <h2>2. What products do you offer?</h2>
            <p>T1 Shop Philippines proudly offers a diverse range of products, including accessories, apparel, uniforms, and collectibles. All items are intricately designed and inspired by the popular esports team T1.</p>
        </div>

        <div class="section">
            <h2>3. How can I place an order?</h2>
            <p>To place an order, you must have an account with us. Browse through our selection, add your desired items to the cart, and proceed to checkout. Wait for the confirmation if the status is processing.</p>
        </div>

        <div class="section">
            <h2>4. What payment methods are accepted?</h2>
            <p>Currently, we only accept cash on delivery as the payment method. Rest assured, we are exploring additional payment options for future convenience.</p>
        </div>

        <div class="section">
            <h2>5. Is it safe to make online payments on T1 Shop Philippines?</h2>
            <p>At the moment, we do not have online payment options. However, we are actively considering implementing secure online payment methods in the future to enhance your shopping experience.</p>
        </div>

        <div class="section">
            <h2>6. Can I modify or cancel my order after placing it?</h2>
            <p>Orders can be canceled if they are still in the "Processing" status. Once an order reaches the "Shipping" status, cancellation is not possible.</p>
        </div>

        <div class="section">
            <h2>7. How can I track the status of my order?</h2>
            <p>Track your order by signing in to your account and navigating to the "Orders" section in the navigation bar. There, you'll find real-time updates on the status of your order.</p>
        </div>

        <div class="section">
            <h2>8. How do I contact customer support?</h2>
            <p>For any concerns or inquiries, please email us at <a href="mailto:t1.shop.ph.global@gmail.com">t1.shop.ph.global@gmail.com</a>. We are committed to addressing your concerns promptly.</p>
        </div>

        <div class="section">
            <h2>9. What are the contact options for customer support?</h2>
            <p>You can contact us either through our Facebook page at <a href="https://www.facebook.com/profile.php?id=61553904224510" target="_blank">T1 Support</a> by sending a direct message or through our email at <a href="mailto:t1.shop.ph.global@gmail.com">t1.shop.ph.global@gmail.com</a>.</p>
        </div>

        <div class="section">
            <h2>10. Do you offer international shipping?</h2>
            <p>Currently, we only offer shipping within the Philippines. T1 Shop Philippines is tailored specifically for the local market, and international shipping is not available.</p>
        </div>

        <div class="section">
            <h2>11. Are the products authentic?</h2>
            <p>Absolutely! Our products are uniquely crafted and authentic, designed exclusively for passionate T1 fans.</p>
        </div>

        <div class="section">
            <h2>12. How can I reset my password?</h2>
            <p>To reset your password, sign in to your account, click on the profile icon, select "Profile," and scroll to the bottom of the page. Locate the "Password" section and click the "Change" button. If you're unable to sign in, click "Forgot Password" in the navigation bar, and follow the instructions. A code will be sent to your email for verification.</p>
        </div>

        <div class="section">
            <h2>13. Are my personal details secure on T1 Shop Philippines?</h2>
            <p>Yes, your security is our priority. Passwords are hashed using the latest secure hashing techniques. Reset codes are also hashed and are only accessible via your email during the password reset process. We do not share your information unless required by law enforcement.</p>
        </div>

        <div class="section">
            <h2>14. Do you have a physical store?</h2>
            <p>Currently, we operate exclusively online and do not have a physical store in the Philippines. Our services are focused on online transactions with cash on delivery.</p>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>