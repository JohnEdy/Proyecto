<?php

include_once("../estructura/conexion.php");
include_once("../estructura/variablesGlobales.php");

$documentoUsuarios = $_POST['documentoUsuarios'];

//Buscamos si el usuario se encuentra registrado
$sql = "SELECT emailUsuarios, nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE documentoUsuarios = '$documentoUsuarios'";
$ejecutar = mysqli_query($conexion, $sql);
$fetch = mysqli_fetch_all($ejecutar);

if (COUNT($fetch) >= 1) {
    $documentoUsuarios = encriptar($documentoUsuarios);

    $asunto     = "Recuperar contraseña SoftPark";
    $mensaje    = "<h1 style='text-align: center;'>Recupera Tu Contraseña</h1>
                    <div style='text-align: center;'>
                        <p><span style='font-weight: bold'>Si usted ha solicitado recuperar su contraseña, por favor, de click en el siguiente botón, de lo contrario, ignore este mensaje.</p>
                        <br>
                        <p><a href='" . $enlaceCorreos . "sinSesion/primeraVez.php?documento=" . $documentoUsuarios . "' style='background-color: #edc847; border-radius: 5pt; padding: 5pt; font-weight: bold; text-decoration: none; color: black;'>Recuperar Contraseña</a></p>
                    </div>
                    <br>
                    <p style='text-align: left; font-weight: bold; font-size: 8pt; text-decoration: none;'>Si al dar click en el boton, no lo redirecciona automaticamente. Copie y pegue el siguiente enlacen en su navegador: " . $enlaceCorreos . "sinSesion/primeraVez.php?documento=" . $documentoUsuarios . "</p>";

    enviarCorreo($fetch[0][0], $fetch[0][1] . " " . $fetch[0][2], $mensaje, $asunto);
    $correo = encriptar($fetch[0][0]);

    echo "<script>window.location.href = '../vistas/sinSesion/index.php?rc=2&em=".$correo."'</script>";
} else {
    echo "<script>window.location.href = '../vistas/sinSesion/index.php?rc=1'</script>";
};
