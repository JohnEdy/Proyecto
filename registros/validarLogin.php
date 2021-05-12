<?php
include_once('../../estructura/conexion.php');

//Revisamos la conexiòn de los usuarios.
@$nombreUsuarios    = $_POST['nombreUsuarios'];
@$passUsuarios      = $_POST['passUsuarios'];
$errores            = "text";

//Usuario creado correctamente
if (@isset($_GET['usu']) && $_GET['usu'] == 1) { ?>
    <div class="alert alert-success alertLogin">Su usuario fue creado de manera satisfactoria. Lo invitamos a revisar la bandeja de entrada de su correo eletrónico.</div>
<?php }

//correo electrònico
if (@isset($_GET['em']) && $_GET['em'] == 1) { ?>
        <div class="alert alert-success alertLogin">Su correo electrónico fue válidado de manera correcta</div>
<?php }

//sesiòn por inactivad
if (@isset($_GET['login']) && $_GET['login'] == 1) { ?>
    <div class="alert alert-danger alertLogin">Cierre de sesión por inactividad</div>
<?php }

//usuario no existe
if (@isset($_GET['rc']) && $_GET['rc'] == 1) { ?>
    <div class="alert alert-danger alertLogin">Lo sentimos, no es posible recuperar su contraseña. El usuario no existe</div>
<?php } else if (@isset($_GET['rc']) && $_GET['rc'] == 2) { 
    //Si se ingresa, significa que se envia el correo para recuperar la contraseña
    $email = desencriptar($_GET['em']); ?>

    <div class="alert alert-success alertLogin">Usuario correcto. Válida tu correo electrónico <strong><?php echo $email ?></strong> para recuperar tu contraseña</div>
<?php }

if (@isset($_GET['pass']) && $_GET['pass'] == 1) { ?>
    <div class="alert alert-success alertLogin">Contraseña modificada correctamente.</div>
<?php }

if (isset($_POST['submitLogin'])) :
    $errores = 0;

    //validamos el usuario
    if (empty($nombreUsuarios)) : ?>
        <div class="alert alert-danger alertLogin">Lo sentimos, no ha ingresado un usuario.</div>
        <?php $errores = $errores + 1; return false; ?>
    <?php elseif (strlen($nombreUsuarios) > $C = 14) : ?>
        <div class="alert alert-danger alertLogin">Lo sentimos, la cantidad de carácteres no puede ser mayor a <?php echo $C ?>.</div>
        <?php $errores = $errores + 1; return false; ?>
    <?php endif;

    //validamos la contraseña
    if (empty($passUsuarios)) : ?>
        <div class="alert alert-danger alertLogin">Lo sentimos, debe ingresar una contraseña.</div>
        <?php $errores = $errores + 1; return false; ?>
    <?php endif;
endif;

//Validamos que se hayan ingresado los datos en ambos campos
if ($errores === 0) :

    $consultaPass = "SELECT passUsuarios, passEstadoUsuarios, idRoles FROM usuarios WHERE documentoUsuarios = '".$nombreUsuarios."'";
    $ejecutarPass = mysqli_query($conexion, $consultaPass);
    $fetchPass = mysqli_fetch_array($ejecutarPass);

    //Verificamos el estado de la contraseña, estado 1, usuario nuevo y no cambiado la contraseña.
    if (@$fetchPass[1] == 0) {
        //Si está en estado 0, se procede a encriptar la contraseña ingresada y se revisa con la ingresada en la BD
        $passUsuarios = encriptar($passUsuarios);

        if ($passUsuarios === @$fetchPass[0]) {
            $passUsuarios = $fetchPass[0];
        } else {
            $passUsuarios = md5("asdfasf");
        }
    }

    //Ejecutamos la consulta para verificar que el usuario y contraseña si existan en la BD
    $consultaSql    = "SELECT * FROM usuarios WHERE documentoUsuarios = '".$nombreUsuarios."' AND
    passUsuarios    = '".$passUsuarios."'";
    $ejecutarSql    = mysqli_query($conexion, $consultaSql);
    $rowsUsuarios   = mysqli_num_rows($ejecutarSql);
    $fetchUsuarios  = mysqli_fetch_array($ejecutarSql);

    if (@$fetchPass['idRoles'] == $idAdministradorEmpresas || @$fetchPass['idRoles'] == $idClienteEmpresas) {
        $nitEmpresas = @$fetchUsuarios['nitEmpresas'];
        $consultaEstadoEmpresa = "SELECT estadoEmpresas FROM empresas WHERE nitEmpresas = '$nitEmpresas'";
        $ejecutarEstadoEmpresas = mysqli_query($conexion, $consultaEstadoEmpresa);
        $fetchEstadoEmpresas = mysqli_fetch_array($ejecutarEstadoEmpresas);
    }

?>
    <!-- Si la información es correcta, se procede a iniciar la sesión. -->
    <?php if ($rowsUsuarios >= 1) :
        if ($fetchPass['idRoles'] == $idAdministradorEmpresas || $fetchPass['idRoles'] == $idClienteEmpresas) {
            if ($fetchEstadoEmpresas[0] == 0) {
                echo '<div class="alert alert-danger alertLogin">Lo sentimos, su empresa se encuentra deshabilitada. Por favor comuniquese con el administrador del sistema.</div>';
                return false;
            }
        }

        @session_start();

        $_SESSION['documentoUsuarios']      = $fetchUsuarios['documentoUsuarios'];
        $_SESSION['nombreUsuarios']         = $fetchUsuarios['nombre1Usuarios']." ".$fetchUsuarios['apellido1Usuarios'];
        $_SESSION['idRoles']                = $fetchUsuarios['idRoles'];
        $_SESSION['idPerfil']               = $fetchUsuarios['idFotoUsuarios'];
        $_SESSION['estadoContra']           = $fetchUsuarios['passEstadoUsuarios'];
        $_SESSION['nitEmpresas']            = $fetchUsuarios['nitEmpresas'];
        $_SESSION['fechaConexion']          = time();
        $_SESSION['validar']                = true;

        if ($fetchUsuarios['estadoCorreo'] == 0) {
            echo '<div class="alert alert-danger alertLogin">Lo sentimos, para iniciar sesión debe validar su correo electrónico.</div>';
            return false;
        }

        if ($_SESSION['estadoContra'] == '1') {
            mysqli_close($conexion);
            echo "<script>location.href='primeraVez.php'</script>";
        } else {

            if ($_SESSION['idRoles'] == $idAdministradorEmpresas) {
                $consultaParametros = "SELECT COUNT(*) FROM parametros WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
                $ejecutarParametros = mysqli_query($conexion, $consultaParametros);
                $fetchParametros     = mysqli_fetch_array($ejecutarParametros);

                if ($fetchParametros[0] == 0) {
                    echo "<script>location.href='../perfil/configuracion.php'</script>";
                }
            }
            mysqli_close($conexion);
            echo "<script>location.href='../inicio/inicio.php'</script>";
        }
    else : ?>
        <div class="alert alert-danger alertLogin">Lo sentimos, el usuario o la contraseña son incorrectos.</div>
<?php
    endif;
endif;
