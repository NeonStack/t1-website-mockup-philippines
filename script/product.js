document.addEventListener("DOMContentLoaded", function () {

    var reviewsTextCont = document.querySelectorAll(".reviews-text-cont");

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            }
        });
    }, { threshold: 0.5 });


    reviewsTextCont.forEach(function (element) {
        observer.observe(element);
    });
});