<?php if (@$_SESSION['idRoles'] == @$idAdministradorEmpresas) {
    @$menuAdministradores = 'administradores';
} else {
    @$menuClientes = 'clientes';
} ?>
<?php $update = '0' ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>

<?php
//Consultamos el id que le corresponde al rol a registrar
$consulta = "SELECT idRoles FROM roles ORDER BY idRoles DESC";
$resultadoConsulta = mysqli_query($conexion, $consulta) or die("no se ejecutó");
$id = mysqli_fetch_array($resultadoConsulta);
?>

<p class="titulos">Registrar Usuarios</p>
<div class="container-menu">
    <form class="" method="POST" action="">
        <?php include_once('../../registros/validarClientes.php') ?>
        <div class="row">
            <div class="col-4">
                <label for="documentoUsuarios" class="form-label">Documento *</label>
                <input type="text" class="form-control" name="documentoUsuarios" id="documentoUsuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                    echo $_POST['documentoUsuarios'];
                                                                                                                } else {
                                                                                                                    echo @$_GET['documento'];
                                                                                                                } ?>" maxlength="15" minlength="5">
                <p class="errorDocumento" id="error" style="display: none;">Lo sentimos, para generar la contraseña, debe introducir el documento.</p>
            </div>
            <div class="col-4">
                <label for="fechaNacimientoUsuarios" class="form-label">Fecha de Nacimiento *<i class="bi bi-asterisk"></i></label>
                <input type="text" id="datepicker" class="form-control" name="fechaNacimientoUsuarios" maxlength="20" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                    echo $_POST['fechaNacimientoUsuarios'];
                                                                                                                                } ?>" autocomplete="off">
            </div>
            <div class="col-4">
                <label for="emailUsuarios" class="form-label">Correo Electrónico *<i class="bi bi-asterisk"></i></label>
                <input type="text" class="form-control" name="emailUsuarios" maxlength="80" value="<?php if (isset($_POST['submit'])) {
                                                                                                        echo $_POST['emailUsuarios'];
                                                                                                    } else {
                                                                                                        echo "@gmail.com";
                                                                                                    } ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <label for="nombre1Usuarios" class="form-label">Primer Nombre *</label>
                <input type="text" class="form-control" name="nombre1Usuarios" maxlength="20" id="nombre1Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['nombre1Usuarios'];
                                                                                                                            } ?>">
            </div>
            <div class="col-3">
                <label for="nombre2Usuarios" class="form-label">Segundo Nombre</label>
                <input type="text" class="form-control" name="nombre2Usuarios" maxlength="20" id="nombre2Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['nombre2Usuarios'];
                                                                                                                            } ?>">
            </div>
            <div class="col-3">
                <label for="apellido1Usuarios" class="form-label">Primer Apellido *<i class="bi bi-asterisk"></i></label>
                <input type="text" class="form-control" name="apellido1Usuarios" maxlength="20" id="apellido1Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                    echo $_POST['apellido1Usuarios'];
                                                                                                                                } ?>">
            </div>
            <div class="col-3">
                <label for="apellido2Usuarios" class="form-label">Segundo Apellido<i class="bi bi-asterisk"></i></label>
                <input type="text" class="form-control" name="apellido2Usuarios" maxlength="20" id="apellido2Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                    echo $_POST['apellido2Usuarios'];
                                                                                                                                } ?>">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="fijoUsuarios" class="form-label">Telefóno Fijo</label>
                <input type="text" class="form-control" name="fijoUsuarios" maxlength="10" id="fijoUsuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                        echo $_POST['fijoUsuarios'];
                                                                                                                    } ?>">
            </div>
            <div class="col">
                <label for="celular1Usuarios" class="form-label">Celular 1 *</label>
                <input type="text" class="form-control" name="celular1Usuarios" maxlength="10" id="celular1Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['celular1Usuarios'];
                                                                                                                            } ?>">
            </div>
            <div class="col">
                <label for="celular2Usuarios" class="form-label">Celular 2</label>
                <input type="text" class="form-control" name="celular2Usuarios" maxlength="10" id="celular2Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['celular2Usuarios'];
                                                                                                                            } ?>">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="direccionUsuarios" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccionUsuarios" id="direccionUsuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                    echo $_POST['direccionUsuarios'];
                                                                                                                } ?>">
            </div>
        </div>
        <div class="row">
            <?php
            if ($_SESSION['idRoles'] == $idAdministradorSistema) :
                $consultaRoles = "SELECT idRoles, nombreRoles FROM roles";
            elseif ($_SESSION['idRoles'] == $idAdministradorEmpresas) :
                $consultaRoles = "SELECT idRoles, nombreRoles FROM roles WHERE NOT idRoles = '1'";
            else :
                $consultaRoles = "SELECT idRoles, nombreRoles FROM roles WHERE NOT idRoles = '1' AND NOT idRoles = '2' AND NOT idRoles = '3' ";
            endif;
            ?>
            <div class="col-6">
                <label class="form-label" for="nombreRoles">Rol *</label>
                <?php cargarSelect($conexion, $consultaRoles, "idRoles", "class='form-control' id='nombreRoles'") ?>
            </div>
            <div class="col-6">
                <?php if ($_SESSION['idRoles'] == $idAdministradorSistema) : ?>
                    <label class="form-label" for="nitEmpresas">Empresa *</label>
                    <?php cargarSelect($conexion, "SELECT nitEmpresas, nombreEmpresas FROM empresas ORDER BY nombreEmpresas", "nitEmpresas", "class='form-control' id='nitEmpresas'") ?>
                    <input type="text" disabled id="nitEmpresasText" name="nitEmpresas">
                <?php else : ?>
                    <label class="form-label" for="nitEmpresas">Empresa *</label>
                    <?php cargarSelect($conexion,  "SELECT nitEmpresas, nombreEmpresas FROM empresas WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreEmpresas", "nitEmpresas", "class='form-control' id='nitEmpresas'") ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-4">
                <label for="apellido2Usuarios" class="form-label">Contraseña</label>
                <a type="button" onclick="generarContraseñaUsuarios()" class="btn btn-info btm-sm form-control disable" tabindex="-1" role="button" aria-disabled="true" style="background-color: #146ca4; border: #146ca4; color: white;">Generar Contraseña</a>
            </div>
            <div class="col-4">
                <label for="contraUsuario" class="form-label" id="labelContraUsuario" style="display: none;">Resultado:</label>
                <input type="text" style="display: none;" maxlength="4" class="form-control" name="passDefectoUsuarios" id="contraUsuario">
            </div>
            <div class="col-2">
            </div>
        </div>
        <div class="btnSubmit">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
            <span class="visually-hidden">Loading...</span>
        </div>
    </form>
</div>

<script>
    $("#nombreRoles").change(function () {
        console.log($("#nombreRoles").val())
        if ($("#nombreRoles").val() == 1) {
            $("#nitEmpresas option[value='150.245.212-2']").attr("selected", true);
            $("#nitEmpresas").prop("disabled", true);
            $("#nitEmpresas").css("cursor", "not-allowed");

            $("#nitEmpresasText").val($("#nitEmpresas").val());
            $("#nitEmpresasText").prop("disabled", false);

        } else {
            $("#nitEmpresas option[value='']").attr("selected", true);
            $("#nitEmpresas").prop("disabled", false);
            $("#nitEmpresas").css("cursor", "default");
            $("#nitEmpresasText").prop("disabled", true);
        }
    });
</script>
<?php require_once('../../estructura/footer.php') ?>