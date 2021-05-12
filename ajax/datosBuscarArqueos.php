<?php
@include_once('../estructura/conexion.php');
@include_once('../estructura/variablesGlobales.php');
@session_start();

//Damos los valores de paginación
$nroRegistros = $_POST['nro'];
$start = ($_POST['page'] - 1) * $nroRegistros;

if (isset($_POST['campoBuscar']) && !empty($_POST['campoBuscar'])) {
    $busqueda = "AND (arqueos.$_POST[campoBuscar] LIKE '%$_POST[txtBuscar]%')";
} else {
    $busqueda = '';
}


$sql =  "SELECT
            arqueos.idArqueos AS 'idArqueos',
            arqueos.valorTotalBilletes AS 'totalBilletes',
            arqueos.valorTotalMonedas AS 'totalMonedas',
            arqueos.fechaRegistro AS 'fechaRegistro',
            usuarios.nombre1Usuarios,
            usuarios.nombre2Usuarios,
            usuarios.apellido1Usuarios,
            usuarios.apellido2Usuarios
        FROM
            arqueos
            INNER JOIN usuarios ON usuarios.documentoUsuarios = arqueos.documentoUsuarios
        WHERE (arqueos.nitEmpresas = '$_SESSION[nitEmpresas]') $busqueda
        ORDER BY
            arqueos.fechaRegistro
            DESC
        LIMIT $start, $nroRegistros";

$ejecutar = mysqli_query($conexion, $sql);
$fetchDatos = mysqli_fetch_all($ejecutar);

$table = "<table class='table table-sm table-hover table-light'>";
$table = $table . "<thead class='table-dark'>";
$table = $table . "<th>ID</th>";
$table = $table . "<th>Valor Billetes</th>";
$table = $table . "<th>Valor Monedas</th>";
$table = $table . "<th>Total Dinero</th>";
$table = $table . "<th>Fecha Realización</th>";
$table = $table . "<th>Realizado A</th>";
$table = $table . "</thead>";
$table = $table . "<tbody>";

if (COUNT($fetchDatos) == 0) {
    $table = $table . "<tr>";
    $table = $table . "<td colspan='6'>";
    $table = $table . '<div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>';
    $table = $table . "</td>";
    $table = $table . "</tr>";
} else {

    foreach ($fetchDatos as $key => $value) {
        $table = $table . "<tr>";
        $table = $table . "<td>" . $value[0] . "</td>";
        $table = $table . "<td> $ " . number_format($value[1]) . "</td>";
        $table = $table . "<td> $ " . number_format($value[2]) . "</td>";
        $table = $table . "<td> $ " . number_format($value[2] + $value[1]) . "</td>";
        $table = $table . "<td>" . $value[3] . "</td>";
        $table = $table . "<td>" . $value[4] . " " . $value[5] . " " . $value[6] . "$value[7]" . "</td>";
        $table = $table . "</tr>";
    }
}
$table = $table . "</tbody>";
$table = $table . "<tfoot class='table-dark'>";
$table = $table . "<th>ID</th>";
$table = $table . "<th>Valor Billetes</th>";
$table = $table . "<th>Valor Monedas</th>";
$table = $table . "<th>Total Dinero</th>";
$table = $table . "<th>Fecha Realización</th>";
$table = $table . "<th>Realizado A</th>";
$table = $table . "</tfoot>";
$table = $table . "</table>";

$resultado[0] = $table;
$resultado[1] = paginacion($conexion, $sql, 'consultarArqueo', $_POST['page'], $nroRegistros, NULL, 1);

echo json_encode($resultado);
