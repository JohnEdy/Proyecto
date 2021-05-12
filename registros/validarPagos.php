<?php
$contadorErrores = 0;

if (isset($_POST['submit'])) {

    $nitEmpresas    = $_POST['nitEmpresas'];
    $idMesess       = $_POST['idMeses'];
    $idPlanes       = $_POST['idPlanes'];
    $factura        = $_POST['factura'];

    $consultaMeses  = "SELECT COUNT(idPagos) FROM pagos WHERE nitEmpresas = '$nitEmpresas' AND idMesPagos = '$idMesess'";
    $ejecutarMeses  = mysqli_query($conexion, $consultaMeses);
    $fetchMeses     = mysqli_fetch_row($ejecutarMeses);

    //Validamos empresa
    if (empty($nitEmpresas)) {
        validarCampos('seleccionar', 'Empresa');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos empresa
    if (empty($idMesess)) {
        validarCampos('seleccionar', 'Mes a Pagar');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ($fetchMeses[0] >= 1) {
        echo "<div class='alert alert-danger'><b>El mes que intenta pagar, ya ha sido cancelado</b></div>";
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos empresa
    if (empty($idPlanes)) {
        validarCampos('seleccionar', 'Plan a Pagar');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Ejecutamos una acción según la opción de fáctura generada
    if ($factura == 1) {

    }

    if ($contadorErrores == 0) {

        $insertPago = "INSERT INTO pagos (nitEmpresas, idMesPagos, idPlanes, fechaRegistro, registroPor) VALUES ('$nitEmpresas', '$idMesess', '$idPlanes', '$fechaRegistros', '$_SESSION[documentoUsuarios]')";
        $ejecutamosInsert = mysqli_query($conexion, $insertPago);

        if ($idPlanes == 2) {

            $updateEmpresa      = "UPDATE `empresas`    SET `permisosMeses`='1', `permisosLavada`='0', `permisosArticulos`='0', `gratisEmpresas` = '0' WHERE nitEmpresas = '$nitEmpresas'";
            $updateParametros   = "UPDATE `parametros`  SET `mesesParametros` = '1', `lavadaParametros` = '0', `articulosParametros` = '0' WHERE nitEmpresas = '$nitEmpresas'";
        } else if ($idPlanes == 3) {

            $updateEmpresa      = "UPDATE `empresas` SET `permisosMeses`='1', `permisosLavada`='1', `permisosArticulos`='1', `gratisEmpresas` = '0' WHERE nitEmpresas = '$nitEmpresas'";
            $updateParametros   = "UPDATE `parametros` SET `mesesParametros` = '1', `lavadaParametros` = '1', `articulosParametros` = '1' WHERE nitEmpresas = '$nitEmpresas'";
        }

        $ejecutarParametros     = mysqli_query($conexion, $updateParametros);
        $ejecutarEmpresa        = mysqli_query($conexion, $updateEmpresa);

        if ($ejecutamosInsert && $ejecutarParametros && $ejecutarEmpresa) {
            echo $siRegistros;
        } else {
            echo $noRegistros;
        }
    }
}