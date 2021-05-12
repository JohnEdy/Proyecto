<?php

include_once('../estructura/conexion.php');
include_once('../estructura/variablesGlobales.php');
@session_start();

$codigo = encriptar($_POST['codigo']);

//validamos que el còdigo del parqueo si exista y sea correcto
$consultaCodigo =   "SELECT
                        vehiculos.tipoVehiculos /*0*/,
                        parqueos.horaIngresoParqueos /*1*/,
                        TIMESTAMPDIFF(
                            HOUR,
                            parqueos.fechaRegistro,
                            CURRENT_TIMESTAMP
                        ) AS 'horasParqueo' /*2*/,
                        parqueos.cantidadCascos /*3*/,
                        parqueos.casilleroCascos /*4*/,
                        parqueos.idParqueos /*5*/,
                        parqueos.lavadaParqueos /*6*/,
                        CASE WHEN parqueos.mensualidadParqueos = 1 THEN tiposVehiculos.mesTiposVehiculos ElSE tiposVehiculos.horaTiposVehiculos END AS 'valorParqueo' /*7*/,
                        CASE WHEN parqueos.lavadaParqueos = 1 THEN tiposVehiculos.lavadaTiposVehiculos ELSE 0 END AS 'valorLavada' /*8*/
                        FROM
                        parqueos
                        INNER JOIN vehiculos ON parqueos.placaVehiculos = vehiculos.placaVehiculos
                        INNER JOIN tiposVehiculos ON tiposVehiculos.idTipoVehiculos = vehiculos.tipoVehiculos
                    WHERE parqueos.codigoRetiroParqueos = '$codigo'
                        AND parqueos.estadoParqueos = '2'
                        AND parqueos.nitEmpresas = '$_SESSION[nitEmpresas]'";

//echo $consultaCodigo;
$ejecutarCodigo     = mysqli_query($conexion, $consultaCodigo);
@$rowCodigo         = mysqli_num_rows($ejecutarCodigo);
@$datosParqueo      = mysqli_fetch_row($ejecutarCodigo);

//Si se encuentra un valor válido, agregamos si existe o no el registro
if ($rowCodigo >= 1) {
    $datosParqueo[9] = 'Si'; // 8
} else {
    $datosParqueo       = array();
    $datosParqueo[9]    = 'No'; // 8
}

//array_push($datosParqueo, $consultaCodigo);
echo json_encode($datosParqueo);
