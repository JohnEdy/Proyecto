<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

//Consulta para traer los planes que puede el administrador de la empresa, registrar la misma
$sql            = "SELECT * FROM planes INNER JOIN imagen ON planes.idImagen = imagen.idImagen ORDER BY planes.precioPlanes";
$ejecutar       = mysqli_query($conexion, $sql);
$datos          = mysqli_fetch_all($ejecutar);

//Consulta para traer el id del plan al que pertenece dicha empresa
$idPlanes       = "SELECT idPlanes FROM empresas WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarPlan   = mysqli_query($conexion, $idPlanes);
$idPlan         = mysqli_fetch_row($ejecutarPlan);

//Consulta para traer el año actual
$sqlAnho        = "SELECT idAnho FROM anho WHERE descripcionAnho = '" . date("Y") . "' AND nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarAnho   = mysqli_query($conexion, $sqlAnho);
$anhoActual     = mysqli_fetch_row($ejecutarAnho);

//Consulta para validar si ya se genero un pago para este mes
$sqlPago        = "SELECT * FROM pagos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' AND fechaRegistro LIKE '%" . date("Y-m-d") . "%'";
$ejecutarPago   = mysqli_query($conexion, $sqlPago);
$rowsPago       = mysqli_num_rows($ejecutarPago);

