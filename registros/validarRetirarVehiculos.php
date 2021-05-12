<?php
include_once('../estructura/conexion.php');
include_once('../estructura/variablesGlobales.php');
@session_start();

$horaSalida     = $_POST['horaSalida'];
$totalCobrar    = $_POST['totalCobrar'];
$idParqueos     = $_POST['idParqueos'];
$horaServicio   = $_POST['cantidadHorasParqueo'];

$update =   "UPDATE
                    parqueos
                SET
                    horaSalidaParqueos      = '$horaSalida',
                    pagoServiciosParqueos   = '$totalCobrar',
                    estadoParqueos          = '3',
                    horaServicioParqueos    = '$horaServicio',
                    registroPor             = '$_SESSION[documentoUsuarios]',
                    fechaRegistro           = '$fechaRegistros'

                WHERE
                    idParqueos = '$idParqueos'";
$ejecutarUpdate = mysqli_query($conexion, $update);

$informacionCliente =   "SELECT
                            parqueos.mensualidadParqueos,
                            usuarios.nombre1Usuarios,
                            usuarios.nombre2Usuarios,
                            usuarios.apellido1Usuarios,
                            usuarios.apellido2Usuarios,
                            usuarios.emailUsuarios,
                            parqueos.placaVehiculos,
                            retiradoPor.documentoUsuarios,
                            retiradoPor.nombre1Usuarios AS 'nombre1Retiro',
                            retiradoPor.nombre2Usuarios AS 'nombre2Retiro',
                            retiradoPor.apellido1Usuarios AS 'apellido1Retiro',
                            retiradoPor.apellido2Usuarios AS 'apellido2Retiro',
                            empresas.nombreEmpresas
                        FROM
                            parqueos
                            LEFT JOIN usuarios ON usuarios.documentoUsuarios = parqueos.documentoUsuarios
                            LEFT JOIN usuarios retiradoPor ON retiradoPor.documentoUsuarios = parqueos.registroPor
                            LEFT JOIN empresas ON retiradoPor.nitEmpresas = empresas.nitEmpresas
                        WHERE
                            parqueos.idParqueos = '$idParqueos'";
$ejecutarInformacion    = mysqli_query($conexion, $informacionCliente);
$fetchInformacion       = mysqli_fetch_row($ejecutarInformacion);
$fechaRetiro            = explode(" ", $fechaRegistros);

if ($fetchInformacion[0] == 1) {
    $nombreDestino      = $fetchInformacion[1] . " " . $fetchInformacion[2] . " " . $fetchInformacion[3] . " " . $fetchInformacion[4];
    $nombreRetiro      = $fetchInformacion[8] . " " . $fetchInformacion[9] . " " . $fetchInformacion[10] . " " . $fetchInformacion[11];
    $asunto             = "Retiro de su vehículo " . $fetchInformacion[6];

    $mensaje    =   "<h1 style='text-align: center;'>Señor (a) " . $nombreDestino . ", Soft Park le informa</h1>
                        <h4>Su vehículo de placas <strong>" . $fetchInformacion[6] . " fue retirado de su parqueadero</strong> </h4>
                        <p style='text-align: left; font-weight: bold'>Datos Retiro:</p>
                        <div style='text-align: center;'>
                            <p><span style='font-weight: bold'>Registrado Por: </span>" . $nombreRetiro . "<span></span></p>
                            <p><span style='font-weight: bold'>Fecha Retiro: </span>" . $fechaRetiro[0] . "<span></span></p>
                            <p><span style='font-weight: bold'>Hora Retiro: </span>" . $horaSalida . "<span></span></p>
                            <p><span style='font-weight: bold'>Nombre Parqueadero: </span>" . $fetchInformacion[12] . "<span></span></p>
                            <br>
                            <p>Si usted ah sido el causante del retiro y propietario del vehículo, omita este mensaje. De lo contrario, le recomendamos acercase al parqueadero anteriormente mencionado.</p>
                        </div>
                        <br>";
}

if ($ejecutarUpdate) {
    if ($fetchInformacion[0] == 1) {
        enviarCorreo($fetchInformacion[5], $nombreRetiro, $mensaje, $asunto);
        registrarHistParqueo($conexion, $fetchInformacion[6], 'Retiro de Vehículo');
    }

    echo "<script>window.location.href = '../vistas/parqueos/retirarVehiculos.php?up=1'</script>";
} else {
    echo "<script>window.location.href = '../vistas/parqueos/retirarVehiculos.php?up=2'</script>";
}
