<?php
if (isset($_POST['submit'])) {

    $idCabecera         = $_POST['idCabecera'];
    $documentoUsuarios  = $_POST['documentoUsuarios'];
    $fechaRegistross    = $_POST['fechaRegistros'];
    $idArticulos        = $_POST['idArticulos'];
    $cantidadArticulos  = $_POST['cantidadArticulos'];
    $precioFinal        = 0;

    if (empty($idArticulos[0]) || empty($cantidadArticulos[0])) {
        echo "<div class='alert alert-danger'>Debe seleccionar al menos un artículo para la venta</div>";
        return false;
    }

    $consultaCabecera   =   "INSERT INTO
                                `cabeceraVentas`(
                                    `documentoUsuarios`,
                                    `fechaRegistro`,
                                    `nitEmpresas`,
                                    registroPor
                                )
                            VALUES
                                (
                                    '$documentoUsuarios',
                                    '$fechaRegistross',
                                    '$_SESSION[nitEmpresas]',
                                    '$_SESSION[documentoUsuarios]'
                                )";
    $registrarCabecera  = mysqli_query($conexion, $consultaCabecera);

    if ($registrarCabecera) {
        $id[0] = $idCabecera + 1;
        echo $siRegistros;

        for ($i=0; $i <= COUNT($idArticulos); $i++) {
            if (!empty($idArticulos[$i]) && !empty($cantidadArticulos[$i])) {
                $consulta = "INSERT INTO
                                `articulosVentas` (
                                    `idArticulo`,
                                    `cantidadVentas`,
                                    `fechaVentas`,
                                    `idCabecera`,
                                    `nitEmpresas`
                                )
                            VALUES
                                (
                                    '$idArticulos[$i]',
                                    '$cantidadArticulos[$i]',
                                    '$fechaRegistross',
                                    '$idCabecera',
                                    '$_SESSION[nitEmpresas]'
                                )";
                $registrar = mysqli_query($conexion, $consulta);

                $select =   "SELECT
                                cantidadArticulos,
                                precioArticulos
                            FROM
                                articulos
                            WHERE
                                idArticulos = '$idArticulos[$i]'";
                $ejecutar = mysqli_query($conexion, $select);
                $cantidad = mysqli_fetch_row($ejecutar);

                @$precioFinal = $precioFinal + ($cantidad[1] * $cantidadArticulos[$i]);
                @$cantidadFinal = $cantidad[0] - $cantidadArticulos[$i];

                $update =   "UPDATE
                                `articulos`
                            SET
                                `cantidadArticulos` = '$cantidadFinal'
                            WHERE
                                `idArticulos` = '$idArticulos[$i]'";
                $ejecutarUpdate = mysqli_query($conexion, $update);
            }
        }

        $updateCabecera = "UPDATE `cabeceraVentas` SET `precioCabecera` = '$precioFinal' WHERE `idCabecera` = '$idCabecera'";
        $ejecutarUpdate = mysqli_query($conexion, $updateCabecera);
    } else {
        echo $noRegistros;
    }


}