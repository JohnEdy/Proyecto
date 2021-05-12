<?php @$menuInformación = 'informacion'; ?>
<?php @$menuAdministradores = 'administradores'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas && $_SESSION['idRoles'] != $idClienteEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

//Arcchivo en el que estamos trabajando
$index = 'verParqueo';

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='" . $index . ".php?page=1&&nro=10&&id=$_GET[id]'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

//Consulta para traer toda la informaciòn del cliente, parqueo y vehículo
$consultaInformacion =  "SELECT
                            CASE
                                WHEN ISNULL(parqueos.documentoUsuarios) THEN 'Sin Propietario Registrado'
                                ELSE parqueos.documentoUsuarios
                            END AS 'documentoUsuarios',
                            parqueos.placaVehiculos,
                            parqueos.horaIngresoParqueos,
                            parqueos.horaSalidaParqueos,
                            parqueos.estadoParqueos,
                            CASE
                                WHEN ISNULL(usuarios.nombre1Usuarios) THEN 'Propietario Sin Nombre Registrado'
                                ELSE usuarios.nombre1Usuarios
                            END AS 'nombre1Usuarios',
                            usuarios.nombre2Usuarios,
                            usuarios.apellido1Usuarios,
                            usuarios.apellido2Usuarios,
                            CASE
                                WHEN ISNULL(usuarios.emailUsuarios) THEN 'Propietario Sin Correo Registrado'
                                ELSE usuarios.emailUsuarios
                            END AS 'emailUsuarios',
                            CASE
                                WHEN ISNULL(marcas.nombreMarcas) THEN 'No Hay Marca Registrada'
                                ELSE marcas.nombreMarcas
                            END AS 'nombreMarcas',
                            CASE
                                WHEN ISNULL(vehiculos.colorVehiculos) THEN 'No Hay Color Registrado'
                                ELSE vehiculos.colorVehiculos
                            END AS 'colorVehiculos',
                            tiposVehiculos.nombreTipoVehiculos AS 'tipoVehiculos',
                            parqueos.cantidadCascos,
                            parqueos.casilleroCascos,
                            usuarios.fijoUsuarios,
                            CASE
                                WHEN ISNULL(usuarios.celular1Usuarios) THEN 'Sin Número Telefónico'
                                ELSE usuarios.celular1Usuarios
                            END 'celular1Usuarios',
                            usuarios.celular2Usuarios,
                            usuarios.direccionUsuarios,
                            parqueos.registroPor,
                            empresas.nombreEmpresas,
                            parqueos.fechaRegistro,
                            parqueos.codigoRetiroParqueos,
                            parqueos.pagoServiciosParqueos,
                            parqueos.horaServicioParqueos,
                            usuariosB.nombre1Usuarios AS 'nombre1Cajeros',
                            usuariosB.nombre2Usuarios AS 'nombre2Cajeros',
                            usuariosB.apellido1Usuarios AS 'apellido1Cajeros',
                            usuariosB.apellido2Usuarios AS 'apellido2Cajeros',
                            parqueos.mensualidadParqueos,
                            tiposVehiculos.horaTiposVehiculos
                        FROM
                        parqueos
                            LEFT JOIN usuarios ON parqueos.documentoUsuarios = usuarios.documentoUsuarios
                            LEFT JOIN vehiculos ON parqueos.placaVehiculos = vehiculos.placaVehiculos
                            LEFT JOIN marcas ON vehiculos.marcaVehiculos = marcas.idMarcas
                            INNER JOIN empresas ON parqueos.nitEmpresas = empresas.nitEmpresas
                            LEFT JOIN usuarios usuariosB ON parqueos.registroPor = usuariosB.documentoUsuarios
                            INNER JOIN tiposVehiculos ON tiposVehiculos.idTipoVehiculos = vehiculos.tipoVehiculos
                        WHERE
                            parqueos.idParqueos = '$_GET[id]'";

$ejecutarInformacion = mysqli_query($conexion, $consultaInformacion);
$fetchInformacion = mysqli_fetch_assoc($ejecutarInformacion);

//Consulta para traer la cantidad de horas que lleva el vehículo en el parqueadero
if ($fetchInformacion['horaSalidaParqueos'] == '00:00:00') {
    $consultaHorasParqueo = "SELECT TIMESTAMPDIFF(hour, parqueos.fechaRegistro, CURRENT_TIMESTAMP) AS 'tiempoParqueo' FROM parqueos WHERE idParqueos = '$_GET[id]'";
} else {
    $consultaHorasParqueo = "SELECT TIMESTAMPDIFF(hour, parqueos.fechaRegistro, parqueos.horaSalidaParqueos) AS 'tiempoParqueo' FROM parqueos WHERE idParqueos = '$_GET[id]'";
}

