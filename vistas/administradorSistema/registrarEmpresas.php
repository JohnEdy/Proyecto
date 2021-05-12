<?php $menuAdministradores = 'administradores'; ?>
<?php $update = '0' ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
//Consultamos el id que le corresponde al rol a registrar
$consulta = "SELECT idRoles FROM roles ORDER BY idRoles DESC";
$resultadoConsulta = mysqli_query($conexion, $consulta) or die("no se ejecutó");
$id = mysqli_fetch_array($resultadoConsulta);
?>

<p class="titulos">Registrar empresas</p>
<div class="container-menu">
    <form class="" method="POST" action="">
        <?php include_once('../../registros/validarEmpresas.php') ?>
        <div class="row">
            <div class="col-4">
                <label for="nitEmpresas" class="form-label">Nit *</label>
                <input type="text" class="form-control" name="nitEmpresas" id="nitEmpresas" value="<?php if (isset($_POST['submit'])) {
                                                                                                        echo $_POST['nitEmpresas'];
                                                                                                    } ?>" maxlength="20">
            </div>
            <div class="col-8">
                <label for="nombreEmpresas" class="form-label">Nombre Empresa *</label>
                <input type="text" class="form-control" name="nombreEmpresas" maxlength="80" id="nombreEmpresas" value="<?php if (isset($_POST['submit'])) {
                                                                                                                            echo $_POST['nombreEmpresas'];
                                                                                                                        } ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="direccionEmpresas" class="form-label">País *</label>
                <?php cargarSelect($conexion, "SELECT id, nombre FROM paises ORDER BY nombre", "paisEmpresas", "class='form-control' id='paisEmpresas' onclick='valorNa()'"); ?>
            </div>
            <div class="col-4">
                <label for="direccionEmpresas" class="form-label">Departamento *</label>
                <?php cargarSelect($conexion, "SELECT idDepartamentos, nombreDepartamentos FROM departamentos ORDER BY nombreDepartamentos", "departamentoEmpresas", "class='form-control' id='departamentoEmpresas' onchange='cargarMunicipio();'"); ?>
            </div>
            <div class="col-4">
                <label for="direccionEmpresas" class="form-label">Ciudad *</label>
                <?php cargarSelect($conexion, "SELECT idMunicipios, nombreMunicipios FROM municipios ORDER BY nombreMunicipios", 'municipioEmpresas', "class='form-control' id='municipioEmpresas'"); ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="direccionEmpresas" class="form-label">Dirección *</label>
                <input type="text" class="form-control" name="direccionEmpresas" maxlength="50" id="direccionEmpresas" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                    echo $_POST['direccionEmpresas'];
                                                                                                                                } ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="telefonoFijoEmpresas" class="form-label">Telefóno Fijo</label>
                <input type="text" class="form-control" name="telefonoFijoEmpresas" maxlength="10" value="<?php if (isset($_POST['submit'])) {
                                                                                                                echo $_POST['telefonoFijoEmpresas'];
                                                                                                            } ?>">
            </div>
            <div class="col-4">
                <label for="telefonoCelularEmpresas" class="form-label">Celular 1 *</label>
                <input type="text" class="form-control" name="telefonoCelularEmpresas" maxlength="10" value="<?php if (isset($_POST['submit'])) {
                                                                                                                    echo $_POST['telefonoCelularEmpresas'];
                                                                                                                } ?>">
            </div>
            <div class="col-4">
                <label for="telefonoCelular2Empresas" class="form-label">Celular 2</label>
                <input type="text" class="form-control" name="telefonoCelular2Empresas" maxlength="10" value="<?php if (isset($_POST['submit'])) {
                                                                                                                    echo $_POST['telefonoCelular2Empresas'];
                                                                                                                } ?>">
            </div>
        </div>
        <div class="btnSubmit">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
            <span class="visually-hidden">Loading...</span>
        </div>
    </form>
</div>

<script type="text/javascript">
    function valorNa() {
        var valueDep = document.getElementById("paisEmpresas").value;

        if (valueDep != "52") {
            document.getElementById("municipioEmpresas").value = 1103;
            document.getElementById("departamentoEmpresas").value = 33;
        } else {
            document.getElementById("municipioEmpresas").value = '';
            document.getElementById("departamentoEmpresas").value = '';
        }
    }

    function cargarMunicipio() {
        $.ajax({
            type: "POST",
            url: "../../ajax/datosCiudad.php",
            data: "departamento=" + $("#departamentoEmpresas").val(),
            success: function(ciudades) {
                $("#municipioEmpresas").html(ciudades);
            }
        })
    }
</script>

<?php require_once('../../estructura/footer.php') ?>