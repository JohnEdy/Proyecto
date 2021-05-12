<?php
@include_once('../estructura/conexion.php');
@include_once('../estructura/variablesGlobales.php');
@session_start();

$sql =  "UPDATE
            tiposVehiculos
        SET
            marcadoVehiculos = '0'
        WHERE
            nitEmpresas = '$_SESSION[nitEmpresas]' AND marcadoVehiculos = '1'";
$ejecutar = mysqli_query($conexion, $sql);


//Pasamos el estado a uno para marcarlo como una motocicleta y que el sistema pueda agarrar sus validaciones
$sql =  "UPDATE
            tiposVehiculos
        SET
            marcadoVehiculos = '1'
        WHERE
            nitEmpresas = '$_SESSION[nitEmpresas]' AND idTipoVehiculos = '$_POST[id]'";
$ejecutar = mysqli_query($conexion, $sql);

if ($ejecutar) {
    echo $siRegistros;
} else {
    echo $noRegistros;
}