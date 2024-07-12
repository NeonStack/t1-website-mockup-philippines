<?php
include('connection_db.php');
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$user_id = $curr_user_id;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T1 Merchandise - PH</title>
    <link rel="icon" href="../img/Red+Logo-tab.png">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/loading.css">
    <script src="../script/profile.js" defer></script>
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
                <li><a href="signin.php">Sign-in</a></li>
                <li><a href="shop.php?category=All">Shop</a></li>
                <li><a href="cart.php"><i class="fa-sharp fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></a></li>
                <li><a href="profile.php" class="selected-nav"><i class="fa-solid fa-user"></i></a></li>

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
                                echo ($cart_count > 0) ? $cart_count : '0';
                            } else {
                                echo "Error";
                            }
                            $stmt->close();
                            $conn->close();
                            ?></span></a></li>
                <li class="li-profile-link selected-nav-bordered"><a onclick="expandProfile()" id="profile-link"><i class="fa-solid fa-user"></i><span class="li-user-name">&bull;
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
        <h1 id="page-title">PROFILE</h1>
    </div>
    <?php if (!$curr_user_id) : ?>
        <div class="profile-cont-cont">
            <div class='empty-cont'>
                <p class='empty-cont-row1'>You are not currently signed-in</p>
                <div class='empty-cont-row2'>
                    <a class='suggestion-btn' href='signup.php'>Create an Account</a>
                    <a class='suggestion-btn' href='signin.php'>Sign In</a>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="profile-cont-cont">
            <div class="profile-cont">
                <?php
                include('connection_db.php');

                $getUserInfoQuery = "SELECT * FROM user_info WHERE id = ?";
                $stmt = $conn->prepare($getUserInfoQuery);
                $stmt->bind_param('i', $curr_user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $userInfo = $result->fetch_assoc();

                $userinfo_first_name = $userInfo['first_name'];
                $userinfo_middle_name = $userInfo['middle_name'];
                $userinfo_last_name = $userInfo['last_name'];
                $userinfo_cell_number = $userInfo['cell_number'];
                $userinfo_email_address = $userInfo['email_address'];
                $userinfo_city = $userInfo['city'];
                $userinfo_postal_code = $userInfo['postal_code'];
                $userinfo_barangay = $userInfo['barangay'];
                $userinfo_street = $userInfo['street'];
                $userinfo_profile_picture = $userInfo['image_path'];

                $infoLabels = [
                    'First Name' => $userinfo_first_name,
                    'Middle Name' => $userinfo_middle_name,
                    'Last Name' => $userinfo_last_name,
                    'Cell Number' => $userinfo_cell_number,
                    'Email Address' => $userinfo_email_address,
                    'City' => $userinfo_city,
                    'Postal Code' => $userinfo_postal_code,
                    'Barangay' => $userinfo_barangay,
                    'Street' => $userinfo_street,
                    'Password' => "&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                ];
                ?>
                <div class="profile-picture-cont">
                    <div class="user-profile-picture-cont">
                        <div class="user-profile-picture-top-cont">
                            <img src="../<?php echo $userinfo_profile_picture ?>" alt="profile_picture" id="user-profile-picture">
                        </div>
                    </div>
                    <form id="profilePictureForm" action="user-change-info.php" method="post" enctype="multipart/form-data">
                        <label for="new_profile_picture" class="file-label-profile-picture">Change profile picture</label>
                        <input type="file" name="new_profile_picture" id="new_profile_picture" class="file-input-profile-picture" accept="image/jpeg, image/jpg, image/png, image/bmp, image/tiff, image/webp" onchange="submitForm()">
                    </form>
                </div>
                <?php
                foreach ($infoLabels as $label => $value) {
                    echo '<div class="info-cont">';
                    echo '<div class="info-cont-title">' . $label . ':</div>';
                    echo '<div class="info-cont-text">';
                    echo '<p>' . $value . '</p>';
                    echo '</div>';
                    echo '<div class="info-cont-button-change">';
                    if ($label == 'Email Address') {
                        echo '<button id="openForm-btn">Cannot Change</button>';
                    } elseif ($label == 'Password') {
                        echo '<form method="post" action="password-reset-from-profile.php" id="changePasswordProfileForm">';
                        echo '    <button type="submit" name="change-pass-btn" id="change-pass-btn">Change</button>';
                        echo '</form>';
                    } else {
                        echo '<button onclick="openForm(\'' . strtolower(str_replace(' ', '_', $label)) . '\')" id="openForm-btn">Change</button>';
                    }
                    echo '</div>';
                    echo '</div>';

                    echo '<form id="' . strtolower(str_replace(' ', '_', $label)) . '_form" class="profile-form" action="user-change-info.php" method="post">';
                    echo '<div class="profile-form-close-btn"><i class="fas fa-times"></i>
                    </div>';
                    echo '<p class="profile-form-current-value"><span class="profile-form-current-value-txt">Current ' . $label . ':</span> ' . $value . '</p>';
                    echo '<div class="profile-form-label-input-cont">';
                    echo '<label for="new_' . strtolower(str_replace(' ', '_', $label)) . '">New ' . $label . ':</label>';
                    if ($label == 'Cell Number') {
                        echo '<input type="tel" placeholder="Enter new ' . $label . '" pattern="\+63[0-9]{10}" value="+63" id="new_' . strtolower(str_replace(' ', '_', $label)) . '" name="new_' . strtolower(str_replace(' ', '_', $label)) . '" class="profile-form-input-text" required>';
                    } elseif ($label == 'Postal Code') {
                        echo '<input type="number" placeholder="Enter new ' . $label . '" id="new_' . strtolower(str_replace(' ', '_', $label)) . '" name="new_' . strtolower(str_replace(' ', '_', $label)) . '" class="profile-form-input-text" required>';
                    } elseif ($label == 'Middle Name') {
                        echo '<input type="text" placeholder="Enter new ' . $label . '" id="new_' . strtolower(str_replace(' ', '_', $label)) . '" name="new_' . strtolower(str_replace(' ', '_', $label)) . '" class="profile-form-input-text" >';
                    } else {
                        echo '<input type="text" placeholder="Enter new ' . $label . '" id="new_' . strtolower(str_replace(' ', '_', $label)) . '" name="new_' . strtolower(str_replace(' ', '_', $label)) . '" class="profile-form-input-text" required>';
                    }

                    echo '</div>';
                    echo '<input type="submit" value="Submit" id="profile-form-submit-btn">';
                    echo '</form>';
                }
                $stmt->close();
                $conn->close();
                ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['profile_update_message'])) : ?>
        <div class="floatingMessageInfo" style="<?php echo isset($_SESSION['profile-form-status-success']) ? ($_SESSION['profile-form-status-success'] ? 'background: rgba(0, 170, 0, 0.837);' : 'background: rgba(170, 17, 0, 0.837);') : ''; ?>">
            <?php $notif_msg = $_SESSION['profile_update_message']; ?>
            <p class="floatingMessageInfo-txt"><?php echo $notif_msg ?></p>
            <?php $_SESSION['profile_update_message'] = null ?>
        </div>
    <?php endif; ?>
    <?php include('footer.php'); ?>
</body>

</html>