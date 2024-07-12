<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
if (isset($curr_user_id)) {
    header("Location: ../index.php");
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
    <link rel="stylesheet" href="../css/signin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/loading.css">
    <script src="../script/loading.js" defer></script>
    <script src="../script/signin.js" defer></script>
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
                                echo ($cart_count>0)?$cart_count:'0';
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
                            $row = $result -> fetch_assoc();
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
    <div class="signin-cont">
        <div class="details-cont">
        </div>
        <form action="signin.php" method="post">
            <h1 id="form-title">SIGN IN</h1>
            <hr>
            <div class="signin-each-cont">
                <label for="l_username">USERNAME OR EMAIL</label>
                <div class="username-cont">
                    <input type="text" name="l_username" id="l_username" placeholder="Enter username or email" title="Enter your username email" class="signin-inputs" required>
                </div>

            </div>
            <div class="signin-each-cont">
                <label for="l_password">PASSWORD</label>
                <div class="password-cont">
                    <input type="password" name="l_password" id="l_password" placeholder="Enter password" title="Enter your password" class="signin-inputs" required>
                </div>
            </div>
            <?php
            include('connection_db.php');
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $error_count = 0;
                $username_or_email = $_POST['l_username'];
                $match_found = false;

                $sql = "SELECT id, username, password, email_address FROM user_info";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    if ($username_or_email == $row['username'] || $username_or_email == $row['email_address']) {
                        $match_found = true;

                        if (password_verify($_POST['l_password'], $row['password'])) {
                            session_start();
                            $_SESSION['id'] = $row['id'];
                            header("Location: ../index.php");
                            exit();
                        } else {
                            echo "<p class='error_msg'>Incorrect Password!</p>";
                        }

                        break;
                    }
                }

                if (!$match_found) {
                    echo "<p class='error_msg'>Username or Email cannot be found!</p>";
                }
            }
            $conn->close();
            ?>
            <a href="signup.php" id="no-account-sign-in-link">Don't have an account?  Sign up</a>
            <div class="signin-each-cont">       
                <input type="submit" value="Sign in" id="submit-btn">
                <a href="forgot-password.php" id="forgot-password-btn">Forgot password?</a>
            </div>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>