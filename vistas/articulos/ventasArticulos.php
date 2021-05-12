<?php $menuArtículos = 'articulos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
$consultaArticulos = "SELECT articulos.idArticulos, articulos.nombreArticulos FROM articulos WHERE articulos.nitEmpresas = '$_SESSION[nitEmpresas]' AND NOT articulos.cantidadArticulos <= '0' ORDER BY articulos.nombreArticulos";
$ejecutarArticulos = mysqli_query($conexion, $consultaArticulos);
$articulos = mysqli_fetch_all($ejecutarArticulos);

$consultaUsuarios = "SELECT documentoUsuarios, CASE WHEN ISNULL(nombre1Usuarios) THEN documentoUsuarios ELSE nombre1Usuarios END, nombre2Usuarios FROM usuarios WHERE nitEmpresas = '$_SESSION[nitEmpresas]' AND idRoles='4' ";

$idFactura = "SELECT CASE WHEN ISNULL(idCabecera) THEN '1' ELSE MAX(idCabecera) + 1 END FROM cabeceraVentas ";
$ejecutar = mysqli_query($conexion, $idFactura);
$id = mysqli_fetch_row($ejecutar);
?>

<p class="titulos">Venta de Artículos</p>

<div class="container-menu">
    <ul class="nav nav-pills justify-content-end" id="pills-tab" role="tablist" style="margin-bottom: 10pt;">
        <li class="nav-item" role="presentation">
            <button type="button" class="agregar btn btn-primary"><?php echo $btnMas ?>Agregar Producto</button>
        </li>
    </ul>
    <?php require_once('../../registros/validarVentasArticulos.php') ?>
    <form action="" method="POST">
        <div class="row">
            <div class="col-1">
                <label for="idCabecera" class="form-label">Nº Venta</label>
                <input type="text" class="form-control" name="idCabecera" maxlength="40" id="nombreArticulos" autocomplete="off" readonly value="<?php echo $id[0] ?>">
            </div>
            <div class="col-6">
                <label for="documentoUsuarios" class="form-label">Cliente</label>
                <?php echo cargarSelect($conexion, $consultaUsuarios, 'documentoUsuarios', 'class="form-control" id="documentoUsuarios"') ?>

            </div>
            <div class="col-5">
                <label for="idParqueos" class="form-label">Fecha Venta</label>
                <input type="text" class="form-control" name="fechaRegistros" maxlength="40" value="<?php echo isset($_POST['submit']) ? $_POST['fechaRegistros'] : $fechaRegistros ?>" id="nombreArticulos" autocomplete="off" readonly>
            </div>
        </div>
        <div class="table-responsive" style="margin-top: 20pt;">
            <span>ARTÍCULOS:</span>
            <table class="table table-hover table-sm table-light">
                <thead class="table-dark">
                    <th style="width: 50%">Producto</th>
                    <th style="width: 50%">Cantidad</th>
                </thead>

                <tbody class="ventas">
                    <tr>
                        <td><?php echo cargarSelect($conexion, $consultaArticulos, "idArticulos[]", "class='form-control'") ?></td>
                        <td><input type="text" name="cantidadArticulos[]" class='form-control' value="1"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="btnSubmit">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </form>
</div>

<?php require_once('../../estructura/footer.php') ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    var i = 1;

    $(document).ready(function() {

        var maxField = 15; //Input fields increment limitation
        var addButton = $('.agregar'); //Add button selector
        var wrapper = $('.ventas'); //Input field wrapper
        var x = 1; //Initial field counter is 1
        var fieldHTML = '<tr><td><select class="form-control" name="idArticulos[]"><option>--Seleccione--</option><?php foreach ($articulos as $value) : echo "<option value=" . $value[0] . ">$value[1]</option>";
                                                                                                                    endforeach; ?></select></td><td><input type="text" name="cantidadArticulos[]" class="form-control" value="1"></td></tr>'; //New input field html

        $(addButton).click(function() { //Once add button is clicked
            if (x < maxField) { //Check maximum number of input fields
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); // Add field html
            }
        });

    });
</script>