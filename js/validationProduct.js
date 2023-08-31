'use strict'

const form = document.querySelector('form');

form.addEventListener('submit', validate);

function validate(event) {
    
    if (!form.checkValidity())
    {
        event.preventDefault();
    }

    form.classList.add('was-validated');
}