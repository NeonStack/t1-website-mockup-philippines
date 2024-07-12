

window.addEventListener('scroll', function() {
    if (window.scrollY > 0) {
        document.querySelector('.selection-bar').style.padding = "10px 0px";
    }
    else{
        document.querySelector('.selection-bar').style.padding = "30px 0px";
    }
});


// SHOW PRODUCTS
let productCont = document.querySelector(".product-container");
window.onload = function () {
    productCont.classList.add('show');
};


