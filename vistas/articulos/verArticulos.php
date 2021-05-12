<?php $menuArtículos = 'articulos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

//Arcchivo en el que estamos trabajando
$index = 'verArticulos';
//Campos para el buscador
$campos = array('fechaRegistros' => 'Fecha');

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='" . $index . ".php?page=1&&nro=10&&id=$_GET[id]'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

$consulta   =   "SELECT
                    articulos.idArticulos,
                    articulos.nombreArticulos,
                    articulos.presentacionArticulos,
                    articulos.medidaArticulos,
                    articulos.precioArticulos,
                    CASE WHEN ISNULL(articulos.codigoArticulos) THEN 'No se ingresó un código de barras' ELSE articulos.codigoArticulos END AS 'codigoArticulos',
                    marcaArticulos.nombreMarcaArticulos,
                    articulos.cantidadArticulos
                FROM
                    articulos
                INNER JOIN marcaArticulos ON articulos.marcaArticulos = marcaArticulos.idMarcaArticulos
                WHERE
                    articulos.idArticulos = '$_GET[id]'";

$ejecutar   = mysqli_query($conexion, $consulta);
$fetch      = mysqli_fetch_row($ejecutar);

$consultaSalidas =  "SELECT
                            cantidadVentas,
                            fechaVentas,
                            idCabecera
                        FROM
                            articulosVentas
                        WHERE
                            idArticulo = '$fetch[0]'
                        ORDER BY fechaVentas DESC
                        LIMIT $start, $nroRegistros";
$ejecutarSalidas = mysqli_query($conexion, $consultaSalidas);
$fetchSalidas = mysqli_fetch_all($ejecutarSalidas);
?>

<p class="titulos">Información Artículo</p>

<div class="container-menu">
    <?php require_once('../../registros/validarAumentarCantidadArticulos.php') ?>
    <?php if ($fetch[7] <= 0) { ?>
        <ul class="nav nav-pills justify-content-end" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#sumarCantidad"><?php echo $btnMas ?>&nbsp;Cantidad</button>
            </li>
        </ul>
    <?php } ?>
    <p class="tituloSecciones">Información</p>
    <div class="row">
        <div class="col-2">
            <p class="subtitulos">ID </p>
            <p class="informacion"><?php echo $fetch[0] ?></p>
        </div>
        <div class="col-8">
            <p class="subtitulos">Nombre </p>
            <p class="informacion"><?php echo $fetch[1] ?></p>
        </div>
        <div class="col-2">
            <p class="subtitulos">Cantidad </p>
            <p class="informacion"><?php echo $fetch[7] ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <p class="subtitulos">Presentación </p>
            <p class="informacion"><?php echo $fetch[2] . " " . $medidasArticulos[$fetch[3]] ?></p>
        </div>
        <div class="col-3">
            <p class="subtitulos">Precio </p>
            <p class="informacion"><?php echo "$ " . number_format($fetch[4]) ?></p>
        </div>
        <div class="col-3">
            <p class="subtitulos">Marca </p>
            <p class="informacion"><?php echo $fetch[6] ?></p>
        </div>
        <div class="col-3">
            <p class="subtitulos">Código de Barras </p>
            <p class="informacion"><?php echo $fetch[5] ?></p>
        </div>
    </div>
    <hr>
    <p class="tituloSecciones">Sálidas</p>
    <div class="table-responsive">

        <table class="table table-sm table-hover table-light" style="width: 100%;">
            <thead class="table-dark">
                <th style="width: 25%">Cantidad Venta</th>
                <th style="width: 25%">Fecha Venta</th>
                <th style="width: 25%">Número Fáctura</th>
                <th style="width: 25%">Precio Venta</th>
            </thead>
            <tbody>
                <?php if (empty($fetchSalidas)) { ?>

                    <tr>
                        <td colspan="6">
                            <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($fetchSalidas as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td><?php echo $value[2] ?></td>
                            <td><?php echo "$ " . number_format($value[0] * $fetch[4]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
            <tfoot class="table-dark">
                <th style="width: 25%">Cantidad Venta</th>
                <th style="width: 25%">Fecha Venta</th>
                <th style="width: 25%">Número Fáctura</th>
                <th style="width: 25%">Precio Venta</th>
            </tfoot>
        </table>
        <?php paginacion($conexion, $consultaSalidas, $index, $_GET['page'], $nroRegistros, $_GET['id']); ?>

    </div>
</div>

<div class="modal fade" id="sumarCantidad" tabindex="-1" aria-labelledby="sumarCantidad" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Agregar Cantidad de Artículos </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input maxlength="11" type="text" id="cantidadArticulos" class="align-middle form-control" placeholder="Ingrese Cantidad De Artículos" name="cantidadArticulos" onkeyup="enviarCantidad();">
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" id="btnSubmit" class="btn btn-primary" style="display: none;"><?php echo $btnRegistrar ?>Registrar</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<script>
    function enviarCantidad() {

        var btnSubmit = document.getElementById("btnSubmit").style;
        var cantidad = document.getElementById("cantidadArticulos");

        if (cantidad.value != "") {
            btnSubmit.display = 'inline';
        } else {
            btnSubmit.display = 'none';
        }
    }
</script>
<?php require_once('../../estructura/footer.php') ?>