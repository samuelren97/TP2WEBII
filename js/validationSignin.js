'use strict'

const signin = document.getElementById('signin');
const emailInput = document.getElementById('email');
const passInput = document.getElementById('password');

signin.addEventListener('submit', validate);

function validate(event) {
    let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
    let isValidEmail = regex.test(emailInput.value.trim());
    
    if (!signin.checkValidity() || !isValidEmail || !isValidPassword())
    {
        event.preventDefault();
    }

    signin.classList.add('was-validated');
}

function isValidPassword(){
    if(passInput.value.trim().length > 0){
        passInput.setCustomValidity('');
        return true;
    }
    passInput.setCustomValidity('Erreur');
    return false;
}