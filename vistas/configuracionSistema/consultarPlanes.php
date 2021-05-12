<?php $menuConfigAdmin = 'configAdmin'; ?>
<?php require_once('../../estructura/header.php'); ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
//Arcchivo en el que estamos trabajando
$index = 'consultarPlanes';
//Campos para el buscador

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    if (!isset($_GET['elim'])) {
        echo "<script>location.href='" . $index . ".php?page=1&&nro=10'</script>";
    } else {
        echo "<script>location.href='" . $index . ".php?page=1&&nro=10&&elim=1'</script>";
    }
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

$sql   =    "SELECT idPlanes, nombrePlanes, fechaRegistros, precioPlanes FROM planes LIMIT $start, $nroRegistros";
$ejecutar   = mysqli_query($conexion, $sql);
$fetch      = mysqli_fetch_all($ejecutar);
?>

<p class="titulos">Planes Registrados</p>
<div class="buscador">
    <ul class="nav nav-pills left-content-end" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="planes.php" class="nav-link btn-primary btn btn-sm"><?php echo $btnAnterior ?>Volver a Planes</a>
        </li>
    </ul>
    <p class="tituloSecciones">Buscar</p>
    <form action="" method="POST">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-11">
                <input type="text" name="placaVehiculos" id="txtBuscar" class="form-control">
            </div>
        </div>
    </form>
</div>

<div class="container-menu">
    <?php if (@$_GET['elim'] == 1) { ?>
        <?php echo $siEliminar ?>
    <?php } ?>
    <div class="table-responsive">
        <div class="cantidadPaginas">
            Mostrando &nbsp;
            <select name="" id="cantidadBusqueda" class="" onchange="enviarCantidadBusqueda('<?php echo $index ?>');">

                <?php foreach ($cantidadPaginacion as $key => $value) { ?>
                    <?php
                    if ($key == $_GET['nro']) {
                        $select = "selected='selected'";
                    } else {
                        $select = "";
                    }
                    ?>
                    <option <?php echo $select ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                <?php } ?>
            </select>
            &nbsp;Registros
        </div>

        <table class="table table-sm table-hover table-light" style="width: 100%;">
            <thead class="table-dark">
                <th style="width: 16.6%">ID</th>
                <th style="width: 16.6%">Título</th>
                <th style="width: 16.6%">Fecha Registro</th>
                <th style="width: 16.6%">Precio</th>
                <th style="width: 16.6%">Acciones</th>
            </thead>
            <tbody id="datosBuscar">
                <?php if (empty($fetch)) { ?>
                    <tr>
                        <td colspan="6">
                            <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($fetch as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td><?php echo $value[2] ?></td>
                            <td><?php echo "$ " . number_format($value[3]) ?></td>
                            <td style='text-align: center; '>
                                <a href='verPlan.php?id=<?php echo $value[0] ?>' title='Ver Plan' data-bs-toggle='tooltip'><?php echo $btnVer ?></a>
                                <a href="editarPlanes.php?id=<?php echo $value[0] ?>" title="Editar Plan" data-bs-toggle="tooltip"><?php echo $btnEditar ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
            <tfoot class="table-dark">
                <th style="width: 16.6%">ID</th>
                <th style="width: 16.6%">Título</th>
                <th style="width: 16.6%">Fecha Registro</th>
                <th style="width: 16.6%">Precio</th>
                <th style="width: 16.6%">Acciones</th>
            </tfoot>
        </table>
        <?php paginacion($conexion, $sql, $index, $_GET['page'], $nroRegistros); ?>

    </div>
</div>

<script>
    $("#txtBuscar").keyup(function() {
        $.ajax({
            type: "POST",
            url: "../../ajax/datosBuscarPlanes.php",
            //dataType:   "json",
            data: "txt=" + $("#txtBuscar").val(),
            success: function(data) {
                $("#datosBuscar").html(data);
            }
        })
    })
</script>

<?php require_once('../../estructura/footer.php') ?>