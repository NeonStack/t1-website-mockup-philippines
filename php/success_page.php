
<?php
session_start(); 
$_SESSION['auth']?'':header('Location: ../index.php'); 
$_SESSION['auth'] = false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T1 Merchandise - PH</title>
    <link rel="icon" href="../img/Red+Logo-tab.png">
    <link rel="stylesheet" href="../css/success_page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/loading.css">
    <script src="../script/loading.js"></script>
    <script src="../script/success_page.js" defer></script>
</head>

<body>
<div class="loading-cont">
        <div id="loading-circle"></div>
        <div class="powered-cont">
            <div class="powered-cont-row1">PLEASE WAIT...</div>
            <div class="powered-cont-row2">POWERED BY: <span id="powered-t1">&nbsp;T1&nbsp;</span>|<span id="powered-olfu">&nbsp;OLFU QC CAMPUS</span></div>
        </div>
    </div>
    <div class="big-cont">
        <h1 class="title-cont">Successful !</h1>
        <p class="txt-cont">You will be redirected shortly. Please wait... <i class="fa-solid fa-spinner" style="color: #ffffff;"></i></p>
        <p class="redirect-cont">Still here? <a href="signin.php">Click to redirect</a></p>
    </div>

</body>

</html>