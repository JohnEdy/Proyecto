<?php
require_once('../../estructura/conexion.php');

$id = $_GET['id'];

$consultaSql = "DELETE FROM usuarios WHERE documentoUsuarios = '$id'";
$ejecutarSql = mysqli_query($conexion, $consultaSql);

if ($ejecutarSql) {
    echo "<script>location.href='../administradorEmpresas/verUsuarios.php?elim=1'</script>";
}
