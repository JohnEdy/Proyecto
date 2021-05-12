<?php
@include_once('../estructura/conexion.php');
@include_once('../estructura/variablesGlobales.php');
@session_start();

//Damos los valores de paginación
$nroRegistros = $_POST['nro'];
$start = ($_POST['page'] - 1) * $nroRegistros;

if (isset($_POST['campoBuscar']) && !empty($_POST['campoBuscar'])) {
    $busqueda = "AND (pagos.$_POST[campoBuscar] LIKE '%$_POST[txtBuscar]%')";
} else {
    $busqueda = '';
}

$sql =  "SELECT
            pagos.idPagos,
            pagos.fechaRegistro,
            anho.descripcionAnho,
            meses.nombreMes,
            planes.nombrePlanes,
            planes.precioPlanes,
            usuarios.nombre1Usuarios,
            usuarios.apellido1Usuarios,
            plazo.nombreMes
        FROM
            pagos
            INNER JOIN anho ON anho.idAnho = pagos.idAnho
            INNER JOIN meses ON meses.idMes = pagos.idMes
            INNER JOIN planes ON planes.idPlanes = pagos.idPlanes
            INNER JOIN usuarios ON usuarios.documentoUsuarios = pagos.registroPor
            INNER JOIN meses plazo ON plazo.idMes - 1 = pagos.idMes
        WHERE
            (pagos.nitEmpresas = '$_SESSION[nitEmpresas]') $busqueda
        ORDER BY
            pagos.idPagos
            DESC
        LIMIT $start, $nroRegistros";

$ejecutar = mysqli_query($conexion, $sql);
$fetchDatos = mysqli_fetch_all($ejecutar);

$table = "<table class='table table-sm table-hover table-light'>";
$table = $table . "<thead class='table-dark'>";
$table = $table . "<th>ID</th>";
$table = $table . "<th>Plan Pagado</th>";
$table = $table . "<th>Mes</th>";
$table = $table . "<th>Año</th>";
$table = $table . "<th>Precio</th>";
$table = $table . "<th>Pagado Por</th>";
$table = $table . "<th>Próximo Pago</th>";
$table = $table . "</thead>";
$table = $table . "<tbody>";

if (COUNT($fetchDatos) == 0) {
    $table = $table . "<tr>";
    $table = $table . "<td colspan='7'>";
    $table = $table . '<div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>';
    $table = $table . "</td>";
    $table = $table . "</tr>";

} else {

    foreach ($fetchDatos as $key => $value) {
        $table = $table . "<tr>";
        $table = $table . "<td>" . $value[0] . "</td>";
        $table = $table . "<td>" . $value[4] . "</td>";
        $table = $table . "<td>" . $value[3] . "</td>";
        $table = $table . "<td>" . $value[2] . "</td>";
        $table = $table . "<td> $ " . number_format($value[5]) . "</td>";
        $table = $table . "<td>" . $value[6] . " " . $value[7] . "</td>";
        $table = $table . "<td>" . $value[8] . " " . $value[2] . "</td>";
        $table = $table . "</tr>";
    }
}
$table = $table . "</tbody>";
$table = $table . "<tfoot class='table-dark'>";
$table = $table . "<th>ID</th>";
$table = $table . "<th>Plan Pagado</th>";
$table = $table . "<th>Mes</th>";
$table = $table . "<th>Año</th>";
$table = $table . "<th>Precio</th>";
$table = $table . "<th>Pagado Por</th>";
$table = $table . "<th>Próximo Pago</th>";
$table = $table . "</tfoot>";
$table = $table . "</table>";

$resultado[0] = $table;
$resultado[1] = paginacion($conexion, $sql, 'misPagos', $_POST['page'], $nroRegistros, NULL, 1);

echo json_encode($resultado);