$ejecutarHorasParqueo = mysqli_query($conexion, $consultaHorasParqueo);
$fetchHorasParqueo = mysqli_fetch_array($ejecutarHorasParqueo);

?>
<p class="titulos">Información Parqueo</p>
<div class="container-menu">
    <ul class="nav justify-content-end">
        <?php if ($fetchInformacion['estadoParqueos'] == 2 || $fetchInformacion['estadoParqueos'] == 3) { ?>
            <li class="nav-item align-middle">
                <a class="nav-link active btn btn-primary btn-sm" target="_blank" href="../PDF/pdfParqueos.php?id=<?php echo $_GET['id'] ?>"><?php echo $btnFacturas ?>Fáctura</a>
            </li>
        <?php } ?>
        <?php if ($fetchInformacion['documentoUsuarios'] == $_SESSION['documentoUsuarios'] && $fetchInformacion['estadoParqueos'] == 1) { ?>
            <li class="nav-item align-middle">
                <a class="nav-link active btn btn-primary btn-sm" href="../acciones/retirarVehiculo.php?id=<?php echo $_GET['id'] ?>"><?php echo $btnRetirar ?>Retirar</a>
            </li>
        <?php } ?>
    </ul>
    <p class="tituloSecciones">Parqueo</p>
    <?php if ($fetchInformacion['estadoParqueos'] == 2 && $fetchInformacion['documentoUsuarios'] == $_SESSION['documentoUsuarios']) { ?>
        <div class="alert alert-secondary">
            Su código de retiro es: <b><?php echo desencriptar($fetchInformacion['codigoRetiroParqueos']) ?></b>
        </div>
    <?php } ?>
    <div class="row containerInto">
        <div class="col-4">
            <p class="subtitulos">Placa: </p>
            <p class="informacion"><?php echo $fetchInformacion['placaVehiculos'] ?></p>
        </div>
        <div class="col-4">
            <p style="font-weight: bold;">Hora Ingreso: </p>
            <p class="informacion"><?php echo $fetchInformacion['fechaRegistro'] ?></p>
        </div>
        <div class="col-4">
            <p style="font-weight: bold;">Hora Sálida: </p>
            <p class="informacion">
                <?php if ($fetchInformacion['horaSalidaParqueos'] == '00:00:00') {
                    echo "N/A";
                } else {
                    echo $fetchInformacion['horaSalidaParqueos'];
                } ?>
            </p>
        </div>
    </div>
    <div class="row containerInto">
        <div class="col-4">
            <p class="subtitulos">Estado: </p>
            <p class="informacion"><?php echo $estadoParqueos[$fetchInformacion['estadoParqueos']] ?></p>
        </div>
        <div class="col-4">
            <p style="font-weight: bold;">Horas En Parqueadero: </p>
            <p class="informacion">
                <?php if ($fetchInformacion['estadoParqueos'] == 3) {
                    echo $fetchInformacion['horaServicioParqueos'] . " Hora(s)";
                } else {
                    echo $fetchHorasParqueo['tiempoParqueo'] . " " . "Hora(s)";
                } ?>
            </p>
        </div>
        <div class="col-4">
            <p style="font-weight: bold;">Precio a cobrar: </p>
            <p class="informacion">
                <?php if ($fetchInformacion['estadoParqueos'] == 3) {
                    echo "$ " . number_format($fetchInformacion['pagoServiciosParqueos']);
                } else {
                    echo "$ " . number_format($fetchInformacion['horaTiposVehiculos'] * $fetchHorasParqueo['tiempoParqueo']);
                } ?>
            </p>
        </div>
    </div>
    <div class="row containerInto">
        <div class="col-4">
            <p class="subtitulos">Atendido En: </p>
            <p class="informacion"><?php echo $fetchInformacion['nombreEmpresas'] ?></p>
        </div>
        <div class="col-4">
            <p style="font-weight: bold;">Atendido Por: </p>
            <p class="informacion"><?php echo $fetchInformacion['nombre1Cajeros'] . " " . $fetchInformacion['nombre2Cajeros'] . " " . $fetchInformacion['apellido1Cajeros'] . " " . $fetchInformacion['apellido2Cajeros'] ?></p>
        </div>

        <?php if ($fetchInformacion['cantidadCascos'] != 0) { ?>
            <div class="col-2">
                <p class="subtitulos">Cant. Cascos: </p>
                <p class="informacion"><?php echo $fetchInformacion['cantidadCascos'] ?></p>
            </div>
            <div class="col-2">
                <p style="font-weight: bold;">Nª Casillero: </p>
                <p class="informacion"><?php echo $fetchInformacion['casilleroCascos'] ?></p>
            </div>
        <?php } ?>
    </div>
    <hr>
    <p class="tituloSecciones">Vehículo</p>
    <div class="row containerInto">
        <div class="col-3">
            <p class="subtitulos">Placa: </p>
            <p class="informacion"><?php echo $fetchInformacion['placaVehiculos'] ?></p>
        </div>
        <div class="col-3">
            <p class="subtitulos">Marca: </p>
            <p class="informacion"><?php echo $fetchInformacion['nombreMarcas'] ?></p>
        </div>
        <div class="col-3">
            <p class="subtitulos">Color: </p>
            <p class="informacion"><?php echo $fetchInformacion['colorVehiculos'] ?></p>
        </div>
        <div class="col-3">
            <p class="subtitulos">Tipo: </p>
            <p class="informacion"><?php echo $fetchInformacion['tipoVehiculos'] ?></p>
        </div>
    </div>
    <hr>
    <p class="tituloSecciones">Propietario</p>
    <div class="row containerInto">
        <div class="col-6">
            <p class="subtitulos">Nombre: </p>
            <p class="informacion"><?php echo $fetchInformacion['nombre1Usuarios'] . " " . $fetchInformacion['nombre2Usuarios'] . " " . $fetchInformacion['apellido1Usuarios'] . " " . $fetchInformacion['apellido2Usuarios'] ?></p>
        </div>
        <div class="col-6">
            <p class="subtitulos">Documento: </p>
            <p class="informacion"><?php echo $fetchInformacion['documentoUsuarios'] ?></p>
        </div>
    </div>
    <div class="row containerInto">
        <div class="col-3">
            <p class="subtitulos">Correo Electrónico: </p>
            <p class="informacion"><?php echo $fetchInformacion['emailUsuarios'] ?></p>
        </div>
        <div class="col-3">
            <?php if ($fetchInformacion['fijoUsuarios'] != 0) { ?>
                <p class="subtitulos">Telefóno Fijo: </p>
                <p class="informacion"><?php echo $fetchInformacion['fijoUsuarios'] ?></p>
            <?php } ?>
        </div>
        <div class="col-3">
            <p class="subtitulos">Celular 1: </p>
            <p class="informacion"><?php echo $fetchInformacion['celular1Usuarios'] ?></p>
        </div>
        <div class="col-3">
            <?php if ($fetchInformacion['celular2Usuarios'] != 0) { ?>
                <p class="subtitulos">Celular 2: </p>
                <p class="informacion"><?php echo $fetchInformacion['celular2Usuarios'] ?></p>
            <?php } ?>
        </div>
    </div>
    <div class="row containerInto">
        <div class="col-12">
            <?php if (!empty($fetchInformacion['direccionUsuarios'])) { ?>
                <p class="subtitulos">Dirección: </p>
                <p class="informacion"><?php echo $fetchInformacion['direccionUsuarios'] ?></p>
            <?php } ?>
        </div>
    </div>
    <?php if ($fetchInformacion['mensualidadParqueos'] == 1) { ?>
        <?php
        $sqlHist = "SELECT historialMes.idHistMes, historialMes.descripcionHistMes, historialMes.fechaRegistro, usuarios.nombre1Usuarios, usuarios.nombre2Usuarios, usuarios.apellido1Usuarios, usuarios.apellido2Usuarios FROM historialMes INNER JOIN usuarios ON usuarios.documentoUsuarios = historialMes.registroPor WHERE placaVehiculos = '$fetchInformacion[placaVehiculos]' ORDER BY fechaRegistro DESC LIMIT $start, $nroRegistros ";
        $hist = mysqli_query($conexion, $sqlHist);
        $datosHist = mysqli_fetch_all($hist);

        ?>
        <hr>
        <p class="tituloSecciones">Historial Parqueo</p>
        <div class="row containerInto">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-light" style="width: 100%;">
                    <thead class="table-dark">
                        <th style="width: 5%">ID</th>
                        <th style="width: 31%">Descripción</th>
                        <th style="width: 31%">Fecha Estado</th>
                        <th style="width: 31%">Registrado Por</th>
                    </thead>
                    <tbody>
                        <?php foreach ($datosHist as $key => $value) : ?>
                            <tr>
                                <td><?php echo $value[0] ?></td>
                                <td><?php echo $value[1] ?></td>
                                <td><?php echo $value[2] ?></td>
                                <td><?php echo $value[3] . " " . $value[4] . " " . $value[5] . " " . $value[6] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-dark">
                        <th style="width: 5%">ID</th>
                        <th style="width: 31%">Descripción</th>
                        <th style="width: 31%">Fecha Estado</th>
                        <th style="width: 31%">Registrado Por</th>
                    </tfoot>
                </table>
                <?php paginacion($conexion, $sqlHist, $index, $_GET['page'], $nroRegistros, $_GET['id']); ?>
            </div>
        </div>
    <?php } ?>
</div>

<?php require_once('../../estructura/footer.php') ?>