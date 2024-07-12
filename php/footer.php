<head>

    <link rel="stylesheet" href="../css/footer.css">

</head>

<footer>

    <div class="footer-column-container">

        <div class="footer-column">

            <p class="footer-title">Quick Links</p>

            <ul>

                <li><a href="../index.php">Home</a></li>

                <?php if (!$curr_user_id) : ?>

                    <li><a href="signup.php">Sign-up</a></li>

                    <li><a href="signin.php">Sign-in</a></li>

                <?php endif; ?>

                <li><a href="profile.php">Profile</a></li>

                <li><a href="shop.php">Shop</a></li>

                <li><a href="cart.php">Cart</a></li>

            </ul>

        </div>

        <div class="footer-column">

            <p class="footer-title">Information</p>

            <ul>

                <li><a href="privacy-policy.php">Privacy Policy</a></li>

                <li><a href="terms-of-service.php">Terms of Service</a></li>

                <li><a href="faqs.php">FAQs</a></li>

                <li><a href="customer-support.php">Customer Support</a></li>

                <li><a href="../about_me">About Me</a></li>

            </ul>

        </div>

        <div class="footer-column">

            <p class="footer-title">Follow Us</p>

            <ul>

                <li><a href="https://www.facebook.com/T1LoL/" target="_blank">Facebook<img src="../img/facebook-logo-2019.svg" alt="" id="sponsor-logo"></a></li>

                <li><a href="https://discord.com/invite/leagueoflegends" target="_blank">Discord<img src="../img/discord.png" alt="" id="sponsor-logo"></a></li>

                <li><a href="https://www.instagram.com/t1lol/?hl=en" target="_blank">Instagram<img src="../img/instagram.png" alt="" id="sponsor-logo"></a></li>

                <li><a href="https://twitter.com/T1LoL" target="_blank">Twitter<img src="../img/x-logo-twitter-transparent-logo-download-3.png" alt="" id="sponsor-logo"></a></li>

            </ul>

        </div>

        <div class="footer-column">

            <p class="footer-title">Powered By</p>

            <ul>

                <li><a href="https://www.fatima.edu.ph/" target="_blank">OLFU QC Campus<img src="../img/OLFU_official_logo.png" id="sponsor-logo"></a></li>

                <li><a href="https://www.mcdonalds.com.ph/" target="_blank">McDonald's<img src="../img/McDonald's_Golden_Arches.png" id="sponsor-logo"></a></li>

                <li><a href="https://www.sminvestments.com/" target="_blank">SM Investments Corporation<img src="../img/sm-blue.png" id="sponsor-logo"></a></li>

                <li><a href="https://smart.com.ph/" target="_blank">Smart Communications, Inc.<img src="../img/smart.png" id="sponsor-logo"></a></li>

                <li><a href="https://www.ayalaland.com.ph/" target="_blank">Ayala Land<img src="../img/Ayalasymbol-removebg-preview.png" id="sponsor-logo"></a></li>

            </ul>

        </div>

    </div>

    <div class="footer-column-container" id="copyright">

    <p>&copy; <?php echo date("Y"); ?> T1 and OLFU QC. All rights reserved. This website is a student project for educational purposes only. The product images and logos used are not owned by us and are the property of their respective owners. The website design and code are original creations. Unauthorized use or reproduction without written consent is prohibited. This site is not affiliated with or endorsed by T1. For inquiries, please <a href="mailto:t1.shop.ph.global@gmail.com">contact us</a>.</p>

    </div>

</footer>