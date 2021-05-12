<?php $menuArtículos = 'articulos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<p class="titulos">Registrar Artículo</p>
<?php
$consultaArticuloId  = "SELECT MAX(idArticulosEmpresas) FROM articulos WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarArticuloId  = mysqli_query($conexion, $consultaArticuloId);
$fetchArticuloId     = mysqli_fetch_row($ejecutarArticuloId);
$id = $fetchArticuloId[0] + 1;

//Realizamos la consulta para validar si quedan disponibles màs registros
$sql = "SELECT
            planes.cantidadArticulos,
            (
                SELECT
                    COUNT(*)
                FROM
                    articulos
                WHERE
                    (nitEmpresas = '$_SESSION[nitEmpresas]')
            ) AS 'cantidadRegArticulos'
            FROM
                empresas
                INNER JOIN planes ON planes.idPlanes = empresas.idPlanes
            WHERE
                empresas.nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarArticulos = mysqli_query($conexion, $sql);
$cantidadRegistros = mysqli_fetch_assoc($ejecutarArticulos);

?>
<div class="container-menu">
    <?php if ($cantidadRegistros['cantidadRegArticulos'] >= $cantidadRegistros['cantidadArticulos']) { ?>
        <div class="alert alert-danger">Lo sentimos, ha cumplido con la cantidad permitida para registrar Artículos</div>
    <?php } else { ?>
        <ul class="nav nav-pills justify-content-end" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#ingresarMarcaArticulos"><?php echo $btnMas ?>&nbsp;Ingresar Marca</button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarArticulos"><?php echo $btnEliminar ?>&nbsp;Eliminar Marca</button>
            </li>
        </ul>
        <form action="" class="row" method="POST" enctype="multipart/form-data">
            <?php include_once('../../registros/validarArticulos.php') ?>
            <div class="row">
                <div class="col-2">
                    <label for="idParqueos" class="form-label">Id</label>
                    <input type="text" class="form-control" readonly value="<?php echo $id ?>" value="<?php echo $id ?>">
                </div>
                <div class="col-6">
                    <label for="idParqueos" class="form-label">Descripción *</label>
                    <input type="text" class="form-control" name="nombreArticulos" maxlength="40" value="<?php echo (isset($_POST['submit'])) ? $_POST['nombreArticulos'] : '' ?>">
                </div>
                <div class="col-2">
                    <label for="precioArticulos" class="form-label">Valor *</label>
                    <input type="text" class="form-control" name="precioArticulos" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['precioArticulos'] : '' ?>">
                </div>
                <div class="col-2">
                    <label for="idParqueos" class="form-label">Cantidad *</label>
                    <input type="text" class="form-control" name="cantidadArticulos" maxlength="11" value="<?php echo (isset($_POST['submit'])) ? $_POST['cantidadArticulos'] : '' ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="idParqueos" class="form-label">Código de Barras *</label>
                    <input type="text" class="form-control" name="codigoArticulos" maxlength="20" value="<?php echo (isset($_POST['submit'])) ? $_POST['codigoArticulos'] : '' ?>">
                </div>
                <div class="col-2">
                    <label for="idParqueos" class="form-label">Presentación *</label>
                    <input type="text" class="form-control" name="presentacionArticulos" maxlength="5" value="<?php echo (isset($_POST['submit'])) ? $_POST['presentacionArticulos'] : '' ?>">
                </div>
                <div class="col-2">
                    <label for="idParqueos" class="form-label">Medida *</label>
                    <?php cargarSelect('', $medidasArticulos, 'medidaArticulos', "class=form-control") ?>
                </div>
                <div class="col-2">
                    <label for="idParqueos" class="form-label">Marca *</label>
                    <?php cargarSelect($conexion, "SELECT idMarcaArticulos, nombreMarcaArticulos FROM marcaArticulos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreMarcaArticulos", 'marcaArticulos', "class=form-control") ?>
                </div>
                <div class="col-3">
                    <label for="idParqueos" class="form-label">Imagen *</label>
                    <input type="file" class="form-control" name="imagenArticulos">
                </div>
            </div>
            <div class="btnSubmit">
                <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
                <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </form>

    <?php } ?>
</div>

<div class="modal fade" id="ingresarMarcaArticulos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Ingresar Marca de Artículos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="row" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <label for="idParqueos" class="form-label">Descripción *</label>
                            <input type="text" class="form-control" name="nombreArticulos" maxlength="40" value="<?php (isset($_POST['submit'])) ? $_POST['nombreArticulos'] : '' ?>" id="nombreArticulos" onkeyup="mostrarSubmit();" autocomplete="off">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submitArticulos" id="btnSubmitArticulos" class="btn btn-primary" style="display: none;"><?php echo $btnRegistrar ?>Registrar</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>
<?php
$consultaMarcaArticulos = "SELECT idMarcaArticulos, nombreMarcaArticulos FROM marcaArticulos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreMarcaArticulos";
$ejecutarMarcaArticulos = mysqli_query($conexion, $consultaMarcaArticulos);
$fetchMarcaArticulos    = mysqli_fetch_all($ejecutarMarcaArticulos);
?>
<div class="modal fade" id="eliminarArticulos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Eliminar Articulos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-light" id="table" style="width: 100%;">
                        <thead>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            <?php foreach ($fetchMarcaArticulos as $key => $value) : ?>
                                <tr>
                                    <td><?php echo $value[0] ?></td>
                                    <td><?php echo $value[1] ?></td>
                                    <td style="text-align: center;">
                                        <a href="../../registros/validarArticulos.php?id=<?php echo $value[0] ?>&&eliminar=1" data-toggle="tooltip" title="Eliminar"><?php echo $btnEliminar ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarSubmit() {
        var btnSubmit = document.getElementById("btnSubmitArticulos");
        var nombreArticulos = document.getElementById("nombreArticulos");

        if (nombreArticulos.value.length >= 1) {
            btnSubmit.style.display = 'inline';
        } else {
            btnSubmit.style.display = 'none';
        }
    }
</script>
<?php require_once('../../estructura/footer.php') ?>