<?php
session_start();
include_once('../estructura/conexion.php');
include_once('../estructura/variablesGlobales.php');

$documentoUsuarios      = $_POST['documentoUsuarios'];
$billete100000          = $_POST['billete100000'];
$billete50000           = $_POST['billete50000'];
$billete20000           = $_POST['billete20000'];
$billete10000           = $_POST['billete10000'];
$billete5000            = $_POST['billete5000'];
$billete2000            = $_POST['billete2000'];
$billete1000            = $_POST['billete1000'];
$moneda1000             = $_POST['moneda1000'];
$moneda500              = $_POST['moneda500'];
$moneda200              = $_POST['moneda200'];
$moneda100              = $_POST['moneda100'];
$moneda50               = $_POST['moneda50'];
$cantidadTotalBilletes  = $_POST['cantidadTotalBilletes'];
$cantidadTotalMonedas   = $_POST['cantidadTotalMonedas'];
$valorTotalBilletes     = $_POST['valorTotalBilletes'];
$valorTotalMonedas      = $_POST['valorTotalMonedas'];

print_r($_POST);

echo $sqlI = "INSERT INTO
        arqueos (
            documentoUsuarios,
            billete100Arqueos,
            billete50Arqueos,
            billete20Arqueos,
            billete10Arqueos,
            billete5Arqueos,
            billete2Arqueos,
            billete1Arqueos,
            moneda100Arqueos,
            moneda50Arqueos,
            moneda20Arqueos,
            moneda10Arqueos,
            moneda5Arqueos,
            cantidadTotalBilletes,
            cantidadTotalMonedas,
            valorTotalBilletes,
            valorTotalMonedas,
            nitEmpresas,
            fechaRegistro
        )
        VALUES
        (
            '$documentoUsuarios',
            '$billete100000',
            '$billete50000',
            '$billete20000',
            '$billete10000',
            '$billete5000',
            '$billete2000',
            '$billete1000',
            '$moneda1000',
            '$moneda500',
            '$moneda200',
            '$moneda100',
            '$moneda50',
            '$cantidadTotalBilletes',
            '$cantidadTotalMonedas',
            '$valorTotalBilletes',
            '$valorTotalMonedas',
            '$_SESSION[nitEmpresas]',
            '$fechaRegistros'
        )";
$insert = mysqli_query($conexion, $sqlI);

$sql = "SELECT CASE WHEN
            ISNULL(idArqueos) THEN 1 ELSE MAX(idArqueos)
        END
        FROM
            arqueos";
$arqueo = mysqli_query($conexion, $sql);
$idArqueo = mysqli_fetch_array($arqueo);

if ($arqueo && $insert) {
    echo "<script>window.location.href = '../vistas/caja/resultadosArqueo.php?id=" . $idArqueo[0] . "'</script>";
}
