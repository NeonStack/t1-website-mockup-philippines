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
    <link rel="stylesheet" href="../css/terms-of-service.css">
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
        <h1 class="main-title">T1 Shop Philippines Terms of Service</h1>

        <h4>Welcome to T1 Shop Philippines! Please carefully read the following terms and conditions governing your use of our website. By accessing and using our website, you agree to comply with and be bound by these terms. If you do not agree with any part of these terms, please do not use our website.</h4>

        <hr>

        <h2>1. Use of the Website</h2>

        <p>1.1 You must be at least 18 years old to use this website. By using the website, you represent and warrant that you are at least 18 years old.</p>
        <p>1.2 You agree to provide accurate, current, and complete information when creating an account on our website. It is crucial that your information is precise, especially for our cash-on-delivery services.</p>
        <p>1.3 You understand and agree that T1 Shop Philippines reserves the right to refuse service, terminate accounts, or cancel orders at our discretion.</p>

        <h2>2. Intellectual Property</h2>

        <p>2.1 The content on this website, including but not limited to text, graphics, logos, images, and software, is not owned by T1 Shop Philippines. This website is created as a project for web development purposes and utilizes content from various sources.</p>
        <p>2.2 You may not reproduce, distribute, display, or create derivative works of any content on this website without the express written permission of the respective owners of the intellectual property.</p>

        <h2>3. User Conduct</h2>

        <p>3.1 You agree not to engage in any conduct that violates any applicable laws or regulations.</p>
        <p>3.2 You are solely responsible for maintaining the confidentiality of your account information and password. It is imperative that you submit accurate information, especially for our cash-on-delivery services, to ensure smooth delivery to your house.</p>

        <h2>4. Limitation of Liability</h2>

        <p>4.1 T1 Shop Philippines is not liable for any direct, indirect, incidental, consequential, or punitive damages arising out of your use or inability to use the website.</p>
        <p>4.2 We do not guarantee the accuracy, completeness, or timeliness of information on the website.</p>
        <p>4.3 You agree that your use of our website is at your sole risk, and you assume full responsibility for any costs associated with your use of our website.</p>

        <h2>5. Termination</h2>

        <p>5.1 T1 Shop Philippines reserves the right to terminate or suspend your account and access to the website for any reason without prior notice.</p>
        <p>5.2 You may terminate your account by contacting us at <a href="mailto:t1.shop.ph.global@gmail.com">t1.shop.ph.global@gmail.com</a>.</p>

        <h2>6. Changes to Terms</h2>

        <p>6.1 T1 Shop Philippines may revise these terms at any time without notice. By using the website, you agree to be bound by the current version of these terms.</p>
        <p>6.2 It is your responsibility to review these terms periodically for changes.</p>

        <h2>7. Contact Us</h2>

        <p>If you have any questions or concerns regarding our Terms of Service, please contact us at <a href="mailto:t1.shop.ph.global@gmail.com">t1.shop.ph.global@gmail.com</a>.</p>

        <p style="margin: 20px 40px">Thank you for choosing T1 Shop Philippines!</p>
        <p>Effective Date: December 08, 2023</p>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>