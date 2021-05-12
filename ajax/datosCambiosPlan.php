<?php 
@include_once('../estructura/conexion.php');
@session_start();

$sql = "UPDATE empresas SET idPlanes = '$_POST[idPlanes]' WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutar = mysqli_query($conexion, $sql);

if ($ejecutar) {
    echo 1;
} else {
    echo 0;
}