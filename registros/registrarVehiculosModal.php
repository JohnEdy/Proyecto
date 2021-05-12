<?php

include_once("../estructura/conexion.php");
include_once("../estructura/variablesGlobales.php");
@session_start();

$placa1Vehiculos        = $_POST['placaVehiculosModal'];
$tipoVehiculoss         = $_POST['tipoVehiculosModal'];
$colorVehiculos         = $_POST['colorVehiculosModal'];
$idMarcaVehiculos       = $_POST['idMarcaVehiculosModal'];
$documentoUsuariosModal = $_POST['documentoUsuariosModal'];

//Guardamos la placa en un solo string en mayúsculas
@$placaVehiculos = strtoupper($placa1Vehiculos);

$consulta        =  "INSERT INTO
                        `vehiculos` (
                            `placaVehiculos`,
                            `tipoVehiculos`,
                            `colorVehiculos`,
                            `marcaVehiculos`,
                            `registradoPor`,
                            `fechaRegistros`,
                            `empresaRegistros`,
                            `documentoUsuarios`,
                            `controlVehiculos`,
                            `nitEmpresas`
                        )
                        VALUES
                        (
                            '$placaVehiculos',
                            '$tipoVehiculoss',
                            '$colorVehiculos',
                            '$idMarcaVehiculos',
                            '$_SESSION[documentoUsuarios]',
                            '$fechaRegistros',
                            '$_SESSION[nitEmpresas]',
                            '$documentoUsuariosModal',
                            '1',
                            '$_SESSION[nitEmpresas]'
                        )";
$ejecutarConsulta   = mysqli_query($conexion, $consulta);

if ($ejecutarConsulta) {
    echo "<script>window.location.href = '../vistas/parqueos/registrarParqueosMes.php?add=1'</script>";
} else {
    echo "<script>window.location.href = '../vistas/parqueos/registrarParqueosMes.php?add=2'</script>";
}
