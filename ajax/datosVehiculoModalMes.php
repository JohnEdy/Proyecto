<?php
@include_once('../estructura/conexion.php');
@session_start();

$sql = "SELECT COUNT(*) FROM vehiculos WHERE placaVehiculos = '$_POST[txt]' AND nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutar = mysqli_query($conexion, $sql);

$row = mysqli_fetch_row($ejecutar);

echo $row[0];