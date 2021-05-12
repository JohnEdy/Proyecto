<?php
include_once("../estructura/conexion.php");

$sql = "SELECT COUNT(*) FROM arqueos WHERE fechaRegistro LIKE '%".Date("Y-m-d")."%' AND documentoUsuarios = '$_POST[cajero]'";
$ejecutar = mysqli_query($conexion, $sql);
$result = mysqli_fetch_row($ejecutar);

echo $result[0];


