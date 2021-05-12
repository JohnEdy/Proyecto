<?php $menuConfigAdmin = 'configAdmin'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
//Consulta para traer toda la informaciòn del cliente, parqueo y vehículo
$consultaInformacion =  "SELECT
                            planes.idPlanes,
                            planes.descripcionPlanes,
                            planes.nombrePlanes,
                            planes.precioPlanes,
                            planes.fechaRegistros,
                            imagen.rutaImagen,
                            usuarios.nombre1Usuarios,
                            usuarios.apellido1Usuarios,
                            planes.registroPor,
                            planes.cantidadParqueosHoras,
                            planes.cantidadParqueosMeses,
                            planes.cantidadArticulos
                        FROM
                            planes
                        INNER JOIN usuarios ON usuarios.documentoUsuarios   = planes.registroPor
                        INNER JOIN imagen   ON imagen.idImagen              = planes.idImagen
                        WHERE
                            idPlanes = '$_GET[id]'";

$ejecutarInformacion = mysqli_query($conexion, $consultaInformacion);
$fetchInformacion = mysqli_fetch_assoc($ejecutarInformacion);

?>
<p class="titulos">Información Plan</p>
<div class="container-menu">
    <ul class="nav nav-pills left-content-end" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="consultarPlanes.php" class="nav-link btn-primary btn btn-sm"><?php echo $btnAnterior ?>Volver a Consultar</a>
        </li>
    </ul>

    <ul class="nav nav-pills justify-content-end" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="editarPlanes.php?id=<?php echo $_GET['id'] ?>" class="nav-link btn-primary btn btn-sm"><?php echo $btnEditar ?>Editar Plan</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#parqueosHoy"><?php echo $btnEliminar ?>Eliminar Plan</a>
        </li>
    </ul>
    <div class="row containerInto">
        <div class="col-2">
            <p class="subtitulos">Id: </p>
            <p class="informacion"><?php echo $fetchInformacion['idPlanes'] ?></p>
        </div>
        <div class="col-10">
            <p class="subtitulos">Título: </p>
            <p class="informacion"><?php echo $fetchInformacion['nombrePlanes'] ?></p>
        </div>
    </div>
    <div class="row containerInto">
        <div class="col-4">
            <p class="subtitulos">Precio: </p>
            <p class="informacion"><?php echo "$ " . number_format($fetchInformacion['precioPlanes']) ?></p>
        </div>
        <div class="col-4">
            <p class="subtitulos">Fecha de Registro: </p>
            <p class="informacion"><?php echo $fetchInformacion['fechaRegistros'] ?></p>
        </div>
        <div class="col-4">
            <p class="subtitulos">Registro Por: </p>
            <p class="informacion"><?php echo $fetchInformacion['nombre1Usuarios'] . " " . $fetchInformacion['apellido1Usuarios'] ?></p>
        </div>
    </div>
    <div class="row containerInto">
        <div class="col-4">
            <p class="subtitulos id="labelContraUsuario">Cantidad Horas
                <span type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Cantidad de registros para los parqueos por horas para las empresas gratuitas">
                    <?php echo $btnAyuda ?>
                </span>
            </p>
            <p class="informacion"><?php echo $fetchInformacion['cantidadParqueosHoras'] ?></p>
        </div>
        <div class="col-4">
            <p class="subtitulos" id="labelContraUsuario">Cantidad Meses <span type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Cantidad de registros para los parqueos por mes para las empresas gratuitas">
                    <?php echo $btnAyuda ?>
                </span>
            </p>
            <p class="informacion"><?php echo $fetchInformacion['cantidadParqueosMeses'] ?></p>
        </div>
        <div class="col-4">
            <p class="subtitulos" id="cantidadArticulos">Cantidad Artículos <span type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Cantidad de registros para los artículos para las empresas gratuitas">
                    <?php echo $btnAyuda ?>
                </span>
            </p>
            <p class="informacion"><?php echo $fetchInformacion['cantidadArticulos'] ?></p>
        </div>
    </div>
    <div class="row containerInto">
        <div class="col-6">
            <p class="subtitulos">Descripción: </p>
            <p class="informacion"><?php echo $fetchInformacion['descripcionPlanes'] ?></p>
        </div>
        <div class="col-6">
            <p class="subtitulos">Imagen: </p>
            <p class="informacion" style="text-aling: center;"><img style="width: 300px; height: 250px;" src="../../<?php echo $fetchInformacion['rutaImagen'] ?>" alt="&nbsp; No se encuentra una imagen disponible"></p>
        </div>
    </div>
</div>

<div class="modal fade" id="parqueosHoy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <div class="alert alert-danger" style="font-weight: bold;">¿Realmente desea eliminar este plan? Después de realizada, no se podra deshacer esta acción</div>
            </div>
            <div class="modal-footer">
                <a href="../acciones/eliminarPlanes.php?id=<?php echo $fetchInformacion['idPlanes'] ?>&&img=<?php echo $fetchInformacion["rutaImagen"] ?>" class="btn btn-primary"><?php echo $btnEliminar ?>&nbsp;Eliminar</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>
<?php require_once('../../estructura/footer.php') ?>