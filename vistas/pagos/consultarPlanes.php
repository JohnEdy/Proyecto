<?php $menuPagos = 'pagos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='consultarPlanes.php?page=1&&nro=10'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

if (isset($_POST['submit'])) {
    $txtBuscar = $_POST['buscador'];
    print_r($_POST);
    echo $condiciones = "WHERE $_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ORDER BY $txtBuscar";
} else {
    $condiciones = 'ORDER BY pagos.fechaRegistro';
}

//Consulta Para mostrar los datos y crear el paginador
$consultaPagos  = "SELECT pagos.idPagos, pagos.idMesPagos,  pagos.nitEmpresas, empresas.nombreEmpresas, planes.nombrePlanes, pagos.fechaRegistro, usuarios.nombre1Usuarios, usuarios.apellido1Usuarios FROM pagos INNER JOIN empresas ON empresas.nitEmpresas = pagos.nitEmpresas INNER JOIN planes ON planes.idPlanes = pagos.idPlanes INNER JOIN usuarios ON pagos.registroPor = usuarios.documentoUsuarios $condiciones LIMIT $start, $nroRegistros";

$ejecutarPagos  = mysqli_query($conexion, $consultaPagos);
$fetchPagos     = mysqli_fetch_all($ejecutarPagos);

//Campos para la busqueda
$campos = array('pagos.idMesPagos' => 'Mes', 'empresas.nombreEmpresas' => 'Empresa', 'planes.idPlanes' => 'Planes', 'pagos.fechaRegistro' => 'Fecha de Pago');

?>

<p class="titulos">Consultar Pagos</p>

<div class="buscador">
    <p class="tituloSecciones">Buscar</p>
    <form action="" method="POST">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-3">
                <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control' id='buscador' onclick='opcionesSelect();'") ?>
            </div>
            <div class="col-4" id="pagos.idMesPagos" style="display: none;">
                <?php cargarSelect($conexion, $idMeses, 'pagos.idMesPagos', "class='form-control'") ?>
            </div>
            <div class="col-4" id="nombreArticulos" style="display: none;">
                <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control'") ?>
            </div>
            <div class="col-4" id="presentacionArticulos" style="display: none;">
                <?php
                cargarSelect($conexion, "SELECT presentacionArticulos, presentacionArticulos FROM articulos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' GROUP BY presentacionArticulos ORDER BY presentacionArticulos", "presentacionArticulos", "class='form-control'")
                ?>
            </div>
            <div class="col-4" id="medidaArticulos" style="display: none;">
                <?php
                cargarSelect('', $medidasArticulos, "medidaArticulos", "class='form-control'")
                ?>
            </div>
            <div class="col-4" id="codigoArticulos" style="display: none;">
                <input type="text" name="codigoArticulos" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['codigoArticulos'] : ''; ?>">
            </div>
            <div class="col-4" id="cantidadArticulos" style="display: none;">
                <input type="text" name="cantidadArticulos" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['cantidadArticulos'] : ''; ?>">
            </div>
            <div class="col-4" id="marcaArticulos" style="display: none;">
                <?php
                cargarSelect($conexion, "SELECT idMarcaArticulos, nombreMarcaArticulos FROM marcaArticulos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreMarcaArticulos", "marcaArticulos", "class='form-control'");
                ?>
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
    <div class="table-responsive">
        <div class="cantidadPaginas">
            Mostrando &nbsp;
            <select name="" id="cantidadBusqueda" class="" onchange="enviarCantidadBusqueda('consultarPlanes');">
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
        <table class="table table-hover table-sm table-light">
            <thead class="table-dark">
                <th style="width: 4%">ID</th>
                <th style="width: 16%">Nit Empresa</th>
                <th style="width: 16%">Empresa</th>
                <th style="width: 16%">Tipo de Plan</th>
                <th style="width: 16%">Mes Pagó</th>
                <th style="width: 16%">Fecha Pagó</th>
                <th style="width: 16%">Cajero</th>
            </thead>
            <tbody>
                <?php if (empty($fetchPagos)) { ?>
                    <tr>
                        <td colspan="6">
                            <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($fetchPagos as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[2] ?></td>
                            <td><?php echo $value[3] ?></td>
                            <td><?php echo $value[4] ?></td>
                            <td><?php echo $idMeses[$value[1]] ?></td>
                            <td><?php echo $value[5] ?></td>
                            <td><?php echo $value[6] . " " . $value[7] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
            <tfoot class="table-dark">
                <th style="width: 4%">ID</th>
                <th style="width: 16%">Nit Empresa</th>
                <th style="width: 16%">Empresa</th>
                <th style="width: 16%">Tipo de Plan</th>
                <th style="width: 16%">Mes Pagó</th>
                <th style="width: 16%">Fecha Pagó</th>
                <th style="width: 16%">Cajero</th>
            </tfoot>
        </table>

        <?php paginacion($conexion, $consultaPagos, 'consultarPlanes', @$_GET['page'], $nroRegistros); ?>
    </div>


</div>

<script>
    function opcionesSelect() {

        var idMesPagos = document.getElementById("pagos.idMesPagos").style;
        var nombreArticulos = document.getElementById("nombreArticulos").style;
        var presentacionArticulos = document.getElementById("presentacionArticulos").style;
        var medidaArticulos = document.getElementById("medidaArticulos").style;
        var codigoArticulos = document.getElementById("codigoArticulos").style;
        var cantidadArticulos = document.getElementById("cantidadArticulos").style;
        var marcaArticulos = document.getElementById("marcaArticulos").style;

        var select = document.getElementById("buscador").value;
        var submit = document.getElementById("submit").style;

        //idArticulos
        if (select == 'pagos.idMesPagos') {
            idMesPagos.display = 'inline';
            submit.display = 'inline';
        } else {
            idMesPagos.display = 'none';
        }

        //nombreArticulos
        if (select == 'nombreArticulos') {
            nombreArticulos.display = 'inline';
            submit.display = 'inline';
        } else {
            nombreArticulos.display = 'none';
        }

        //presentacionArticulos
        if (select == 'presentacionArticulos') {
            presentacionArticulos.display = 'inline';
            submit.display = 'inline';
        } else {
            presentacionArticulos.display = 'none';
        }

        //medidaArticulos
        if (select == 'medidaArticulos') {
            medidaArticulos.display = 'inline';
            submit.display = 'inline';
        } else {
            medidaArticulos.display = 'none';
        }

        //codigoArticulos
        if (select == 'codigoArticulos') {
            codigoArticulos.display = 'inline';
            submit.display = 'inline';
        } else {
            codigoArticulos.display = 'none';
        }

        //cantidadArticulos
        if (select == 'cantidadArticulos') {
            cantidadArticulos.display = 'inline';
            submit.display = 'inline';
        } else {
            cantidadArticulos.display = 'none';
        }

        //marcaArticulos
        if (select == 'marcaArticulos') {
            marcaArticulos.display = 'inline';
            submit.display = 'inline';
        } else {
            marcaArticulos.display = 'none';
        }
    }

    opcionesSelect();
</script>

<?php require_once('../../estructura/footer.php') ?>