function format(input) {
    var num = input.value.replace(/\./g, '');
    if (!isNaN(num)) {
        // num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
        // num = num.split('').reverse().join('').replace(/^[\,]/,'');
        // input.value = num;
    } else {
        //alert('Solo se permiten numeros');
        input.value = input.value.replace(/[^\d\.]*/g, '');
    }
}

//Mostramos el spinner al dar click en ingresar.
function spinner() {
    var submit = document.getElementById("btnSubmit");
    var spinner = document.getElementById("spinner");
    submit.style.display = 'None';
    spinner.style.display = 'block';
}

function generarContraseñaUsuarios() {
    var numeroDocumento = document.getElementById("documentoUsuarios").value;
    var error = document.getElementById("error");
    var labelPassword = document.getElementById("labelContraUsuario");

    if (numeroDocumento == "") {
        console.log("Vacio");
        error.style.display = "inline";
    } else {

        if (error.style.display == "inline") {
            error.style.display = "none";
        }

        var contraUsuarios = numeroDocumento.slice(-4);
        var inputContra = document.getElementById("contraUsuario");

        if (inputContra.style.display == 'none' && labelPassword.style.display == 'none') {
            inputContra.style.display = 'inline';
            labelPassword.style.display = 'inline';
        } else {
            inputContra.style.display = 'none';
            labelPassword.style.display = 'none';
        }

        inputContra.value = contraUsuarios;
    }
}

function mostrarEditarFotoPerfil() {
    var fotoPerfil = document.getElementById("editarFoto");
    if (fotoPerfil.style.display == 'none') {
        fotoPerfil.style.display = 'inline';
        estadoDiv = 1;
        console.log(estadoDiv);
    } else {
        fotoPerfil.style.display = 'none';
        estadoDiv = 0;
    }
}

function mostrarEditarPassword() {
    var editarPassword = document.getElementById("passUsuarios1");
    var editarPassword1 = document.getElementById("passUsuarios2");

    var estadoPass = document.getElementById("estadoPass").value;

    if (estadoPass === '0') {
        document.getElementById("estadoPass").value = '1';
        console.log("estado " + estadoPass);
    } else {
        document.getElementById("estadoPass").value = '0';
        console.log("estado " + estadoPass);
    }

    if (editarPassword.style.display == 'none' && editarPassword1.style.display == 'none') {
        editarPassword.style.display = 'inline';
        editarPassword1.style.display = 'inline';
    } else {
        editarPassword.style.display = 'none';
        editarPassword1.style.display = 'none';
    }
}

function mostrarBuscarDocumento() {

    var clienteNombre = document.getElementById('clienteNombre');
    var clienteDocumento = document.getElementById('clienteDocumento');

    if (clienteNombre.style.display == 'inline') {
        clienteNombre.style.display = 'none';
        clienteDocumento.style.display = 'inline';
        clienteNombre.value = "";
        console.log("Adios")
    } else {
        clienteNombre.style.display = 'inline';
        clienteDocumento.style.display = 'none';
        clienteDocumento.value = null;
        console.log("Hola")
    }
}

/**
 *
 *
 * AGRAGAMOS UN GUIÓN A LA PLACA AL LLEGAR A LOS 3 CARACTERES
 *
 */
function placa(placaVehiculos = "placaVehiculos") {
    var caracteres = document.getElementById(placaVehiculos).value;
    if (caracteres.length == 3 && caracteres.length < 4) {
        document.getElementById(placaVehiculos).value = caracteres + "-";
    }
}

//Para el menú de acordeon
$(function () {
    $(".accordion-titulo").click(function (e) {

        e.preventDefault();
        var contenido = $(this).next(".accordion-content");

        if (contenido.css("display") == "none") { //open
            contenido.slideDown(250);
            $(this).addClass("open");
        } else { //close
            contenido.slideUp(250);
            $(this).removeClass("open");
        }

    });
});

//Para enviar la cantidad de registros a mostrar
function enviarCantidadBusqueda(index) {

    let params = new URLSearchParams(location.search);
    var contract = params.get('page');
    var cantidadBusqueda = document.getElementById("cantidadBusqueda").value;

    if (cantidadBusqueda != 0) {
        location.href = index + ".php?page=" + contract + "&&nro=" + cantidadBusqueda;
    }
}

const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 0
})