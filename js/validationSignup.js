'use strict'

const signup = document.getElementById('signup');
const emailInput = document.getElementById('email');
const passInput = document.getElementById('password');
const passConfInput = document.getElementById('passwordConf');
const firstName = document.getElementById('firstName');
const lastName = document.getElementById('lastName');
const address = document.getElementById('shippingAddress');


signup.addEventListener('submit', validate);


function validate(event) {
    let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
    let isValidEmail = regex.test(emailInput.value.trim());
    
    if (!signup.checkValidity() || 
    !isValidEmail || 
    !isSamePassword() || 
    !isValidFirstName() || 
    !isValidLastName() || 
    !isValidAddress()) {
        event.preventDefault();
    }

    signup.classList.add('was-validated');
}

function isSamePassword() {
    let passInputText = passInput.value.trim();
    let passConfInputText = passConfInput.value.trim();

    if(passInputText.length > 0 && passInputText == passConfInputText){
        passConfInput.setCustomValidity('');
        return true;
    }
    passConfInput.setCustomValidity('Erreur');
  
    return false;
}

function isValidFirstName(){
    if(firstName.value.trim().length > 0){
        firstName.setCustomValidity('');
        return true;
    }
    firstName.setCustomValidity('Erreur');
    return false;
}

function isValidLastName(){
    if(lastName.value.trim().length > 0){
        lastName.setCustomValidity('');
        return true;
    }
    lastName.setCustomValidity('Erreur');
    return false;
}

function isValidAddress(){
    if(address.value.trim().length > 0){
        address.setCustomValidity('');
        return true;
    }
    address.setCustomValidity('Erreur');
    return false;
}

