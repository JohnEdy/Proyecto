<?php @$menuAdministradores = 'administradores'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
//Arcchivo en el que estamos trabajando
$index = 'verVehiculos';
//Campos para el buscador
$campos = array('placaVehiculos' => 'Placa', 'tipoVehiculos' => 'Tipo', 'marcaVehiculos' => 'Marca');

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='" . $index . ".php?page=1&&nro=10'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

if (isset($_POST['submit'])) {
    $txtBuscar = $_POST['buscador'];
    $condiciones = "AND vehiculos.$_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ";
} else {
    $condiciones = '';
}

$sql   =    "SELECT
                vehiculos.placaVehiculos,
                vehiculos.colorVehiculos,
                tiposVehiculos.nombreTipoVehiculos,
                marcas.nombreMarcas,
                usuarios.nombre1Usuarios,
                usuarios.nombre2Usuarios,
                usuarios.apellido1Usuarios,
                usuarios.apellido2Usuarios
            FROM
                vehiculos
            LEFT JOIN marcas           ON marcas.idMarcas                  = vehiculos.marcaVehiculos
            LEFT JOIN usuarios         ON usuarios.documentoUsuarios       = vehiculos.documentoUsuarios
            Right JOIN tiposVehiculos   ON tiposVehiculos.idTipoVehiculos   = vehiculos.tipoVehiculos
            WHERE
                vehiculos.nitEmpresas           = '$_SESSION[nitEmpresas]'
                $condiciones
            ORDER BY
                vehiculos.placaVehiculos
            LIMIT $start, $nroRegistros";


$ejecutar   = mysqli_query($conexion, $sql);
$fetch      = mysqli_fetch_all($ejecutar);
?>

<p class="titulos">Vehículos Registrados</p>
<div class="buscador">
    <p class="tituloSecciones">Buscar</p>

    <form action="" method="POST">
        <div class="row">

            <div class="col-1"></div>
            <div class="col-3">
                <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control' id='buscador' onclick='opcionesSelect();'") ?>
            </div>

            <div class="col-4" id="placaVehiculos" style="display: none;">
                <input type="text" name="placaVehiculos" id="placaVehiculoss" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['placaVehiculos'] : ''; ?>" onkeypress="placa('placaVehiculoss');" maxlength="7">
            </div>

            <div class="col-4" id="tipoVehiculos" style="display: none;">
                <?php cargarSelect($conexion, "$tipoVehiculos", 'tipoVehiculos', "class='form-control' id='buscador' onclick='opcionesSelect();'") ?>
            </div>

            <div class="col-4" id="marcaVehiculos" style="display: none;">
                <?php cargarSelect($conexion, "SELECT idMarcas, nombreMarcas FROM marcas WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreMarcas", 'marcaVehiculos', "class='form-control'") ?>
            </div>

            <div class="col-2" id="submit" style="display: none;">
                <button type="submit" class="btn btn-primary btn-sm" name="submit" id=""><?php echo $btnBuscar ?>&nbsp;Buscar</button>
            </div>

            <?php if (isset($_POST['submit'])) { ?>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary btn-sm" name="submitLimpiar" id=""><?php echo $btnLimpiar ?>&nbsp;Limpiar</button>
                </div>
            <?php }  ?>
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
                <th style="width: 16.6%">Placa</th>
                <th style="width: 16.6%">Color</th>
                <th style="width: 16.6%">Tipo</th>
                <th style="width: 16.6%">Marca</th>
                <th style="width: 16.6%">Propietario</th>
                <th style="width: 16.6%">Acciones</th>
            </thead>
            <tbody>
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
                            <td><?php echo $value[3] ?></td>
                            <td><?php echo $value[4] . " " . $value[5] . " " . $value[6] . " " . $value[7] ?></td>
                            <td style='text-align: center; '>
                                <a href="../administradores/verEmpresa.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Eliminar Usuario" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $value[0] ?>"><?php echo $btnEliminar ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
            <tfoot class="table-dark">
                <th style="width: 16.6%">Placa</th>
                <th style="width: 16.6%">Color</th>
                <th style="width: 16.6%">Tipo</th>
                <th style="width: 16.6%">Marca</th>
                <th style="width: 16.6%">Propietario</th>
                <th style="width: 16.6%">Acciones</th>
            </tfoot>
        </table>
        <?php paginacion($conexion, $sql, $index, $_GET['page'], $nroRegistros); ?>

    </div>
</div>
<?php foreach ($fetch as $key => $value) : ?>
    <div class="modal fade" id="exampleModal-<?php echo $value[0] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger"><?php echo $preguntaEliminar ?></div>
                    <p class="subtitulos">Vehículo A Eliminar: </p>
                    <p class="informacion"><?php echo $value[0] ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $cerrarSesion ?>Cerrar</button>
                    <a type="button" class="btn btn-primary" href="../acciones/eliminarVehiculos.php?id=<?php echo $value[0] ?>"><?php echo $btnEliminar ?>&nbsp;Eliminar Usuario</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    function opcionesSelect() {

        var select = document.getElementById("buscador").value;
        var submit = document.getElementById("submit").style;

        var placaVehiculos = document.getElementById("placaVehiculos").style;
        var tipoVehiculos = document.getElementById("tipoVehiculos").style;
        var marcaVehiculos = document.getElementById("marcaVehiculos").style;

        //documentoUsuarios
        if (select == 'placaVehiculos') {
            placaVehiculos.display = 'inline';
            submit.display = 'inline';
        } else {
            placaVehiculos.display = 'none';
        }

        //idRoles
        if (select == 'tipoVehiculos') {
            tipoVehiculos.display = 'inline';
            submit.display = 'inline';
        } else {
            tipoVehiculos.display = 'none';
        }

        //nombreEmpresas
        if (select == 'marcaVehiculos') {
            marcaVehiculos.display = 'inline';
            submit.display = 'inline';
        } else {
            marcaVehiculos.display = 'none';
        }

    }
    opcionesSelect();
</script>

<?php require_once('../../estructura/footer.php') ?>