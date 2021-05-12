<?php $menuInicio = 'inicio'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
$consulta   = "SELECT nombreEmpresas FROM empresas WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutar   = mysqli_query($conexion, $consulta);
$fetch      = mysqli_fetch_row($ejecutar);

$tipoVehiculoss = $tipoVehiculos;
?>
<p class="titulos">Información Cliente</p>
<div class="container-menu">
    <?php include_once('../../registros/validarUsuariosTodos.php') ?>
    <form action="" method="POST">
        <div class="row">
            <div class="col">
                <label for="" class="form-label">Documento *</label>
                <input type="text" name="documentoUsuarios" class="form-control" id="documentoClientes" maxlength="15" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                    echo $_POST['documentoUsuarios'];
                                                                                                                                } ?>">
                <input type="hidden" name="placaVehiculos" value='<?php echo $_GET['placa'] ?>'>
            </div>
            <div class="col">
                <label for="" class="form-label">Celular *</label>
                <input type="text" name="celular1Usuarios" class="form-control" id="celular1Usuarios" maxlength="10" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['celular1Usuarios'];
                                                                                                                            } ?>">
            </div>
            <div class="col">
                <label for="nombreRoles" class="form-label">Tipo Vehículo *</label>
                <?php cargarSelect($conexion, $tipoVehiculoss, 'tipoVehiculos', 'class="form-control"') ?>
            </div>
            <div class="btnSubmit">
                <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
                <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function cerrar() {
        window.open("cerrar_window2.html", "miventana", "width=300,height=200,menubar=yes");
    }
</script>

<?php require_once('../../estructura/footer.php') ?>