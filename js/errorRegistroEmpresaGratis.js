var errores = 1;
var errores = 1;

function errorDocumentoUsuarios() {

    var text = document.getElementById("documentoUsuarios");
    var mostrarError = document.getElementById("errorDocumentoUsuarios");

    //Validamos el campo nombre empresa
    if (text.value == "") {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede estar vacio';
        return false;
    } else if (text.value.length > 15) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede contener más de 15 carácteres';
        return false;
    } else if (isNaN(text.value)) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo debe ser sólo de números';
        return false;
    } else {
        mostrarError.style.color = 'green';
        mostrarError.innerHTML = "<i class='fas fa-check icon'></i> Este campo es válido";
        return true;
    }
}

function errorNombreUsuarios() {

    var text = document.getElementById("nombreUsuarios");
    var mostrarError = document.getElementById("errorNombreUsuarios");

    //Validamos el campo nombre empresa
    if (text.value == "") {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede estar vacio';
        return false;
    } else if (text.value.length > 80) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede contener más de 80 carácteres';
        return false;
    } else if (!isNaN(text.value)) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo debe ser sólo en letras.';
        return false;
    } else {
        mostrarError.style.color = 'green';
        mostrarError.innerHTML = "<i class='fas fa-check icon'></i> Este campo es válido. Recuerde el orden: Nombres Apellidos";
        return true;
    }
}

function errorEmailUsuarios() {

    var text = document.getElementById("emailUsuarios");
    var mostrarError = document.getElementById("errorEmailUsuarios");
    var email = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

    //Validamos el campo nombre empresa
    if (text.value == "") {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede estar vacio';
        return false;
    } else if (text.value.length > 80) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede contener más de 80 carácteres';
        return false;
    } else if (!email.exec(text.value)) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Lo sentimos, no ha ingresado un email válido';
        return false;
    } else {
        mostrarError.style.color = 'green';
        mostrarError.innerHTML = "<i class='fas fa-check icon'></i> Este campo es válido";
        return true;
    }
}

function errorCelular1Usuarios() {

    var text = document.getElementById("celular1Usuarios");
    var mostrarError = document.getElementById("errorCelular1Usuarios");

    //Validamos el campo nombre empresa
    if (text.value == "") {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede estar vacio';
        return false;
    } else if (text.value.length > 10) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede contener más de 10 carácteres';
        return false;
    } else if (isNaN(text.value)) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo debe ser sólo de números';
        return false;
    } else {
        mostrarError.style.color = 'green';
        mostrarError.innerHTML = "<i class='fas fa-check icon'></i> Este campo es válido";
        return true;
    }
}

function errorPassUsuarios() {

    var text = document.getElementById("passUsuarios");
    var mostrarError = document.getElementById("errorPassUsuarios");

    //Validamos el campo nombre empresa
    if (text.value == "") {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede estar vacio';
        return false;
    } else {
        mostrarError.style.color = 'green';
        mostrarError.innerHTML = "<i class='fas fa-check icon'></i> Este campo es válido";
        return true;
    }
}

function errorPassUsuarios1() {

    var text = document.getElementById('passUsuarios1');
    var mostrarError = document.getElementById("errorPassUsuarios1");
    var pass1 = document.getElementById("passUsuarios");

    //Validamos el campo nombre empresa
    if (text.value == "") {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede estar vacio';
        return false;
    } else if (text.value != pass1.value) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Las contraseñas no coinciden';
        return false;
    } else {
        mostrarError.style.color = 'green';
        mostrarError.innerHTML = "<i class='fas fa-check icon'></i> Las contraseñas son correctas";
        return true;
    }
}

function errorNombreEmpresas() {

    var text = document.getElementById("nombreEmpresas");
    var mostrarError = document.getElementById("errorNombreEmpresas");

    //Validamos el campo nombre empresa
    if (text.value == "") {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede estar vacio';
        return false;
    } else if (text.value.length > 80) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede contener más de 80 carácteres';
        return false;
    } else {
        mostrarError.style.color = 'green';
        mostrarError.innerHTML = "<i class='fas fa-check icon'></i> Este campo es válido";
        return true;
    }
}

function errorpaisEmpresas() {

    var text = document.getElementById("paisEmpresas");
    var mostrarError = document.getElementById("errorPaisEmpresas");

    //Validamos el campo nombre empresa
    if (text.value == "") {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Este campo no puede estar vacio';
        return false;
    } else if (isNaN(text.value)) {
        mostrarError.style.color = 'red';
        mostrarError.innerHTML = '<i class="fas fa-exclamation icon"></i>Debe seleccionar un país correcto';
        return false;
    } else {
        mostrarError.style.color = 'green';
        mostrarError.innerHTML = "<i class='fas fa-check icon'></i> Este campo es válido";
        return true;
    }
}

function enviar() {

    var formulario = document.getElementById("formRegistrarEmpresa");

    if (errorNombreEmpresas() && errorpaisEmpresas() && errorDocumentoUsuarios() && errorEmailUsuarios() && errorCelular1Usuarios() && errorPassUsuarios() && errorPassUsuarios1()) {
        formulario.submit();
        return true;
    } else {
        errorNombreEmpresas();
        errorpaisEmpresas();
        errorDocumentoUsuarios();
        errorEmailUsuarios();
        errorCelular1Usuarios();
        errorPassUsuarios();
        errorPassUsuarios1();
        errorNombreUsuarios();
        return false;
    }
}