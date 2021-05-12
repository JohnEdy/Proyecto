<?php
require_once('../../estructura/conexion.php');

$id = $_GET['id'];

$consultaEmpresas   = "SELECT estadoEmpresas FROM empresas WHERE nitEmpresas = '$id'";
$ejecutarEmpresas   = mysqli_query($conexion, $consultaEmpresas);
$fetchEmpresas      = mysqli_fetch_array($ejecutarEmpresas);

if ($fetchEmpresas[0] == 1) {
    $consulta           = "UPDATE `empresas` SET `estadoEmpresas` = '0' WHERE `nitEmpresas` = '$id'";
    $ejecutarConsulta   = mysqli_query($conexion, $consulta);
    if ($ejecutarConsulta) {
        echo "<script>location.href='../administradorSistema/consultarEmpresas.php?in=2'</script>";
    }
} else {
    $consulta           = "UPDATE `empresas` SET `estadoEmpresas` = '1' WHERE `nitEmpresas` = '$id'";
    $ejecutarConsulta   = mysqli_query($conexion, $consulta);
    if ($ejecutarConsulta) {
        echo "<script>location.href='../administradorSistema/consultarEmpresas.php?in=1'</script>";
    }
}

$ejecutarConsulta = mysqli_query($conexion, $consulta);

if ($ejecutarConsulta) {
    echo "<script>location.href='../administradorSistema/consultarEmpresas.php'</script>";
}
