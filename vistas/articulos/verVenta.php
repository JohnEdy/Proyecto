<?php @$menuAdministradores = 'administradores'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

//Arcchivo en el que estamos trabajando
$index = 'verVenta';
$valorUnitario  = 0;
$valorTotal     = 0;

$consultaVenta =    "SELECT
                        cabeceraVentas.idCabecera,
                        CASE WHEN ISNULL(usuarios.nombre1Usuarios) THEN 'Usuario Sin Nombre Registrado' ELSE usuarios.nombre1Usuarios
                    END,
                        cabeceraVentas.fechaRegistro,
                        cabeceraVentas.precioCabecera,
                        usuarios.apellido1Usuarios
                    FROM
                        cabeceraVentas
                    LEFT JOIN usuarios ON usuarios.documentoUsuarios = cabeceraVentas.documentoUsuarios
                    WHERE
                        cabeceraVentas.idCabecera = $_GET[id]";

$ejecutarVenta = mysqli_query($conexion, $consultaVenta);
$fetch = mysqli_fetch_row($ejecutarVenta);

$consultaArticulos =    "SELECT
                            articulosVentas.idArticulo,
                            articulos.nombreArticulos,
                            articulosVentas.cantidadVentas,
                            articulos.precioArticulos,
                            articulos.precioArticulos * articulosVentas.cantidadVentas
                        FROM
                            articulosVentas
                        INNER JOIN articulos ON articulos.idArticulos = articulosVentas.idArticulo
                        WHERE
                            articulosVentas.idCabecera = '$_GET[id]'";
$ejecutarArticulos  = mysqli_query($conexion, $consultaArticulos);
$fetchArticulos     = mysqli_fetch_all($ejecutarArticulos);
?>

<p class="titulos">Información Venta</p>

<div class="container-menu">
    <?php require_once('../../registros/validarAumentarCantidadArticulos.php') ?>
    <p class="tituloSecciones">Información</p>
    <div class="row">
        <div class="col-2">
            <p class="subtitulos">Nº Fáctura: </p>
            <p class="informacion"><?php echo $fetch[0] ?></p>
        </div>
        <div class="col-10">
            <p class="subtitulos">Nombre Cliente</p>
            <p class="informacion"><?php echo $fetch[1] . " " . $fetch[4] ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <p class="subtitulos">Fecha Venta </p>
            <p class="informacion"><?php echo $fetch[2] ?></p>
        </div>
        <div class="col-6">
            <p class="subtitulos">Precio </p>
            <p class="informacion"><?php echo "$ " . number_format($fetch[3]) ?></p>
        </div>
    </div>
    <hr>
    <p class="tituloSecciones">Artículos Vendidos</p>
    <div class="table-responsive">

        <table class="table table-sm table-hover table-light" style="width: 100%;">
            <thead class="table-dark">
                <th style="width: 20%">ID</th>
                <th style="width: 20%">Descripción</th>
                <th style="width: 20%">Cantidad</th>
                <th style="width: 20%">Precio Unitario</th>
                <th style="width: 20%">Precio Total</th>
            </thead>
            <tbody>
                <?php if (empty($fetchArticulos)) { ?>

                    <tr>
                        <td colspan="6">
                            <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($fetchArticulos as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td><?php echo $value[2] ?></td>
                            <td><?php echo "$ " . number_format($value[3]) ?></td>
                            <?php $valorUnitario = $valorUnitario + $value[3] ?>
                            <td><?php echo "$ " . number_format($value[4]) ?></td>
                            <?php $valorTotal = $valorTotal + $value[4] ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-info">
                        <td colspan="3" style="text-align: right;">TOTAL: </td>
                        <td><?php echo "$ " . number_format($valorUnitario) ?></td>
                        <td><?php echo "$ " . number_format($valorTotal) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot class="table-dark">
                <th style="width: 20%">ID</th>
                <th style="width: 20%">Descripción</th>
                <th style="width: 20%">Cantidad</th>
                <th style="width: 20%">Precio Unitario</th>
                <th style="width: 20%">Precio Total</th>
            </tfoot>
        </table>
    </div>
</div>

<?php require_once('../../estructura/footer.php') ?>