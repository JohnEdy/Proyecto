<?php $update = '1'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Volvemos un get para el paginador
if (!isset($_GET['i'])) {
    if (@$_GET['id'] != $_SESSION['documentoUsuarios']) {
        echo "<script>location.href='modificar.php?id=$_SESSION[documentoUsuarios]'</script>";
    }
}
?>
<?php
$consultaUsuario = "SELECT * FROM usuarios WHERE documentoUsuarios = '$_SESSION[documentoUsuarios]'";

$ejecutarConfig = mysqli_query($conexion, $consultaUsuario);
$fetchUsuarios = mysqli_fetch_array($ejecutarConfig);
?>

<p class='titulos'>Modificar Usuario</p>

<div class="container-menu">
    <form class="" method="POST" action="">
        <ul class="nav justify-content-end">
            <li class="nav-item align-middle">
                <a class="nav-link active btn btn-primary btn-sm" href="#" onclick="mostrarEditarPassword()"><?php echo $btnModifcarContraseña ?>Modificar Contraseña</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active btn btn-primary btn-sm" href="#" onclick="mostrarEditarFotoPerfil()"><?php echo $btnUsuarios ?>Editar Avatar</a>
            </li>
        </ul>
        <?php include_once('../../registros/validarClientes.php') ?>
        <div id="editarFoto" style="display: none;">
            <div class="row">
                <label for="" class="form-label">Modificar Foto de perfil</label>
                <?php
                $consulta = "SELECT idFotos, rutaFotos FROM fotos ORDER BY idFotos ASC";
                $ejecutar = mysqli_query($conexion, $consulta);
                $resultado = mysqli_fetch_all($ejecutar);

                foreach ($resultado as $key => $value) : ?>
                    <?php
                    if ($value[0] == $_SESSION['idPerfil']) {
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }
                    ?>
                    <div class="col">
                        <input style="cursor: pointer;" type="radio" <?php echo $checked ?> name="idFotos" id="idFoto-<?php echo $value[0] ?>" value="<?php echo $value[0] ?>" value="asdfasfsafd"> <label style="cursor: pointer;" for="idFoto-<?php echo $value[0] ?>"><img style="cursor: pointer;" src="<?php echo $value[1] ?>" alt=""></label>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <label for="documentoUsuarios" class="form-label">Documento *</label>
                <input readonly type="text" class="form-control" name="documentoUsuarios" id="documentoUsuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                            echo $_POST['documentoUsuarios'];
                                                                                                                        } else {
                                                                                                                            echo $fetchUsuarios['documentoUsuarios'];
                                                                                                                        } ?>" maxlength="15" minlength="5">
                <p class="errorDocumento" id="error" style="display: none;">Lo sentimos, para generar la contraseña, debe introducir el documento.</p>
            </div>
            <div class="col-4">
                <label for="fechaNacimientoUsuarios" class="form-label">Fecha de Nacimiento *<i class="bi bi-asterisk"></i></label>
                <input type="date" class="form-control" name="fechaNacimientoUsuarios" maxlength="20" value="<?php if (isset($_POST['submit'])) {
                                                                                                                    echo $_POST['fechaNacimientoUsuarios'];
                                                                                                                } else {
                                                                                                                    echo $fetchUsuarios['fechaNacimientoUsuarios'];
                                                                                                                } ?>">
            </div>
            <div class="col-4">
                <label for="emailUsuarios" class="form-label">Correo Electrónico *<i class="bi bi-asterisk"></i></label>
                <input type="text" class="form-control" name="emailUsuarios" maxlength="80" value="<?php if (isset($_POST['submit'])) {
                                                                                                        echo $_POST['emailUsuarios'];
                                                                                                    } else {
                                                                                                        echo $fetchUsuarios['emailUsuarios'];
                                                                                                    } ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <label for="nombre1Usuarios" class="form-label">Primer Nombre *</label>
                <input type="text" class="form-control" name="nombre1Usuarios" maxlength="20" id="nombre1Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['nombre1Usuarios'];
                                                                                                                            } else {
                                                                                                                                echo $fetchUsuarios['nombre1Usuarios'];
                                                                                                                            } ?>">
            </div>
            <div class="col-3">
                <label for="nombre2Usuarios" class="form-label">Segundo Nombre</label>
                <input type="text" class="form-control" name="nombre2Usuarios" maxlength="20" id="nombre2Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['nombre2Usuarios'];
                                                                                                                            } else {
                                                                                                                                echo $fetchUsuarios['nombre2Usuarios'];
                                                                                                                            } ?>">
            </div>
            <div class="col-3">
                <label for="apellido1Usuarios" class="form-label">Primer Apellido *<i class="bi bi-asterisk"></i></label>
                <input type="text" class="form-control" name="apellido1Usuarios" maxlength="20" id="apellido1Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                    echo $_POST['apellido1Usuarios'];
                                                                                                                                } else {
                                                                                                                                    echo $fetchUsuarios['apellido1Usuarios'];
                                                                                                                                } ?>">
            </div>
            <div class="col-3">
                <label for="apellido2Usuarios" class="form-label">Segundo Apellido<i class="bi bi-asterisk"></i></label>
                <input type="text" class="form-control" name="apellido2Usuarios" maxlength="20" id="apellido2Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                    echo $_POST['apellido2Usuarios'];
                                                                                                                                } else {
                                                                                                                                    echo $fetchUsuarios['apellido2Usuarios'];
                                                                                                                                } ?>">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="fijoUsuarios" class="form-label">Telefóno Fijo</label>
                <input type="text" class="form-control" name="fijoUsuarios" maxlength="10" id="fijoUsuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                        echo $_POST['fijoUsuarios'];
                                                                                                                    } else {
                                                                                                                        echo $fetchUsuarios['fijoUsuarios'];
                                                                                                                    } ?>">
            </div>
            <div class="col">
                <label for="celular1Usuarios" class="form-label">Celular 1 *</label>
                <input type="text" class="form-control" name="celular1Usuarios" maxlength="10" id="celular1Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['celular1Usuarios'];
                                                                                                                            } else {
                                                                                                                                echo $fetchUsuarios['celular1Usuarios'];
                                                                                                                            } ?>">
            </div>
            <div class="col">
                <label for="celular2Usuarios" class="form-label">Celular 2</label>
                <input type="text" class="form-control" name="celular2Usuarios" maxlength="10" id="celular2Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['celular2Usuarios'];
                                                                                                                            } else {
                                                                                                                                echo $fetchUsuarios['celular2Usuarios'];
                                                                                                                            } ?>">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="direccionUsuarios" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccionUsuarios" id="direccionUsuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                    echo $_POST['direccionUsuarios'];
                                                                                                                } else {
                                                                                                                    echo $fetchUsuarios['direccionUsuarios'];
                                                                                                                } ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label class="form-label" for="nombreRoles">Seleccionar rol *</label>
                <?php cargarSelect($conexion, "SELECT idRoles, nombreRoles FROM roles", "Roles", "class='custom-select form-control' id='nombreRoles'", $fetchUsuarios['idRoles'], '1') ?>
                <input type="hidden" name="idRoles" value="<?php echo $fetchUsuarios['idRoles'] ?>">
            </div>
            <div class="col-3" id="passUsuarios1" style="display: none;">
                <label for="pass1Usuarios" class="form-label">Modificar Contraseña</label>
                <input type="password" maxlength="15" class="form-control" id="pass1Usuarios" name="pass1Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['pass1Usuarios'];
                                                                                                                            } else {
                                                                                                                                echo desencriptar($fetchUsuarios['passUsuarios']);
                                                                                                                            } ?>">
            </div>
            <div class="col-3" id="passUsuarios2" style="display: none;">
                <label for="pass2Usuarios" class="form-label">Repita la Contraseña</label>
                <input type="password" maxlength="15" class="form-control" id="pass2Usuarios" name="pass2Usuarios" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo $_POST['pass2Usuarios'];
                                                                                                                            } else {
                                                                                                                                echo desencriptar($fetchUsuarios['passUsuarios']);
                                                                                                                            } ?>">
                <input type="hidden" name="estadoPassword" value="0" id="estadoPass">
            </div>

        </div>
        <div class="btnSubmit">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnEditar ?>Modificar Información</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
            <span class="visually-hidden">Loading...</span>
        </div>
    </form>

</div>

<?php require_once('../../estructura/footer.php') ?>