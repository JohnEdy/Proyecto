<?php

require_once('../../estructura/conexion.php');

$id     = $_GET['id'];
$img    = "../configuracionAdmin/" . $_GET['img'];

$consultaSolicitud  = "DELETE FROM planes WHERE idPlanes = '$id'";
$ejecutarSolicitud  = mysqli_query($conexion, $consultaSolicitud);


if ($ejecutarSolicitud) {
    @unlink($Img);
    echo "<script>location.href='../configuracionSistema/consultarPlanes.php?elim=1'</script>";
}
