<?php $menuConfigAdmin = 'configAdmin'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

$updateTestimonios = 0;
$sql        = "SELECT COUNT(*) FROM testimonios WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutar   = mysqli_query($conexion, $sql);
$fetchSql   = mysqli_fetch_row($ejecutar);

if ($fetchSql[0] >= 1) {
    $updateTestimonios = 1;

    //Buscamos los valores para mostrar en los campos
    $sqlDatos = "SELECT cargoTestimonios, descripcionTestimonios, imagen.rutaImagen, testimonios.idImagen FROM testimonios INNER JOIN imagen ON imagen.idImagen = testimonios.idImagen WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
    $ejecutar   = mysqli_query($conexion, $sqlDatos);
    $fetchDatos = mysqli_fetch_row($ejecutar);

} else {
    $updateTestimonios = 0;
}
?>
<p class="titulos">Mi Testimonio</p>
<div class="container-menu">
    <form action="" class="row g-3 forms" method="POST" enctype="multipart/form-data">
        <?php include_once('../../registros/validarTestimonios.php') ?>
        <div class="row">
            <div class="col-6">
                <label for="direccionEmpresas" class="form-label">Cargo *</label>
                <input type="text" class="form-control" name="cargoTestimonios" maxlength="50" id="" value="<?php echo isset($_POST['submit']) ? $_POST['cargoTestimonios'] : @$fetchDatos[0] ?>">
            </div>
            <div class="col-6">
                <?php if (!empty($fetchDatos[2]) && $updateTestimonios == 1) { ?>
                    <label for="direccionEmpresas" class="form-label" title="Da click aquí para ver tu imagen" data-bs-toggle="tooltip"><a type="button" data-bs-toggle="modal" data-bs-target="#img">Imagen <?php echo $btnVer ?></a></label>
                    <input type="file" class="form-control" name="imgTestimonios" id="" multiple>
                    <input type="hidden" name="idImagenEdi" value="<?php echo $fetchDatos[3] ?>">
                    <input type="hidden" name="rutaImagenId" value="<?php echo $fetchDatos[2] ?>">
                <?php } else { ?>
                    <label for="direccionEmpresas" class="form-label">Imagen *</label>
                    <input type="file" class="form-control" name="imgTestimonios" id="" multiple>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="descripcionTestimonios" class="form-label">Descripción *</label>
                <textarea name="descripcionTestimonios" class="content"><?php echo isset($_POST['submit']) ? $_POST['descripcionTestimonios'] : @$fetchDatos[1] ?></textarea>
            </div>
        </div>
        <div style="align-items: center; text-align: center;">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Guardar Configuración</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
            <span class="visually-hidden">Loading...</span>
        </div>
    </form>
</div>

<div class="modal fade" id="img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Imagen Testimonio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <img style="width: 300px; height: 250px; border-radius: 5pt" src="../../<?php echo $fetchDatos[2] ?>" alt="&nbsp; No se encuentra una imagen disponible">
            </div>
            <div class="modal-footer">
                <button type="button" cla ss="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<?php require_once('../../estructura/footer.php') ?>