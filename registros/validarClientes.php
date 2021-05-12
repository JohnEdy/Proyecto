<?php
$contadorErrores = 0;
if (@$_GET['i'] == 1) {
    echo $siEditar;
}


if (isset($_POST['submit'])) {

    @$nombre1           = ucfirst($_POST['nombre1Usuarios']);
    @$nombre2           = ucfirst($_POST['nombre2Usuarios']);
    @$apellido1         = ucfirst($_POST['apellido1Usuarios']);
    @$apellido2         = ucfirst($_POST['apellido2Usuarios']);
    @$documento         = $_POST['documentoUsuarios'];
    @$fechaNacimiento   = $_POST['fechaNacimientoUsuarios'];
    @$passDefecto       = $_POST['passDefectoUsuarios'];
    @$idRoles           = $_POST['idRoles'];
    @$emailUsuarios     = $_POST['emailUsuarios'];
    @$pass1Usuarios     = $_POST['pass1Usuarios'];
    @$pass2Usuarios     = $_POST['pass2Usuarios'];
    @$estadoPassword    = $_POST['estadoPassword'];
    @$idFotos           = $_POST['idFotos'];
    @$nitEmpresas       = $_POST['nitEmpresas'];
    @$fijoUsuarios      = $_POST['fijoUsuarios'];
    @$celular1Usuarios  = $_POST['celular1Usuarios'];
    @$celular2Usuarios  = $_POST['celular2Usuarios'];
    @$direccionUsuarios = $_POST['direccionUsuarios'];

    //Validamos el campo documento
    $consultaClientes = "SELECT * FROM usuarios WHERE documentoUsuarios = '" . $documento . "'";
    $ejecutaClientes = mysqli_query($conexion, $consultaClientes);
    $contadorClientes = mysqli_num_rows($ejecutaClientes);

    if (empty($documento)) {
        validarCampos('vacio', 'Documento');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ($update == 0 && $contadorClientes >= 1) {
        validarCampos('noExiste', 'Documento');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($documento) >= $C = 15) {
        validarCampos('caracteres', 'Documento', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo de la fecha de nacimiento
    if (empty($fechaNacimiento)) {
        validarCampos('vacio', 'Fecha de nacimiento');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //validamos el campo email
    if (empty($emailUsuarios)) {
        validarCampos('vacio', 'Correo electrónico');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!validarCampos('email', 'Correo electrónico', '', '', $emailUsuarios)) {
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo primer nombre
    if (empty($nombre1)) {
        validarCampos('vacio', 'Primer nombre');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($nombre1) > $C = 20) {
        validarCampos('caracteres', 'Primer nombre', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo segundo nombre
    if (strlen($nombre2) > $C = 20) {
        validarCampos('caracteres', 'Segundo nombre', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo primer apellido
    if (empty($apellido1)) {
        validarCampos('vacio', 'Primer apellido');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($apellido1) > $C = 20) {
        validarCampos('caracteres', 'Primer apellido', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo segundo apellido
    if (strlen($apellido2) > $C = 20) {
        validarCampos('caracteres', 'Segundo apellido', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos campo passDefecto, por si se desea modificar el valor.
    if (empty($passDefecto)) {
        $i = strlen($documento) - 4;
        $passDefecto = substr($documento, $i, 4);
    }

    //Validar campo teléfono fijo
    if (strlen($fijoUsuarios) > $C = 10) {
        validarCampos('caracteres', 'Teléfono Fijo', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($fijoUsuarios)) {
        if (empty($fijoUsuarios)) {
            $fijoUsuarios = NULL;
        } else {
            validarCampos('numeros', 'Teléfono Fijo');
            $contadorErrores = $contadorErrores + 1;
            return false;
        }
    }

    //Validamos el campo celular 1
    if (empty($celular1Usuarios)) {
        validarCampos('vacio', 'Celular 1');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($celular1Usuarios) > $C = 10) {
        validarCampos('caracteres', 'Celular 1', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($celular1Usuarios)) {
        validarCampos('numeros', 'Celular 1');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validar campo celular 2
    if (strlen($celular2Usuarios) > $C = 10) {
        validarCampos('caracteres', 'Celular 2', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($celular2Usuarios)) {
        if (empty($celular2Usuarios)) {
            $celular2Usuarios = NULL;
        } else {
            validarCampos('numeros', 'Celular 2');
            $contadorErrores = $contadorErrores + 1;
            return false;
        }
    }

    //Validamos que se haya seleccionado un rol
    if (empty($idRoles)) {
        validarCampos('seleccionar', 'rol');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos que se haya seleccionado una empresa
    if (empty($nitEmpresas) && $update == '0') {
        validarCampos('seleccionar', 'Empresa');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Si estamos realizando una consulta una modificación de un registro, validamos las contraseñas.
    if ($update == '1') {
        if (empty($pass1Usuarios) && empty($pass2Usuarios)) {
            validarCampos('vacio', 'Contraseña');
            $contadorErrores = $contadorErrores + 1;
            return false;
        }

        if ($pass1Usuarios === $pass2Usuarios) {
        } else {
            validarCampos('igualPassword', 'contraseñas');
            $contadorErrores = $contadorErrores + 1;
            return false;
        }
    }

    //Despuès de verificar todo el formulario, contamos que no hayan errores y procedemos a registrar
    if ($contadorErrores == 0) {

        if ($update == 0) {

            $hashUsuario = generarHash();
            $insert         =   "INSERT INTO
                                    `usuarios`(
                                        `documentoUsuarios`,
                                        `fechaRegistroUsuarios`,
                                        `nombre1Usuarios`,
                                        `emailUsuarios`,
                                        `idRoles`,
                                        `nombre2Usuarios`,
                                        `apellido1Usuarios`,
                                        `apellido2Usuarios`,
                                        `fechaNacimientoUsuarios`,
                                        `passDefectoUsuarios`,
                                        `passUsuarios`,
                                        `nitEmpresas`,
                                        `fijoUsuarios`,
                                        `celular1Usuarios`,
                                        `celular2Usuarios`,
                                        `direccionUsuarios`,
                                        hashUsuario
                                    )
                                VALUES
                                    (
                                        '$documento',
                                        '$fechaRegistros',
                                        '$nombre1',
                                        '$emailUsuarios',
                                        '$idRoles',
                                        '$nombre2',
                                        '$apellido1',
                                        '$apellido2',
                                        '$fechaNacimiento',
                                        '$passDefecto',
                                        '$passDefecto',
                                        '$nitEmpresas',
                                        '$fijoUsuarios',
                                        '$celular1Usuarios',
                                        '$celular2Usuarios',
                                        '$direccionUsuarios',
                                        '$hashUsuario'
                                    )";
            $ejecutarInsert = mysqli_query($conexion, $insert);

            $nombreUsuarios = $nombre1 . " " . $nombre2 . " " . $apellido1 . " " . $apellido2;
            $documentoUsuarios = $documento;

            if ($ejecutarInsert) {

                $asunto     = "Validacion de Registro SoftPark";
                $mensaje    = "<h1 style='text-align: center;'>Señor (a) " . $nombreUsuarios . ", Soft Park le da la bienvenida</h1>
                <p style='text-align: left; font-weight: bold'>Sus Datos:</p>
                <div style='text-align: center;'>
                    <p><span style='font-weight: bold'>Su documento: </span>" . $documentoUsuarios . "<span></span></p>
                    <p><span style='font-weight: bold'>Su nombre: </span>" . $nombreUsuarios . "<span></span></p>
                    <p><span style='font-weight: bold'>Sus nùmeros de contacto: </span>" . $celular1Usuarios . "<span></span></p>
                    <br>
                    <p>Lo invitamos a validar su correo dando click en el siguiente botón: </p>
                    <p><a href='" . $enlaceCorreos . "sinSesion/validarCorreo.php?hash=" . $hashUsuario . "&&documento=" . $documentoUsuarios . "' style='background-color: #edc847; border-radius: 5pt; padding: 5pt; font-weight: bold; text-decoration: none; color: black;'>Confirmar Correo Electrónico</a></p>
                </div>
                <p>Sus datos han sido registrados satisfactoriamente.</p>
                <br>
                <br>
                <p style='text-align: left; font-weight: bold; font-size: 8pt; text-decoration: none;'>Si al dar click en el boton, no lo redirecciona automaticamente. Copie y pegue el siguiente enlacen en su navegador: " . $enlaceCorreos . "sinSesion/validarCorreo.php?hash=" . $hashUsuario . "&&documento=" . $documentoUsuarios . "</p>";

                enviarCorreo($emailUsuarios, $nombre1 . " " . $apellido1, $mensaje, $asunto);
                echo $siRegistros;
            } else {
                echo $noRegistros;
            }
        } else if ($update == 1) {
            $pass1Usuarios  = encriptar($pass1Usuarios);
            $update         =   "UPDATE
                                    `usuarios`
                                SET
                                    `passUsuarios` = '$pass1Usuarios',
                                    `nombre1Usuarios` = '$nombre1',
                                    `emailUsuarios` = '$emailUsuarios',
                                    `nombre2Usuarios` = '$nombre2',
                                    `apellido1Usuarios` = '$apellido1',
                                    `apellido2Usuarios` = '$apellido2',
                                    `fechaNacimientoUsuarios` = '$fechaNacimiento',
                                    `idFotoUsuarios` = '$idFotos',
                                    `fijoUsuarios` = '$fijoUsuarios',
                                    `celular1Usuarios` = '$celular1Usuarios',
                                    `celular2Usuarios` = '$celular2Usuarios',
                                    `direccionUsuarios` = '$direccionUsuarios'
                                WHERE
                                    `documentoUsuarios` = '$documento' ";
            $ejecutarUpdate = mysqli_query($conexion, $update);


            if ($ejecutarUpdate) {
                $_SESSION['idPerfil'] = $_POST['idFotos'];
                echo "<script>window.location.href = 'modificar.php?i=1';</script>";
            } else {
                echo $noEditar;
            }
        }
    }
}
