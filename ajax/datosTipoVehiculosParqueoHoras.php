<?php
@include_once('../estructura/conexion.php');
@include_once('../estructura/variablesGlobales.php');

$sql        = "SELECT COUNT(tipoVehiculos) FROM vehiculos WHERE placaVehiculos = '$_POST[placa]'";
$ejecutar   = mysqli_query($conexion, $sql);
$datos      = mysqli_fetch_row($ejecutar);

if ($datos[0] > 0) {
    echo 1;
} else {
    echo 0;
}
