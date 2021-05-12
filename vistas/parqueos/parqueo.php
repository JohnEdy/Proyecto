<?php $menuInformación = 'informacion'; ?>
<?php require_once('../../estructura/header.php'); ?>
<?php
$consultaParqueos = "SELECT usuarios.nombre1Usuarios, usuarios.apellido1Usuarios, parqueos.placaVehiculos, parqueos.horaIngresoParqueos, parqueos.fechaRegistro, parqueos.estadoParqueos, parqueos.idParqueos, usuarios.nombre2Usuarios, usuarios.apellido2Usuarios FROM parqueos INNER JOIN usuarios ON usuarios.documentoUsuarios = parqueos.documentoUsuarios WHERE parqueos.documentoUsuarios = '$_SESSION[documentoUsuarios]' ORDER BY parqueos.fechaRegistro DESC";
$ejecutarParqueos = mysqli_query($conexion, $consultaParqueos);
$fetchParqueos = mysqli_fetch_all($ejecutarParqueos);
?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas && $_SESSION['idRoles'] != $idClienteEmpresas ) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>

<p class="titulos">Consultar Parqueos</p>

<div class="container-menu">
    <div class="table-responsive">
        <table class="table table-sm table-hover table-light" id="table" style="width: 100%;">
            <thead>
                <th>Usuario</th>
                <th>Placa</th>
                <th>Hora Ingreso</th>
                <th>Fecha Ingreso</th>
                <th>Estado</th>
                <th>Ver</th>
            </thead>
            <tbody>
                <?php foreach ($fetchParqueos as $key => $value) : ?>
                    <tr>
                        <td><?php echo $value[0] . " " . $value[7] . " " . $value[1] . " " . $value[8] ?></td>
                        <td><?php echo $value[2] ?></td>
                        <td><?php echo $value[3] ?></td>
                        <td>
                            <?php
                            $fecha = explode(" ", $value[4]);
                            echo $fecha[0];
                            ?>
                        </td>
                        <td><?php echo $estadoParqueos[$value[5]] ?></td>
                        <td>
                            <a href="verParqueo.php?id=<?php echo $value[6] ?>" data-toggle="tooltip" title="Ver Información"><?php echo $btnVer ?></a>
                            <?php if ($value[5] == 2 || $value[5] == 3) { ?>
                                <a target="_blank" href="../PDF/pdfParqueos.php?id=<?php echo $value[6] ?>" data-toggle="tooltip" title="Ver Información"><?php echo $btnFacturass ?></a>
                            <?php } ?>
                            <?php if ($value[5] == 1) { ?>
                                <a href="../configuraciones/retirarVehiculo.php?id=<?php echo $value[6] ?>"><?php echo $btnRetirar ?></a>
                            <?php } ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<?php require_once('../../estructura/footer.php') ?>