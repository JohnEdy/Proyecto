<?php
@include_once('../estructura/conexion.php');

$sql = "SELECT * FROM empresas WHERE nitEmpresas = '$_POST[nit]'";
$ejecutar = mysqli_query($conexion, $sql);

if ($ejecutar) {
    echo $rows = mysqli_num_rows($ejecutar);

    // if ($rows >= 1) {
    //     echo 0;
    // } else {
    //     echo 1;
    // }
}
