<?php $menuMensajes = "mensajes" ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idAdministradorSistema && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
$id = $_GET['id'];

//Mostrar Todos los datos del mensaje
$consultaSolicitud = "SELECT * FROM mensajes INNER JOIN usuarios_mensajes ON mensajes.idMensajes = usuarios_mensajes.idMensajes WHERE mensajes.idMensajes = '$id'";
$ejecutarSolicitud = mysqli_query($conexion, $consultaSolicitud);
$fetchSolicitud = mysqli_fetch_array($ejecutarSolicitud);

//Mostrar Nombre Del Usuario
$consultaNombreUsuario = "SELECT nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE documentoUsuarios = '$fetchSolicitud[4]'";
$ejecutarNombreUsuario = mysqli_query($conexion, $consultaNombreUsuario);
$fetchNombreUsuario = mysqli_fetch_array($ejecutarNombreUsuario);

//Mostrar Nombre Destinatario
$consultaNombreDestino = "SELECT nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE documentoUsuarios = '$fetchSolicitud[7]'";
$ejecutarNombreDestinatario = mysqli_query($conexion, $consultaNombreDestino);
$fetchNombreDestinatario = mysqli_fetch_array($ejecutarNombreDestinatario);

//Revisamos si hay respuestas a la solicitud
$consultaSolicitud = "SELECT * FROM respuestas WHERE idSolicitud = '$_GET[id]'";
$ejecutarSolicitud = mysqli_query($conexion, $consultaSolicitud);
$rowSolicitud = mysqli_num_rows($ejecutarSolicitud);

//Consulta de respuesta
$consultaRespuestas = "SELECT usuarios.nombre1Usuarios, usuarios.nombre2Usuarios, usuarios.apellido1Usuarios, usuarios.apellido2Usuarios, mensajes.descripcionMensajes, mensajes.fechaRegistro FROM respuestas INNER JOIN mensajes ON mensajes.idMensajes = respuestas.idRespuesta INNER JOIN usuarios ON usuarios.documentoUsuarios = mensajes.documentoUsuarios WHERE respuestas.idSolicitud = $id";
$ejecutarRespuetas = mysqli_query($conexion, $consultaRespuestas);
$fetchRespuestas = mysqli_fetch_all($ejecutarRespuetas);

$i = 1;

if ($fetchSolicitud[9] == 0 && $fetchSolicitud[7] == $_SESSION['documentoUsuarios']) {
    $estado = 1;

    //Leer solicitud
    $consultaLeer = "UPDATE usuarios_mensajes SET estadoSolicitud = '$estado' WHERE idMensajes = '$_GET[id]'";
    $ejecutarLeer = mysqli_query($conexion, $consultaLeer);

    $consultaSolicitud = "SELECT * FROM mensajes INNER JOIN usuarios_mensajes ON mensajes.idMensajes = usuarios_mensajes.idMensajes WHERE mensajes.idMensajes = '$id'";
    $ejecutarSolicitud = mysqli_query($conexion, $consultaSolicitud);
    $fetchSolicitud = mysqli_fetch_array($ejecutarSolicitud);
}

?>
<p class="titulos">Revisar Solicitud</p>

<div class="container-menu">
    <?php if (($fetchSolicitud[7] == $_SESSION['documentoUsuarios'] || $fetchSolicitud[4] == $_SESSION['documentoUsuarios']) && $fetchSolicitud[4] != 666666666) { ?>
        <ul class="nav justify-content-end">
            <li class="nav-item align-middle">
                <a class="nav-link active btn btn-primary btn-sm" href="responderSolicitudes.php?id=<?php echo $fetchSolicitud[0] ?>"><?php echo $btnLeido ?>Responder</a>
            </li>
        </ul>
    <?php } ?>
    <?php if (@$_GET['save'] == 1) { ?>
        <div class="alert alert-success">Respuesta almacenada de manera satisfactoria.</div>
    <?php } ?>
    <div class="row">
        <div class="col-8">
            <p class="subtitulos">Título: </p>
            <span class="informacion"><?php echo $fetchSolicitud[1] ?></span>
        </div>
        <div class="col-4">
            <p class="subtitulos">Fecha Solicitud: </p>
            <span class="informacion"><?php echo $fetchSolicitud[3] ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="subtitulos">Estado: </p>
            <span class="informacion"><?php echo $estadoMensajes[$fetchSolicitud[9]] ?></span>
        </div>
        <div class="col">
            <p class="subtitulos">Remitente: </p>
            <span class="informacion"><?php echo $fetchNombreUsuario[0] . " " . $fetchNombreUsuario[1] ?></span>
        </div>
        <div class="col">
            <p class="subtitulos">Destinatario: </p>
            <span class="informacion"><?php echo $fetchNombreDestinatario[0] . " " . $fetchNombreDestinatario[1] ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="subtitulos">Mensaje: </p>
            <div class="informacion"><?php echo $fetchSolicitud[2] ?></div>
        </div>
    </div>
    <?php if ($rowSolicitud > 0) { ?>
        <hr>
        <p class="tituloSecciones">Respuestas</p>
        <div class="table-responsive">
            <table class="table table-hover table-light table-bordered table-sm">
                <thead class='table-dark'>
                    <th style="width: 2.5%;">#</th>
                    <th>Respondido por</th>
                    <th>Respuesta</th>
                    <th>Fecha Respuesta</th>
                </thead>
                <tbody>
                    <?php foreach ($fetchRespuestas as $key => $value) { ?>
                        <tr class="rowT">
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $value[0] . " " . $value[1] . " " . $value[2] . " " . $value[3] ?></td>
                            <td><?php echo $value[4] ?></td>
                            <td><?php echo $value[5] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot class='table-dark'>
                    <th style="width: 2.5%;">#</th>
                    <th>Respondido por</th>
                    <th>Respuesta</th>
                    <th>Fecha Respuesta</th>
                </tfoot>
            </table>
        </div>


    <?php } ?>
</div>
<?php require_once('../../estructura/footer.php') ?>