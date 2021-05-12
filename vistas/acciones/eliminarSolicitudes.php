<?php
require_once('../../estructura/conexion.php');

$id = $_GET['id'];

$consultaSolicitud  = "DELETE FROM mensajes WHERE idMensajes = '$id'";
$consultaRespuestas = "DELETE FROM respuestas WHERE idSolicitud = '$id'";
$consultaUsuarios   = "DELETE FROM usuarios_mensajes WHERE idMensajes = '$id'";

$ejecutarSolicitud  = mysqli_query($conexion, $consultaSolicitud);
$ejecutarRespuestas = mysqli_query($conexion, $consultaRespuestas);
$ejecutarUsuarios   = mysqli_query($conexion, $consultaUsuarios);


if ($ejecutarSolicitud && $ejecutarRespuestas && $ejecutarUsuarios) {
    echo "<script>location.href='../mensajes/misSolicitudes.php?elim=1'</script>";
}
