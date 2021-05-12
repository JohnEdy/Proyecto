<?php
//Variable de control para los erroes encontrados
$errores = 0;

if (isset($_POST['submit'])) {

    $cantidadParqueosHoras  =  $_POST['cantidadParqueosHoras'];
    $cantidadParqueosMeses  =  $_POST['cantidadParqueosMeses'];
    $cantidadArticulos      =  $_POST['cantidadArticulos'];

    //Validamos el primer campo de horas
    if (empty($cantidadParqueosHoras)) {
        validarCampos('vacio', 'Cantidad Horas');
        $errores = $errores + 1;
        return false;
    } else if (!is_numeric($cantidadParqueosHoras)) {
        validarCampos('numeros', 'Cantidad Horas');
        $errores = $errores + 1;
        return false;
    }

    //Validamos el segundo campo de meses
    if (empty($cantidadParqueosMeses)) {
        validarCampos('vacio', 'Cantidad Meses');
        $errores = $errores + 1;
        return false;
    } else if (!is_numeric($cantidadParqueosMeses)) {
        validarCampos('numeros', 'Cantidad Meses');
        $errores = $errores + 1;
        return false;
    }

    //Validamos el segundo campo de meses
    if (empty($cantidadArticulos)) {
        validarCampos('vacio', 'Cantidad Artículos');
        $errores = $errores + 1;
        return false;
    } else if (!is_numeric($cantidadArticulos)) {
        validarCampos('numeros', 'Cantidad Artículos');
        $errores = $errores + 1;
        return false;
    }

    //Si no hay errores, realizamos el registro o actualizaciòn
    if ($errores == 0) {

        //Si la variable de update es 0, insertamos registros nuevos
        if ($updateParametros == 0) {
            $sql =  "INSERT INTO
                        parametrosSoftPark (
                            cantidadParqueosHoras,
                            cantidadParqueosMeses,
                            cantidadArticulos,
                            fechaRegistros,
                            registroPor
                        )
                    VALUES
                        (
                            '$cantidadParqueosHoras',
                            '$cantidadParqueosMeses',
                            '$cantidadArticulos',
                            '$fechaRegistros',
                            '$_SESSION[documentoUsuarios]'
                        )";
            $ejecutar = mysqli_query($conexion, $sql);

            if ($ejecutar) {
                echo $siRegistros;
            } else {
                echo $noRegistros;
            }

            //De lo contrario, actualizamos el registro actual
        } else if ($updateParametros == 1) {
            $sql = "UPDATE
                            parametrosSoftPark
                        SET
                            cantidadParqueosHoras = '$cantidadParqueosHoras',
                            cantidadParqueosMeses = '$cantidadParqueosMeses',
                            cantidadArticulos = '$cantidadArticulos',
                            fechaRegistros = '$fechaRegistros',
                            registroPor = '$_SESSION[documentoUsuarios]'
                        WHERE
                            idParametrosSoftPark = '1'";
            $ejecutar = mysqli_query($conexion, $sql);

            if ($ejecutar) {
                echo $siEditar;
            } else {
                echo $noEditar;
            }
        }
    }
}