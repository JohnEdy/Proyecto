<?php
session_start();
include_once("../../estructura/conexion.php");

//Agregamos la marca
if (isset($_POST['submitMarcas'])) {

    $sql        = "INSERT INTO marcas (nombreMarcas, nitEmpresas) VALUES ('$_POST[nombreMarcas]', '$_SESSION[nitEmpresas]') ";
    $insertar   = mysqli_query($conexion, $sql);

    if ($insertar) {
        echo "<script>location.href='../clientes/registrarVehiculos.php?add=1'</script>";
    } else {
        echo "<script>location.href='../clientes/registrarVehiculos.php?add=0'</script>";
    }
}

//Eliminamos la marca
if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['eliminar']) && ($_GET['eliminar'] == 1)) {
    $sql        = "DELETE FROM marcas WHERE idMarcas = '$_GET[id]'";
    $delete     = mysqli_query($conexion, $sql);

    if ($delete) {
        echo "<script>location.href='../clientes/registrarVehiculos.php?delete=1'</script>";
    } else {
        echo "<script>location.href='../clientes/registrarVehiculos.php?delete=0'</script>";
    }
}
