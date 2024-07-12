<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
($_SESSION['auth'] ? '' : header('Location: ../index.php'));
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
    <link rel="stylesheet" href="../css/password-reset-code-verify.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/loading.css">
    <script src="../script/loading.js" defer></script>
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
                <li><a href="signin.php" class="selected-nav">Sign-in</a></li>
                <li><a href="shop.php?category=All">Shop</a></li>
                <li><a href="cart.php"><i class="fa-sharp fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></a></li>
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
        <h1 id="page-title">ACCOUNT PASSWORD RESET</h1>
    </div>
    <form action="password-reset-code-verify.php" id="forgot-password-form" method="post">
        <h2 id="form-title">We sent you a code</h2>
        <p id="form-explain">Check your email to get your confirmation code. Reset code will expire after 15 minutes.</p>
        <input type="text" placeholder="Enter reset code" id="form-input-reset-code" name="inputtedResetCode" required>
        <input type="submit" value="Next" id="submit-btn">
        <a id="go-back-btn" href="forgot-password.php">Go Back</a>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_reset_password_id = isset($_SESSION['user-reset-password-id']) ? $_SESSION['user-reset-password-id'] : null;

            if ($user_reset_password_id) {
                // Fetch the reset code and expiration time for the user ID
                $fetchResetInfoSql = "SELECT reset_code, reset_code_expires_at FROM user_info WHERE id = ?";
                $fetchResetInfoStmt = $conn->prepare($fetchResetInfoSql);
                $fetchResetInfoStmt->bind_param('i', $user_reset_password_id);
                $fetchResetInfoStmt->execute();
                $fetchResetInfoStmt->bind_result($resetCode, $resetExpiresAt);
                $fetchResetInfoStmt->fetch();
                $fetchResetInfoStmt->close();

                $inputtedResetCode = $_POST['inputtedResetCode'];
                $resetCode;

                if (password_verify($inputtedResetCode, $resetCode)) {
                    // Check if the reset code has expired
                    date_default_timezone_set('Asia/Manila');
                    $currentTimestamp = time();
                    $resetExpiresAtTimestamp = strtotime($resetExpiresAt);
                    echo $resetExpiresAtTimestamp . "<br>";
                    echo $currentTimestamp . "<br>";

                    // Display timestamps in "Y-m-d H:i:s" format
                    $currentTimestampFormatted = date('Y-m-d H:i:s', $currentTimestamp);
                    $resetExpiresAtTimestampFormatted = date('Y-m-d H:i:s', $resetExpiresAtTimestamp);
                    echo $resetExpiresAtTimestampFormatted . "<br>";
                    echo $currentTimestampFormatted . "<br>";


                    if ($currentTimestamp <= $resetExpiresAtTimestamp) {
                        $_SESSION['auth'] = false;
                        $_SESSION['challenge'] = true;
                        header('Location: password-reset-verified.php');
                        exit();
                    } else {
                        // Reset code is expired
                        echo '<p class="error-msg-cont">Reset code has expired. Please go back and request a new one.</p>';
                    }
                } else {
                    // Invalid reset code
                    echo '<p class="error-msg-cont">Invalid reset code. Please try again.</p>';
                }
            } else {
                // Session variable not set, handle the error
                echo '<p class="error-msg-cont">Error: User ID not found.</p>';
            }
        }

        // Close the MySQLi connection
        $conn->close();
        ?>
    </form>

    <?php include('footer.php'); ?>

</body>

</html>