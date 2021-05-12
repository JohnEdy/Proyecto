<?php
$contadorErrores = 0;
if (@$_GET['i'] == 1) {
    echo $siEditar;
} else if (@$_GET['i'] == 2) {
    echo $siRegistros;
}

if (isset($_POST['submit'])) {

    @$horasParametros           = $_POST['horasParametros'];
    @$mesesParametros           = $_POST['mesesParametros'];
    @$lavadaParametros          = $_POST['lavadaParametros'];
    @$articulosParametros       = $_POST['articulosParametros'];

    @$valorHorasParqueaderos    = $_POST['valorHorasParqueaderos'];
    @$idHorasParqueaderos       = $_POST['idHorasParqueaderos'];

    @$valorMesesParqueaderos    = $_POST['valorMesesParqueaderos'];
    @$idMesesParqueaderos       = $_POST['idMesesParqueaderos'];

    @$valorLavadasParqueaderos  = $_POST['valorLavadasParqueaderos'];
    @$idLavadasParqueaderos     = $_POST['idLavadasParqueaderos'];

    if (empty($horasParametros)) {
        $horasParametros = 0;
    }
    if (empty($mesesParametros)) {
        $mesesParametros = 0;
    }
    if (empty($lavadaParametros)) {
        $lavadaParametros = 0;
    }
    if (empty($articulosParametros)) {
        $articulosParametros = 0;
    }

    $horas = 0;
    //Editamos los valores de las horas en su tabla
    foreach ($idHorasParqueaderos as $valueIdHoras) {
        $sql =  "UPDATE
                    `tiposVehiculos`
                SET
                    horaTiposVehiculos = '$valorHorasParqueaderos[$horas]'
                WHERE
                    idTipoVehiculos = '$valueIdHoras'";
        mysqli_query($conexion, $sql);
        $horas++;
    }

    $meses = 0;
    //Editamos los valores de los meses en su tabla
    foreach ($idMesesParqueaderos as $valueIdHoras) {
        $sql =  "UPDATE
                    `tiposVehiculos`
                SET
                    mesTiposVehiculos = '$valorMesesParqueaderos[$meses]'
                WHERE
                    idTipoVehiculos = '$valueIdHoras'";
        mysqli_query($conexion, $sql);
        $meses++;
    }

    $lavadas = 0;
    //Editamos los valores de las horas en su tabla
    foreach ($idLavadasParqueaderos as $valueIdHoras) {
        $sql =  "UPDATE
                    `tiposVehiculos`
                SET
                    lavadaTiposVehiculos = '$valorLavadasParqueaderos[$lavadas]'
                WHERE
                    idTipoVehiculos = '$valueIdHoras'";
        mysqli_query($conexion, $sql);
        $lavadas++;
    }

    if ($contadorErrores == 0) {

        if ($update == 0) {
            $consultaInsert =   "INSERT INTO `parametros`(
                                        `horasParametros`,
                                        `mesesParametros`,
                                        `articulosParametros`,
                                        `lavadaParametros`,
                                        `registradoPor`,
                                        `fechaRegistro`,
                                        `nitEmpresas`
                                    )
                                    VALUES(
                                        '$horasParametros',
                                        '$mesesParametros',
                                        '$articulosParametros',
                                        '$lavadaParametros',
                                        '$_SESSION[documentoUsuarios]',
                                        '$fechaRegistros',
                                        '$_SESSION[nitEmpresas]'
                                    )";
            $ejecutarInsert = mysqli_query($conexion, $consultaInsert);

            if ($ejecutarInsert) {
                echo $siRegistros;
                echo "<script>window.location.href = 'configuracion.php?i=2';</script>";
            } else {
                echo $noRegistros;
            }
        } else if ($update == 1) {
            $consultaUpdate =   "UPDATE
                                        parametros
                                    SET
                                        `horasParametros`       = '$horasParametros',
                                        `mesesParametros`       = '$mesesParametros',
                                        `articulosParametros`   = '$articulosParametros',
                                        `lavadaParametros`      = '$lavadaParametros'
                                    WHERE
                                        nitEmpresas = '$_SESSION[nitEmpresas]'";
            $ejecutarUpdate = mysqli_query($conexion, $consultaUpdate);

            if ($ejecutarUpdate) {
                echo "<script>window.location.href = 'configuracion.php?i=1';</script>";
                echo $siEditar;
            } else {
                echo $noEditar;
            }
        } else if ($update == 3) {

            $nitEmpresas            = $_POST['nitEmpresas'];
            $mesesParametros        = $_POST['mesesParametros'];
            $lavadaParametros       = $_POST['lavadaParametros'];
            $articulosParametros    = $_POST['articulosParametros'];

            $consultaUpdate = "UPDATE parametros SET mesesParametros = '$mesesParametros', lavadaParametros = '$lavadaParametros', `articulosParametros` = '$articulosParametros' WHERE nitEmpresas = '$nitEmpresas'";
            $ejecutarUpdate = mysqli_query($conexion, $consultaUpdate);

            if ($ejecutarUpdate) {
                echo $siEditar;
            } else {
                echo $noEditar;
            }
        }
    }
}
