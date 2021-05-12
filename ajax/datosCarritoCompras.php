<?php
include_once("../estructura/conexion.php");
include_once("../estructura/variablesGlobales.php");
@session_start();

$idArticulo = $_POST['idArticulo'];

if ($_POST['agregar'] == 1) {
    //Insertamos el articulo a adquirir
    $sql =  "INSERT INTO `carritoCompras`(
                `idArticulo`,
                `cantidadCarritoCompras`,
                `nitEmpresas`,
                `documentoUsuarios`,
                `estadoCarritoCompras`
            )
            VALUES  ('$idArticulo',
                    '1',
                    '$_SESSION[nitEmpresas]',
                    '$_SESSION[documentoUsuarios]',
                    '1')";
    $ejecutar = mysqli_query($conexion, $sql);
} else {
    $sql = "DELETE FROM carritoCompras WHERE idArticulo = '$idArticulo' AND nitEmpresas = '$_SESSION[nitEmpresas]' AND documentoUsuarios = '$_SESSION[documentoUsuarios]'";
    $ejecutar = mysqli_query($conexion, $sql);
}

//Realizamos la consulta de los artículos para agregar su tabla
$sqlCarrito =   "SELECT
                    articulos.nombreArticulos,
                    SUM(
                        carritoCompras.cantidadCarritoCompras
                    ) AS 'cantidadCompra',
                    articulos.precioArticulos AS 'precioUnitario',
                    articulos.precioArticulos * SUM(
                        carritoCompras.cantidadCarritoCompras
                    ) AS 'precioTotal',
                    articulos.idArticulos
                FROM
                    carritoCompras
                    INNER JOIN articulos ON articulos.idArticulos = carritoCompras.idArticulo
                WHERE
                    carritoCompras.nitEmpresas = '$_SESSION[nitEmpresas]'
                    AND carritoCompras.documentoUsuarios = '$_SESSION[documentoUsuarios]'
                GROUP BY
                    articulos.nombreArticulos";
$ejecutarCarritos = mysqli_query($conexion, $sqlCarrito);
$fetchDatos = mysqli_fetch_all($ejecutarCarritos);

$table = "<table class='table table-sm table-hover table-light' id='table'>";
$table = $table . "<thead class='table-dark'>";
$table = $table . "<th>Nombre Artículos</th>";
$table = $table . "<th>Cantidad Compra</th>";
$table = $table . "<th>Precio Unidad</th>";
$table = $table . "<th>Precio Total</th>";
$table = $table . "<th>Eliminar</th>";
$table = $table . "</thead>";
$table = $table . "<tbody>";

if (COUNT($fetchDatos) == 0) {
    $table = $table . "<tr>";
    $table = $table . "<td colspan='5'>";
    $table = $table . '<div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>';
    $table = $table . "</td>";
    $table = $table . "</tr>";
} else {

    foreach ($fetchDatos as $key => $value) {
        $table = $table . "<tr>";
        $table = $table . "<td>" . $value[0] . "</td>";
        $table = $table . "<td id='elimCantidadCompra-" . $value[4] . "'>" . $value[1] . "</td>";
        $table = $table . "<td> $ " . number_format($value[2]) . "</td>";
        $table = $table . "<td> $ " . number_format($value[3]) . "</td>";
        $table = $table . "<td style='text-align: center;'>
                            <input type='hidden' value='" . $value[4] . "' name='idArticuCierre' id='idArtElim-" . $value[4] . "'>
                            <input type='hidden' value='" . $value[1] . "' name='cantiTotalArt'>
                            <button data-bs-toggle='tooltip' data-bs-placement='right' title='Descartar Articulo' class='btn btn-primary' id='btnEliminarArticulo-" . $value[4] . "'>" . $btnEliminar . "</button></td>";
        $table = $table . "</tr>";
    }
}

$table = $table . "</tbody>";
$table = $table . "<tfoot class='table-dark'>";
$table = $table . "<th>Nombre Artículos</th>";
$table = $table . "<th>Cantidad Compra</th>";
$table = $table . "<th>Precio Unidad</th>";
$table = $table . "<th>Precio Total</th>";
$table = $table . "<th>Eliminar</th>";
$table = $table . "</tfoot>";
$table = $table . "</table>";

echo $table;
