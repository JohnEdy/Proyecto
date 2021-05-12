<?php
@include_once('../estructura/conexion.php');

if ($_POST['departamento'] === 0 || $_POST['departamento'] === 1103) {
    $sql = "SELECT idMunicipios, nombreMunicipios FROM municipios ORDER BY nombreMunicipios";
} else {
    $sql = "SELECT idMunicipios, nombreMunicipios FROM municipios WHERE idDepartamentos = '$_POST[departamento]'";
}

$ejecutar       = mysqli_query($conexion, $sql);
$municipios     = mysqli_fetch_all($ejecutar);

$datos = "<option value='0'>-- Seleccione -- </option>";
foreach ($municipios as $key => $value) {
    $datos = $datos . "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
}

echo $datos;
