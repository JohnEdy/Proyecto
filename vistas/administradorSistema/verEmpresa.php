<?php
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
if (!isset($_GET['id'])) {
    echo "<script>window.location.href = 'consultarEmpresas.php';</script>";
}
?>
<?php $menuAdministradoresSis = 'administradoresSis'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
$id = $_GET['id'];

$consultaSql =  "SELECT
                        empresas.nitEmpresas,
                        empresas.nombreEmpresas,
                        empresas.telefonoCelularEmpresa,
                        empresas.estadoEmpresas,
                        empresas.gratisEmpresas,
                        CASE WHEN ISNULL(parametros.mesesParametros) 		THEN '-1' ELSE parametros.mesesParametros 		END AS 'mesesEmpresas',
                        CASE WHEN ISNULL(parametros.articulosParametros) 	THEN '-1' ELSE parametros.articulosParametros 	END AS 'articulosEmpresas',
                        CASE WHEN ISNULL(parametros.lavadaParametros) 		THEN '-1' ELSE parametros.lavadaParametros 		END AS 'lavadaEmpresas',
                        empresas.telefonoCelular2Empresas,
                        empresas.telefonoFijoEmpresas
                    FROM
                        empresas
                    LEFT JOIN parametros ON parametros.nitEmpresas = empresas.nitEmpresas
                    WHERE empresas.nitEmpresas = '$id'";

$ejecutarSql = mysqli_query($conexion, $consultaSql);
$fetchSql = mysqli_fetch_assoc($ejecutarSql);

//Para modificar los parametros de la empresa
$update = 3;
?>
<!-- Block level -->
<p class="titulos">Información Empresa</p>

<div class="container-menu">
    <?php include_once('../../registros/validarParametros.php'); ?>
    <div class="row">
        <div class="col-2">
            <p class="subtitulos">ID </p>
            <p class="informacion"><?php echo $fetchSql['nitEmpresas'] ?></p>
        </div>
        <div class="col-6">
            <p class="subtitulos">Nombre </p>
            <p class="informacion"><?php echo $fetchSql['nombreEmpresas'] ?></p>
        </div>
        <div class="col-2">
            <p class="subtitulos">Estado </p>
            <p class="informacion"><?php echo $estadoEmpresas[$fetchSql['estadoEmpresas']] ?></p>
        </div>
        <div class="col-2">
            <p class="subtitulos">Gratuito </p>
            <p class="informacion"><?php echo $siNo[$fetchSql['gratisEmpresas']] ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p class="subtitulos">Teléfono Fijo </p>
            <p class="informacion"><?php echo $fetchSql['telefonoFijoEmpresas'] ?></p>
        </div>
        <div class="col-4">
            <p class="subtitulos">Celular 1 </p>
            <p class="informacion"><?php echo $fetchSql['telefonoCelularEmpresa'] ?></p>
        </div>
        <div class="col-4">
            <p class="subtitulos">Celular 2 </p>
            <p class="informacion"><?php echo $fetchSql['telefonoCelular2Empresas'] ?></p>
        </div>
    </div>
    <p class="tituloSecciones">Permisos</p>
    <?php if ($fetchSql['lavadaEmpresas'] != -1 && $fetchSql['lavadaEmpresas'] != -1 && $fetchSql['articulosEmpresas'] != -1) { ?>

        <form action="" method="POST">
            <div class="row" style="margin-left: 5pt;">
                <div class="col-3">
                    <label for="valorHoraMotosParametros" class="form-label" id="labelContraUsuario">¿Parqueo Por Horas?</label>
                    <div class="row" style="margin-left: 5pt;">
                        <div class="col">
                            <input type="radio" class="form-check-input" id="flexRadioDisabled" disabled><label class="form-check-label" for="flexRadioDisabled" style="color: gray;">&nbsp;No</label>
                        </div>
                        <div class="col">
                            <input checked class="form-check-input" id="flexRadioDisabled" disabled type="radio"><label class="form-check-label" for="flexRadioDisabled" style="color: gray;">&nbsp;Si</label>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="valorHoraMotosParametros" class="form-label" id="labelContraUsuario">¿Parqueo Mensual?</label>
                    <div class="row" style="margin-left: 5pt;">
                        <div class="col">
                            <input class="form-check-input" type="radio" id="noMeses" name="mesesParametros" onclick="mesesParqueos()" value="0" <?php echo $fetchSql['mesesEmpresas'] == 0 ? 'checked' : '' ?>><label class="form-check-label" for="noMeses">&nbsp;No</label>
                        </div>
                        <div class="col">
                            <input class="form-check-input" type="radio" id="siMeses" name="mesesParametros" onclick="mesesParqueos()" value="1" <?php echo $fetchSql['mesesEmpresas'] == 1 ? 'checked' : '' ?>><label class="form-check-label" for="siMeses">&nbsp;Si</label>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="valorHoraMotosParametros" class="form-label">¿Lavada de Vehìculos?</label>
                    <div class="row" style="margin-left: 5pt;">
                        <div class="col">
                            <input class="form-check-input" type="radio" id="noLavada" name="lavadaParametros" onclick="lavadaVehiculos()" value="0" <?php echo $fetchSql['lavadaEmpresas'] == 0 ? 'checked' : '' ?>><label class="form-check-label" for="noLavada">&nbsp;No</label>
                        </div>
                        <div class="col">
                            <input class="form-check-input" type="radio" id="siLavada" name="lavadaParametros" onclick="lavadaVehiculos()" value="1" <?php echo $fetchSql['lavadaEmpresas'] == 1 ? 'checked' : '' ?>><label class="form-check-label" for="siLavada">&nbsp;Si</label>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="valorHoraMotosParametros" class="form-label">¿Venta De Artículos?</label>
                    <div class="row" style="margin-left: 5pt;">
                        <div class="col">
                            <input class="form-check-input" type="radio" id="noArticulos" name="articulosParametros" value="0" <?php echo $fetchSql['articulosEmpresas'] == 0 ? 'checked' : '' ?>><label class="form-check-label" for="noArticulos">&nbsp;No</label>
                        </div>
                        <div class="col">
                            <input class="form-check-input" type="radio" id="siArticulos" name="articulosParametros" value="1" <?php echo $fetchSql['articulosEmpresas'] == 1 ? 'checked' : '' ?>><label class="form-check-label" for="siArticulos">&nbsp;Si</label>
                            <input type="hidden" name="nitEmpresas" value="<?php echo $fetchSql['nitEmpresas'] ?>">

                        </div>
                    </div>
                </div>
            </div>
            <div class="btnSubmit">
                <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnEditar ?>Modificar</button>
                <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
                <span class="visually-hidden">Loading...</span>
            </div>
        </form>

    <?php } else { ?>
        <div class="alert alert-secondary">El usuario no ha ingresado sus parametros</div>
    <?php } ?>
</div>
<!-- Inline level -->
<?php require_once('../../estructura/footer.php') ?>