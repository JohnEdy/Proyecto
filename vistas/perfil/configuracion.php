<?php require_once('../../estructura/header.php') ?>
<?php

if ($_SESSION['idRoles'] != $idAdministradorEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}

if (isset($_POST['submit'])) {
    @$consultaParametros = "SELECT * FROM parametros WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
    @$ejecutarParametros = mysqli_query($conexion, $consultaParametros);
    @$fetchParametros = mysqli_fetch_array($ejecutarParametros);
    $rowParametros = mysqli_num_rows($ejecutarParametros);
}

//Traemos la información de los parametros de la empresa
@$consultaParametros    = "SELECT * FROM parametros WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
@$ejecutarParametros    = mysqli_query($conexion, $consultaParametros);
@$fetchParametros       = mysqli_fetch_array($ejecutarParametros);
$rowParametros          = mysqli_num_rows($ejecutarParametros);

if ($rowParametros >= 1) {
    $update = 1;
} else {
    $update = 0;
}

//Para determinar el valor a seleccionar en las horas
if (@$fetchParametros['horasParametros'] == 1 && !isset($_POST['submit'])) {
    $checkedHoras1 = 'checked';
} else if (@$fetchParametros['horasParametros'] == 0 && !isset($_POST['submit'])) {
    $checkedHoras0 = 'checked';
}

//Para determinar el valor a seleccionar en las meses
if (@$fetchParametros['mesesParametros'] == 1 && !isset($_POST['submit'])) {
    $checkedMeses1 = 'checked';
} else if (@$fetchParametros['mesesParametros'] == 0 && !isset($_POST['submit'])) {
    $checkedMeses0 = 'checked';
}

//Para determinar el valor a seleccionar en las lavadas
if (@$fetchParametros['lavadaParametros'] == 1 && !isset($_POST['submit'])) {
    $checkedLavadas1 = 'checked';
} else if (@$fetchParametros['lavadaParametros'] == 0 && !isset($_POST['submit'])) {
    $checkedLavadas0 = 'checked';
}

//Para determinar el valor a seleccionar en las horas
if (@$fetchParametros['articulosParametros'] == 1 && !isset($_POST['submit'])) {
    $checkedArticulos1 = 'checked';
} else if (@$fetchParametros['articulosParametros'] == 0 && !isset($_POST['submit'])) {
    $checkedArticulos0 = 'checked';
}

//Traemos la informaciòn de la tabla tipoVehiculos, donde traemos los campos de las horas para cada tipo de vehiculo registrados
$horasSelect                = "SELECT idTipoVehiculos, nombreTipoVehiculos, horaTiposVehiculos FROM tiposVehiculos WHERE nitEmpresas        = '$_SESSION[nitEmpresas]'";
$ejecutarHorasSelect        = mysqli_query($conexion, $horasSelect);
$fetchHoras                 = mysqli_fetch_all($ejecutarHorasSelect);
$postHoras                  = 0;

//Traemos la informaciòn de la tabla tipoVehiculos, donde traemos los campos de las meses para cada tipo de vehiculo registrados
$mesesSelect                = "SELECT idTipoVehiculos, nombreTipoVehiculos, mesTiposVehiculos FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarMesesSelect        = mysqli_query($conexion, $mesesSelect);
$fetchMeses                 = mysqli_fetch_all($ejecutarMesesSelect);
$postMeses                  = 0;

//Traemos la informaciòn de la tabla tipoVehiculos, donde traemos los campos de las meses para cada tipo de vehiculo registrados
$LavadasSelect              = "SELECT idTipoVehiculos, nombreTipoVehiculos, lavadaTiposVehiculos FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarLavadasSelect      = mysqli_query($conexion, $LavadasSelect);
$fetchLavadas               = mysqli_fetch_all($ejecutarLavadasSelect);
$postLavadas                = 0;


//Tremos el vehiculo que esta marcado
$marcadoVehiculo            = "SELECT idTipoVehiculos FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' AND marcadoVehiculos = '1'";
$ejecutarMarcado            = mysqli_query($conexion, $marcadoVehiculo);
$fetchMarcado               = mysqli_fetch_row($ejecutarMarcado);


//Traemos los tipos de vehiculo
$datosTipos     = "SELECT * FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarTipos  = mysqli_query($conexion, $datosTipos);
$datosVehiculos = mysqli_fetch_all($ejecutarTipos);
?>

