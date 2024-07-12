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
    <link rel="stylesheet" href="../css/privacy-policy.css">
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
        <h1 class="main-title">T1 Shop Philippines Privacy Policy</h1>

        <h4>Welcome to T1 Shop Philippines! At T1 Shop Philippines, we are committed to protecting the privacy and security of your personal information. This Privacy Policy outlines how we collect, use, and protect the information you provide when using our website.</h4>

        <hr>

        <h2>1. Information We Collect</h2>

        <h3>1.1 Personal Information</h3>

        <p>When you create an account on T1 Shop Philippines, we collect various pieces of personal information to enhance your shopping experience. This includes your name, email address, and a securely encrypted password. Additionally, when you make a purchase, we collect billing and shipping information to process your orders efficiently. We may also ask for additional information, such as phone numbers or preferences, to better tailor our services to your needs.</p>

        <h3>1.2 Non-Personal Information</h3>

        <p>For the functionality of our sign-up process, we use cookies. Cookies are small text files stored on your device that help us recognize you when you return to our site. These cookies are used exclusively for the sign-up process and do not capture personal information.</p>

        <h2>2. How We Use Your Information</h2>

        <p>At T1 Shop Philippines, we take privacy seriously. Your personal information is used solely for the purpose of processing your orders and providing customer support. We prioritize the security of your data by encrypting your password and adhering to industry-standard security measures. Rest assured that we do not use your email for spam, marketing notifications, or advertisements. Cookies, employed only for the functionality of the sign-up process, are a standard web practice to enhance user experience.</p>

        <h2>3. Account Security</h2>

        <p>We understand the importance of securing your personal information. Your T1 Shop Philippines account is protected by encryption and industry-standard security protocols. Our commitment to maintaining the highest standards of security means that we regularly update our security measures to safeguard your information against potential threats.</p>

        <h2>4. Third-Party Disclosure</h2>

        <p>At T1 Shop Philippines, we prioritize transparency. We want you to feel confident that your personal information is safe with us. Therefore, we do not sell, trade, or otherwise transfer your personal information to outside parties. Your trust in our commitment to privacy is of utmost importance to us.</p>

        <h2>5. Your Consent</h2>

        <p>By using our website, you explicitly consent to the terms outlined in our Privacy Policy. Your trust is essential to us, and we are dedicated to maintaining the confidentiality and security of your personal information.</p>

        <h2>6. Changes to Privacy Policy</h2>

        <p>Our commitment to transparency extends to keeping you informed about any changes to our Privacy Policy. We may update this policy to reflect changes in our practices or to comply with legal requirements. Please check the "Effective Date" below for the latest version of our Privacy Policy.</p>

        <h2>7. Contact Us</h2>

        <p>If you have any questions or concerns regarding our Privacy Policy, please do not hesitate to contact us at <a href="mailto:t1.shop.ph.global@gmail.com">t1.shop.ph.global@gmail.com</a>. Your satisfaction and peace of mind are important to us, and we are here to address any inquiries you may have.</p>

        <p style="margin: 20px 40px">Thank you for choosing T1 Shop Philippines!</p>
        <p>Effective Date: December 08, 2023</p>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>