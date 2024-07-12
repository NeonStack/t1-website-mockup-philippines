window.onload = function () {
    setTimeout(function () {
        window.location.href = 'signin.php';
    }, 5000);


    setTimeout(function () {
        document.querySelector('.redirect-cont').style.display = 'block';
    }, 6000);
}