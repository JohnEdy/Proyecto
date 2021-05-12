<?php $menuParqueos = 'parqueos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>

<p class="titulos">Retirar Vehículo</p>
<div class="container-menu">
    <?php if (isset($_GET['up']) && $_GET['up'] == 1) { ?>
        <div class="alert alert-success">El retiro del vehiculo fue registrado correctamente</div>
    <?php } else if (isset($_GET['up']) && $_GET['up'] != 1) { ?>
        <div class="alert alert-danger">Lo sentimos, ah surgido un error al registrar el retiro</div>
    <?php } ?>
    <div class="row g-3 forms" id="codigoParqueoActivo">
        <div class="alert alert-danger" id="mensajeCodigoError" style="display: none;"></div>
        <input type="text" class="form-control" placeholder="Ingrese el código dado por el usuario" name="codigoRetiroParqueos" autocomplete="off" id="codigoParqueos">
        <input type="hidden" name="buscarCodigo" value="1">
        <div style="align-items: center; text-align: center;">
            <button name="submit" id="btnCodigo" class="btn btn-primary"><?php echo $btnRegistrar ?>Retirar</button>
        </div>
    </div>

    <form action="../../registros/validarRetirarVehiculos.php" class="row g-3 forms" method="POST" id="resultadoDatosParqueo" style="display: none;">
        <div class="row">
            <div class="col">
                <label for="horaIngresoParqueos" class="form-label">Hora Ingreso<i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" name="horaIngresoParqueos" id="horaIngresoParqueos" maxlength="20">
            </div>
            <div class="col">
                <label for="cantidadHorasParqueo" class="form-label">Cantidad Horas<i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" name="cantidadHorasParqueo" id="cantidadHorasParqueo" maxlength="20">
            </div>
            <div class="col">
                <label for="horaSalida" class="form-label">Hora Sálida<i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" name="horaSalida" id="horaSalida" value="<?php echo date("H:i:s") ?>" maxlength="20">
            </div>
            <div class="col">
                <label for="totalDineroParqueos" class="form-label">Total Parqueo<i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" maxlength="20" id="totalDineroParqueos">
            </div>
        </div>

        <div class="row">

            <div class="col seccionMotos" style="displaY: none;">
                <label for="cantidadCascosParqueo" class="form-label">Cantidad Cascos: <i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" name="cantidadCascosParqueo" id="cantidadCascosParqueo" maxlength="20">
            </div>
            <div class="col seccionMotos" style="displaY: none;">
                <label for="casilleroCascosParqueo" class="form-label">Casillero: <i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" name="casilleroCascosParqueo" id="casilleroCascosParqueo" maxlength="20">
            </div>

            <div class="col seccionLavada" style="display: none;">
                <label for="lavadaVehiculosParqueo" class="form-label">¿Lavada Vehículo? <i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" name="lavadaVehiculosParqueo" id="lavadaVehiculosParqueo" maxlength="20">
            </div>
            <div class="col seccionLavada" style="display: none;">
                <label for="valorLavadaParqueo" class="form-label">Valor Lavada: <i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" name="valorLavadaParqueo" id="valorLavadaParqueo" maxlength="20">
            </div>

        </div>

        <div class="row">
            <div class="col"></div>
            <div class="col">
                <label for="reciboDinero" class="form-label">Se reciben: <i class="bi bi-asterisk"></i></label>
                <input type="text" class="form-control" name="reciboDinero" id="reciboDinero" maxlength="20">
                <input type="hidden" class="form-control" name="reciboDinero" id="reciboDineroF" maxlength="20">
            </div>
            <div class="col">
                <label for="colorVehiculos" class="form-label">Se devuelven: <i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" name="colorVehiculos" id="regresoDinero">
                <input type="hidden" name="retiro" value="1">
                <input type="hidden" name="idParqueos" id="idParqueos">
            </div>
            <div class="col">
                <label for="totalCobrarParqueo" class="form-label">Total A Cobrar: <i class="bi bi-asterisk"></i></label>
                <input type="text" readonly class="form-control" name="totalCobrarParqueo" id="totalCobrarParqueo">
                <input type="hidden" readonly id="totalCobrarParqueoF" class="form-control" name="totalCobrar" id="totalCobrar" maxlength="20">
            </div>
        </div>
        <div class="btnSubmit">
            <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Verificar Retirar</button>
            <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </form>
</div>
<script>
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0
    })

    $("#reciboDinero").keyup(function() {
        var devolucionDinero = parseInt($("#reciboDinero").val()) - parseInt($("#totalCobrarParqueoF").val());
        $("#regresoDinero").val(formatter.format(devolucionDinero));
    })

    $("#btnCodigo").click(function() {
        $.ajax({
            type: "POST",
            url: "../../ajax/datosValidarRetirar.php",
            data: "codigo=" + $("#codigoParqueos").val(),
            dataType: "json",
            success: function(data) {
                console.log(data);
                //Si se encuentran los datos, mostramos la seccion con la informaciòn del parqueo
                if (data[9] == 'Si') {
                    //Ocultamos la sección donde se ingresa el código y mostramos los datos del parqueo
                    $("#codigoParqueoActivo").hide();
                    $("#resultadoDatosParqueo").show();
                    $("#idParqueos").val(data[5]);

                    //Damos los valores a los campos
                    $("#horaIngresoParqueos").val(data[1]);
                    $("#cantidadHorasParqueo").val(data[2]);

                    //Calculamos el valor del parqueo y lo mostramos en su campo
                    var total = parseInt(data[2]) * parseInt(data[7]);
                    totalF = formatter.format(total);
                    $("#totalDineroParqueos").val(totalF);

                    //Si es una moto, mostramos la seccion de las motos para mostrar donde están ubicados los cascos y cuantos son
                    if (data[0] == <?php echo $idMotocicleta ?>) {
                        $(".seccionMotos").show();
                        $("#cantidadCascosParqueo").val(data[3]);
                        $("#casilleroCascosParqueo").val(data[4]);
                    }

                    //Validamos si el vehículo tiene incluida su lavada
                    if (data[6] == 1) {
                        $(".seccionLavada").show();
                        $("#lavadaVehiculosParqueo").val("Si");
                        $("#valorLavadaParqueo").val(formatter.format(data[10]));
                    }

                    //Ingresamos el total que debe de pagar el cliente
                    var totalParqueo = parseInt(total) + parseInt(data[8]); //Sumamos las horas del parqueo más la lavada
                    totalParqueoF = formatter.format(totalParqueo)
                    $("#totalCobrarParqueo").val(totalParqueoF);
                    $("#totalCobrarParqueoF").val(totalParqueo);

                } else {
                    $("#mensajeCodigoError").show();
                    $("#mensajeCodigoError").html("<b> El codigo ingresado, no pertenece a ningún parqueo activo.");
                }
            },
            error: function(data) {
                console.log("Error: " + data);
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

    //EE1U3o
</script>

<!-- Inline level -->
<?php require_once('../../estructura/footer.php') ?>