<p class="titulos">Configuración</p>
<div class="container-menu">
    <ul class="nav d-flex bd-highlight mb-3">
        <li class="p-2 bd-highlight">
            <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarArticulos"><?php echo $btnVehiculos ?>&nbsp;Tipo Vehiculos</button>
        </li>
        <!-- <li class="p-2 bd-highlight">
            <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#aforoParqueo"><?php echo $btnVehiculos ?>&nbsp;Espacios Parqueo</button>
        </li> -->
        <li class="ms-auto p-2 bd-highlight">
            Marca Tu Motocicleta <?php echo cargarSelect($conexion, $tipoVehiculos, "tipoVehiculos", "class='form-control' id='vehiculoMarcado'", @$fetchMarcado[0]) ?>
        </li>
    </ul>
    <form action="" class="row g-3 forms" method="POST">
        <div id="respuestaMarcado" style="display: none;"></div>
        <?php include_once('../../registros/validarParametros.php') ?>
        <p class="tituloSecciones">Opciones <span style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#primeraVez"><?php echo $btnAyuda ?></span> </p>
        <div class="row" style="margin-left: 5pt;">
            <div class="col-3">
                <label for="valorHoraMotosParametros" class="form-label" id="labelContraUsuario">¿Parqueo Por Horas?</label>
                <div class="row" style="margin-left: 5pt;">
                    <div class="col">
                        <input class="form-check-input" type="radio" id="noHoras" name="horasParametros" onclick="horasParqueos()" value="0" <?php echo (isset($_POST['submit']) && $_POST['horasParametros'] == 0) ? 'checked' : @$checkedHoras0 ?>><label class="form-check-label" for="noHoras">&nbsp;No</label>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="radio" id="siHoras" name="horasParametros" onclick="horasParqueos()" value="1" <?php echo (isset($_POST['submit']) && $_POST['horasParametros'] == 1) ? 'checked' : @$checkedHoras1 ?>><label class="form-check-label" for="siHoras">&nbsp;Si</label>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <label for="valorHoraMotosParametros" class="form-label" id="labelContraUsuario">¿Parqueo Mensual?</label>
                <div class="row" style="margin-left: 5pt;">
                    <div class="col">
                        <input class="form-check-input" type="radio" id="noMeses" name="mesesParametros" onclick="mesesParqueos()" value="0" <?php echo (isset($_POST['submit']) && @$_POST['mesesParametros'] == 0) ? 'checked' : @$checkedMeses0 ?>><label class="form-check-label" for="noMeses">&nbsp;No</label>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="radio" id="siMeses" name="mesesParametros" onclick="mesesParqueos()" value="1" <?php echo (isset($_POST['submit']) && @$_POST['mesesParametros'] == 1) ? 'checked' : @$checkedMeses1 ?>><label class="form-check-label" for="siMeses">&nbsp;Si</label>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <label for="valorHoraMotosParametros" class="form-label">¿Lavada de Vehìculos?</label>
                <div class="row" style="margin-left: 5pt;">
                    <div class="col">
                        <input class="form-check-input" type="radio" id="noLavada" name="lavadaParametros" onclick="lavadaVehiculos()" value="0" <?php echo (isset($_POST['submit']) && @$_POST['lavadaParametros'] == 0) ? 'checked' : @$checkedLavadas0 ?>><label class="form-check-label" for="noLavada">&nbsp;No</label>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="radio" id="siLavada" name="lavadaParametros" onclick="lavadaVehiculos()" value="1" <?php echo (isset($_POST['submit']) && @$_POST['lavadaParametros'] == 1) ? 'checked' : @$checkedLavadas1 ?>><label class="form-check-label" for="siLavada">&nbsp;Si</label>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <label for="valorHoraMotosParametros" class="form-label">¿Venta De Artículos?</label>
                <div class="row" style="margin-left: 5pt;">
                    <div class="col">
                        <input class="form-check-input" type="radio" id="noArticulos" name="articulosParametros" value="0" <?php echo (isset($_POST['submit']) && @$_POST['articulosParametros'] == 0) ? 'checked' : @$checkedArticulos0 ?>><label class="form-check-label" for="noArticulos">&nbsp;No</label>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="radio" id="siArticulos" name="articulosParametros" value="1" <?php echo (isset($_POST['submit']) && @$_POST['articulosParametros'] == 1) ? 'checked' : @$checkedArticulos1 ?>><label class="form-check-label" for="siArticulos">&nbsp;Si</label>
                    </div>
                </div>
            </div>
        </div>
        <div id="seccionHoras" style="display: none;">
            <hr>
            <p class="tituloSecciones">Precios Parqueo Por Horas</p>
            <div class="row" style="margin-left: 5pt;">
                <?php if (empty($fetchHoras)) { ?>
                    <div class="alert alert-secondary">No Se Ha Registrado Ningún Vehículo</div>
                <?php } else { ?>
                    <?php foreach ($fetchHoras as $value) { ?>
                        <div class="col-3" style="margin-top: 10pt;">
                            <label for="valorHora<?php echo $value[1] ?>Parametros" class="form-label" id="labelContraUsuario">Precio Horas <?php echo $value[1] ?>* </label>
                            <input type="text" class="form-control" name="valorHorasParqueaderos[]" id="valorHora<?php echo $value[1] ?>Parametros" onkeyup="format(this)" onchange="format(this)" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['valorHorasParqueaderos'][$postHoras] : $value[2] ?>">
                            <input type="hidden" name="idHorasParqueaderos[]" id="valorHora<?php echo $value[1] ?>Parametros" value="<?php echo $value[0] ?>">
                        </div>
                    <?php $postHoras++;
                    } ?>
                <?php  } ?>

            </div>
        </div>

        <div id="seccionMeses" style="display: none;">
            <hr>
            <p class="tituloSecciones">Precios Parqueo Por Meses</p>
            <div class="row" style="margin-left: 5pt;">
                <?php if (empty($fetchMeses)) { ?>
                    <div class="alert alert-secondary">No Se Ha Registrado Ningún Vehículo</div>
                <?php } else { ?>
                    <?php foreach ($fetchMeses as $value) { ?>
                        <div class="col-3" style="margin-top: 10pt;">
                            <label for="valorHora<?php echo $value[1] ?>Parametros" class="form-label" id="labelContraUsuario">Precio Mes <?php echo $value[1] ?>* </label>
                            <input type="text" class="form-control" name="valorMesesParqueaderos[]" id="valorHora<?php echo $value[1] ?>Parametros" onkeyup="format(this)" onchange="format(this)" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['valorMesesParqueaderos'][$postMeses] : $value[2] ?>">
                            <input type="hidden" name="idMesesParqueaderos[]" id="valorHora<?php echo $value[1] ?>Parametros" value="<?php echo $value[0] ?>">
                        </div>
                    <?php $postMeses++;
                    } ?>

                <?php  } ?>
            </div>
        </div>
        <div id="seccionLavada" style="display: none;">
            <hr>
            <p class="tituloSecciones">Precios Lavada</p>
            <div class="row" style="margin-left: 5pt;">
                <?php if (empty($fetchLavadas)) { ?>
                    <div class="alert alert-secondary">No Se Ha Registrado Ningún Vehículo</div>
                <?php } else { ?>
                    <?php foreach ($fetchLavadas as $value) { ?>
                        <div class="col-3" style="margin-top: 10pt;">
                            <label for="valorHora<?php echo $value[1] ?>Parametros" class="form-label" id="labelContraUsuario">Precio Lavada <?php echo $value[1] ?>* </label>
                            <input type="text" class="form-control" name="valorLavadasParqueaderos[]" id="valorHora<?php echo $value[1] ?>Parametros" onkeyup="format(this)" onchange="format(this)" maxlength="10" value="<?php echo (isset($_POST['submit'])) ? $_POST['valorLavadasParqueaderos'][$postLavadas] : $value[2] ?>">
                            <input type="hidden" name="idLavadasParqueaderos[]" id="valorHora<?php echo $value[1] ?>Parametros" value="<?php echo $value[0] ?>">
                        </div>
                    <?php $postLavadas++;
                    } ?>

                <?php  } ?>
            </div>
        </div>
        <div style="align-items: center; text-align: center;">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Guardar Configuración</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
            <span class="visually-hidden">Loading...</span>
        </div>
    </form>
