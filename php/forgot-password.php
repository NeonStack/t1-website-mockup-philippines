<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
($curr_user_id ? header('Location: ../index.php') : '');
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
    <link rel="stylesheet" href="../css/forgot-password.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/loading.css">
    <script src="../script/loading.js" defer></script>
    <script src="../script/forgot-password.js" defer></script>
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
    <!-- gagawa ka na ng forgot passsword and achuchu -->
    <form action="forgot-password.php" id="forgot-password-form" method="post">
        <h2 id="form-title">Find your T1 account</h2>
        <p id="form-explain">Enter your username or email associated with your account to change your password.</p>
        <input type="text" placeholder="Username or Email" id="form-input-username-email" name="usernameOrEmailInput" required>
        <input type="submit" value="Next" id="submit-btn">
        <?php

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require '../PHPMailer/src/Exception.php';
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';

        include 'connection_db.php';
        $_SESSION['FromProfileResetPassword'] = isset($_SESSION['FromProfileResetPassword']) ? $_SESSION['FromProfileResetPassword'] : false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SESSION['FromProfileResetPassword']) {
            function generateResetCode()
            {
                return rand(100000, 999999);
            }

            $userEmailOrUsername = $_SESSION['FromProfileResetPassword'] ? $_SESSION['user_email'] : $_POST['usernameOrEmailInput'];

            // Check if email or username exists
            $checkSql = "SELECT email_address, first_name FROM user_info WHERE email_address = ? OR username = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param('ss', $userEmailOrUsername, $userEmailOrUsername);
            $checkStmt->execute();
            $checkStmt->store_result(); // Store the result set
            $checkStmt->bind_result($userEmail, $first_name);

            if ($checkStmt->num_rows > 0) {
                $checkStmt->fetch(); // Fetch the result after checking the number of rows

                // Email or username exists, proceed with password reset
                $resetCode = generateResetCode();

                // Set up PHPMailer
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 't1.shop.ph.global@gmail.com';
                $mail->Password   = 'ezbj dqkn amec zrtn';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
                $mail->setFrom('t1.shop.ph.global@gmail.com', 'T1 Support PH');
                $mail->addAddress($userEmail);
                $mail->Subject = "Password Reset Code";
                $mail->isHTML(true);
                $mail->Body = '<div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
                            <h1 style="color: #333333; font-size: 24px;">T1 ACCOUNT PASSWORD RESET</h1>
                            <p style="color: #555555;">Hello <strong style="color: #007BFF;">' . $first_name . ',</strong></p>
                            <p style="color: #555555;">We received a request to reset your password. To proceed with the password reset, please use the following code:</p>
                            <p style="font-size: 24px; color: #007BFF; margin-bottom: 20px;"><strong>Reset Code:</strong> ' . $resetCode . '</p>
                            <p style="color: #555555;">This code will expire in 15 minutes. If you did not request a password reset, please ignore this email.</p>
                            <p style="margin-top: 20px; color: #888888;">Thank you,<br>T1 Shop Philippines</p>
                        </div>';
                try {
                    $mail->send();

                    date_default_timezone_set('Asia/Manila');
                    $timenowManila = time();
                    $expireTime = date('Y-m-d H:i:s', strtotime('+15 minutes', $timenowManila));

                    $updateSql = "UPDATE user_info SET reset_code = ?, reset_code_expires_at = ? WHERE email_address = ?";
                    $updateStmt = $conn->prepare($updateSql);

                    $resetCode = password_hash($resetCode, PASSWORD_BCRYPT);
                    $updateStmt->bind_param('sss', $resetCode, $expireTime, $userEmail);
                    $updateStmt->execute();

                    if ($updateStmt->affected_rows > 0) {
                        $fetchUserIdSql = "SELECT id FROM user_info WHERE email_address = ?";
                        $fetchUserIdStmt = $conn->prepare($fetchUserIdSql);
                        $fetchUserIdStmt->bind_param('s', $userEmail);
                        $fetchUserIdStmt->execute();
                        $fetchUserIdStmt->bind_result($userId);
                        $fetchUserIdStmt->fetch();
                        $fetchUserIdStmt->close();
                        // Set the session variable
                        $_SESSION['user-reset-password-id'] = $userId;
                        $_SESSION['auth'] = true;
                        unset($_SESSION['user_email']);
                        header('Location: password-reset-code-verify.php');
                        exit();
                    } else {
                        echo '<p class="error-msg-cont">Error updating database.</p>';
                    }

                    // Close the statement
                    $updateStmt->close();
                } catch (Exception $e) {
                    echo '<p class="error-msg-cont">Error sending email. ' . $mail->ErrorInfo . '</p>';
                }
            } else {
                echo '<p class="error-msg-cont">Email or username does not exist.</p>';
            }

            // Close the statement for checking existence
            $checkStmt->close();
        }

        // Close the MySQLi connection
        $conn->close();
        ?>
    </form>

    <?php include('footer.php'); ?>

</body>

</html>