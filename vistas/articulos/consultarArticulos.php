<?php $menuArtículos = 'articulos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='consultarArticulos.php?page=1&&nro=10'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

if (isset($_POST['submit'])) {
    $txtBuscar = $_POST['buscador'];
    $condiciones = "AND $_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ORDER BY $txtBuscar";
} else {
    $condiciones = 'ORDER BY nombreArticulos';
}

//Consulta Para mostrar los datos y crear el paginador
$consultaArticulos  =   "SELECT
                            articulos.idArticulos,
                            articulos.nombreArticulos,
                            articulos.presentacionArticulos,
                            articulos.medidaArticulos,
                            articulos.cantidadArticulos,
                            articulos.precioArticulos,
                            marcaArticulos.nombreMarcaArticulos,
                            (
                            SELECT
                                SUM(cantidadVentas)
                            FROM
                                articulosVentas
                            WHERE
                                idArticulo = articulos.idArticulos
                            ) AS 'cantidadVentas',
                            articulos.cantidadEntrada
                        FROM
                            articulos
                            INNER JOIN marcaArticulos ON marcaArticulos.idMarcaArticulos = articulos.marcaArticulos
                        WHERE
                            articulos.nitEmpresas = '$_SESSION[nitEmpresas]' $condiciones
                        LIMIT $start, $nroRegistros";
$ejecutarArticulos  = mysqli_query($conexion, $consultaArticulos);
$fetchArticulos     = mysqli_fetch_all($ejecutarArticulos);

//Campos para la busqueda
$campos = array('idArticulosEmpresa' => 'Id', 'nombreArticulos' => 'Descripción', 'presentacionArticulos' => 'Presentación', 'medidaArticulos' => 'Medad', 'codigoArticulos' => 'Código', 'cantidadArticulos' => 'Cantidad', 'marcaArticulos' => 'Marca');

?>

<p class="titulos">Consultar Artículo</p>

<div class="buscador">
    <p class="tituloSecciones">Buscar</p>
    <form action="" method="POST">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-3">
                <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control' id='buscador' onclick='opcionesSelect();'") ?>
            </div>
            <div class="col-4" id="idArticulosEmpresas" style="display: none;">
                <input type="text" name="idArticulosEmpresas" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['idArticulos'] : ''; ?>">
            </div>
            <div class="col-4" id="nombreArticulos" style="display: none;">
                <input type="text" name="nombreArticulos" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['nombreArticulos'] : ''; ?>">
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
            <select name="" id="cantidadBusqueda" class="" onchange="enviarCantidadBusqueda('consultarArticulos');">
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
                <th style="width: 13%">Descripción</th>
                <th style="width: 13%">Presentación</th>
                <th style="width: 13%">Valor Unitario</th>
                <th style="width: 13%">Cantidad Actual</th>
                <th style="width: 13%">Ventas</th>
                <th style="width: 13%">Entrada</th>
                <th style="width: 13%">Marca</th>
                <th style="width: 3%">Acciones</th>
            </thead>
            <tbody>
                <?php if (empty($fetchArticulos)) { ?>
                    <tr>
                        <td colspan="9">
                            <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($fetchArticulos as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td><?php echo $value[2] . " " . $medidasArticulos[$value[3]] ?></td>
                            <td><?php echo "$ " . number_format($value[5]) ?></td>
                            <td><?php echo $value[4] ?></td>
                            <td><?php echo empty($value[7]) ? '0' : $value[7] ?></td>
                            <td><?php echo empty($value[8]) ? '0' : $value[8] ?></td>
                            <td><?php echo $value[6] ?></td>
                            <td style="text-align: center;">
                                <a href="../articulos/verArticulos.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Ver Artículo"><?php echo $btnVer ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
            <tfoot class="table-dark">
                <th style="width: 4%">ID</th>
                <th style="width: 13%">Descripción</th>
                <th style="width: 13%">Presentación</th>
                <th style="width: 13%">Valor Unitario</th>
                <th style="width: 13%">Cantidad Actual</th>
                <th style="width: 13%">Ventas</th>
                <th style="width: 13%">Entrada</th>
                <th style="width: 13%">Marca</th>
                <th style="width: 3%">Acciones</th>
            </tfoot>
        </table>

        <?php paginacion($conexion, $consultaArticulos, 'consultarArticulos', @$_GET['page'], $nroRegistros); ?>
    </div>


</div>

<script>
    function opcionesSelect() {

        var select = document.getElementById("buscador").value;
        var idArticulosEmpresas = document.getElementById("idArticulosEmpresas").style;
        var nombreArticulos = document.getElementById("nombreArticulos").style;
        var presentacionArticulos = document.getElementById("presentacionArticulos").style;
        var medidaArticulos = document.getElementById("medidaArticulos").style;
        var codigoArticulos = document.getElementById("codigoArticulos").style;
        var cantidadArticulos = document.getElementById("cantidadArticulos").style;
        var marcaArticulos = document.getElementById("marcaArticulos").style;
        var submit = document.getElementById("submit").style;

        //idArticulosEmpresas
        if (select == 'idArticulosEmpresas') {
            idArticulosEmpresas.display = 'inline';
            submit.display = 'inline';
        } else {
            idArticulosEmpresas.display = 'none';
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