?>
<p class="titulos">Adquirir Planes</p>
<div class="container-menu">
    <ul class="nav justify-content-end">
        <li class="nav-item align-middle">
            <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarArticulos"><?php echo $btnMas ?>&nbsp;Agregar Año</button>
        </li>
        <li class="nav-item align-middle">
            <a type="button" class="nav-link btn-primary btn btn-sm" href="misPagos.php"><?php echo $btnPagos ?>&nbsp;Mis Pagos</a>
        </li>
    </ul>
    <?php if (isset($_GET['plan']) && $_GET['plan'] == 1) : ?>
        <div class="alert alert-success">Su modificación fue ingresada correctamente</div>
    <?php elseif (isset($_GET['plan']) && $_GET['plan'] == 0) : ?>
        <div class="alert alert-danger">Lo sentimos, surgió un error al realizar la comprar de su plan</div>
    <?php endif; ?>
    <?php if (isset($_GET['pag']) && $_GET['pag'] == 1) : ?>
        <div class="alert alert-danger">Lo sentimos, no ha ingresado un pago para el mes y año actuales</div>
    <?php endif; ?>
    <div class="row" style="align-items: center; text-align: center;">
        <?php foreach ($datos as $dato) : ?>
            <?php if ($dato[0] == $idPlan[0]) { //Realizamos la validacion del plan actual para generar el texto
                $actual     = 'Plan Actual';
            } else {
                $actual     = "";
            } ?>

            <?php if ($rowsPago >= 1) { //Validamos si este mes ya se realizo un pago, y desactivamos el boton para adiquirir planes
                $disabled   = 'disabled';
                $info       = '&nbsp;<span data-bs-toggle="tooltip" data-bs-placement="right" title="Este mes ya ha realizado el pago de un plan">' . $btnAyuda . '</span>';
            } else {
                $disabled   = '';
                $info       = '<span class="btnInfo"></span>';
            } ?>
            <div class="col-3" style="margin-top: 10pt; margin-bottom: 10pt;">
                <div class="card" style="width: 18rem;">
                    <img src="../../<?php echo $dato[12] ?>" class="card-img-top" alt="..." style="width: 200; height: 125pt;">
                    <div class="card-body">
                        <h5 class="card-title text-start"><?php echo $dato[2] ?></h5>
                        <h3><?php echo "$ " . number_format($dato[3]) ?> COP/Mes</h3>
                        <div class="card-text text-center">
                            <span>Cantidad de registro por: </span><br>
                            <span><strong>Parqueos Horas:</strong> <?php echo $dato[7] ?></span><br>
                            <span><strong>Parqueos Meses:</strong> <?php echo $dato[8] ?></span><br>
                            <span><strong>Artículos:</strong> <?php echo $dato[9] ?></span><br><br>
                            <?php echo $dato[1] ?>
                            <input type="hidden" id="idPlanes-<?php echo $dato[0] ?>" value="<?php echo $dato[0] ?>">
                        </div>
                        <div class="text-end">
                            <span style="font-size: 10pt; font-weight: bold; color: red;"><?php echo $actual ?></span>
                            <?php if ($dato[0] == $idPlan[0]) { ?>
                                <button data-bs-toggle="modal" data-bs-target="#pagoPlan-<?php echo $dato[0] ?>" class="btn btn-primary" <?php echo $dato[0] == 1 ? 'disabled' : '' ?>>Realizar Pago</button>
                            <?php } else { ?>
                                <button <?php echo $disabled ?> data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $dato[0] ?>" class="btn btn-primary btnAdquirirPlan">Adquirir</button><?php echo $info ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modales -->
<?php foreach ($datos as $key => $dato) : ?>
    <div class="modal fade" id="exampleModal-<?php echo $dato[0] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adquirir Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">¿Esta seguro de adquirir el plan <?php echo $dato[2] ?>?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $cerrarSesion ?>Cerrar</button>
                    <a type="button" class="btn btn-primary" id="btnAdquirir-<?php echo $dato[0] ?>"><?php echo $btnPremium ?>&nbsp;Adquirir Plan</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($datos as $key => $dato) : ?>
    <?php if ($dato[0] == $idPlan[0]) { ?>
        <div class="modal fade" id="pagoPlan-<?php echo $dato[0] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Realizar Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="mensajePagos" style="display:none; color: red; font-size: 10pt; font-weight: bold;"></div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="placaVehiculos" class="form-label">Plan A Pagar</label>
                                <p style="margin-left: 10pt;"><?php echo $dato[2] ?></p>
                                <input type="hidden" id="idPlanPago" value="<?php echo $dato[0] ?>">
                            </div>
                            <div class="col-6">
                                <label for="placaVehiculos" class="form-label">Valor A Pagar *</label>
                                <p style="margin-left: 10pt;"><?php echo "$ " . number_format($dato[3]) ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="idMes" class="form-label">Mes De Pago*</label>
                                <?php cargarSelect($conexion, "SELECT idMes, nombreMes FROM meses", 'idMes', 'class="form-control" id="idMes"', date("n")) ?>
                            </div>
                            <div class="col-6">
                                <label for="idAnho" class="form-label">Año Actual *</label>
                                <?php @cargarSelect($conexion, "SELECT idAnho, descripcionAnho FROM anho WHERE nitEmpresas = '$_SESSION[nitEmpresas]'", 'idAnho', 'class="form-control" id="idAnho"', $anhoActual[0]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $cerrarSesion ?>Cerrar</button>
                        <a type="button" class="btn btn-primary" id="btnRealizarPago"><?php echo $btnPremium ?>&nbsp;Realizar Pago</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php endforeach; ?>

<div class="modal fade" id="eliminarArticulos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Agregar Año</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="mensajeErrorAnho" style="display:none; color: red; font-size: 10pt; font-weight: bold;"></div>
                <label for="" class="form-label">Año</label>
                <input autocomplete="off" onkeyup="format(this)" onchange="format(this)" id="anhoNuevo" type="text" maxlength="4" class="form-control">
                <input type="hidden" value="<?php echo $_SESSION['nitEmpresas'] ?>" id="nitEmpresasAnho">
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" id="btnSubmitAnho" class="btn btn-primary" style="display: none;"><?php echo $btnRegistrar ?>Registrar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<script>
    //Funcion que nos llama el ajax para realizar el cambio de plan
    <?php foreach ($datos as $dato) : ?>
        $("#btnAdquirir-<?php echo $dato[0] ?>").click(function() {
            $.ajax({
                data: 'idPlanes=' + $("#idPlanes-<?php echo $dato[0] ?>").val(),
                url: '../../ajax/datosCambiosPlan.php',
                type: 'POST',
                success: function(data) {
                    if (data == 1) {
                        window.location.href = 'comprarPlanes.php?plan=1';
                        window.open("https://www.pse.com.co/persona-tu-primer-pago-por-pse");
                    } else {
                        window.location.href = 'comprarPlanes.php?plan=0';
                    }
                },
                error: function(data) {
                    console.log("ERROR " + data);
                }

            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 0) {
                    alert('Not connect: Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (textStatus === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (textStatus === 'timeout') {
                    alert('Time out error.');
                } else if (textStatus === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error: ' + jqXHR.responseText);
                }

            });
        })
    <?php endforeach; ?>

    //Para ejecutar el insert del año
    $("#anhoNuevo").keyup(function() {
        if ($("#anhoNuevo").val().length == 4) {
            $.ajax({
                type: "POST",
                data: "nitEmpresas=" + $("#nitEmpresasAnho").val() + "&anho=" + $("#anhoNuevo").val() + "&busqueda=1",
                url: "../../ajax/registrarAnho.php",
                success: function(data) {
                    if (data == 10) {
                        $("#mensajeErrorAnho").html("Lo sentimos, este año ya se encuentra registrado");
                        $("#mensajeErrorAnho").show();
                    } else {
                        $("#mensajeErrorAnho").hide();
                        $("#btnSubmitAnho").show();
                    }
                }
            });
        } else {
            $("#btnSubmitAnho").hide();
        }
    });

    //Funciòn para registrar los años por ajax
    $("#btnSubmitAnho").click(function() {
        $.ajax({
            type: "POST",
            data: "nitEmpresas=" + $("#nitEmpresasAnho").val() + "&anho=" + $("#anhoNuevo").val() + "&busqueda=0",
            url: "../../ajax/registrarAnho.php",
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    window.location.href = 'comprarPlanes.php?plan=1';
                } else {
                    $("#mensajeErrorAnho").html("Lo sentimos, los datos no fueron registrados");
                    $("#mensajeErrorAnho").show();
                }
            },
            error: function(data) {
                console.log("ERROR " + data);
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 0) {
                alert('Not connect: Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                alert('Time out error.');
            } else if (textStatus === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error: ' + jqXHR.responseText);
            }

        });

    });

    //Funcion para realizar los pagos por ajax
    $("#btnRealizarPago").click(function() {
        validarPagos();
    });

    function validarPagos() {
        $.ajax({
            data: "idMes=" + $("#idMes").val() + "&idAnho=" + $("#idAnho").val() + "&registro=1&idPlanPago=" + $("#idPlanPago").val(),
            type: "POST",
            url: "../../ajax/registrarPagos.php",
            success: function(data) {
                console.log(data);
                if (data == 3) {
                    $("#mensajePagos").show();
                    $("#mensajePagos").css("color", "red");
                    $("#mensajePagos").html("Lo sentimos, ya ha realizado un pago para este mes.");
                } else if (data == 1) {
                    $("#mensajePagos").show();
                    $("#mensajePagos").css("color", "green");
                    $("#mensajePagos").html("Su pago fue realizado de manera satisfactoria");
                    $(".btnAdquirirPlan").prop("disabled", true);
                    $(".btnInfo").html('&nbsp;<span data-bs-toggle="tooltip" data-bs-placement="right" title="Este mes ya ha realizado el pago de un plan"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg></span>');

                } else if (data != 3 && data != 1) {
                    $("#mensajePagos").show();
                    $("#mensajePagos").css("color", "red");
                    $("#mensajePagos").html("Lo sentimos, ha ocurrido un error al guardar sus datos");
                }
            },
            error: function(data) {
                console.log("ERROR " + data);
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 0) {
                alert('Not connect: Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                alert('Time out error.');
            } else if (textStatus === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error: ' + jqXHR.responseText);
            }

        });
    };
</script>

<?php require_once('../../estructura/footer.php') ?>