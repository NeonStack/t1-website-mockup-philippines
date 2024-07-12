<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/png" href="../img/Red+Logo-tab.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>About Me - John Lloyd Umani</title>
</head>

<body>
    <div class="bgbigcont">
        <div class="bigcont">
            <div class="smallcont1">
                <div class="txtbox">
                    <h2>JOHN LLOYD UMANI</h2>
                </div>
                <div class="subscont">
                    <div class="subs1">
                        <h1>"Learning to become a full-stack developer"</h1>
                    </div>
                    <div class="subs2">
                        <p>
                            Greetings! I am a second-year IT student at Our Lady of Fatima University, on a mission to become a skilled full-stack developer. Explore my portfolio to witness my coding journey and projects. Let's shape the future with code!
                        </p>
                    </div>
                </div>
                <div class="buttonsCont">
                    <a class="link1">Explore Now (soon)</a>
                    <a class="link2">Let's Talk (soon)</a>
                </div>
                <div class="socialmedia">
                    <a class="soclink" href="https://www.facebook.com/MCPEJL.25/" target="_blank"><i class="fa-brands fa-facebook" id="fbicon"></i></a>
                    <a class="soclink" href="https://www.instagram.com/john_greenteam/" target="_blank"><i class="fa-brands fa-instagram" id="instagramicon"></i></a>
                    <a class="soclink" href="https://twitter.com/MCPEJL" target="_blank"><i class="fa-brands fa-square-x-twitter" id="twittericon"></i></a>
                    <a class="soclink" href="mailto:t1.shop.ph.global@gmail.com" target="_blank"><i class="fa-solid fa-envelope" id="emailicon"></i></a>
                    <a class="soclink" href="https://discordapp.com/users/494144440844288013" target="_blank"><i class="fa-brands fa-discord" id="discordicon"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>