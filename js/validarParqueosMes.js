let erroresProp = 0;

$(document).ready(function () {
    cargarValoresClientes();
    cargarValoresTipVehiculo();
})

function cargarValoresClientes() {
    $.ajax({
        type: "POST",
        url: "../../ajax/datosCliente.php",
        data: "placa=" + $("#placaVehiculos").val(),
        dataType: "json",
        success: function (documentoUsuarios) {
            $("#documentoUsuarios").html(documentoUsuarios[0]);
            if (documentoUsuarios[1] == 1) {
                $("#documentoUsuarios").css('cursor', 'not-allowed');
                $("#documentoUsuarios").attr('readonly', 'readonly');
            } else {
                $("#documentoUsuarios").css('cursor', 'default');
                $("#documentoUsuarios").removeAttr('readonly');
            }
        },
        error: function () {
            console.log("Error ajax documentoUsuarios");
        }
    })
}

function validarCamposPropietarios(nombreCampo) {
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    $.ajax({
        data: 'txt=' + $("#documentoPropietarios").val(),
        type: "POST",
        url: "../../ajax/datosClienteGratis.php",
        success: function (data) {
            if (data == 1) {
                $("#mensaje_documentoPropietarios").html("Este usuario ya se encuentra registrado.");
                $("#mensaje_documentoPropietarios").css("color", "red");
                return false;
            }
        }
    })
    if ($("#" + nombreCampo).val() == "") {
        $("#mensaje_" + nombreCampo).html("Este campo no puede estar vacío");
        $("#mensaje_" + nombreCampo).css("color", "red");
        return false;
    } else if (nombreCampo == "emailPropietarios") {
        if (!regex.test($('#emailPropietarios').val().trim())) {
            $("#mensaje_emailPropietarios").css("color", "red");
            $("#mensaje_emailPropietarios").html("Ingrese un correo válido");
            return false;
        } else {
            $("#mensaje_" + nombreCampo).css("color", "green");
            $("#mensaje_" + nombreCampo).html("Campo Correcto");
            return true;
        }
    } else {
        $("#mensaje_" + nombreCampo).css("color", "green");
        $("#mensaje_" + nombreCampo).html("Campo Correcto");
        return true;
    }
}

function activarSubmit() {
    if (validarCamposPropietarios('documentoPropietarios') && validarCamposPropietarios('emailPropietarios') && validarCamposPropietarios('nombre1Propietarios') && validarCamposPropietarios('apellido1Propietarios')) {
        $("#btnSubmitPropietario").show();
    } else {
        $("#btnSubmitPropietario").hide();
    }
}

//Validamos el formulario de los propietarioVehiculos
$("#documentoPropietarios").keyup(function () {
    validarCamposPropietarios('documentoPropietarios');
    activarSubmit();
});

//Validamos el formulario de los propietarioVehiculos
$("#documentoPropietarios").blur(function () {
    validarCamposPropietarios('documentoPropietarios');
    activarSubmit();
});

//Validamos el formulario de los emailPropietarios
$("#emailPropietarios").keyup(function () {
    validarCamposPropietarios('emailPropietarios');
    activarSubmit();
    console.log($("#mensaje_emailPropietarios").val().indexOf('@', 0));
});

//Validamos el formulario de los emailPropietarios
$("#emailPropietarios").blur(function () {
    validarCamposPropietarios('emailPropietarios');
    activarSubmit();
});

//Validamos el formulario de los nombre1Propietarios
$("#nombre1Propietarios").keyup(function () {
    validarCamposPropietarios('nombre1Propietarios');
    activarSubmit();
});

//Validamos el formulario de los nombre1Propietarios
$("#nombre1Propietarios").blur(function () {
    validarCamposPropietarios('nombre1Propietarios');
    activarSubmit();
});

//Validamos el formulario de los propietarioVehiculos
$("#apellido1Propietarios").keyup(function () {
    validarCamposPropietarios('apellido1Propietarios');
    activarSubmit();
});

//Validamos el formulario de los propietarioVehiculos
$("#apellido1Propietarios").blur(function () {
    validarCamposPropietarios('apellido1Propietarios');
    activarSubmit();
});

/***********************************
 *
 * REALIZAMOS VALIDACIONES PARA EL MODAL DE VEHÍCULOS
 *
 ***********************************/

