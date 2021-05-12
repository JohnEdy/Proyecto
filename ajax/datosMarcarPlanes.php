<?php
@include_once('../estructura/conexion.php');
@include_once('../estructura/variablesGlobales.php');
@session_start();

$sql =  "UPDATE
            planes
        SET
            marcadoPlanes = '0'
        WHERE
            marcadoPlanes = '1'";
$ejecutar = mysqli_query($conexion, $sql);


//Pasamos el estado a uno para marcarlo como una motocicleta y que el sistema pueda agarrar sus validaciones
$sql =  "UPDATE
            planes
        SET
            marcadoPlanes = '1'
        WHERE
            idPlanes = '$_POST[id]'";
$ejecutar = mysqli_query($conexion, $sql);

if ($ejecutar) {
    echo $siRegistros;
} else {
    echo $noRegistros;
}