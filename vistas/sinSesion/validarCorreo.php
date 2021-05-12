<?php
@include_once('../../estructura/conexion.php');
$sql = "UPDATE usuarios SET estadoCorreo = '1'  WHERE documentoUsuarios = '$_GET[documento]' AND hashUsuario = '$_GET[hash]'";
$update = mysqli_query($conexion, $sql);

if ($update) {
    echo "<script>window.location.href = 'index.php?em=1'</script>";
}