function validarModalVehiculos(nombreCampoValidar) {

    if (nombreCampoValidar == "placaVehiculosModal") {
        if ($("#placaVehiculosModal").val() == "") {
            $("#mensaje_placaVehiculosModal").html("Este campo no puede estar vacio.");
            $("#mensaje_placaVehiculosModal").css("color", "red");
            return false;
        } else {
            $.ajax({
                data: 'txt=' + $("#placaVehiculosModal").val(),
                type: "POST",
                url: "../../ajax/datosVehiculoModalMes.php",
                success: function (data) {
                    console.log(data + "F");
                    if (data == 1) {
                        $("#mensaje_placaVehiculosModal").html("Lo sentimos, este vehículo ya se encuentra registrado");
                        $("#mensaje_placaVehiculosModal").css("color", "red");
                        return false;
                    } else {
                        validarAjax = 0;
                    }
                }
            })
            $("#mensaje_placaVehiculosModal").css("color", "green");
            $("#mensaje_placaVehiculosModal").html("Campo Correcto");
            return true;
        }
    }

    if (nombreCampoValidar == "tipoVehiculosModal") {
        if ($("#tipoVehiculosModal").val() == "") {
            $("#mensaje_tipoVehiculosModal").html("Debe seleccionar un tipo de vehículo.");
            $("#mensaje_tipoVehiculosModal").css("color", "red");
            return false;
        } else {
            $("#mensaje_tipoVehiculosModal").css("color", "green");
            $("#mensaje_tipoVehiculosModal").html("Campo Correcto");
            return true;
        }
    }

    if (nombreCampoValidar == "idMarcaVehiculosModal") {
        if ($("#idMarcaVehiculosModal").val() == "") {
            $("#mensaje_idMarcaVehiculosModal").html("Debe seleccionar una marca.");
            $("#mensaje_idMarcaVehiculosModal").css("color", "red");
            return false;
        } else {
            $("#mensaje_idMarcaVehiculosModal").css("color", "green");
            $("#mensaje_idMarcaVehiculosModal").html("Campo Correcto");
            return true;
        }
    }

    if (nombreCampoValidar == "colorVehiculosModal") {
        if ($("#colorVehiculosModal").val() == "") {
            $("#mensaje_colorVehiculosModal").html("Este campo no puede estar vacio.");
            $("#mensaje_colorVehiculosModal").css("color", "red");
            return false;
        } else {
            $("#mensaje_colorVehiculosModal").css("color", "green");
            $("#mensaje_colorVehiculosModal").html("Campo Correcto");
            return true;
        }
    }
}

function activarSubmitModalVehiculos() {
    if (validarModalVehiculos('placaVehiculosModal') && validarModalVehiculos('tipoVehiculosModal') && validarModalVehiculos('idMarcaVehiculosModal') && validarModalVehiculos('colorVehiculosModal')) {
        $("#btnSubmitModalVehiculos").show();
    } else {
        $("#btnSubmitModalVehiculos").hide();
    }
}
//Validamos el formulario de los placaVehiculosModal
$("#placaVehiculosModal").keyup(function () {
    validarModalVehiculos('placaVehiculosModal');
    activarSubmitModalVehiculos();
});

//Validamos el formulario de los placaVehiculosModal
$("#placaVehiculosModal").blur(function () {
    validarModalVehiculos('placaVehiculosModal');
    activarSubmitModalVehiculos();
});

//Validamos el formulario de los tipoVehiculosModal
$("#tipoVehiculosModal").blur(function () {
    validarModalVehiculos('tipoVehiculosModal');
    activarSubmitModalVehiculos();
});

//Validamos el formulario de los tipoVehiculosModal
$("#tipoVehiculosModal").change(function () {
    validarModalVehiculos('tipoVehiculosModal');
    activarSubmitModalVehiculos();
});

//Validamos el formulario de los idMarcaVehiculosModal
$("#idMarcaVehiculosModal").blur(function () {
    validarModalVehiculos('idMarcaVehiculosModal');
    activarSubmitModalVehiculos();
});

//Validamos el formulario de los idMarcaVehiculosModal
$("#idMarcaVehiculosModal").change(function () {
    validarModalVehiculos('idMarcaVehiculosModal');
    activarSubmitModalVehiculos();
});

//Validamos el formulario de los colorVehiculosModal
$("#colorVehiculosModal").blur(function () {
    validarModalVehiculos('colorVehiculosModal');
    activarSubmitModalVehiculos();
});

//Validamos el formulario de los colorVehiculosModal
$("#colorVehiculosModal").keyup(function () {
    validarModalVehiculos('colorVehiculosModal');
    activarSubmitModalVehiculos();
});