<?php
require('../../fpdf/fpdf.php');
include_once('../../estructura/variablesGlobales.php');

$server     = "localhost";
$database   = "proyecto";
$user       = "root";
$pass       = "";

$conexion = mysqli_connect($server, $user, $pass, $database);

//Consultamos los datos del parqueo a mostrar
@$sql               =   "SELECT
                            *
                        FROM
                            parqueos
                            RIGHT JOIN empresas 		ON empresas.nitEmpresas 			= parqueos.nitEmpresas
                            INNER JOIN vehiculos 		ON vehiculos.placaVehiculos 		= parqueos.placaVehiculos
                            INNER JOIN tiposVehiculos 	ON tiposVehiculos.idTipoVehiculos 	= vehiculos.tipoVehiculos
                        WHERE parqueos.idParqueos = '$_GET[id]'";
@$ejecutarSql       = mysqli_query($conexion, @$sql);
@$fetchSql          = mysqli_fetch_assoc(@$ejecutarSql);

@$sqlNombre         = "SELECT nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE documentoUsuarios = '@$fetchSql[registroPor]'";
@$ejecutarSqlNombre = mysqli_query($conexion, @$sqlNombre);
@$fetchSqlNombre    = mysqli_fetch_array(@$ejecutarSqlNombre);

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $server     = "localhost";
        $database   = "proyecto";
        $user       = "root";
        $pass       = "";

        $conexion = mysqli_connect($server, $user, $pass, $database);

        @$sql            = "SELECT * FROM parqueos INNER JOIN empresas ON empresas.nitEmpresas = parqueos.nitEmpresas WHERE parqueos.idParqueos = '$_GET[id]'";
        @$ejecutarSql    = mysqli_query(@$conexion, @$sql);
        @$fetchSql       = mysqli_fetch_array(@$ejecutarSql);

        // Logo
        //$this->Image('logo.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 10);
        // Movernos a la derecha
        $this->Cell(20);
        $this->Cell(20, 4, @$fetchSql['nombreEmpresas'], 0, 0, 'C');
        $this->Ln();
        $this->Cell(20);
        $this->Cell(20, 4, utf8_decode("Nit: " . @$fetchSql['nitEmpresas'] . " REGIMEN COMÚN"), 0, 0, 'C');
        $this->Ln();
        $this->Cell(20);
        $this->Cell(20, 4, utf8_decode(@$fetchSql['direccionEmpresas']), 0, 0, 'C');
        // Salto de línea
        $this->Ln(15);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-30);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 3, "*************************************************************");
        $this->ln();
        $this->MultiCell(0, 3, utf8_decode("LA EMPRESA NO RESPONDE POR DAÑOS, PERDIDAS O DETERIORO OCURRIDOS POR MOTÍN, INCENDIO, TERREMOTO, ATRACOS Y DEMÁS SITUACIONES QUE SE PUEDAN PRESENTAR Y SEAN AJENAS A NUESTRO SERVICIO."), '0', 'C');
        $this->Cell('0', 3, utf8_decode("SOFTWARE CREADO POR: ParkingSoft WEB: www.parkingsoft.com"), '0', '0', 'C');
        // Número de página
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

//Definimos H
@$h = '4';

// Creación del objeto de la clase heredada
@$pdf = new PDF();
@$pdf->AliasNbPages();
@$pdf->AddPage('Portrait', array('80', '120'));
@$pdf->SetFont('Times', '', 10);

//INFORMACIÓN PARQUEO
@$pdf->Cell('0', @$h, utf8_decode("FACTURA Nº: " . @$fetchSql['idParqueos']));
@$pdf->ln();
@$pdf->Cell('0', @$h, utf8_decode("CAJERO Nº: " . @$fetchSql['registroPor']));
@$pdf->ln();
@$pdf->Cell('0', @$h, utf8_decode("HORA DE INGRESO: " . @$fetchSql['horaIngresoParqueos']));
@$pdf->ln();
@$pdf->Cell('0', @$h, utf8_decode("FECHA Y HORA: " . @$fetchSql['fechaRegistro']));
@$pdf->ln('10');

//INFORMACIÓN VEHÍCULO Y RETIRO
@$pdf->Cell('30', @$h, utf8_decode("TIPO: " . @$fetchSql['nombreTipoVehiculos']));
@$pdf->Cell('30', @$h, utf8_decode("PLACA: " . @$fetchSql['placaVehiculos']));

if (@$fetchSql['tipoVehiculos'] == $idMotocicleta) {
    @$pdf->ln();
    @$pdf->Cell('30', @$h, utf8_decode("CASCOS: " . @$fetchSql['cantidadCascos']));
    @$pdf->Cell('30', @$h, utf8_decode("Nº LOCKER: " . @$fetchSql['casilleroCascos']));
}
@$pdf->ln();
@$pdf->Cell('0', @$h, utf8_decode("CÓDIGO: " . desencriptar(@$fetchSql['codigoRetiroParqueos'])), '0', '0', 'C');
@$pdf->ln('10');


@$pdf->Output();
