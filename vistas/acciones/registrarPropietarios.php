<?php

include_once('../../estructura/conexion.php');
include_once('../../estructura/variablesGlobales.php');
@session_start();

$contadorErrores = 0;
if (@$_GET['i'] == 1) {
    echo $siEditar;
}

@$nombre1           = ucfirst($_POST['nombre1Usuarios']);
@$nombre2           = ucfirst($_POST['nombre2Usuarios']);
@$apellido1         = ucfirst($_POST['apellido1Usuarios']);
@$apellido2         = ucfirst($_POST['apellido2Usuarios']);
@$documento         = $_POST['documentoUsuarios'];
@$fechaNacimiento   = $_POST['fechaNacimientoUsuarios'];
@$passDefecto       = $_POST['passDefectoUsuarios'];
@$idRoles           = '4';
@$emailUsuarios     = $_POST['emailUsuarios'];
@$pass1Usuarios     = $_POST['pass1Usuarios'];
@$pass2Usuarios     = $_POST['pass2Usuarios'];
@$estadoPassword    = $_POST['estadoPassword'];
@$idFotos           = '1';
@$nitEmpresas       = $_SESSION['nitEmpresas'];
@$fijoUsuarios      = $_POST['fijoUsuarios'];
@$celular1Usuarios  = $_POST['celular1Usuarios'];
@$celular2Usuarios  = $_POST['celular2Usuarios'];
@$direccionUsuarios = $_POST['direccionUsuarios'];
@$archivoActual     = $_POST['archivoActual'];

//Validamos el campo documento
$consultaClientes   = "SELECT * FROM usuarios WHERE documentoUsuarios = '" . $documento . "'";
$ejecutaClientes    = mysqli_query($conexion, $consultaClientes);
$contadorClientes   = mysqli_num_rows($ejecutaClientes);

if (empty($documento)) {
    validarCampos('vacio', 'Documento');
    $contadorErrores = $contadorErrores + 1;
    return false;
} else if ($contadorClientes >= 1) {
    validarCampos('noExiste', 'Documento');
    $contadorErrores = $contadorErrores + 1;
    return false;
} else if (strlen($documento) >= $C = 15) {
    validarCampos('caracteres', 'Documento', $C);
    $contadorErrores = $contadorErrores + 1;
    return false;
}

//validamos el campo email
if (empty($emailUsuarios)) {
    validarCampos('vacio', 'Correo electrónico');
    $contadorErrores = $contadorErrores + 1;
    return false;
} else if (!validarCampos('email', 'Correo electrónico', '', '', $emailUsuarios)) {
    $contadorErrores = $contadorErrores + 1;
    return false;
}

//Validamos el campo primer nombre
if (empty($nombre1)) {
    validarCampos('vacio', 'Primer nombre');
    $contadorErrores = $contadorErrores + 1;
    return false;
} else if (strlen($nombre1) > $C = 20) {
    validarCampos('caracteres', 'Primer nombre', $C);
    $contadorErrores = $contadorErrores + 1;
    return false;
}

//Validamos el campo segundo nombre
if (strlen($nombre2) > $C = 20) {
    validarCampos('caracteres', 'Segundo nombre', $C);
    $contadorErrores = $contadorErrores + 1;
    return false;
}

//Validamos el campo primer apellido
if (empty($apellido1)) {
    validarCampos('vacio', 'Primer apellido');
    $contadorErrores = $contadorErrores + 1;
    return false;
} else if (strlen($apellido1) > $C = 20) {
    validarCampos('caracteres', 'Primer apellido', $C);
    $contadorErrores = $contadorErrores + 1;
    return false;
}

//Validamos el campo segundo apellido
if (strlen($apellido2) > $C = 20) {
    validarCampos('caracteres', 'Segundo apellido', $C);
    $contadorErrores = $contadorErrores + 1;
    return false;
}

