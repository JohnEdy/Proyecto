<?php

if (@$_GET['add'] == 1) {
    echo $siRegistros;
} else if (@$_GET['add'] == 2) {
    echo $noRegistros;
}

$cantidadErrores = 0;

if (isset($_POST['submit'])) {
    $fechaHoy = explode(" ", $fechaRegistros);

    @$placaVehiculos        = $_POST['placaVehiculos'];
    @$horaParqueos          = $_POST['horaParqueos'];
    @$cantidadCascos        = $_POST['cantidadCascos'];
    @$casilleroCascos       = $_POST['casilleroCascos'];
    @$retirarPor            = $_POST['retirarPor'];
    @$tipoVehiculosHoras    = $_POST['tipoVehiculos'];
    @$id                    = $_POST['idParqueos'];

    if (empty($_POST['lavadaParqueos'])) {
        @$lavadaParqueos     = 0;
    } else {
        @$lavadaParqueos     = $_POST['lavadaParqueos'];
    }

    //Verificamos por consulta si existe o no la placa a registrar.
    $consultaPlaca  = "SELECT * FROM vehiculos WHERE placaVehiculos = '$placaVehiculos'";
    $ejecutarPlaca  = mysqli_query($conexion, $consultaPlaca) or die("Error en cosulta");
    $rowPlaca       = mysqli_num_rows($ejecutarPlaca);
    $fetchPlaca     = mysqli_fetch_assoc($ejecutarPlaca);

    @$documentoUsuarios = $fetchPlaca['documentoUsuarios'];

    //Verificamos por consulta si existe el cliente en la BD
    $consultaUsuarios   = "SELECT * FROM usuarios WHERE documentoUsuarios = '$documentoUsuarios'";
    $ejecutarUsuarios   = mysqli_query($conexion, $consultaUsuarios);
    $rowUsuarios        = mysqli_num_rows($ejecutarUsuarios);

    //Verificamos que el vehículo a parquear no tenga un parqueo activo
    $consultaParqueo    = "SELECT * FROM parqueos WHERE (estadoParqueos = '1' OR estadoParqueos = '2') AND placaVehiculos = '$placaVehiculos' AND nitEmpresas = '$_SESSION[nitEmpresas]'";
    $ejecutarParqueo     = mysqli_query($conexion, $consultaParqueo);
    $rowParqueo         = mysqli_num_rows($ejecutarParqueo);

    //Validamos el vehìculo
    $consultaVehiculo   = "SELECT COUNT(*) FROM `vehiculos` WHERE placaVehiculos = '$placaVehiculos' AND nitEmpresas = '$_SESSION[nitEmpresas]'";
    $ejecutarVehiculo   = mysqli_query($conexion, $consultaVehiculo);
    $fetchVehiculo      = mysqli_fetch_array($ejecutarVehiculo);

    //Validamos que se haya ingresado una hora valida
    $hora = explode(':', $horaParqueos);

    //Placa vehículos
    if (empty($placaVehiculos)) {
        validarCampos('vacio', 'Placa');
        $cantidadErrores = $cantidadErrores + 1;
        return false;
    } else if ($rowParqueo >= 1) {
        echo "<div class='alert alert-danger'>Lo sentimos, este vehículo ya se encuentra en parqueadero.</div>";
        $cantidadErrores = $cantidadErrores + 1;
        return false;
    } else if (strlen($placaVehiculos) >= $C = 8) {
        validarCampos('caracteres', "Placa", $C);
        $cantidadErrores = $cantidadErrores + 1;
        return false;
    } else if ($_POST['mensualidadParqueos'] == 1 && $fetchVehiculo[0] == 0) {
        validarCampos('noRegistrado', "Placa", $C);
        $cantidadErrores = $cantidadErrores + 1;
        return false;
    }

    //Validaciones extra para cuando es un mensualidad
    if ($parqueoMensualidad == 1) {

        $documentoUsuarios  = $_POST['documentoUsuarios'];
        $tipoVehiculosMes   = $_POST['tipoVehiculos'];

        //Validamos el cliente, cuando es una mensualidad
        if (empty($documentoUsuarios)) {
            validarCampos('seleccionar', 'Cliente');
            $cantidadErrores = $cantidadErrores + 1;
            return false;
        }

        //Validamos el tipoVehiculos
        if (empty($tipoVehiculosMes)) {
            validarCampos('seleccionar', 'Tipo Vehículo');
            $cantidadCascos = $cantidadCascos + 1;
            return false;
        }
    }

    //volvemos las letras de las placas a mayúscula
    $placaVehiculos = strtoupper($placaVehiculos);

    //Documento Clientes
    if (empty($documentoUsuarios) && $parqueoMensualidad == 0) {
        $documentoUsuarios = NULL;
    }

    //Hora parqueos
    if (empty($horaParqueos)) {
        validarCampos('vacio', 'Hora Ingreso');
        $cantidadErrores = $cantidadErrores + 1;
        return false;
    } else if (!is_array($hora)) {
        echo "<div class='alert alert-danger'>Lo sentimos, no ingreso una hora válida.</div>";
        $cantidadErrores = $cantidadErrores + 1;
        return false;
    }

    //Realizamos consulta para revisar que tipo de vehículo está registrando
    $consultaTipo   = "SELECT vehiculos.tipoVehiculos FROM `vehiculos` WHERE placaVehiculos = '$placaVehiculos'";
    $ejecutarTipo   = mysqli_query($conexion, $consultaTipo);
    $fetchTipo      = mysqli_fetch_array($ejecutarTipo);

    if ($parqueoMensualidad == 1) {
        if (@$tipoVehiculosMes == $idMotocicleta) {
            if ($cantidadCascos == 0) {
                validarCampos('vacio', 'Cantidad Cascos');
                $cantidadErrores = $cantidadErrores + 1;
                return false;
            }

            if (empty($casilleroCascos)) {
                validarCampos('vacio', 'Nª Casillero');
                $cantidadErrores = $cantidadErrores + 1;
                return false;
            }
        }
    } else {
        if (@$tipoVehiculosHoras == $idMotocicleta) {
            if ($cantidadCascos == 0) {
                validarCampos('vacio', 'Cantidad Cascos');
                $cantidadErrores = $cantidadErrores + 1;
                return false;
            }

            if (empty($casilleroCascos)) {
                validarCampos('vacio', 'Nª Casillero');
                $cantidadErrores = $cantidadErrores + 1;
                return false;
            }
        }
    }


    if ($cantidadErrores == 0) {
        if ($parqueoMensualidad == 1) {

            //Validamos que no se haya modificado el propietario del vehículo, si es así, lo editamos por el nuevo.
            $sqlInfo =   "SELECT
                                documentoUsuarios,
                                tipoVehiculos
                            FROM
                                vehiculos
                            WHERE
                                placaVehiculos = '$placaVehiculos'";

            $ejecutarInfo    = mysqli_query($conexion, $sqlInfo);
            $info   = mysqli_fetch_row($ejecutarInfo);

            //Si es diferente el usuario registrado al usuario ingresado, se modifica en bd su propietario
            if ($info[0] != $documentoUsuarios) {

                $sqlCliente =   "UPDATE
                                    vehiculos
                                SET
                                    documentoUsuarios = '$documentoUsuarios'
                                WHERE
                                    placaVehiculos = '$placaVehiculos'";
                $editamosCliente = mysqli_query($conexion, $sqlCliente);
            }

            //Si es diferente el tipo de vehiculos ingresado, procedemos a editarlo
            if ($info[1] != $tipoVehiculosMes) {
                $sqlVehiculo =  "UPDATE
                                    vehiculos
                                SET
                                    tipoVehiculos = '$tipoVehiculosMes'
                                WHERE
                                    placaVehiculos = '$placaVehiculos'";

                $editamosVehiculo = mysqli_query($conexion, $sqlVehiculo);
            }

            if ($tipoVehiculosMes != $idMotocicleta) {
                $cantidadCascos = '0';
            }

            registrarHistParqueo($conexion, $placaVehiculos, 'Ingreso A Parqueadero');

            $consulta           =   "INSERT INTO
                                        `parqueos` (
                                            `documentoUsuarios`,
                                            `placaVehiculos`,
                                            `horaIngresoParqueos`,
                                            `nitEmpresas`,
                                            `registroPor`,
                                            `fechaRegistro`,
                                            `cantidadCascos`,
                                            `casilleroCascos`,
                                            diaParqueos,
                                            lavadaParqueos,
                                            mensualidadParqueos,
                                            idParqueosEmpresa
                                        )
                                    VALUES
                                        (
                                            '$documentoUsuarios',
                                            '$placaVehiculos',
                                            '$horaParqueos',
                                            '$_SESSION[nitEmpresas]',
                                            '$_SESSION[documentoUsuarios]',
                                            '$fechaRegistros',
                                            '$cantidadCascos',
                                            '$casilleroCascos',
                                            '$fechaHoy[0]',
                                            '$lavadaParqueos',
                                            '1',
                                            $id
                                        )";
            $ejecutarConsulta   = mysqli_query($conexion, $consulta);

            if ($ejecutarConsulta) {
                echo $siRegistros;
            } else {
                echo $noRegistros;
            }
        }
    }
}
