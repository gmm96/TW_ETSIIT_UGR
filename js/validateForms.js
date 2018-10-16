// Formulario de usuario
function validateUser() {
    return validateEmail() && validatePass() && validatePhone();
}

function validateEmail() {
    var email = document.user.email.value;

    if (!email.endsWith("@innotechmon.com")) {
        alert("El email debe terminar con \"@innotechmon.com\"");
        return false;
    }
    else if (( email.match(/ /g) || []).length != 0) {
        alert("No puede haber espacios en blanco en el email.");
        return false;
    }
    else if (!email.match(/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/)) {
        alert("El email solo puede contener carácteres de a-z, números, \".\" y \"_\".");
        return false;
    }

    return true;
}

function validatePass() {
    var pass = document.user.pass.value;

    if (pass.length < 4 || pass.length > 20){
        alert("La contraseña debe tener entre 4 y 20 caracteres.");
        return false;
    }
    return true;
}

function validatePhone() {
    var phone = document.user.phone.value.toString().replace(/\s/g, '');

    if (phone.length != 9){
        alert("El número de teléfono debe contener 9 cifras.");
        return false;
    }
    else if (!phone.match(/^[6789]{1}[0-9]{8}$/)){
        alert("El formato del número de teléfono no es correcto.");
        return false;
    }
    return true;
}


function checkDirector(cb) {
    if(cb.checked == true){
        document.user.admin.checked = true;
        document.user.admin.setAttribute("onclick", "return false");
    }else{
        document.user.admin.checked = false;
        document.user.admin.removeAttribute("onclick");
    }
}


// Formulario de proyecto
function validateProject() {
    return validateDates();
}

function validateDates() {
    var ini_date = new Date(document.getElementById('ini-date').value);
    var fin_date = new Date(document.getElementById('fin-date').value);

    if(ini_date > fin_date){
        alert("La fecha de inicio debe ser anterior a la final.");
        return false;
    }

    return true;
}