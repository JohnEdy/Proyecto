<?php

include_once("../estructura/conexion.php");
include_once("../estructura/variablesGlobales.php");
@session_start();

//Ejecutamos el insert
if ($_POST['registro'] == 1) {

    $sql = "SELECT * FROM pagos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' AND idAnho = '$_POST[idAnho]' AND idMes = '$_POST[idMes]'";
    $ejecutar = mysqli_query($conexion, $sql);
    $rows = mysqli_num_rows($ejecutar);

    if ($rows > 0) {
        echo 3;
    } else {
        $sql =  "INSERT INTO
                    pagos (
                        idMes,
                        idAnho,
                        idPlanes,
                        nitEmpresas,
                        fechaRegistro,
                        registroPor
                    )
                VALUES
                    (
                        '$_POST[idMes]',
                        '$_POST[idAnho]',
                        '$_POST[idPlanPago]',
                        '$_SESSION[nitEmpresas]',
                        '$fechaRegistros',
                        '$_SESSION[documentoUsuarios]'
                    )";
        $ejecutar = mysqli_query($conexion, $sql);

        if ($ejecutar) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
