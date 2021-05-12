<?php
$contadorErrores = 0;

    if  (isset($_POST['submit'])) {

        $placa1Vehiculos    = $_POST['placaVehiculos'];
        $tipoVehiculoss     = $_POST['tipoVehiculos'];
        $colorVehiculos     = $_POST['colorVehiculos'];
        $idMarcaVehiculos   = $_POST['idMarcaVehiculos'];

        //Verificamos desde que campo se está buscando la información y damos valor
        if ($_POST['documento1Usuarios'] == "") {
            $documentoUsuarios = $_POST['documento2Usuarios'];
        } else {
            $documentoUsuarios = $_POST['documento1Usuarios'];
        }

        //Guardamos la placa en un solo string en mayúsculas
        @$placaVehiculos = strtoupper($placa1Vehiculos);

        //Verificamos si el vehículao ya está registrado
        @$consultaPlaca = "SELECT * FROM vehiculos WHERE placaVehiculos = '$placaVehiculos' AND nitEmpresas = '$_SESSION[nitEmpresas]'";
        @$ejecutarPlaca = mysqli_query($conexion, $consultaPlaca);
        @$rowPlaca = mysqli_num_rows($ejecutarPlaca);

        //Verificamos que el cliente exista o no
        @$consultaUsuario = "SELECT * FROM usuarios WHERE documentoUsuarios = '$documentoUsuarios'";
        @$ejecutarUsuario = mysqli_query($conexion, $consultaUsuario);
        @$rowUsuarios = mysqli_num_rows($ejecutarUsuario);

        //Hacemos las validaciones
        //Placa
        if (empty($placaVehiculos)) {
            validarCampos('vacio', 'Placa');
            $contadorErrores = $contadorErrores + 1;
            return false;
        } elseif ($rowPlaca >= 1) {
            validarCampos('noExiste', 'Vehículo');
            $contadorErrores = $contadorErrores + 1;
            return false;
        } elseif (strlen($placaVehiculos) < $C = 7) {
            echo "<div class='alert alert-danger'>Lo sentimos, la placa que ingresó no es válida.</div>";
            $contadorErrores = $contadorErrores + 1;
            return false;
        } elseif (strlen($placaVehiculos) > $C = 7) {
            validarCampos('caracteres', 'Placa', $C);
            $contadorErrores = $contadorErrores + 1;
            return false;
        }

        //tipo de vehículo
        if (empty($tipoVehiculoss)) {
            validarCampos('seleccionar', 'Tipo de vehículo');
            $contadorErrores = $contadorErrores + 1;
            return false;
        }

        //color de vehículos
        if (empty($colorVehiculos)) {
            validarCampos('vacio', 'Color');
            $contadorErrores = $contadorErrores + 1;
            return false;
        } elseif (strlen($colorVehiculos) > $C = 20) {
            validarCampos('caracteres', 'Color', $C);
            $contadorErrores = $contadorErrores + 1;
            return false;
        }

        //Marca
        if (empty($idMarcaVehiculos)) {
            validarCampos('seleccionar', 'Marca de Vehículos');
            $contadorErrores = $contadorErrores + 1;
            return false;
        }

        //Usuarios
        if (empty($documentoUsuarios)) {
            validarCampos('vacio', 'Propietario');
            $contadorErrores = $contadorErrores + 1;
            return false;
        } elseif ($rowUsuarios == 0) {
            echo "<div class='alert alert-danger'>Lo sentimos, el propietario que està buscando, no se encuentra registrado.</div>";
            $contadorErrores = $contadorErrores + 1;
            return false;
        }

        if ($contadorErrores == 0) {

            $consulta           = "INSERT INTO `vehiculos` (`placaVehiculos`, `tipoVehiculos`, `colorVehiculos`, `marcaVehiculos`, `registradoPor`, `fechaRegistros`, `empresaRegistros`, `documentoUsuarios`, `controlVehiculos`, `nitEmpresas`) VALUES ('$placaVehiculos', '$tipoVehiculoss', '$colorVehiculos', '$idMarcaVehiculos', '$_SESSION[documentoUsuarios]', '$fechaRegistros', '$_SESSION[nitEmpresas]', '$documentoUsuarios', '1', '$_SESSION[nitEmpresas]')";
            $ejecutarConsulta   = mysqli_query($conexion, $consulta);

            if ($ejecutarConsulta) {
                echo $siRegistros;
            } else {
                echo $noRegistros;
            }
        }
    }
?>