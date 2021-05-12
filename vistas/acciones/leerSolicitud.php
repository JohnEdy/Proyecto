<?php
    require('../../estructura/conexion.php');

    $opcion = $_GET['opcion'];
    $id = $_GET['id'];

    if ($opcion == '1') {
        $consultaLeido = "UPDATE usuarios_mensajes SET estadoSolicitud = '3' WHERE idMensajes='$id'";
        mysqli_query($conexion, $consultaLeido);
        echo "<script>window.location='../mensajes/ver.php?id=$id';</script>";
    }