const form = document.getElementById('form1');
const inputs = document.querySelectorAll('#form1 input');

const expres = {
    surname: /^[a-zA-ZÀ-ÿ\s]{1,50}$/,
    email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/
}

const campos = {
    surname: false,
    email: false,
    password: false
}

const validateForm = (e) => {
    switch (e.target.name){
        case "username":
            state(expres.surname, e.target, 'username');
        break;
        case "email":
            state(expres.email, e.target, 'email');
        break;
        case "password":
            state(expres.password, e.target, 'password');
        break;
    }
}

const state = (expres, input, x) => {

    if(expres.test(input.value)){
    document.getElementById(`x_${x}`).classList.remove('x_grupo-incorrecto');
    document.getElementById(`x_${x}`).classList.add('x_grupo-correcto');
    document.querySelector(`#x_${x} i`).classList.remove('bi-exclamation-circle-fill');
    document.querySelector(`#x_${x} i`).classList.add('bi-check-circle-fill');
    document.querySelector(`#x_${x} .x_typerror`).classList.remove('x_typerror-block');
    campos[x] = true;
    } 
    else {
    document.getElementById(`x_${x}`).classList.add('x_grupo-incorrecto');
    document.getElementById(`x_${x}`).classList.remove('x_grupo-correcto');
    document.querySelector(`#x_${x} i`).classList.add('bi-exclamation-circle-fill');
    document.querySelector(`#x_${x} i`).classList.remove('bi-check-circle-fill');
    document.querySelector(`#x_${x} .x_typerror`).classList.add('x_typerror-block');
    campos[x] = false;
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', validateForm);
    input.addEventListener('blur', validateForm);
});