function closeTermsCondition(){
    document.querySelector('.terms-condition-cont').style.display = 'none';
}

function showTermsCondition(){
    document.querySelector('.terms-condition-cont').style.display = 'flex';
}

window.onload = function(){
    document.getElementById('form-title-sign-up').classList.add('anim');
    document.querySelectorAll('.input-head').forEach(function(element){
        element.classList.add('anim');
    });
    document.querySelector('.input-personal-cont').classList.add('anim');
    document.querySelector('.input-account-cont').classList.add('anim');
    document.querySelector('.input-contact-cont').classList.add('anim');
    document.querySelector('.input-address-cont').classList.add('anim');
};