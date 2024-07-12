  
document.getElementById('changePasswordProfileForm').addEventListener('submit', function () {
    document.querySelector('.loading-cont').style.display = 'flex';
});
  
  function submitForm() {
    document.getElementById('profilePictureForm').submit();
  }

  document.querySelectorAll(".fas.fa-times").forEach(function(element) {
    element.addEventListener("click", function(){
        hideAllForms();
        console.log('clicked');
    });
});



  function openForm(typeOfForm) {
    hideAllForms();

    document.getElementById(typeOfForm + '_form').style.display = 'flex';
}

function hideAllForms() {
    const forms = document.querySelectorAll('.profile-form');
    forms.forEach(form => form.style.display = 'none');
}
