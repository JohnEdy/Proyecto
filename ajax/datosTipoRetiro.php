<?php

include_once('../estructura/conexion.php');

// $select         =   "SELECT
//                         idParqueos
//                     FROM
//                         parqueos
//                     WHERE
//                         documentoUsuarios = '$documentoUsuarios'
//                         AND placaVehiculos = '$placaVehiculos'
//                         AND fechaRegistro = '$fechaRegistros'";
// $ejecutarSelect = mysqli_query($conexion, $select);
// $fetch          = mysqli_fetch_row($ejecutarSelect);

if ( $_POST['valRetirar'] == 2) {
	$sql = "SELECT documentoUsuarios, tipoVehiculos FROM vehiculos WHERE placaVehiculos = '$_POST[placa]'";
	$ejecutar = mysqli_query($conexion, $sql);
	$fetch = mysqli_fetch_row($ejecutar);

	if (@($fetch[0] != NULL || !empty($fetch[0])) && ($fetch[1] != NULL || !empty($fetch[1]))) {
		echo 1;
	} else {
		echo 0;
	}
} else if ($_POST['valRetirar'] == 3) {
	$sql = "SELECT vehiculos.documentoUsuarios, vehiculos.tipoVehiculos, usuarios.celular1Usuarios FROM vehiculos INNER JOIN usuarios ON vehiculos.documentoUsuarios = usuarios.documentoUsuarios WHERE placaVehiculos = '$_POST[placa]'";
	$ejecutar = mysqli_query($conexion, $sql);
	$fetch = mysqli_fetch_row($ejecutar);

	if (@($fetch[0] != NULL || !empty($fetch[0])) && ($fetch[1] != NULL || !empty($fetch[1])) && ($fetch[2] != NULL || !empty($fetch[2]))) {
		echo 1;
	} else {
		echo 0;
	}
}


