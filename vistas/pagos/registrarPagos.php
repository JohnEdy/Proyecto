<?php $menuPagos = 'pagos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>

<p class="titulos">Registrar Pagos</p>

<div class="container-menu">
    <?php include_once('../../registros/validarPagos.php') ?>
    <form class="" method="POST" action="">
        <div class="row">
            <div class="col">
                <label for="documentoUsuarios" class="form-label">Empresa *</label>
                <?php cargarSelect($conexion, "SELECT nitEmpresas, nombreEmpresas FROM empresas WHERE NOT nitEmpresas = '$nitParkingSoft' ORDER BY nombreEmpresas", "nitEmpresas", "class='form-control' id='nitEmpresas' onclick='mostrarSubmit();'") ?>
            </div>
        </div>
        <div class="row" id="seccionPagos" style="display: none;">
            <div class="col-4">
                <label for="documentoUsuarios" class="form-label">Mes a Pagar *</label>
                <?php cargarSelect($conexion, $idMeses, 'idMeses', 'class="form-control"') ?>
            </div>
            <div class="col-4">
                <label for="documentoUsuarios" class="form-label">Plan a Pagar *</label>
                <?php cargarSelect($conexion, "SELECT idPlanes, nombrePlanes FROM planes WHERE NOT idPlanes = '1'", 'idPlanes', 'class="form-control"') ?>
            </div>
            <div class="col-4">
                <label for="documentoUsuarios" class="form-label">¿Generar Fáctura?</label>
                <div class="row" style="margin-left: 10pt;">
                    <div class="col">
                        <input class="form-check-input" type="radio" id="noMeses" name="factura" value="0" checked><label class="form-check-label" for="noMeses">&nbsp;No</label>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="radio" id="siMeses" name="factura" value="1"><label class="form-check-label" for="siMeses">&nbsp;Si</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="btnSubmit" id="btnSubmit">
            <button type="submit" name="submit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
            <span class="visually-hidden">Loading...</span>
        </div>
    </form>
</div>

<script>
    var nitEmpresas = document.getElementById("nitEmpresas");
    var btnSubmit = document.getElementById("btnSubmit");
    var seccionPagos = document.getElementById("seccionPagos");

    mostrarSubmit();

    function mostrarSubmit() {
        if (nitEmpresas.value != 0) {
            btnSubmit.style.display = 'block';
            seccionPagos.style.display = 'flex';
        } else {
            btnSubmit.style.display = 'none';
            seccionPagos.style.display = 'none';
        }
    }
</script>




<?php require_once('../../estructura/footer.php') ?>