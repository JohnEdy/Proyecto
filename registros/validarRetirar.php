<?php
include_once('../../estructura/conexion.php');
include_once('../../estructura/variablesGlobales.php');
$contadorErrores = 0;

if (@isset($_POST['submit'])) {

    @$documentoUsuarios = $_POST['documentoUsuarios'];
    @$celular1Usuarios  = $_POST['celular1Usuarios'];

    $consultaDocumentos = "SELECT COUNT(documentoUsuarios) FROM usuarios WHERE documentoUsuarios = '$documentoUsuarios'";
    $ejecutarDocumento  = mysqli_query($conexion, $consultaDocumentos);
    $fetchDocumento     = mysqli_fetch_row($ejecutarDocumento);

    if (empty($documentoUsuarios)) {
        validarCampos('vacio', 'Documento');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($documentoUsuarios)) {
        validarCampos('numeros', 'Documento');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($documentoUsuarios) > $C = 15) {
        validarCampos('caracteres', 'Documento', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ($fetchDocumento[0] == 0) {
        validarCampos('noRegistrado', 'Documento');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    $consultaDCelular   = "SELECT COUNT(celular1Usuarios) FROM usuarios WHERE celular1Usuarios = '$celular1Usuarios'";
    $ejecutarCelular    = mysqli_query($conexion, $consultaDCelular);
    $fetchCelular       = mysqli_fetch_row($ejecutarCelular);

    if (empty($celular1Usuarios)) {
        validarCampos('vacio', 'Teléfono');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($celular1Usuarios)) {
        validarCampos('numeros', 'Teléfono');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($celular1Usuarios) > $C = 15) {
        validarCampos('caracteres', 'Teléfono', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ($fetchCelular[0] == 0) {
        validarCampos('noRegistrado', 'Teléfono');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    if ($contadorErrores == 0) {
        echo $consulta   = "SELECT COUNT(usuarios.documentoUsuarios), parqueos.idParqueos FROM usuarios INNER JOIN parqueos ON parqueos.documentoUsuarios = usuarios.documentoUsuarios WHERE usuarios.documentoUsuarios = '$documentoUsuarios' AND usuarios.celular1Usuarios = '$celular1Usuarios' AND parqueos.estadoParqueos = '2'";
        $ejecutar   = mysqli_query($conexion, $consulta);
        $fetch      = mysqli_fetch_row($ejecutar);

        print_r($fetch);
        if ($fetch[0] == 0) {
            echo "<div class='alert alert-danger'>Usted no posee parqueos activos</div>";
            return false;
        } else {
            mysqli_close($conexion);
            echo "<script>window.open('../PDF/pdfParqueos.php?id=$fetch[1]&&pdf=1', '_blank')</script>";
        }
    }
}