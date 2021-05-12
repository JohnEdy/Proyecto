<?php
@include_once('../estructura/conexion.php');
@include_once('../estructura/variablesGlobales.php');
@session_start();

$cantiTotalArts         = explode(',', $_POST['cantiTotalArt']);
$idArticuloCierres      = explode(',', $_POST['idArticuloCierre']);
$articulos              = "<p><span style='font-weight: bold'>ARTÍCULOS ADQUIRIDOS:</span></p><ul>";
$i                      = 0;
$totalCompra            = 0;

//Realizamos el insert de la cabecera de la venta de la factura
$sqlCabecera = "INSERT INTO
                cabeceraVentas (
                    documentoUsuarios,
                    fechaRegistro,
                    nitEmpresas,
                    registroPor,
                    carritoCompras
                )
                VALUES
                (
                    '$_SESSION[documentoUsuarios]',
                    '$fechaRegistros',
                    '$_SESSION[nitEmpresas]',
                    '$_SESSION[documentoUsuarios]',
                    '1'
                )";
$insertCabecera = mysqli_query($conexion, $sqlCabecera);

if ($insertCabecera) {

    //Traemos el id que acabamos de registrar
    $sql = "SELECT MAX(idCabecera) FROM cabeceraVentas";
    $idCabecera = mysqli_fetch_array(mysqli_query($conexion, $sql));

    foreach ($idArticuloCierres as $key => $idArticuloCierre) {
        //Realizamos el update de la cantidad de cada uno de los artículos para dejarlo con la cantidad actual
        $sqlCantArt     = "SELECT cantidadArticulos, nombreArticulos, precioArticulos FROM articulos WHERE idArticulos = '$idArticuloCierre'";
        $cantidad       = mysqli_fetch_array(mysqli_query($conexion, $sqlCantArt));

        $cantFinal      = $cantidad[0] - $cantiTotalArts[$i];
        $update         = "UPDATE articulos SET cantidadArticulos = '$cantFinal' WHERE idArticulos = '$idArticuloCierre'";
        $ejecutarUpdate = mysqli_query($conexion, $update);

        //Realizamos la creaciòn del listado de artìculos para enviarla por correo
        $articulos = $articulos . "<li>" . $cantidad[1] . " Cant. " . $cantiTotalArts[$i] . " Unidad(es)</li>";

        //Realizamos la suma para dar el valor final de la compra
        $totalCompra = ($cantidad[2] * $cantiTotalArts[$i]) + $totalCompra;

        //Eliminamos los datos que se han enviado por el carritoCompras
        $sql = "DELETE FROM carritoCompras WHERE idArticulo = '$idArticuloCierre' AND documentoUsuarios = '$_SESSION[documentoUsuarios]' AND nitEmpresas = '$_SESSION[nitEmpresas]'";
        mysqli_query($conexion, $sql);

        //Realizamos el registro en la tabla final para cerrar la venta
        $insertVenta = "INSERT INTO
                            articulosVentas (
                                idArticulo,
                                cantidadVentas,
                                fechaVentas,
                                idCabecera,
                                nitEmpresas
                            )
                            VALUES
                            (
                                '$idArticuloCierre',
                                '$cantiTotalArts[$i]',
                                '$fechaRegistros',
                                '$idCabecera[0]',
                                '$_SESSION[nitEmpresas]'
                            )";
        $ejecutarVenta = mysqli_query($conexion, $insertVenta);

        $i++;
    }

    $articulos = $articulos . "</ul>";
}
//Le damos el valor final de la compra a la cabecera
$sql = "UPDATE cabeceraVentas SET precioCabecera = '$totalCompra' WHERE idCabecera = '$idCabecera[0]'";
mysqli_query($conexion, $sql);

//Enviamos el correo a los administradores del parqueosCajero y el cliente final
$sql = "SELECT nombre1Usuarios, apellido1Usuarios, emailUsuarios FROM usuarios WHERE (nitEmpresas = '$_SESSION[nitEmpresas]' AND idRoles = '$idAdministradorEmpresas') OR (documentoUsuarios = '$_SESSION[documentoUsuarios]')";
$emailUsuarios = mysqli_fetch_all(mysqli_query($conexion, $sql));

//Buscamos la información del usuario que esta enviando la compra
$sql = "SELECT usuarios.nombre1Usuarios, usuarios.apellido1Usuarios, usuarios.celular1Usuarios, usuarios.emailUsuarios, empresas.direccionEmpresas FROM usuarios INNER JOIN empresas ON empresas.nitEmpresas = usuarios.nitEmpresas WHERE documentoUsuarios = '$_SESSION[documentoUsuarios]'";
$infoCliente = mysqli_fetch_all(mysqli_query($conexion, $sql));

$asunto     = "Compra Carrito de Compras SoftPark " . date("Y-m-d");
$mensaje    = "<h1 style='text-align: center;'>Soft Park le informa</h1>
                <p style='text-align: left; font-weight: bold'>El usuario " . $_SESSION['documentoUsuarios'] . " ha realizado compra de artículos por el carrito de compras:</p>
                <div style='text-align: center;'>
                    <p><span style='font-weight: bold'>Fecha y Hora: </span>" . date("Y-m-d H:m:i") . "<span></span></p>
                    <p><span style='font-weight: bold'>Nombre Cliente: </span>" . $infoCliente[0][0] . " " . $infoCliente[0][1] . "<span></span></p>
                    <p><span style='font-weight: bold'>Celular Cliente: </span>" . $infoCliente[0][2] . "<span></span></p>
                    <p><span style='font-weight: bold'>Correo Cliente: </span>" . $infoCliente[0][3] . "<span></span></p>
                    <p><span style='font-weight: bold'>Dirección Parqueadero: </span>" . $infoCliente[0][4] . "<span></span></p>
                    <br>
                </div>
                " . $articulos . "
                <br>
                <br>";

foreach ($emailUsuarios as $emailUsuario) {
    enviarCorreo($emailUsuario[2], $emailUsuario[0]. " " . $emailUsuario[1] , $mensaje, $asunto);
}

$resultados[0] = 1;
$resultados[1] = "<div class='alert alert-success'>Tu compra se ha registrado con éxito. Los datos te serán enviados al correo, para recoger tus artículos en el parqueadero.</div>";
echo json_encode($resultados);