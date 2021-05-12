<?php

@$contadorErrores = 0;

if (isset($_POST['submit'])) {

    @$documentoUsuarios  = $_POST['documentoUsuarios'];
    @$placaVehiculos     = $_POST['placaVehiculos'];
    @$celular1Usuarios   = $_POST['celular1Usuarios'];
    @$tipoVehiculos      = $_POST['tipoVehiculos'];

    $i = strlen($documentoUsuarios) - 4;
    $passDefecto = substr($documentoUsuarios, $i, 4);


    //Validamos documentoUsuarios
    $consultaClientes = "SELECT * FROM usuarios WHERE documentoUsuarios = '".$documentoUsuarios."'";
    $ejecutaClientes = mysqli_query($conexion, $consultaClientes);
    $contadorClientes = mysqli_num_rows($ejecutaClientes);

    if (empty($documentoUsuarios)) {
        validarCampos('vacio', 'Documento');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ($contadorClientes >= 1) {
        validarCampos('noExiste', 'Documento');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($documentoUsuarios) >= $C = 15) {
        validarCampos('caracteres', 'Documento', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo celular 1
    if (empty($celular1Usuarios)) {
        validarCampos('vacio', 'Celular');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($celular1Usuarios) > $C = 10) {
        validarCampos('caracteres', 'Celular', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($celular1Usuarios)) {
        validarCampos('numeros', 'Celular');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos tipo vehiculos
    if (empty($tipoVehiculos)) {
        validarCampos('seleccionar', 'Tipo de Vehículo');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    if ($contadorErrores == 0) {

        //Registro en la tabla vehiculos
        $consultaVehiculos = "INSERT INTO vehiculos (placaVehiculos, registradoPor, fechaRegistros, empresaRegistros, documentoUsuarios, tipoVehiculos) VALUES ('$placaVehiculos', '$_SESSION[documentoUsuarios]', '$fechaRegistros', '$_SESSION[nitEmpresas]', '$documentoUsuarios', $tipoVehiculos)";
        $ejecutarVehiculos = mysqli_query($conexion, $consultaVehiculos);

        //Registramos en la tabla de usuarios
        $consultaUsuarios = "INSERT INTO usuarios (documentoUsuarios, passUsuarios, fechaRegistroUsuarios, passDefectoUsuarios, nitEmpresas, celular1Usuarios, idRoles) VALUES ('$documentoUsuarios', '$passDefecto', '$fechaRegistros', '$passDefecto', '$_SESSION[nitEmpresas]', '$celular1Usuarios', '$idClienteEmpresas')";
        $ejecutarUsuarios = mysqli_query($conexion, $consultaUsuarios);

        //Editamos el propietario del vehículo
        $updatePropietario = "UPDATE vehiculos SET documentoUsuarios = '$documentoUsuarios' WHERE placaVehiculos = '$placaVehiculos'";
        $ejecutarPropietario = mysqli_query($conexion, $updatePropietario);

        $updateParqueo = "UPDATE parqueos SET documentoUsuarios = '$documentoUsuarios' WHERE placaVehiculos = '$placaVehiculos'";
        $ejecutarParqueo = mysqli_query($conexion, $updateParqueo);

        if ($ejecutarUsuarios && $ejecutarVehiculos && $ejecutarPropietario && $ejecutarParqueo) {
            echo $siRegistros;
            echo "<script>Window.Close()</script>";
        } else {
            echo $noRegistros;
        }
    }
}