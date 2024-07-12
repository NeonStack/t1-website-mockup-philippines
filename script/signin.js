// Check if the animationPlayed cookie exists and is set to true
const cookieValue = document.cookie.match(/(?:^|;) *animationPlayed=([^;]*)/);
const playedOnce = cookieValue && cookieValue[1] === 'true';

if (!playedOnce) {
  // Execute the animation code
  window.onload = function() {
    var detailsCont = document.querySelector('.details-cont');
    var signinForm = document.querySelector('.signin-cont form');
    signinForm.style.transform = 'translateX(-50%)';
    detailsCont.style.transform = 'translateX(50%)';
    detailsCont.style.borderRadius = '40px';
    signinForm.style.borderRadius = '40px';

    detailsCont.style.animation = 'center-slide 2s ease forwards 1s, details-cont-border-radius 2s ease forwards 1s';

    signinForm.style.animation = 'center-slide 2s ease forwards 1s, form-border-radius 2s ease forwards 1s';

    // Set the cookie with an expiration time of three minutes
    document.cookie = 'animationPlayed=true; max-age=180';
  };
}
