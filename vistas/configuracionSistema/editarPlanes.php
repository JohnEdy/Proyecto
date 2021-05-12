<?php $menuConfigAdmin = 'configAdmin'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}

//Validamos que si se esta recibiendo un valor get para mostrar los datos
if (!isset($_GET['id'])) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}

$sql =  "SELECT
            nombrePlanes,
            precioPlanes,
            descripcionPlanes,
            planes.idImagen,
            imagen.rutaImagen,
            planes.cantidadParqueosHoras,
            planes.cantidadParqueosMeses,
            planes.cantidadArticulos
        FROM
            planes
            INNER JOIN imagen ON imagen.idImagen = planes.idImagen
        WHERE
            idPlanes = '$_GET[id]'";
$ejecutar   = mysqli_query($conexion, $sql);
$rows       = mysqli_fetch_assoc($ejecutar);

?>

<p class="titulos">Editar Plan</p>
<div class="container-menu">
    <ul class="nav nav-pills left-content-end" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="consultarPlanes.php" class="nav-link btn-primary btn btn-sm"><?php echo $btnAnterior ?>Volver a Consultar</a>
        </li>
    </ul>
    <form action="" class="row g-3 forms" method="POST" enctype="multipart/form-data">
        <?php include_once('../../registros/validarPlanes.php') ?>
        <div class="row">
            <div class="col-12">
                <label for="nombrePlanes" class="form-label">Título *</label>
                <input type="text" class="form-control" name="nombrePlanes" maxlength="15" id="nombrePlanes" value="<?php echo isset($_POST['submit']) ? $_POST['nombrePlanes'] : $rows['nombrePlanes'] ?>">
                <input type="hidden" value="1" name="update">
                <input type="hidden" value="<?php echo $_GET['id'] ?>" name="idPlanes">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="direccionEmpresas" class="form-label">Valor *</label>
                <input type="text" class="form-control" name="precioPlanes" maxlength="11" id="" value="<?php echo isset($_POST['submit']) ? $_POST['precioPlanes'] : $rows['precioPlanes'] ?>">
            </div>
            <div class="col-6">
                <label for="direccionEmpresas" class="form-label" title="Da click aquí para ver tu imagen" data-bs-toggle="tooltip"><a type="button" data-bs-toggle="modal" data-bs-target="#img">Imagen <?php echo $btnVer ?></a></label>
                <input type="file" class="form-control" name="imgPlanes" id="" multiple>
                <input type="hidden" name="idImagenEdi" value="<?php echo $rows['idImagen'] ?>">
                <input type="hidden" name="rutaImagenId" value="<?php echo $rows['rutaImagen'] ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="cantidadParqueosHoras" class="form-label" id="labelContraUsuario">Cantidad Horas
                    <span type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Cantidad de registros para los parqueos por horas para las empresas gratuitas">
                        <?php echo $btnAyuda ?>
                    </span>*
                </label>
                <input type="text" class="form-control" name="cantidadParqueosHoras" id="cantidadParqueosHoras" onkeyup="format(this)" onchange="format(this)" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['cantidadParqueosHoras'] : $rows['cantidadParqueosHoras'] ?>">
            </div>
            <div class="col-4">
                <label for="cantidadParqueosMeses" class="form-label" id="labelContraUsuario">Cantidad Meses <span type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Cantidad de registros para los parqueos por mes para las empresas gratuitas">
                        <?php echo $btnAyuda ?>
                    </span>*
                </label>
                <input type="text" class="form-control" name="cantidadParqueosMeses" id="cantidadParqueosMeses" onkeyup="format(this)" onchange="format(this)" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['cantidadParqueosMeses'] : $rows['cantidadParqueosMeses'] ?>">
            </div>
            <div class="col-4">
                <label for="cantidadArticulos" class="form-label" id="cantidadArticulos">Cantidad Artículos <span type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Cantidad de registros para los artículos para las empresas gratuitas">
                        <?php echo $btnAyuda ?>
                    </span>*
                </label>
                <input type="text" class="form-control" name="cantidadArticulos" id="cantidadArticulos" onkeyup="format(this)" onchange="format(this)" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['cantidadArticulos'] : $rows['cantidadArticulos'] ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <label for="descripcionPlanes" class="form-label">Descripción *</label>
                <textarea name="descripcionPlanes" class="content"><?php echo isset($_POST['submit']) ? $_POST['descripcionPlanes'] : $rows['descripcionPlanes'] ?></textarea>
            </div>
        </div>
        <div style="align-items: center; text-align: center;">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnEditar ?>Editar Plan</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
            <span class="visually-hidden">Loading...</span>
        </div>
    </form>
</div>

<div class="modal fade" id="img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Imagen Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <img style="width: 300px; height: 250px; border-radius: 5pt" src="../../<?php echo $rows['rutaImagen'] ?>" alt="&nbsp; No se encuentra una imagen disponible">
            </div>
            <div class="modal-footer">
                <button type="button" cla ss="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<?php require_once('../../estructura/footer.php') ?>