<?php
@include_once('../estructura/conexion.php');
@include_once('../estructura/variablesGlobales.php');

$sql        = "SELECT idPlanes, nombrePlanes, fechaRegistros, precioPlanes FROM planes WHERE idPlanes = '$_POST[txt]' OR nombrePlanes LIKE '%$_POST[txt]%' OR precioPlanes LIKE '%$_POST[txt]%'";
$ejecutar   = mysqli_query($conexion, $sql);
$row        = mysqli_fetch_all($ejecutar);

$filas = "<tr>";
if (!empty($row[0])) {
    foreach ($row as $key => $value) {
        $filas = $filas . "<td>" . $value[0] . "</td><td>" . $value[1] . "</td><td>" . $value[2] . "</td><td> $ " . number_format($value[3]) . "</td><td style='text-align: center;'><a href='verPlan.php?id=" . $value[0] . "' title='Ver Plan' data-bs-toggle='tooltip'>" . $btnVer . "</a>&nbsp;<a href='editarPlanes.php?id=" . $value[0] . "' title='Editar Plan' data-bs-toggle='tooltip'>" . $btnEditar . "</a></td></tr>";
    }
} else {
    $filas = "<td class='alert-secondary' colspan='5' style='text-align: center;'>No se encontraron resultados</td></tr>";
}

echo $filas;
//echo json_encode($row);