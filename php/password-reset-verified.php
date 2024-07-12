<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
($_SESSION['challenge'] ? '' : header('Location: ../index.php'));
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
    <link rel="stylesheet" href="../css/password-reset-verified.css">
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
    <form action="password-reset-verified.php" id="forgot-password-form" method="post">
        <h2 id="form-title">Choose a new password</h2>
        <p id="form-explain">Make sure your new password is 8-16 characters only. Try including numbers, letters, and punctuation marks for a strong password. </p>
        <input type="password" placeholder="Enter your new password" id="form-input-password" name="inputtedPassword" maxlength="16" minlength="8" required>
        <input type="password" placeholder="Re-type your new password" id="form-input-retype-password" name="inputtedRetypedPassword" required>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_reset_password_id = isset($_SESSION['user-reset-password-id']) ? $_SESSION['user-reset-password-id'] : null;
            $input_password = $_POST['inputtedPassword'];
            $input_retype_password = $_POST['inputtedRetypedPassword'];

            if ($input_password === $input_retype_password) {
                $input_password = password_hash($input_password, PASSWORD_BCRYPT);
                $updatePasswordStmt = $conn->prepare("UPDATE user_info SET password = ?, reset_code = NULL, reset_code_expires_at = NULL WHERE id = ?");
                if ($updatePasswordStmt) {
                    $updatePasswordStmt->bind_param('si', $input_password, $user_reset_password_id);
                    $updatePasswordStmt->execute();
                    $updatePasswordStmt->close();
                    unset($_SESSION['user-reset-password-id']);
                    unset($_SESSION['challenge']);
                    $_SESSION['auth'] = true;
                    header('Location: success_page.php');
                    exit();
                } else {
                    // Handle prepare error
                    echo "<p class='error-msg-cont'>Prepare error: " . $conn->error."</p>";
                }
            } else {
                // Handle password mismatch error
                echo "<p class='error-msg-cont'>Passwords do not match</p>";
            }
        }
        ?>
        <input type="submit" value="Next" id="submit-btn">
    </form>
    <!-- update password ng user -->
    <?php include('footer.php'); ?>

</body>

</html>

<!--
    $_SESSION['challenge']
    $_SESSION['user-reset-password-id']
     $fetchResetInfoSql = "SELECT reset_code, reset_code_expires_at FROM user_info WHERE id = ?";
                $fetchResetInfoStmt = $conn->prepare($fetchResetInfoSql);
                $fetchResetInfoStmt->bind_param('i', $user_reset_password_id);
                $fetchResetInfoStmt->execute();
                $fetchResetInfoStmt->bind_result($resetCode, $resetExpiresAt);
                $fetchResetInfoStmt->fetch();
                $fetchResetInfoStmt->close();
-->