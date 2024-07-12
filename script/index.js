function expandProfile() {
    var expandDiv = document.querySelector('.expand-profile');
    expandDiv.style.display = (expandDiv.style.display === 'flex') ? 'none' : 'flex';
}


document.addEventListener("DOMContentLoaded", function () {
    //FOR ANIMATION SCROLL
    // Get all featured product elements
    var featuredElements = document.querySelectorAll(".featured");
    var notMemberElement = document.querySelector('.not-member-cont');
    // Create an Intersection Observer
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            } else {
                entry.target.classList.remove("show");
            }
        });
    }, { threshold: 0.5 });

    // Observe each featured element
    featuredElements.forEach(function (element) {
        observer.observe(element);
    });

    observer.observe(notMemberElement);
});