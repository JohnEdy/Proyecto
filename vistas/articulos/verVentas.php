<?php $menuArtículos = 'articulos'; ?>
<?php require_once('../../estructura/header.php'); ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
//Arcchivo en el que estamos trabajando
$index = 'verVentas';
//Campos para el buscador
$campos = array('idCabecera' => 'Numero Fáctura', 'fechaRegistro' => 'Fecha Venta', 'documentoUsuarios' => 'Cliente');

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='" . $index . ".php?page=1&&nro=10'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

if (isset($_POST['submit'])) {
    $txtBuscar = $_POST['buscador'];
    $condiciones = "AND cabeceraVentas.$_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ";
} else {
    $condiciones = '';
}

$consultaUsuarios = "SELECT documentoUsuarios, CASE WHEN ISNULL(nombre1Usuarios) THEN documentoUsuarios ELSE nombre1Usuarios END, nombre2Usuarios FROM usuarios WHERE nitEmpresas = '$_SESSION[nitEmpresas]' AND idRoles='4' ";

$consultaVentas =   "SELECT
                            cabeceraVentas.idCabecera,
                            cabeceraVentas.fechaRegistro,
                            cabeceraVentas.precioCabecera,
                            (
                            CASE WHEN cabeceraVentas.documentoUsuarios = '' THEN 'Venta Sin Cliente Registrado' ELSE usuarios.nombre1Usuarios
                            END
                            ),
                            usuarios.apellido1Usuarios,
                            cabeceraVentas.precioCabecera,
                            (
                                SELECT
                                    COUNT(*)
                                FROM
                                    articulosVentas
                                WHERE
                                    articulosVentas.idCabecera = cabeceraVentas.idCabecera
                            )
                            FROM
                                cabeceraVentas
                            LEFT JOIN usuarios ON usuarios.documentoUsuarios = cabeceraVentas.documentoUsuarios
                        WHERE
                            cabeceraVentas.nitEmpresas = '$_SESSION[nitEmpresas]' $condiciones
                        ORDER BY cabeceraVentas.idCabecera DESC
                        LIMIT $start, $nroRegistros";
$ejecutarVentas = mysqli_query($conexion, $consultaVentas);
$fetchVentas = mysqli_fetch_all($ejecutarVentas);
?>
<p class="titulos">Consultar Ventas de Artículos</p>

<div class="buscador">
    <p class="tituloSecciones">Buscar</p>

    <form action="" method="POST">
        <div class="row">

            <div class="col-1"></div>
            <div class="col-3">
                <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control' id='buscador' onchange='opcionesSelect();'") ?>
            </div>

            <div class="col-4" id="idCabecera" style="display: none;">
                <input type="text" id="nit" name="idCabecera" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['idCabecera'] : ''; ?>">
            </div>

            <div class="col-4" id="fechaRegistro" style="display: none;">
                <input type="text" class="form-control" name="fechaRegistro" id="datepicker" value="<?php echo isset($_POST['submit']) ? @$_POST['fechaRegistro'] : DATE("Y-m-d"); ?>">
            </div>

            <div class="col-4" id="documentoUsuarios" style="display: none;">
                <?php cargarSelect($conexion, $consultaUsuarios, 'documentoUsuarios', "class='form-control'") ?>
            </div>

            <div class="col-2" id="submit" style="display: none;">
                <button type="submit" class="btn btn-primary btn-sm" name="submit" id=""><?php echo $btnBuscar ?>&nbsp;Buscar</button>
            </div>

            <?php if (isset($_POST['submit'])) { ?>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary btn-sm" name="submitLimpiar" id="btnsubmit"><?php echo $btnLimpiar ?>&nbsp;Limpiar</button>
                </div>
            <?php }  ?>
        </div>
    </form>
</div>

<div class="container-menu">
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

        <table class="table table-sm table-hover table-light">
            <thead class="table-dark">
                <th>Nº Venta</th>
                <th>Cliente</th>
                <th>Fecha y Hora</th>
                <th>Valor</th>
                <th>Articulos Vendidos</th>
                <th>Ver</th>
            </thead>

            <tbody>
                <?php if (empty($fetchVentas)) { ?>

                    <tr>
                        <td colspan="6">
                            <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($fetchVentas as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[3] . " " . $value[4] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td><?php echo "$ " . number_format($value[5]) ?></td>
                            <td><?php echo $value[6] ?></td>
                            <td style="text-align: center;">
                                <a href="../articulos/verVenta.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Ver Información"><?php echo $btnVer ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>

            <tfoot class="table-dark">
                <th>Nº Venta</th>
                <th>Cliente</th>
                <th>Fecha y Hora</th>
                <th>Valor</th>
                <th>Articulos Vendidos</th>
                <th>Ver</th>
            </tfoot>
        </table>
        <?php paginacion($conexion, $consultaVentas, $index, $_GET['page'], $nroRegistros); ?>
    </div>
</div>

<script>
    function opcionesSelect() {

        var select = document.getElementById("buscador").value;
        var submit = document.getElementById("submit");

        console.log(submit);
        var idCabecera = document.getElementById("idCabecera");
        var fechaRegistro = document.getElementById("fechaRegistro");
        var documentoUsuarios = document.getElementById("documentoUsuarios");

        //idMensajes
        if (select == 'idCabecera') {
            idCabecera.style.display = 'inline';
            submit.style.display = 'inline';
        } else {
            idCabecera.style.display = 'none';
        }

        //tituloMensajes
        if (select == 'fechaRegistro') {
            fechaRegistro.style.display = 'inline';
            submit.style.display = 'inline';
        } else {
            fechaRegistro.style.display = 'none';
        }

        //fechaRegistro
        if (select == 'documentoUsuarios') {
            documentoUsuarios.style.display = 'inline';
            submit.style.display = 'inline';
        } else {
            documentoUsuarios.style.display = 'none';
        }
    }

    opcionesSelect();
</script>
<?php require_once('../../estructura/footer.php') ?>