<?php
@include_once('../estructura/conexion.php');

$sql = "SELECT COUNT(*) FROM usuarios WHERE documentoUsuarios = '$_POST[txt]'";
$ejecutar = mysqli_query($conexion, $sql);

$row = mysqli_fetch_row($ejecutar);

echo $row[0];