<?php
@include_once('../estructura/conexion.php');
@include_once('../estructura/variablesGlobales.php');

//Buscamos el tipo de vehiculo que tiene asignado dicha placa
$sql            = "SELECT tipoVehiculos FROM vehiculos WHERE placaVehiculos = '$_POST[placa]'";
$ejecutar       = mysqli_query($conexion, $sql);
$datos          = mysqli_fetch_row($ejecutar);

$sqlTipo        = "SELECT idTipoVehiculos, nombreTipoVehiculos FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarTipos  = mysqli_query($conexion, $sqlTipo);
$datosTipos     = mysqli_fetch_all($ejecutarTipos);

$resultado[1]   = intval(0);
$resultado[0]   = "<option value=''>-- Seleccione --</option>";

foreach ($datosTipos as $key => $value) {
    if (@$datos[0] == $value[0]) {
        $select = "selected='selected'";
        $resultado[2] = 1;
        $resultado[1] = intval($datos[0]);
    } else {
        $select = "";
    }
    $resultado[0] = $resultado[0] . "<option " . $select . " value='" . $value[0] . "'>" . $value[1] . "</option>";
}

echo json_encode($resultado);