//Validamos campo passDefecto, por si se desea modificar el valor.
if (empty($passDefecto)) {
    $i = strlen($documento) - 4;
    $passDefecto = substr($documento, $i, 4);
}

//Despuès de verificar todo el formulario, contamos que no hayan errores y procedemos a registrar
if ($contadorErrores == 0) {

    $hashUsuario    =   generarHash();
    $insert         =   "INSERT INTO
                                `usuarios`(
                                    `documentoUsuarios`,
                                    `fechaRegistroUsuarios`,
                                    `nombre1Usuarios`,
                                    `emailUsuarios`,
                                    `idRoles`,
                                    `nombre2Usuarios`,
                                    `apellido1Usuarios`,
                                    `apellido2Usuarios`,
                                    `fechaNacimientoUsuarios`,
                                    `passDefectoUsuarios`,
                                    `passUsuarios`,
                                    `nitEmpresas`,
                                    `fijoUsuarios`,
                                    `celular1Usuarios`,
                                    `celular2Usuarios`,
                                    `direccionUsuarios`,
                                    hashUsuario
                                )
                            VALUES
                                (
                                    '$documento',
                                    '$fechaRegistros',
                                    '$nombre1',
                                    '$emailUsuarios',
                                    '$idRoles',
                                    '$nombre2',
                                    '$apellido1',
                                    '$apellido2',
                                    '$fechaNacimiento',
                                    '$passDefecto',
                                    '$passDefecto',
                                    '$nitEmpresas',
                                    '$fijoUsuarios',
                                    '$celular1Usuarios',
                                    '$celular2Usuarios',
                                    '$direccionUsuarios',
                                    '$hashUsuario'
                                )";
    $ejecutarInsert = mysqli_query($conexion, $insert);

    $nombreUsuarios = $nombre1 . " " . $nombre2 . " " . $apellido1 . " " . $apellido2;
    $documentoUsuarios = $documento;

    if ($ejecutarInsert) {

        $asunto     = "Validación de Registro SoftPark";
        $mensaje    = "<h1 style='text-align: center;'>Señor (a) " . $nombreUsuarios . ", Soft Park le da la bienvenida</h1>
                <p style='text-align: left; font-weight: bold'>Sus Datos:</p>
                <div style='text-align: center;'>
                    <p><span style='font-weight: bold'>Su documento: </span>" . $documentoUsuarios . "<span></span></p>
                    <p><span style='font-weight: bold'>Su nombre: </span>" . $nombreUsuarios . "<span></span></p>
                    <p><span style='font-weight: bold'>Sus nùmeros de contacto: </span>" . $celular1Usuarios . "<span></span></p>
                    <br>
                    <p>Lo invitamos a validar su correo dando click en el siguiente botón: </p>
                    <p><a href='" . $enlaceCorreos . "sinSesion/validarCorreo.php?hash=" . $hashUsuario . "&&documento=" . $documentoUsuarios . "' style='background-color: #edc847; border-radius: 5pt; padding: 5pt; font-weight: bold; text-decoration: none; color: black;'>Confirmar Correo Electrónico</a></p>
                </div>
                <p>Sus datos han sido registrados satisfactoriamente.</p>
                <br>
                <br>
                <p style='text-align: left; font-weight: bold; font-size: 8pt; text-decoration: none;'>Si al dar click en el boton, no lo redirecciona automaticamente. Copie y pegue el siguiente enlacen en su navegador: " . $enlaceCorreos . "sinSesion/validarCorreo.php?hash=" . $hashUsuario . "&&documento=" . $documentoUsuarios . "</p>";

        enviarCorreo($emailUsuarios, $nombre1 . " " . $apellido1, $mensaje, $asunto);

        echo "<script>window.location.href = '../parqueos/".$archivoActual."?add=1'</script>";
    } else {
        echo "<script>window.location.href = '../parqueos/".$archivoActual."?add=0'</script>";
    }
}
