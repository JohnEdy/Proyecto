<?php
include_once("../estructura/conexion.php");

if ($_POST['busqueda'] == 1) {

    $sql = "SELECT * FROM anho WHERE nitEmpresas = '$_POST[nitEmpresas]' AND descripcionAnho = '$_POST[anho]'";
    $ejecutar = mysqli_query($conexion, $sql);
    $rows = mysqli_num_rows($ejecutar);

    if ($rows >= 1) {
        echo 10;
    } else {
        echo 20;
    }

} else {
    $sql = "INSERT INTO anho (descripcionAnho, nitEmpresas) VALUES ('$_POST[anho]', '$_POST[nitEmpresas]')";
    $ejecutar = mysqli_query($conexion, $sql);

    if ($ejecutar) {
        echo 1;
    } else {
        echo 2;
    }
}
