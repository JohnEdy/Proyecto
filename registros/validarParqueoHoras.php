<?php

if (@$_GET['add'] == 1) {
    echo $siRegistros;
} else if (@$_GET['add'] == 2) {
    echo $noRegistros;
}

$cantidadErrores = 0;

if (isset($_POST['submit'])) {

    @$placaVehiculos        = strtoupper($_POST['placaVehiculos']);
    @$horaParqueos          = $_POST['horaParqueos'];
    @$cantidadCascos        = $_POST['cantidadCascos'];
    @$casilleroCascos       = $_POST['casilleroCascos'];
    @$retirarPor            = $_POST['retirarPor'];
    @$tipoVehiculosHoras    = $_POST['tipoVehiculos'];
    @$imprimirFactura       = $_POST['imprimirFactura'];
    @$enviarFactura         = $_POST['enviarFactura'];
    @$emailUsuarios         = $_POST['emailUsuarios'];

    if (empty($_POST['lavadaParqueos'])) {
        @$lavadaParqueos     = 0;
    } else {
        @$lavadaParqueos     = $_POST['lavadaParqueos'];
    }

    //Verificamos que el vehículo a parquear no tenga un parqueo activo
    $consultaParqueo    = "SELECT * FROM parqueos WHERE (estadoParqueos = '1' OR estadoParqueos = '2') AND placaVehiculos = '$placaVehiculos' AND nitEmpresas = '$_SESSION[nitEmpresas]'";
    $ejecutarParqueo    = mysqli_query($conexion, $consultaParqueo);
    $rowParqueo         = mysqli_num_rows($ejecutarParqueo);

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
    }

    //Validamos el tipo de vehiculo
    if (empty($tipoVehiculosHoras)) {
        validarCampos('seleccionar', 'Tipo Vehículos');
        $cantidadErrores = $cantidadErrores + 1;
        return false;
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
    } else {
        $cantidadCascos = 0;
    }

    if (empty($imprimirFactura) && empty($enviarFactura)) {
        validarCampos('vacio', 'Metodo Retiro');
        $cantidadErrores = $cantidadErrores + 1;
        return false;
    }

    if (@$enviarFactura == '1' && empty($emailUsuarios)) {
        validarCampos('vacio', 'Correo Electrónico');
        $cantidadErrores = $cantidadErrores + 1;
        return false;
    }

    if ($cantidadErrores == 0) {
        if ($parqueoMensualidad == 0) {

            // //Realizamos una consulta para revisar si el vehículo se encuentra registrado
            $sqlVehiculo = "SELECT * FROM vehiculos WHERE placaVehiculos = '$placaVehiculos' AND nitEmpresas = '$_SESSION[nitEmpresas]'";
            $ejecutarVehiculo = mysqli_query($conexion, $sqlVehiculo);
            $rowsVehiculos = mysqli_num_rows($ejecutarVehiculo);

            if ($rowsVehiculos == 0) {
                $insertVehiculos = "INSERT INTO vehiculos (placaVehiculos, tipoVehiculos, nitEmpresas, fechaRegistros) VALUES ('$placaVehiculos', '$tipoVehiculosHoras', '$_SESSION[nitEmpresas]', '$fechaRegistros')";
                $ejecutarVehiculo = mysqli_query($conexion, $insertVehiculos);

                if ($ejecutarVehiculo) {
                    $insertVehiculo = true;
                } else {
                    $insertVehiculo = false;
                    echo "<script>alert('Error al registra el vehículo')</script>";
                }
            } else {
                $insertVehiculo = true;
            }
            //Insertamos el parqueo en su tabla
            $fechaHoy = explode(" ", $fechaRegistros);

            $consulta           =   "INSERT INTO
                                        `parqueos` (
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
                                            '$placaVehiculos',
                                            '$horaParqueos',
                                            '$_SESSION[nitEmpresas]',
                                            '$_SESSION[documentoUsuarios]',
                                            '$fechaRegistros',
                                            '$cantidadCascos',
                                            '$casilleroCascos',
                                            '$fechaHoy[0]',
                                            '$lavadaParqueos',
                                            '$_POST[mensualidadParqueos]'
                                            ,$id
                                        )";
            $ejecutarConsulta   = mysqli_query($conexion, $consulta);

            //Seleccionamos el id del Parqueo recien registrado
            $sqlIdParqueo = "SELECT MAX(idParqueos) FROM parqueos";
            $idParqueo = mysqli_fetch_array(mysqli_query($conexion, $sqlIdParqueo));

            generarCodigo($conexion, 6, $idParqueo[0]);

            if ($imprimirFactura == 1) {
                echo "<script>window.open('../PDF/pdfParqueos.php?id=$idParqueo[0]', '_blank');</script>";
            }

            if ($enviarFactura == 1) {

                if (@$tipoVehiculosHoras == $idMotocicleta) {
                    $motocicleta =  "<p><span style='font-weight: bold'>Cantidad Cascos: </span>" . $cantidadCascos . "<span></span></p>
                                    <p><span style='font-weight: bold'>Ubicación de los mismos: </span> casillero Nº" . $casilleroCascos . "<span></span></p>";
                } else {
                    $motocicleta = '';
                }

                $asunto     = "Retiro Vehiculo " . $placaVehiculos;
                $mensaje    = "<h1 style='text-align: center;'>Apreciado(a) usuario(a), Soft Park encuentre aquí sus datos:</h1>
                <p style='text-align: left; font-weight: bold'>Sus Datos:</p>
                <div style='text-align: center;'>
                    <p><span style='font-weight: bold'>Su vehìculo: </span>" . $placaVehiculos . "<span></span></p>
                    <p><span style='font-weight: bold'>Su hora de ingreso: </span>" . $horaParqueos . "<span></span></p>
                    <p><span style='font-weight: bold'>Su fecha de ingreso: </span>" . $fechaRegistros . "<span></span></p>
                    " . $motocicleta . "
                    <br>
                    <p>Lo invitamos a descargar su factura dando click en el siguiente botón: </p>
                    <p><a href='" . $enlaceCorreos . "/PDF/pdfParqueos.php?id=" . $idParqueo[0] . "' style='background-color: #edc847; border-radius: 5pt; padding: 5pt; font-weight: bold; text-decoration: none; color: black;'>Descargar Factura</a></p>
                </div>
                <br>
                <p style='text-align: left; font-weight: bold; font-size: 8pt; text-decoration: none;'>Si al dar click en el boton, no lo redirecciona automaticamente. Copie y pegue el siguiente enlacen en su navegador: " . $enlaceCorreos . "vistas/PDF/pdfParqueos.php?id=" . $idParqueo[0] . "</p>";

                enviarCorreo($emailUsuarios, $emailUsuarios, $mensaje, $asunto);
            }

            if ($ejecutarConsulta && $insertVehiculo) {
                echo $siRegistros;
            } else {
                echo $noRegistros;
            }
        }
    }
}
