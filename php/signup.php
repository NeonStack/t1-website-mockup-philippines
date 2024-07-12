<?php

session_start();

$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if (isset($curr_user_id)) {

    header("Location: ../index.php");

}

?>

<?php

$u_fname = '';

$u_lname = '';

$u_mname = '';

$u_username = '';

$u_password = '';

$u_retype_password = '';

$u_cellnum = '';

$u_email = '';

$u_barangay = '';

$u_street = '';

$u_city = '';

$u_postal_code = '';

$u_retype_password_error_mismatch = '';

$u_username_error_length = '';

$u_username_error_exist = '';

$u_password_error_length = '';

$u_email_error_exist = '';

$error_count = 0;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    //HCAPTHCA

    $secretKey = 'YOUR_SECRET_KEY'; // Replace with your hCaptcha secret key

    $captchaResponse = $_POST['h-captcha-response'];



    // Build the verification URL

    $verificationUrl = "https://api.hcaptcha.com/siteverify";



    // Build the POST data

    $postData = array(

        'secret' => $secretKey,

        'response' => $captchaResponse,

    );



    // Initialize cURL session

    $ch = curl_init($verificationUrl);



    // Set cURL options

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



    // Execute cURL session and get the response

    $verificationResult = curl_exec($ch);



    // Close cURL session

    curl_close($ch);



    // Decode the JSON response

    $verificationData = json_decode($verificationResult);



    if ($verificationData->success) {

        echo "Captcha verification successful!";

    } else {

        $error_count++;

        $u_captcha_not_verified= "Please verify if you are a human by checking the hCaptcha";

    }

    //END HCAPTCHA



    include('connection_db.php');

    // Personal Information

    $u_fname = $_POST['input-fname'] ?? '';

    $u_lname = $_POST['input-lname'] ?? '';

    $u_mname = $_POST['input-mname'] ?? '';



    // Account Information

    $u_username = $_POST['input-username'] ?? '';

    $u_password = $_POST['input-password'] ?? '';

    $u_retype_password = $_POST['input-retype-password'] ?? '';



    // Contact Information

    $u_cellnum = $_POST['input-cellnum'] ?? '';

    $u_email = $_POST['input-email'] ?? '';



    // Address Information

    $u_barangay = $_POST['input-barangay'] ?? '';

    $u_street = $_POST['input-street'] ?? '';

    $u_city = $_POST['input-city'] ?? '';

    $u_postal_code = $_POST['input-postal-code'] ?? '';



    // Validate retype password

    if ($u_password !== $u_retype_password) {

        $u_retype_password_error_mismatch = "Re-typed password is wrong";

        $error_count++;

    }



    // Validate username length

    if (strlen($u_username) > 20) {

        $u_username_error_length = "Username length must be up to 20 characters only";

        $error_count++;

    }



    // Validate password length

    if (strlen($u_password) < 8 || strlen($u_password) > 16) {

        $u_password_error_length = "Password must be between 8 and 16 characters";

        $error_count++;

    }



    // Username already exists

    $sql = "SELECT username FROM user_info WHERE username = '$u_username'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $error_count++;

        $u_username_error_exist = "Username already exists. Change username or sign-in instead";

    }



    // Email already exists

    $sql = "SELECT email_address FROM user_info WHERE email_address = '$u_email'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $error_count++;

        $u_email_error_exist = "Email address already exists. Change your email or sign-in instead";

    }



    // Check for errors

    if ($error_count == 0) {

        $u_fname = strtoupper($u_fname);

        $u_lname = strtoupper($u_lname);

        $u_mname = strtoupper($u_mname);

        $u_barangay = strtoupper($u_barangay);

        $u_street = strtoupper($u_street);

        $u_city = strtoupper($u_city);



        $u_hashed_password = password_hash($u_password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO user_info (first_name, last_name, middle_name, username, password, cell_number, email_address, barangay, street, city, postal_code)

VALUES ('$u_fname', '$u_lname', '$u_mname', '$u_username', '$u_hashed_password', '$u_cellnum', '$u_email', '$u_barangay', '$u_street', '$u_city', '$u_postal_code')";

        if ($conn->query($sql) === TRUE) {

            echo "Account created successfully";

        } else {

            echo "Error: " . $sql . "<br>" . $conn->error;

        }

        $conn->close();

        $_SESSION['auth'] = true;

        header('Location: success_page.php');

        exit;

    }

    $conn->close();

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

    <link rel="stylesheet" href="../css/signup.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../css/loading.css">

    <script src="../script/loading.js" defer></script>

    <script src="../script/signup.js" defer></script>

    <script src="../script/profile_expand.js" defer></script>

    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

</head>



<body>

    <div class="terms-condition-cont">

        <div class="terms-condition-subcont">

            <div class="terms-condition-title">

                <h1>TERMS AND CONDITIONS:</h1>

                <h3 id="close-terms-condition-btn" onclick="closeTermsCondition()">x</h3>

            </div>

            <div class="terms-condition-content">

                <h2>Last Updated: November 22, 2023</h2>



                <p>Welcome to the T1 website, operated by T1 in partnership with Our Lady of Fatima University - Quezon City. These Terms and Conditions govern your use of our Website. By accessing or using the Website, you agree to be bound by these Terms. If you do not agree to these Terms, please do not use the Website.</p>



                <h2>1. ACCEPTANCE OF TERMS</h2>

                <p>1.1. By accessing or using the Website, you acknowledge that you have read, understood, and agree to be bound by these Terms and any amendments thereto. We reserve the right to update, modify, or revise these Terms at any time without notice. Your continued use of the Website following the posting of changes will indicate your acceptance of such changes.</p>



                <h2>2. USER ACCOUNTS</h2>

                <p>2.1. To access certain features of the Website, you may be required to create a user account. You agree to provide accurate, current, and complete information during the registration process and to update such information to keep it accurate, current, and complete.</p>



                <p>2.2. You are responsible for maintaining the confidentiality of your account credentials, including your password. You agree not to disclose your password to any third party and to notify us immediately if you suspect any unauthorized use of your account.</p>



                <p>2.3. We use industry-standard security measures to protect your account information. However, you acknowledge that no online platform can guarantee absolute security, and you agree that we are not liable for any unauthorized access to your account.</p>



                <h2>3. COLLECTION AND USE OF PERSONAL INFORMATION</h2>

                <p>3.1. We may collect personal information from users in accordance with our Privacy Policy. By using the Website, you consent to the collection, use, and disclosure of your personal information as described in the Privacy Policy.</p>



                <p>3.2. We do not provide ads on our Website. However, we may store certain non-personal information, such as IP addresses, for system administration purposes.</p>



                <p>3.3. Your personal information, including but not limited to your name, email address, and contact details, may be stored securely. We do not share your personal information with third parties without your consent.</p>



                <p>3.4. Passwords are hashed for security purposes. We strongly advise you to choose a strong and unique password to enhance the security of your account.</p>



                <h2>4. USER CONDUCT</h2>

                <p>4.1. You agree not to use the Website for any unlawful or prohibited purpose. You must comply with all applicable laws and regulations while using the Website.</p>



                <p>4.2. You are solely responsible for any action you do on the Website. We reserve the right to remove any content that violates these Terms or is deemed inappropriate.</p>



                <h2>5. INTELLECTUAL PROPERTY</h2>

                <p>5.1. The content on the Website, including but not limited to text, graphics, logos, images, and software, is the property of T1 and is protected by intellectual property laws. You may not reproduce, distribute, or modify any content from the Website without our prior written consent.</p>



                <h2>6. DISCLAIMERS AND LIMITATION OF LIABILITY</h2>

                <p>6.1. The Website is provided "as is" without any warranties, express or implied. We do not guarantee the accuracy, completeness, or reliability of any content on the Website.</p>



                <p>6.2. We are not liable for any direct, indirect, incidental, consequential, or punitive damages arising out of your use or inability to use the Website.</p>



                <h2>7. TERMINATION</h2>

                <p>7.1. We reserve the right to terminate or suspend your account and access to the Website at our sole discretion, without prior notice, for any reason, including but not limited to a violation of these Terms.</p>



                <h2>8. GOVERNING LAW</h2>

                <p>8.1. These Terms are governed by the laws of the Philippines. Any disputes arising out of or in connection with these Terms shall be subject to the exclusive jurisdiction of the courts of the Philippines.</p>



                <h2>9. CONTACT INFORMATION</h2>

                <p>9.1. For any questions or concerns regarding these Terms, please contact us at <a href="mailto:t1.shop.ph.global@gmail.com" style="color: black;">t1.shop.ph.global@gmail.com</a>. By using the T1 Website, you agree to abide by these Terms and Conditions. Thank you for choosing T1!</p>

            </div>

        </div>

    </div>

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

                <li><a href="signup.php" class="selected-nav">Sign-up</a></li>

                <li><a href="signin.php">Sign-in</a></li>

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

    <div class="signup-cont">

        <form action="signup.php#submit-btn" method="post" id="submitinfoform">

            <h1 id="form-title-sign-up">T1 SIGN-UP FORM</h1>

            <hr>

            <div class="input-head">

                <h2>Personal Information</h2>

            </div>

            <div class="input-personal-cont">



                <div class="form-group">

                    <label for="input-fname"><span style="color:red">*</span>First Name: </label>

                    <input type="text" name="input-fname" id="input-fname" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_fname) : ''; ?>" required>

                </div>



                <div class="form-group">

                    <label for="input-lname"><span style="color:red">*</span>Last Name: </label>

                    <input type="text" name="input-lname" id="input-lname" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_lname) : ''; ?>" required>

                </div>



                <div class="form-group">

                    <label for="input-mname">Middle Name (optional): </label>

                    <input type="text" name="input-mname" id="input-mname" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_mname) : ''; ?>">

                </div>

            </div>

            <hr>

            <div class="input-head">

                <h2>Account Information</h2>

            </div>

            <div class="input-account-cont">

                <div class="form-group">

                    <label for="input-username"><span style="color:red">*</span>Create a Username (up to 20 characters only): </label>

                    <input type="text" name="input-username" id="input-username" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_username) : ''; ?>" required>

                </div>



                <div class="form-group">

                    <label for="input-password"><span style="color:red">*</span>Create a Password (8-16 characters only): </label>

                    <input type="password" name="input-password" id="input-password" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_password) : ''; ?>" required>

                </div>



                <div class="form-group">

                    <label for="input-retype-password"><span style="color:red">*</span>Re-type your Password: </label>

                    <input type="password" name="input-retype-password" id="input-retype-password" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_retype_password) : ''; ?>" required>

                </div>

            </div>

            <hr>

            <div class="input-head">

                <h2>Contact Information</h2>

            </div>

            <div class="input-contact-cont">

                <div class="form-group">

                    <label for="input-cellnum"><span style="color:red">*</span>Cell#: </label>

                    <input type="tel" name="input-cellnum" id="input-cellnum" pattern="\+63[0-9]{10}" title="Enter a valid 11-digit cellphone number" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_cellnum) : '+63'; ?>" required>

                </div>



                <div class="form-group">

                    <label for="input-email"><span style="color:red">*</span>Email Address: </label>

                    <input type="email" name="input-email" id="input-email" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_email) : ''; ?>" required>

                </div>

            </div>

            <hr>

            <div class="input-head">

                <h2>Address</h2>

            </div>

            <div class="input-address-cont">

                <div class="form-group">

                    <label for="input-barangay"><span style="color:red">*</span>Barangay: </label>

                    <input type="text" name="input-barangay" id="input-barangay" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_barangay) : ''; ?>" required>

                </div>



                <div class="form-group">

                    <label for="input-street"><span style="color:red">*</span>Street: </label>

                    <input type="text" name="input-street" id="input-street" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_street) : ''; ?>" required>

                </div>



                <div class="form-group">

                    <label for="input-city"><span style="color:red">*</span>City: </label>

                    <input type="text" name="input-city" id="input-city" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_city) : ''; ?>" required>

                </div>



                <div class="form-group">

                    <label for="input-postal-code"><span style="color:red">*</span>Postal Code: </label>

                    <input type="number" name="input-postal-code" id="input-postal-code" value="<?php echo ($error_count > 0) ? htmlspecialchars($u_postal_code) : ''; ?>" required>

                </div>

            </div>



            <!-- PHPPPPPPPPPPPPPPPPPPPPPPP -->

            <?php

            if ($error_count > 0) {

                echo "<div class ='errors_display'><p>There " . ($error_count > 1 ? "are $error_count errors: " : "is 1 error: ") . "</p>";

                if (isset($u_username_error_length)) {

                    echo "<div class='error-msg'>$u_username_error_length</div>";

                }

                if (isset($u_password_error_length)) {

                    echo "<div class='error-msg'>$u_password_error_length</div>";

                }

                if (isset($u_retype_password_error_mismatch)) {

                    echo "<div class='error-msg'>$u_retype_password_error_mismatch</div>";

                }

                if (isset($u_username_error_exist)) {

                    echo "<div class='error-msg'>$u_username_error_exist</div>";

                }

                if (isset($u_email_error_exist)) {

                    echo "<div class='error-msg'>$u_email_error_exist</div>";

                }

                if (isset($u_captcha_not_verified)){

                    echo "<div class='error-msg'>$u_captcha_not_verified</div>";

                }

                echo "</div>";

            };

            ?>

            <!-- EMDDDD -->



            <div class="terms-cont">

                <input type="checkbox" name="input-terms" id="input-terms" title="Please Check" required>

                <label for="input-terms">I agree to the <a id="terms-conditions-btn" onclick="showTermsCondition()">Terms and Conditions</a><span style="color:red">*</span></label>

            </div>

            <div class="h-captcha" data-sitekey="58067ad5-cc6f-43b6-bdbc-31a2a1e23bc7"></div>

            <div class="form-group">

                <input type="submit" value="SUBMIT" id="submit-btn">

            </div>

        </form>

    </div>

    <?php include('footer.php'); ?>

</body>



</html>