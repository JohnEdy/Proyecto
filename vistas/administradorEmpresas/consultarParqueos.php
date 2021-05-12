<?php $menuAdministradores = 'administradores'; ?>
<?php require_once('../../estructura/header.php'); ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='consultarParqueos.php?page=1&&nro=10'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;
?>
<p class="titulos">Consultar Parqueos</p>
<div class="buscador">
    <ul class="nav nav-pills justify-content-end" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#parqueosHoy">Parqueos Hoy</button>
        </li>
        <li class="nav-item" role="presentation">
            <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#parqueosCajero">Parqueos por Cajero</button>
        </li>
        <li class="nav-item" role="presentation">
            <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#parqueosTotal">Consolidado Total</button>
        </li>
        <?php if (isset($_POST['submit']) && $_POST['buscador'] == 'parqueos.fechaRegistro') { ?>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#parqueosFechas">Consolidado Fecha</button>
            </li>
        <?php } ?>
    </ul>
    <p class="tituloSecciones">Buscar</p>
    <form action="" method="POST">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-3">
                <select class="form-control" name="buscador" id="buscador" onclick="opcionesSelect()">
                    <?php
                    if (isset($_POST['submit']) && $_POST['buscador'] == 'parqueos.registroPor') {
                        $registroPor = "selected='selected'";
                    } else if (isset($_POST['submit']) && $_POST['buscador'] == 'parqueos.estadoParqueos') {
                        $estadoParqueoss = "selected='selected'";
                    } else if (isset($_POST['submit']) && $_POST['buscador'] == 'parqueos.fechaRegistro') {
                        $fechaRegistro = "selected='selected'";
                    } else if (isset($_POST['submit']) && $_POST['buscador'] == 'parqueos.placaVehiculos') {
                        $placaVehiculos = "selected='selected'";
                    } else if (isset($_POST['submit']) && $_POST['buscador'] == 'parqueos.documentoUsuarios') {
                        $documentoUsuarios = "selected='selected'";
                    } else if (isset($_POST['submit']) && $_POST['buscador'] == 'parqueos.mensualidadParqueos') {
                        $mensualidadParqueos = "selected='selected'";
                    }

                    ?>
                    <option value="">-- Seleccione --</option>
                    <option <?php echo @$registroPor ?> value="parqueos.registroPor">Cajero</option>
                    <option <?php echo @$estadoParqueoss ?> value="parqueos.estadoParqueos">Estado</option>
                    <option <?php echo @$fechaRegistro ?> value="parqueos.fechaRegistro">Fecha Ingreso</option>
                    <option <?php echo @$placaVehiculos ?> value="parqueos.placaVehiculos">Placa</option>
                    <option <?php echo @$documentoUsuarios ?> value="parqueos.documentoUsuarios">Cliente</option>
                    <?php if (otrosServicios(@$conexion, @$_SESSION['nitEmpresas'], @$configMeses)) { ?>
                        <option <?php echo @$mensualidadParqueos ?> value="parqueos.mensualidadParqueos">Mensualidad</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-4" id="cajero" style="display: none;">
                <?php
                cargarSelect($conexion, "SELECT documentoUsuarios, nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE idRoles = '$idCajeroEmpresas' OR idRoles = '$idAdministradorEmpresas' AND nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombre1Usuarios", "cajeros", "class='form-control'")
                ?>
            </div>
            <div class="col-4" id="estado" style="display: none;">
                <select name="estadoId" id="" class="form-control">
                    <option value="0">-- Seleccione --</option>
                    <?php
                    foreach ($estadoParqueos as $key => $value) {
                        print_r($value);
                        echo "<option value='$key'>$value</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-4" id="fechaIngreso" style="display: none;">
                <input type="text" class="form-control" name="fechaIngreso" id="datepicker" value="<?php echo (isset($_POST['submit'])) ? $_POST['fechaIngreso'] : date("Y-m-d") ?>">
            </div>
            <div class="col-4" id="placa" style="display: none;">
                <?php
                cargarSelect($conexion, "SELECT placaVehiculos, placaVehiculos FROM vehiculos ORDER BY placaVehiculos", "placaVehiculos", "class='form-control'");
                ?>
            </div>
            <div class="col-4" id="usuario" style="display: none;">
                <?php
                cargarSelect($conexion, "SELECT documentoUsuarios, nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE idRoles = '$idClienteEmpresas' AND nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombre1Usuarios", "clienteDocumento", "class='form-control'");
                ?>
            </div>
            <div class="col-4" id="mensualidad" style="display: none;">
                <?php
                if (isset($_POST['submit']) && isset($_POST['mensualidadParqueo'])) {
                    if (@$_POST['mensualidadParqueo'] == 1) {
                        $checkMes1 = "checked";
                    } else if (@$_POST['mensualidadParqueo'] == 0) {
                        $checkMes0 = "checked";
                    }
                } else {
                    $checkMes1 = "checked";
                    $checkMes0 = "";
                }
                ?>
                <span style="margin-right: 40%; margin-left: 10%;"><input <?php echo @$checkMes1 ?> name="mensualidadParqueos" type="radio" value="1" id="mensualidad1"> <label for="mensualidad1">SI</label></span>
                <input name="mensualidadParqueos" <?php echo @$checkMes0 ?> type="radio" value="0" id="mensualidad0"> <label for="mensualidad0">No</label>
            </div>
            <div class="col-2" id="submit" style="display: none;">
                <button type="submit" class="btn btn-primary btn-sm" name="submit" id=""><?php echo $btnBuscar ?>&nbsp;Buscar</button>
            </div>
            <?php if (isset($_POST['submit'])) { ?>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary btn-sm" name="submitLimpiar" id=""><?php echo $btnLimpiar ?>&nbsp;Limpiar</button>
                </div>
            <?php }  ?>
        </div>
    </form>
</div>
<?php
if (isset($_POST['submit']) && !empty($_POST['buscador'])) {
    if ($_POST['buscador'] == "parqueos.registroPor") {
        $resBuscar = "= '$_POST[cajeros]'";
    } else if ($_POST['buscador'] == "parqueos.estadoParqueos") {
        $resBuscar = "= '$_POST[estadoId]'";
    } else if ($_POST['buscador'] == "parqueos.fechaRegistro") {
        $resBuscar = "LIKE '%$_POST[fechaIngreso]%'";
    } else if ($_POST['buscador'] == "parqueos.placaVehiculos") {
        $resBuscar = "= '$_POST[placaVehiculos]'";
    } else if ($_POST['buscador'] == "parqueos.documentoUsuarios") {
        $resBuscar = "= '$_POST[clienteDocumento]'";
    } else if ($_POST['buscador'] == "parqueos.mensualidadParqueos") {
        $resBuscar = "= $_POST[mensualidadParqueos]";
    }

    $buscar = "AND $_POST[buscador] $resBuscar";
} else {
    $buscar = '';
}

$consultaParqueos = "SELECT
                        CASE
                            WHEN ISNULL(usuarios.nombre1Usuarios) THEN parqueos.documentoUsuarios
                            ELSE usuarios.nombre1Usuarios
                        END,
                        usuarios.apellido1Usuarios,
                        parqueos.placaVehiculos,
                        parqueos.horaIngresoParqueos,
                        parqueos.fechaRegistro,
                        parqueos.estadoParqueos,
                        parqueos.idParqueos,
                        usuarios.nombre2Usuarios,
                        usuarios.apellido2Usuarios,
                        parqueos.registroPor,
                        usuariosB.nombre1Usuarios,
                        usuariosB.apellido1Usuarios,
                        CASE
                            WHEN (parqueos.mensualidadParqueos = 1) THEN 'Si'
                            ELSE 'No'
                        END AS 'mesParqueos',
                        parqueos.idParqueosEmpresa
                    FROM
                        parqueos
                        LEFT JOIN usuarios ON usuarios.documentoUsuarios = parqueos.documentoUsuarios
                        INNER JOIN usuarios usuariosB ON usuariosB.documentoUsuarios = parqueos.registroPor
                    WHERE
                        parqueos.nitEmpresas = '$_SESSION[nitEmpresas]' $buscar
                    ORDER BY
                        parqueos.fechaRegistro DESC
                    LIMIT
                        $start,
                        $nroRegistros";
$ejecutarParqueos = mysqli_query($conexion, $consultaParqueos);
$fetchParqueos = mysqli_fetch_all($ejecutarParqueos);

?>

<div class="container-menu">
    <?php if (isset($_POST['submit'])) { ?>
        <p class="tituloSecciones">Resultados Búsqueda</p>
    <?php } ?>
    <div class="table-responsive">
        <div class="cantidadPaginas">
            Mostrando &nbsp;
            <select name="" id="cantidadBusqueda" class="" onchange="enviarCantidadBusqueda('consultarParqueos');">
                <?php foreach ($cantidadPaginacion as $key => $value) { ?>
                    <?php
                    if ($key == $_GET['nro']) {
                        $select = "selected='selected'";
                    } else {
                        $select = "";
                    }
                    ?>
                    <option <?php echo $select ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                <?php } ?>
            </select>
            &nbsp;Registros
        </div>
        <table class="table table-sm table-hover table-light" style="width: 100%;">
            <thead class="table-dark">
                <th>ID</th>
                <th>Título</th>
                <th>Fecha Registro</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Cajero</th>
                <th>Mensualidad</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                <?php if (empty($fetchParqueos)) { ?>
                    <tr>
                        <td colspan="8">
                            <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($fetchParqueos as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value[13] ?></td>
                            <td><?php echo $value[2] ?></td>
                            <td><?php echo $value[3] ?></td>
                            <td>
                                <?php
                                $fecha = explode(" ", $value[4]);
                                echo $fecha[0];
                                ?>
                            </td>
                            <td><?php echo $estadoParqueos[$value[5]] ?></td>
                            <td><?php echo $value[10] . " " . $value[11] ?></td>
                            <td><?php echo $value[12] ?></td>
                            <td style="text-align: center;">
                                <a href="../parqueos/verParqueo.php?id=<?php echo $value[6] ?>" data-toggle="tooltip" title="Ver Información"><?php echo $btnVer ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
            <tfoot class="table-dark">
                <th>ID</th>
                <th>Título</th>
                <th>Fecha Registro</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Cajero</th>
                <th>Mensualidad</th>
                <th>Acciones</th>
            </tfoot>
        </table>
        <?php paginacion($conexion, $consultaParqueos, 'consultarParqueos', @$_GET['page'], $nroRegistros); ?>
    </div>
</div>

<?php
//Información para el parqueo de hoy
$hoy = date("Y-m-d");

//Total Parqueos HOY
$consultaCantidad = "SELECT COUNT(idParqueos) FROM parqueos WHERE fechaRegistro LIKE '%$hoy%' AND parqueos.nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarCantidad = mysqli_query($conexion, $consultaCantidad);
$fetchCantidad = mysqli_fetch_row($ejecutarCantidad);

//Carros HOY
$consultaCarros = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '1' AND parqueos.fechaRegistro LIKE '%$hoy%' AND parqueos.nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarCarros = mysqli_query($conexion, $consultaCarros);
$fetchCarros = mysqli_fetch_row($ejecutarCarros);

//Motos HOY
$consultaMotos = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '2' AND parqueos.fechaRegistro LIKE '%$hoy%' AND parqueos.nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarMotos = mysqli_query($conexion, $consultaMotos);
$fetchMotos = mysqli_fetch_row($ejecutarMotos);

//Cajeros
$consultaCajeros = "SELECT documentoUsuarios, nombre1Usuarios, nombre2Usuarios, apellido1Usuarios, apellido2Usuarios FROM usuarios WHERE nitEmpresas = '$_SESSION[nitEmpresas]' AND (idRoles = '$idCajeroEmpresas' OR idRoles = '$idAdministradorEmpresas')";
$ejecutarCajeros = mysqli_query($conexion, $consultaCajeros);
$fetchCajeros = mysqli_fetch_all($ejecutarCajeros);

//Total Parqueos
$consultaCantidadTotal = "SELECT COUNT(idParqueos) FROM parqueos WHERE  nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarCantidadTotal = mysqli_query($conexion, $consultaCantidadTotal);
$fetchCantidadTotal = mysqli_fetch_row($ejecutarCantidadTotal);

//Carros
$consultaCarrosTotal = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '1' AND parqueos.nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarCarrosTotal = mysqli_query($conexion, $consultaCarrosTotal);
$fetchCarrosTotal = mysqli_fetch_row($ejecutarCarrosTotal);

//Motos
$consultaMotosTotal = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '2' AND parqueos.nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarMotosTotal = mysqli_query($conexion, $consultaMotosTotal);
$fetchMotosTotal = mysqli_fetch_row($ejecutarMotosTotal);

//Informacion por fechas
if (isset($_POST['submit']) && $_POST['buscador'] == 'parqueos.fechaRegistro') {
    //Total Parqueos HOY
    $consultaCantidad = "SELECT COUNT(idParqueos) FROM parqueos WHERE fechaRegistro LIKE '%$_POST[fechaIngreso]%' AND parqueos.nitEmpresas = '$_SESSION[nitEmpresas]'";
    $ejecutarCantidad = mysqli_query($conexion, $consultaCantidad);
    $fetchCantidadDia = mysqli_fetch_row($ejecutarCantidad);

    //Carros HOY
    $consultaCarros = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '1' AND parqueos.fechaRegistro LIKE '%$_POST[fechaIngreso]%' AND parqueos.nitEmpresas = '$_SESSION[nitEmpresas]'";
    $ejecutarCarros = mysqli_query($conexion, $consultaCarros);
    $fetchCarrosDia = mysqli_fetch_row($ejecutarCarros);

    //Motos HOY
    $consultaMotos = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '2' AND parqueos.fechaRegistro LIKE '%$_POST[fechaIngreso]%' AND parqueos.nitEmpresas = '$_SESSION[nitEmpresas]'";
    $ejecutarMotos = mysqli_query($conexion, $consultaMotos);
    $fetchMotosDia = mysqli_fetch_row($ejecutarMotos);
}
?>

<!-- Modal -->
<div class="modal fade" id="parqueosHoy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Información Hoy: <?php echo $hoy ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="tituloSecciones">Cantidad Parqueos:</p>
                <p class="informacion"><?php echo "Hoy se han registrado: " . $fetchCantidad[0] . " Parqueo(s) en total." ?></p>

                <p class="tituloSecciones">Cantidad Por Vehículos</p>
                <div class="row">
                    <div class="col">
                        <p class="subtitulos">Automóviles: </p>
                        <p class="informacion"><?php echo "Hoy se han atendido: " . $fetchCarros[0] . " Automóvil (es)." ?></p>
                    </div>
                    <div class="col">
                        <p class="subtitulos">Motos: </p>
                        <p class="informacion"><?php echo "Hoy se han atendido: " . $fetchMotos[0] . " Moto (s)." ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="parqueosCajero" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Parqueos Por Cajero: <?php echo $hoy ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php foreach ($fetchCajeros as $key => $value) { ?>
                    <?php
                    //Total Parqueos
                    $consultaCantidad = "SELECT COUNT(idParqueos) FROM parqueos WHERE fechaRegistro LIKE '%$hoy%' AND parqueos.registroPor = '$value[0]'";
                    $ejecutarCantidad = mysqli_query($conexion, $consultaCantidad);
                    $fetchCantidad = mysqli_fetch_row($ejecutarCantidad);

                    //Carros
                    $consultaCarros = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '1' AND parqueos.fechaRegistro LIKE '%$hoy%' AND parqueos.registroPor = '$value[0]'";
                    $ejecutarCarros = mysqli_query($conexion, $consultaCarros);
                    $fetchCarros = mysqli_fetch_row($ejecutarCarros);

                    //Motos
                    $consultaMotos = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '2' AND parqueos.fechaRegistro LIKE '%$hoy%' AND parqueos.registroPor = '$value[0]'";
                    $ejecutarMotos = mysqli_query($conexion, $consultaMotos);
                    $fetchMotos = mysqli_fetch_row($ejecutarMotos);
                    ?>
                    <p class="subtitulos"><?php echo $value[1] . " " . $value[2] . " " . $value[3] . " " . $value[4] ?></p>
                    <div class="row">
                        <div class="col">
                            <p class="informacion"><?php echo "Motos: " . $fetchMotos[0] ?> </p>
                        </div>
                        <div class="col">
                            <p class="informacion"><?php echo "Autos: " . $fetchCarros[0] ?> </p>
                        </div>
                        <div class="col">
                            <p class="informacion"><?php echo "Total: " . $fetchCantidad[0] ?> </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="parqueosTotal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Consolidado Total</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="tituloSecciones">Cantidad Parqueos:</p>
                <p class="informacion"><?php echo "Se han registrado: " . $fetchCantidadTotal[0] . " Parqueo(s) en total." ?></p>

                <p class="tituloSecciones">Cantidad Por Vehículos</p>
                <div class="row">
                    <div class="col">
                        <p class="subtitulos">Automóviles: </p>
                        <p class="informacion"><?php echo "Se han atendido: " . $fetchCarrosTotal[0] . " Automóvil (es)." ?></p>
                    </div>
                    <div class="col">
                        <p class="subtitulos">Motos: </p>
                        <p class="informacion"><?php echo "Se han atendido: " . $fetchMotosTotal[0] . " Moto (s)." ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="parqueosFechas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Información Día: <?php echo $_POST['fechaIngreso'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <p class="tituloSecciones">Cantidad Parqueos:</p>
                    <p class="informacion"><?php echo "Se registraron: " . $fetchCantidadDia[0] . " Parqueo(s) en total." ?></p>

                    <p class="tituloSecciones">Cantidad Por Vehículos</p>
                    <div class="row">
                        <div class="col">
                            <p class="subtitulos">Automóviles: </p>
                            <p class="informacion"><?php echo "Se registraron: " . $fetchCarrosDia[0] . " Automóvil (es)." ?></p>
                        </div>
                        <div class="col">
                            <p class="subtitulos">Motos: </p>
                            <p class="informacion"><?php echo "Se registraron: " . $fetchMotosDia[0] . " Moto (s)." ?></p>
                        </div>
                    </div>

                    <p class="tituloSecciones">Información Cajeros</p>
                    <?php foreach ($fetchCajeros as $key => $value) { ?>
                        <?php
                        //Total Parqueos
                        $consultaCantidad = "SELECT COUNT(idParqueos) FROM parqueos WHERE fechaRegistro LIKE '%$_POST[fechaIngreso]%' AND parqueos.registroPor = '$value[0]'";
                        $ejecutarCantidad = mysqli_query($conexion, $consultaCantidad);
                        $fetchCantidad = mysqli_fetch_row($ejecutarCantidad);

                        //Carros
                        $consultaCarros = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '1' AND parqueos.fechaRegistro LIKE '%$_POST[fechaIngreso]%' AND parqueos.registroPor = '$value[0]'";
                        $ejecutarCarros = mysqli_query($conexion, $consultaCarros);
                        $fetchCarros = mysqli_fetch_row($ejecutarCarros);

                        //Motos
                        $consultaMotos = "SELECT COUNT(*) FROM parqueos INNER JOIN vehiculos ON vehiculos.placaVehiculos = parqueos.placaVehiculos WHERE vehiculos.tipoVehiculos = '2' AND parqueos.fechaRegistro LIKE '%$_POST[fechaIngreso]%' AND parqueos.registroPor = '$value[0]'";
                        $ejecutarMotos = mysqli_query($conexion, $consultaMotos);
                        $fetchMotos = mysqli_fetch_row($ejecutarMotos);
                        ?>
                        <p class="subtitulos"><?php echo $value[1] . " " . $value[2] . " " . $value[3] . " " . $value[4] ?></p>
                        <div class="row">
                            <div class="col">
                                <p class="informacion"><?php echo "Motos: " . $fetchMotos[0] ?> </p>
                            </div>
                            <div class="col">
                                <p class="informacion"><?php echo "Autos: " . $fetchCarros[0] ?> </p>
                            </div>
                            <div class="col">
                                <p class="informacion"><?php echo "Total: " . $fetchCantidad[0] ?> </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<script>
    function opcionesSelect() {
        var select = document.getElementById("buscador").value;
        var cajero = document.getElementById("cajero").style;
        var estado = document.getElementById("estado").style;
        var fechaIngreso = document.getElementById("fechaIngreso").style;
        var placa = document.getElementById("placa").style;
        var usuario = document.getElementById("usuario").style;
        var mensualidad = document.getElementById("mensualidad").style;

        var submit = document.getElementById("submit").style;
        mensualidad

        //Cajero
        if (select == 'parqueos.registroPor') {
            cajero.display = 'inline';
            submit.display = 'inline';
        } else {
            cajero.display = 'none';
        }

        //Estado
        if (select == 'parqueos.estadoParqueos') {
            estado.display = 'inline';
            submit.display = 'inline';
        } else {
            estado.display = 'none';
        }

        //fechaIngreso
        if (select == 'parqueos.fechaRegistro') {
            fechaIngreso.display = 'inline';
            submit.display = 'inline';
        } else {
            fechaIngreso.display = 'none';
        }

        //placa
        if (select == 'parqueos.placaVehiculos') {
            placa.display = 'inline';
            submit.display = 'inline';
        } else {
            placa.display = 'none';
        }

        //Usuario
        if (select == 'parqueos.documentoUsuarios') {
            usuario.display = 'inline';
            submit.display = 'inline';
        } else {
            usuario.display = 'none';
        }

        //mensualidad
        if (select == 'parqueos.mensualidadParqueos') {
            mensualidad.display = 'inline';
            submit.display = 'inline';
        } else {
            mensualidad.display = 'none';
        }
    }

    opcionesSelect();
</script>

<?php require_once('../../estructura/footer.php') ?>