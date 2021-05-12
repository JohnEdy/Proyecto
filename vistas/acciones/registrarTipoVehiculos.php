<?php

include_once('../../estructura/conexion.php');
session_start();

@$nombreTipoVehiculos    = $_POST['nombreTipoVehiculos'];
@$horasTipoVehiculos     = $_POST['horasTipoVehiculos'];
@$mesesTipoVehiculos     = $_POST['mesesTipoVehiculos'];
@$lavadaTipoVehiculos    = $_POST['lavadaTipoVehiculos'];
$archivoActual          = $_POST['archivoActual'];

if (empty($horasTipoVehiculos)) {
    $horasTipoVehiculos = 0;
} else {
    $horasTipoVehiculos = '$horasTipoVehiculos';
}
if (empty($mesesTipoVehiculos)) {
    $mesesTipoVehiculos = 0;
} else {
    $mesesTipoVehiculos = '$mesesTipoVehiculos';
}
if (empty($lavadaTipoVehiculos)) {
    $lavadaTipoVehiculos = 0;
} else {
    $lavadaTipoVehiculos = '$lavadaTipoVehiculos';
}

$sql =  "INSERT INTO tiposVehiculos(
            nombreTipoVehiculos,
            horaTiposVehiculos,
            mesTiposVehiculos,
            lavadaTiposVehiculos,
            nitEmpresas
        )
        VALUES(
            '$nombreTipoVehiculos',
            '$horasTipoVehiculos',
            '$mesesTipoVehiculos',
            '$lavadaTipoVehiculos',
            '$_SESSION[nitEmpresas]'
        )";

$ejecutar = mysqli_query($conexion, $sql);

if ($ejecutar) {
    echo "<script>location.href='../".$archivoActual."?add=1'</script>";
} else {
    echo "<script>location.href='../".$archivoActual."?add=2'</script>";
}
