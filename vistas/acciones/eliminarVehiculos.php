<?php
require_once('../../estructura/conexion.php');

$id = $_GET['id'];

$consultaSql = "DELETE FROM vehiculos WHERE placaVehiculos = '$id'";
$ejecutarSql = mysqli_query($conexion, $consultaSql);

if ($ejecutarSql) {
    echo "<script>location.href='../administradorEmpresas/verVehiculos.php?elim=1'</script>";
}
