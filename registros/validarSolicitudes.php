<?php
$contadorErrores = 0;
@$estadoMensaje = $_POST['estadoMensajes'];

if ($estadoMensaje == '0') {
    $mensaje = 'Mensaje';
} else {
    $mensaje = 'Respuesta';
}

if (isset($_POST['submit'])) {

    @$tituloMensajes        = $_POST['tituloMensajes'];
    @$descripcionMensajes   = $_POST['descripcionMensajes'];
    @$destinatarioMensajes  = $_POST['destinatarioMensajes'];

    //Validamos que se haya ingresado un título
    if (empty($tituloMensajes)) {
        validarCampos('vacio', 'Título');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($tituloMensajes) > $C = 80) {
        validarCampos('caracteres', 'Título', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos que se haya seleccionado un destinatario
    if (empty($destinatarioMensajes)) {
        validarCampos('seleccionar', 'Destinatario');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos que se haya ingresado un mensaje
    if ($descripcionMensajes == "<div><br></div>") {
        validarCampos('vacio', $mensaje);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }
}

//Para insertar una nueva petición
if (@$estadoMensaje == '0') {

    //Despuès de verificar todo el formulario, contamos que no hayan errores y procedemos a registrar
    if ($contadorErrores == 0) {

        $insert         = "INSERT INTO `mensajes` (`tituloMensajes`, `descripcionMensajes`, `fechaRegistro`, `documentoUsuarios`, `estadoMensaje`) VALUES ('$tituloMensajes', '$descripcionMensajes', '$fechaRegistros', $_SESSION[documentoUsuarios], '1')";
        $ejecutarInsert = mysqli_query($conexion, $insert);

        $select         = "SELECT idMensajes FROM mensajes WHERE tituloMensajes = '$tituloMensajes' AND descripcionMensajes = '$descripcionMensajes' AND fechaRegistro = '$fechaRegistros' ";
        $ejecutarSelect = mysqli_query($conexion, $select);
        @$fetchSelect   = mysqli_fetch_array($ejecutarSelect);

        @$insertSolicitudes         = "INSERT INTO usuarios_mensajes (`idMensajes`, `documentoUsuarios`, `fechaRegistro`) VALUES ('$fetchSelect[0]', '$destinatarioMensajes', '$fechaRegistros')";
        $ejecutarInsertSolicitudes  = mysqli_query($conexion, $insertSolicitudes);

        if ($ejecutarInsert && $ejecutarInsertSolicitudes) {
            echo $siRegistros;
        } else {
            echo $noRegistros;
        }
    }

//Para insertar una respuesta.
} else if (@$estadoMensaje == '2') {

    @$tituloMensajes        = $_POST['tituloMensajes'];
    @$documentoUsuario      = $_POST['documentoUsuario'];
    @$destinatarioMensajes  = $_POST['destinatarioMensajes'];
    @$idMensajeRespuesta    = $_POST['idMensajeRespuesta'];

    //Despuès de verificar todo el formulario, contamos que no hayan errores y procedemos a registrar
    if ($contadorErrores == 0) {

        //Inserto los valores de la respuesta
        $insert         = "INSERT INTO `mensajes` (`tituloMensajes`, `descripcionMensajes`, `fechaRegistro`, `documentoUsuarios`) VALUES ('$tituloMensajes', '$descripcionMensajes', '$fechaRegistros', $_SESSION[documentoUsuarios])";
        $ejecutarInsert = mysqli_query($conexion, $insert);

        //Seleccion el id de la respuesta que acabamos de crear
        $select         = "SELECT idMensajes FROM mensajes WHERE tituloMensajes = '$tituloMensajes' AND descripcionMensajes = '$descripcionMensajes' AND fechaRegistro = '$fechaRegistros' ";
        $ejecutarSelect = mysqli_query($conexion, $select);
        $fetchSelect    = mysqli_fetch_array($ejecutarSelect);

        //Insertamos la solicitud en la tabla usuarios_mensajes para determinar a quién se le envió el mensaje
        $insertSolicitudes          = "INSERT INTO usuarios_mensajes (`idMensajes`, `documentoUsuarios`, `fechaRegistro`, `estadoSolicitud`) VALUES ('$fetchSelect[0]', '$destinatarioMensajes', '$fechaRegistros', '2')";
        $ejecutarInsertSolicitudes = mysqli_query($conexion, $insertSolicitudes);

        //Pasamos el estado de la solicitud a leída
        // $updateEstado           = "UPDATE usuarios_mensajes SET estadoSolicitud = '1' WHERE idMensajes = '$_GET[id]'";
        // $ejecutarUpdateEstado   = mysqli_query($conexion, $updateEstado);

        //Insertamos en la tabla de respuestas, el id de la respuesta.
        $consultaRespuesta = "INSERT INTO respuestas (`idSolicitud`, `idRespuesta`, `fechaRegistro`) VALUES ('$_GET[id]', '$fetchSelect[0]', '$fechaRegistros')";
        $ejecutarRespuesta = mysqli_query($conexion, $consultaRespuesta);


        if ($ejecutarInsert && $ejecutarInsertSolicitudes) {
            echo "<script>location.href='../mensajes/ver.php?id=$_GET[id]&&save=1'</script>";
            echo $siRegistros;
        } else {
            echo $noRegistros;
        }
    }
}
