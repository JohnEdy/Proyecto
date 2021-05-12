<?php $menuAdministradoresSis = 'administradoresSis'; ?>
<?php require_once('../../estructura/header.php'); ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
//Arcchivo en el que estamos trabajando
$index = 'consultarEmpresas';
//Campos para el buscador
$campos = array('nitEmpresas' => 'Nit', 'nombreEmpresas' => 'Nombre', 'estadoEmpresas' => 'Estado');

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='" . $index . ".php?page=1&&nro=10'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

if (isset($_POST['submit'])) {
    $txtBuscar = $_POST['buscador'];
    $condiciones = "WHERE $_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ";
} else {
    $condiciones = '';
}

$consultaEmpresas =     "SELECT
                                empresas.nitEmpresas,
                                empresas.nombreEmpresas,
                                empresas.telefonoCelularEmpresa,
                                empresas.estadoEmpresas,
                                CASE WHEN ISNULL(parametros.mesesParametros) 		THEN '-1' ELSE parametros.mesesParametros 		END,
                                CASE WHEN ISNULL(parametros.articulosParametros) 	THEN '-1' ELSE parametros.articulosParametros 	END,
                                CASE WHEN ISNULL(parametros.lavadaParametros) 		THEN '-1' ELSE parametros.lavadaParametros 		END
                            FROM empresas
                                LEFT JOIN parametros ON parametros.nitEmpresas = empresas.nitEmpresas $condiciones
                            ORDER BY nombreEmpresas LIMIT $start, $nroRegistros";

$ejecutarEmpresas = mysqli_query($conexion, $consultaEmpresas);
$fetchEmpresas = mysqli_fetch_all($ejecutarEmpresas);
?>
<p class="titulos">Consultar Empresas</p>

<div class="buscador">
    <p class="tituloSecciones">Buscar</p>

    <form action="" method="POST">
        <div class="row">

            <div class="col-1"></div>
            <div class="col-3">
                <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control' id='buscador' onclick='opcionesSelect();'") ?>
            </div>

            <div class="col-4" id="nitEmpresas" style="display: none;">
                <input type="text" id="nit" name="nitEmpresas" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['nitEmpresas'] : ''; ?>" onkeyup="nitText();">
            </div>

            <div class="col-4" id="nombreEmpresas" style="display: none;">
                <input type="text" class="form-control" name="nombreEmpresas" value="<?php echo isset($_POST['submit']) ? @$_POST['nombreEmpresas'] : ''; ?>">
            </div>

            <div class="col-4" id="estadoEmpresas" style="display: none;">
                <?php cargarSelect('', $estadoEmpresas, 'estadoEmpresas', "class='form-control'") ?>
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
    <?php if (@$_GET['in'] == 1) { ?>
        <div class='alert alert-success'>La empresa fue <b>Habilitada</b> correctamente</div>
    <?php } else if (@$_GET['in'] == 2) { ?>
        <div class='alert alert-success'>La empresa fue <b>Inhabilitada</b> correctamente</div>
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

        <table class="table table-sm table-hover table-light">
            <thead class="table-dark">
                <th>Nit</th>
                <th>Nombre</th>
                <th>Nª Celular</th>
                <th>Estado</th>
                <th>Meses</th>
                <th>Lavadas</th>
                <th>Articulos</th>
                <th>Ver</th>
            </thead>

            <tbody>
                <?php if (empty($fetchEmpresas)) { ?>

                    <tr>
                        <td colspan="6">
                            <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($fetchEmpresas as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td><?php echo $value[2] ?></td>
                            <td><?php echo $estadoEmpresas[$value[3]] ?></td>
                            <td><?php echo $value[0] != $nitParkingSoft ? $siNo[$value[4]] : 'N/A' ?></td>
                            <td><?php echo $value[0] != $nitParkingSoft ? $siNo[$value[5]] : 'N/A' ?></td>
                            <td><?php echo $value[0] != $nitParkingSoft ? $siNo[$value[6]] : 'N/A' ?></td>
                            <td style="text-align: center;">
                                <a href="../administradorSistema/verEmpresa.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Ver Información"><?php echo $btnVer ?></a>
                                <?php if ($value[0] != $nitParkingSoft) { ?>
                                    <?php if ($value[3] == 0) {
                                        $btn = $btnRegistrar;
                                    } else {
                                        $btn = $btnInhabilitar;
                                    } ?>
                                    <a href="../acciones/inhabilitarEmpresas.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Desabilitar/Inhabilitar"><?php echo $btn ?></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>

            <tfoot class="table-dark">
                <th>Nit</th>
                <th>Nombre</th>
                <th>Nª Celular</th>
                <th>Estado</th>
                <th>Meses</th>
                <th>Lavadas</th>
                <th>Articulos</th>
                <th>Ver</th>
            </tfoot>
        </table>
        <?php paginacion($conexion, $consultaEmpresas, $index, $_GET['page'], $nroRegistros); ?>
    </div>
</div>

<script>
    function opcionesSelect() {

        var select = document.getElementById("buscador").value;
        var submit = document.getElementById("submit").style;

        var nitEmpresas = document.getElementById("nitEmpresas").style;
        var nombreEmpresas = document.getElementById("nombreEmpresas").style;
        var estadoEmpresas = document.getElementById("estadoEmpresas").style;

        //idMensajes
        if (select == 'nitEmpresas') {
            nitEmpresas.display = 'inline';
            submit.display = 'inline';
        } else {
            nitEmpresas.display = 'none';
        }

        //tituloMensajes
        if (select == 'nombreEmpresas') {
            nombreEmpresas.display = 'inline';
            submit.display = 'inline';
        } else {
            nombreEmpresas.display = 'none';
        }

        //fechaRegistro
        if (select == 'estadoEmpresas') {
            estadoEmpresas.display = 'inline';
            submit.display = 'inline';
        } else {
            estadoEmpresas.display = 'none';
        }

    }

    function nitText() {

        var nit = document.getElementById("nit");

        console.log(nit);
        if (nit.value.length == 3) {
            nit.value = nit.value + ".";
        }

        if (nit.value.length == 7) {
            nit.value = nit.value + ".";
        }

        if (nit.value.length == 11) {
            nit.value = nit.value + "-";
        }
    }
    opcionesSelect();
</script>
<?php require_once('../../estructura/footer.php') ?>