<?php $update = '1' ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorSistema && $_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
//Consultamos el id que le corresponde al rol a registrar
$consulta =     "SELECT
                    empresas.nitEmpresas,
                    empresas.nombreEmpresas,
                    empresas.telefonoCelularEmpresa,
                    empresas.telefonoFijoEmpresas,
                    empresas.direccionEmpresas,
                    empresas.paisEmpresas,
                    empresas.departamentoEmpresas,
                    empresas.municipioEmpresas,
                    empresas.telefonoCelular2Empresas,
                    imagen.rutaImagen,
                    empresas.idImagen
                FROM
                    empresas
                LEFT JOIN departamentos ON departamentos.idDepartamentos = empresas.departamentoEmpresas
                LEFT JOIN municipios ON municipios.idMunicipios = empresas.municipioEmpresas
                LEFT JOIN imagen ON imagen.idImagen = empresas.idImagen
                WHERE
                    nitEmpresas = '$_SESSION[nitEmpresas]'";
$resultadoConsulta = mysqli_query($conexion, $consulta) or die("no se ejecutó");
$datos = mysqli_fetch_assoc($resultadoConsulta);

?>

<p class="titulos">Mi empresa</p>
<div class="container-menu">
    <form class="" method="POST" action="" enctype="multipart/form-data">
        <?php include_once('../../registros/validarEmpresas.php') ?>
        <div class="row">
            <div class="col-4">
                <label for="nitEmpresas" class="form-label">Nit *</label>
                <input type="text" class="form-control" readonly name="nitEmpresas" id="nitEmpresas" value="<?php echo isset($_POST['sumbit']) ? $_POST['nitEmpresas'] : $datos['nitEmpresas'] ?>" maxlength="20">
            </div>
            <div class="col-8">
                <label for="nombreEmpresas" class="form-label">Nombre Empresa *</label>
                <input type="text" class="form-control" name="nombreEmpresas" maxlength="80" id="nombreEmpresas" value="<?php echo isset($_POST['sumbit']) ? $_POST['nombreEmpresas'] : $datos['nombreEmpresas'] ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="direccionEmpresas" class="form-label">País *</label>
                <?php cargarSelect($conexion, "SELECT id, nombre FROM paises ORDER BY nombre", "paisEmpresas", "class='form-control' id='paisEmpresas' onclick='valorNa()'", isset($_POST['submit']) ? $_POST['paisEmpresas'] : $datos['paisEmpresas']); ?>
            </div>
            <div class="col-4">
                <label for="direccionEmpresas" class="form-label">Departamento *</label>
                <?php cargarSelect($conexion, "SELECT idDepartamentos, nombreDepartamentos FROM departamentos ORDER BY nombreDepartamentos", "departamentoEmpresas", "class='form-control' id='departamentoEmpresas' onchange='cargarMunicipio();'", isset($_POST['submit']) ? $_POST['departamentoEmpresas'] : $datos['departamentoEmpresas']); ?>
            </div>
            <div class="col-4">
                <label for="direccionEmpresas" class="form-label">Municipio *</label>
                <?php cargarSelect($conexion, "SELECT idMunicipios, nombreMunicipios FROM municipios ORDER BY nombreMunicipios", 'municipioEmpresas', "class='form-control' id='municipioEmpresas'", isset($_POST['submit']) ? $_POST['municipioEmpresas'] : $datos['municipioEmpresas']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="direccionEmpresas" class="form-label">Dirección *</label>
                <input type="text" class="form-control" name="direccionEmpresas" maxlength="50" id="direccionEmpresas" value="<?php echo isset($_POST['sumbit']) ? $_POST['direccionEmpresas'] : $datos['direccionEmpresas'] ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <label for="telefonoFijoEmpresas" class="form-label">Telefóno Fijo</label>
                <input type="text" class="form-control" name="telefonoFijoEmpresas" maxlength="10" value="<?php echo isset($_POST['sumbit']) ? $_POST['telefonoFijoEmpresas'] : $datos['telefonoFijoEmpresas'] ?>">
            </div>
            <div class="col-3">
                <label for="telefonoCelularEmpresas" class="form-label">Celular 1 *</label>
                <input type="text" class="form-control" name="telefonoCelularEmpresas" maxlength="10" value="<?php echo isset($_POST['sumbit']) ? $_POST['telefonoCelularEmpresas'] : $datos['telefonoCelularEmpresa'] ?>">
            </div>
            <div class="col-3">
                <label for="telefonoCelular2Empresas" class="form-label">Celular 2</label>
                <input type="text" class="form-control" name="telefonoCelular2Empresas" maxlength="10" value="<?php echo isset($_POST['sumbit']) ? $_POST['telefonoCelular2Empresas'] : $datos['telefonoCelular2Empresas']  ?>">
            </div>
            <div class="col-3">
                <label class="form-label" <?php echo empty($datos['rutaImagen']) ? 'for="idImagen"' : 'data-bs-toggle="tooltip" title="Da click aquí para ver tu imagen"' ?>><a type="button" <?php echo empty($datos['rutaImagen']) ? '' : 'data-bs-toggle="modal" data-bs-target="#img"' ?>>Imagen <?php echo empty($datos['rutaImagen']) ? '' : $btnVer ?></a></label>
                <input type="file" class="form-control" name="idImagen" id="idImagen" <?php echo $_SESSION['nitEmpresas'] == $nitParkingSoft ? 'disabled' : '' ?>>
                <input type="hidden" name="idImagenEdi" value="<?php echo empty($datos['idImagen']) ? '0' : $datos['idImagen'] ?>">
                <input type="hidden" name="rutaImagenEdi" value="<?php echo empty($datos['rutaImagen']) ? '' : $datos['rutaImagen'] ?>">
            </div>
        </div>
        <div class="btnSubmit">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
            <span class="visually-hidden">Loading...</span>
        </div>
    </form>
</div>

<div class="modal fade" id="img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Imagen Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <img style="width: 300px; height: 250px; border-radius: 5pt" src="<?php echo "../../" . $datos['rutaImagen'] ?>" alt="&nbsp; No se encuentra una imagen disponible">
            </div>
            <div class="modal-footer">
                <button type="button" cla ss="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
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