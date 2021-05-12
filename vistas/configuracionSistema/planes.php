<?php $menuConfigAdmin = 'configAdmin'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}

$sql = "SELECT idPlanes FROM planes WHERE marcadoPlanes = '1'";
$ejecutar = mysqli_query($conexion, $sql);
$idPlan = mysqli_fetch_row($ejecutar);
?>

<p class="titulos">Planes Página Web</p>
<div class="container-menu">
    <ul class="nav nav-pills justify-content-end" id="pills-tab" role="tablist">
        <li class="nav-item" style="margin-top: 5pt; margin-right: 5pt; ">
            <strong> Plan Gratuito: </strong>
        </li>
        <li class="nav-item align-middle">
            <?php echo @cargarSelect($conexion, "SELECT idPlanes, nombrePlanes FROM planes", "tipoVehiculos", "class='form-control' id='planGratuito'", $idPlan[0]) ?>
        </li>
        <li class="nav-item" role="presentation">
            <a href="consultarPlanes.php" class="nav-link btn-primary btn btn-sm"><?php echo $btnVerRegistros ?>Ver Planes</a>
        </li>
    </ul>
    <form action="" class="row g-3 forms" method="POST" enctype="multipart/form-data">
        <?php include_once('../../registros/validarPlanes.php') ?>
        <div id="respuestaMarcado" style="display: none;"></div>
        <div class="row">
            <div class="col-12">
                <label for="nombrePlanes" class="form-label">Título *</label>
                <input type="text" class="form-control" name="nombrePlanes" maxlength="15" id="nombrePlanes" value="<?php echo isset($_POST['submit']) ? $_POST['nombrePlanes'] : '' ?>">
                <input type="hidden" value="0" name="update">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="direccionEmpresas" class="form-label">Valor *</label>
                <input type="text" class="form-control" name="precioPlanes" maxlength="11" id="" value="<?php echo isset($_POST['submit']) ? $_POST['precioPlanes'] : '' ?>">
            </div>
            <div class="col-6">
                <label for="direccionEmpresas" class="form-label">Imagen *</label>
                <input type="file" class="form-control" name="imgPlanes" id="" multiple>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="cantidadParqueosHoras" class="form-label" id="labelContraUsuario">Cantidad Horas
                    <span type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Cantidad de registros para los parqueos por horas para las empresas gratuitas">
                        <?php echo $btnAyuda ?>
                    </span>*
                </label>
                <input type="text" class="form-control" name="cantidadParqueosHoras" id="cantidadParqueosHoras" onkeyup="format(this)" onchange="format(this)" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['cantidadParqueosHoras'] : '' ?>">
            </div>
            <div class="col-4">
                <label for="cantidadParqueosMeses" class="form-label" id="labelContraUsuario">Cantidad Meses <span type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Cantidad de registros para los parqueos por mes para las empresas gratuitas">
                        <?php echo $btnAyuda ?>
                    </span>*
                </label>
                <input type="text" class="form-control" name="cantidadParqueosMeses" id="cantidadParqueosMeses" onkeyup="format(this)" onchange="format(this)" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['cantidadParqueosMeses'] : '' ?>">
            </div>
            <div class="col-4">
                <label for="cantidadArticulos" class="form-label" id="cantidadArticulos">Cantidad Artículos <span type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Cantidad de registros para los artículos para las empresas gratuitas">
                        <?php echo $btnAyuda ?>
                    </span>*
                </label>
                <input type="text" class="form-control" name="cantidadArticulos" id="cantidadArticulos" onkeyup="format(this)" onchange="format(this)" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['cantidadArticulos'] : '' ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="descripcionPlanes" class="form-label">Descripción *</label>
                <textarea name="descripcionPlanes" class="content"><?php echo isset($_POST['submit']) ? $_POST['descripcionPlanes'] : '' ?></textarea>

            </div>
        </div>
        <div style="align-items: center; text-align: center;">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Guardar Configuración</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
            <span class="visually-hidden">Loading...</span>
        </div>
    </form>
</div>

<script>
    //Enviamos el vehìculo que será marcado como motocicleta para las validaciones integrity
    $("#planGratuito").change(function() {
        console.log($("#planGratuito").val());
        $.ajax({
            type: "POST",
            url: "../../ajax/datosMarcarPlanes.php",
            data: "id=" + $("#planGratuito").val(),
            success: function(data) {
                $("#respuestaMarcado").show();
                $("#respuestaMarcado").html(data);
            },
            error: function() {
                console.log("ERROR");
            }
        });
    })
</script>
<?php require_once('../../estructura/footer.php') ?>