window.addEventListener('scroll', function() {
    if (window.scrollY > 0) {
        document.querySelector('.selection-bar').style.padding = "10px 0px";
    }
    else{
        document.querySelector('.selection-bar').style.padding = "30px 0px";
    }
});

  function closeRatingModal() {
    document.getElementById('ratingModal').style.display = 'none';
  }

//for orders each cont
const eachOrderElements = document.querySelectorAll('.each-order');
eachOrderElements.forEach((element, index) => {
    const delay = index * 0.1;
    element.style.animation = `riseToTheTop 1.4s ease forwards ${delay}s`;
});

