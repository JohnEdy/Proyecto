<?php
@include_once('../estructura/conexion.php');
@session_start();

@$consulta   =  "SELECT
                    documentoUsuarios
                FROM
                    vehiculos
                WHERE
                    placaVehiculos = '$_POST[placa]'
                    AND nitEmpresas = '$_SESSION[nitEmpresas]'";
@$ejecutar   = mysqli_query($conexion, $consulta);
@$datos      = mysqli_fetch_row($ejecutar);
@$cantidad   = mysqli_num_rows($ejecutar);

@$sqlUsuarios        =  "SELECT
                            documentoUsuarios,
                            CASE
                                WHEN ISNULL(nombre1Usuarios) THEN documentoUsuarios
                                ELSE nombre1Usuarios
                            END,
                            apellido1Usuarios
                        FROM
                            usuarios
                        WHERE
                            nitEmpresas = '$_SESSION[nitEmpresas]'";
@$ejecutarUsuarios   = mysqli_query($conexion, $sqlUsuarios);
@$datosUsuarios      = mysqli_fetch_all($ejecutarUsuarios);

if ($cantidad >= 1) {
    $disabled = 'disabled style="cursor: not-allowed;"';
} else {
    $disabled = 'style="cursor: default;"';
}

$datosFinales[0] = "<option value='0'>-- Seleccione --</option>";

foreach ($datosUsuarios as $key => $value) {
    if (@$datos[0] === $value[0]) {
        $select = "selected='selected'";
        $datosFinales[1] = 1;
    } else {
        $select = "";
    }
    $datosFinales[0] = $datosFinales[0] . "<option " . $select . " value='" . $value[0] . "'>" . $value[1] . " " . $value[2] . "</option>";
}

echo json_encode($datosFinales);