</div>

<div class="modal fade" id="primeraVez" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Tutorial Opciones</h5>
                <button type="button" class="btn-close closePrimeraVez" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../acciones/registrarTipoVehiculos.php" method="POST">
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closePrimeraVez" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="aforoParqueo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Capacidad Vehículos</h5>
                <button type="button" class="btn-close closePrimeraVez" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../acciones/registrarTipoVehiculos.php" method="POST">
                <div class="modal-body">
                    <?php print_r($datosVehiculos) ?>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="registrarAforo-tab" data-toggle="tab" href="#registrarAforo" role="tab" aria-controls="registrarAforo" aria-selected="true">Ingresar</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="consultaAforo-tab" data-toggle="tab" href="#consultaAforo" role="tab" aria-controls="consultaAforo" aria-selected="false">Consultar</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" style="margin-left: 20pt; margin-right: 20pt; margin-top: 10pt; margin-bottom: 10pt;">
                        <div class="tab-pane fade show active" id="registrarAforo" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col">
                                    <label for="nombreTipoVehiculos" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombreTipoVehiculos" id="nombreTipoVehiculos">
                                    <input type="hidden" name="archivoActual" value="perfil/<?php echo basename(__FILE__) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="consultaAforo" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover table-light" id="table" style="width: 100%;">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Cant. Horas</th>
                                        <th>Cant. Meses</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($datosVehiculos as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value[1] ?></td>
                                                <td><?php echo $value[7] ?></td>
                                                <td><?php echo $value[8] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="btnSubmitModal" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
                    <button type="button" class="btn btn-secondary closePrimeraVez" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="eliminarArticulos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Tipo de Vehículos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../acciones/registrarTipoVehiculos.php" method="POST">
                <div class="modal-body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ingresar</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Consultar</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" style="margin-left: 20pt; margin-right: 20pt; margin-top: 10pt; margin-bottom: 10pt;">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col">
                                    <label for="nombreTipoVehiculos" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombreTipoVehiculos" id="nombreTipoVehiculos">
                                    <input type="hidden" name="archivoActual" value="perfil/<?php echo basename(__FILE__) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover table-light" id="table" style="width: 100%;">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Horas</th>
                                        <th>Meses</th>
                                        <th>Lavada</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($datosVehiculos as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value[1] ?></td>
                                                <td><?php echo "$ " . number_format($value[3]) ?></td>
                                                <td><?php echo "$ " . number_format($value[4]) ?></td>
                                                <td><?php echo "$ " . number_format($value[5]) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="btnSubmitModal" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="fondoModal"></div>

<script>
    /* Para realizar el tutorial */
    $(document).ready(function() {
        <?php if ($update == 0) { ?>
            $("#primeraVez").show("slow");
            $("#primeraVez").addClass("show");
            $("#primeraVez").css("style", "display");
            $("#fondoModal").addClass("modal-backdrop fade show");


            $(".closePrimeraVez").click(function() {
                $("#primeraVez").hide("slow");
                $("#fondoModal").removeClass("modal-backdrop fade show");
            })
        <?php } ?>
    });
    /*Definimos Variables*/
    var mesesPar = document.getElementById("siMeses");
    var lavadaVehi = document.getElementById("siLavada");
    var horasPar = document.getElementById("siHoras");
    var seccionMeses = document.getElementById("seccionMeses").style;
    var seccionLavada = document.getElementById("seccionLavada").style;
    var seccionHoras = document.getElementById("seccionHoras").style;

    /* Ejecutamos Funciones */
    mesesParqueos();
    lavadaVehiculos();
    horasParqueos();

    /* Creamos Funciones */
    function mesesParqueos() {
        if (mesesPar.checked) {
            seccionMeses.display = 'inline';
        } else {
            seccionMeses.display = 'none';
        }
    };

    function horasParqueos() {
        if (horasPar.checked) {
            seccionHoras.display = 'inline';
        } else {
            seccionHoras.display = 'none';
        }
    };

    function lavadaVehiculos() {
        if (lavadaVehi.checked) {
            seccionLavada.display = 'inline';
        } else {
            seccionLavada.display = 'none';
        }
    };

    //Enviamos el vehìculo que será marcado como motocicleta para las validaciones integrity
    $("#vehiculoMarcado").change(function() {
        $.ajax({
            type: "POST",
            url: "../../ajax/datosMarcarVehiculos.php",
            data: "id=" + $("#vehiculoMarcado").val(),
            success: function(data) {
                $("#respuestaMarcado").html(data);
            },
            error: function() {
                console.log("ERROR");
            }
        });
    })
</script>
<?php require_once('../../estructura/footer.php') ?>