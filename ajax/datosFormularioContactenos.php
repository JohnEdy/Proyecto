<?php
include_once('../estructura/conexion.php');
include_once('../estructura/variablesGlobales.php');

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$message = "<p>Nombre cliente: <strong>" . $name . "</strong><br> y correo electrónico: <strong>" . $email . "</strong><br><br>" . $message . "</p>";

$messageEmail    =   "<h1 style='text-align: center;'>Señor (a) " . $name . ", gracias por elegirnos.</h1>
                <h4>Su información fue enviada correctamente pronto nos pondremos en contacto con usted</h4>
                <p style='text-align: left; font-weight: bold'>Tus datos y mensaje: </p>
                <div style='text-align: center;'>
                    <p style='border: 1 solid;'>$message</p>
                </div>
                <br>";

if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql =  "INSERT INTO `mensajes`(`tituloMensajes`, `descripcionMensajes`, `fechaRegistro`, `documentoUsuarios`, `estadoMensaje`) VALUES ('$subject','$message','$fechaRegistros','666666666','4')";

        $ejecutar = mysqli_query($conexion, $sql);

        $sql = "INSERT INTO `usuarios_mensajes`(`documentoUsuarios`, `idMensajes`, `estadoSolicitud`, `fechaRegistro`) VALUES ($documentoAdministrador,(SELECT MAX(idMensajes) FROM mensajes),'0','$fechaRegistros')";
        $ejecutarUm = mysqli_query($conexion, $sql);

        if ($ejecutar && $ejecutarUm) {
            enviarCorreo($email, $name, $messageEmail, $subject);
            echo 1;
        } else {
            echo 0;
        }
    }
}
