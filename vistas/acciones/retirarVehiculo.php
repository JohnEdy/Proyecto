<?php
include_once('../../estructura/conexion.php');
include_once('../../estructura/variablesGlobales.php');

if (generarCodigo($conexion, 6, $_GET['id'], 1)) {
    echo "<script>location.href='../parqueo/verParqueo.php?id=$_GET[id]'</script>";
}
