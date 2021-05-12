<?php $menuArqueos = 'arqueos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>

<p class="titulos">Registrar Arqueo</p>

<div class="container-menu">
    <div class="row">
        <div class="alert alert-danger" id="mensajeError" style="display: none;">Lo sentimos, este cajero ya le fue realizado un arqueo el día de hoy.</div>
        <form action="../../registros/validarRegistrarArqueo.php" method="POST">
            <label class="form-label" for="nitEmpresas">Cajero</label>
            <?php cargarSelect($conexion,  "SELECT documentoUsuarios, nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE nitEmpresas = '$_SESSION[nitEmpresas]' AND idRoles = '$idCajeroEmpresas' ORDER BY nombre1Usuarios", "documentoUsu", "class='form-control' id='arqueoUsuarios'") ?>
            <input type="hidden" id="documentoUsuarios" name="documentoUsuarios">
    </div>
    <div class="arqueos" id="seccionArqueo" style="display: none; margin-top: 10pt;">
        <p class="tituloSecciones">Billetes</p>
        <!-- Billetes 100,000  50,000 y 20,000-->
        <div class="row">
            <div class="col text-center" style="align-items: center;">
                <label for="billete100"><img style="border-radius: 10pt;" src="../../img/billete100.jpg" alt="Billete de $ 100.000" class="billete" data-bs-toggle="tooltip" title="Billete $ 100,000 COP"></label>
                <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                    <input onkeyup="dineroBilletes()" maxlength="3" type="text" id="billete100" class="form-control" placeholder="Ingrese Cantidad" name="billete100000" style="margin-top: 15pt;">
                </div>
            </div>
            <div class="col text-center" style="align-items: center;">
                <label for="billete50"><img style="border-radius: 10pt;" src="../../img/billete50000.png" alt="Billete de $ 50.000" class="billete" data-bs-toggle="tooltip" title="Billete $ 50,000 COP"></label>
                <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                    <input onkeyup="dineroBilletes()" maxlength="3" type="text" id="billete50" class="align-middle form-control" placeholder="Ingrese Cantidad" name="billete50000">
                </div>
            </div>
            <div class="col text-center" style="align-items: center;">
                <label for="billete20"><img style="border-radius: 10pt;" src="../../img/billete20000.png" alt="Billete de $ 20.000" class="billete" data-bs-toggle="tooltip" title="Billete $ 20,000 COP"></label>
                <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                    <input onkeyup="dineroBilletes()" maxlength="3" type="text" id="billete20" class="align-middle form-control" placeholder="Ingrese Cantidad" name="billete20000">
                </div>
            </div>
            <div class="col text-center" style="align-items: center;">
                <label for="billete10"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Billete $ 10,000 COP" src="../../img/billete10000.png" alt="Billete de $ 10.000" class="billete"></label>
                <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                    <input onkeyup="dineroBilletes()" maxlength="3" type="text" id="billete10" class="align-middle form-control" placeholder="Ingrese Cantidad" name="billete10000">
                </div>
            </div>
            <!-- Billetes 10,000 5,000  2,000 1,000-->
            <div class="row">
                <div class="col text-center" style="align-items: center;">
                    <label for="billete5"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Billete $ 5,000 COP" src="../../img/billete5000.jpg" alt="Billete de $ 5.000" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <input onkeyup="dineroBilletes()" maxlength="3" type="text" id="billete5" class="align-middle form-control" placeholder="Ingrese Cantidad" name="billete5000">
                    </div>
                </div>
                <div class="col text-center" style="align-items: center;">
                    <label for="billete2"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Billete $ 2,000 COP" src="../../img/billete2000.jpg" alt="Billete de $ 20.000" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <input onkeyup="dineroBilletes()" maxlength="3" type="text" id="billete2" class="align-middle form-control" placeholder="Ingrese Cantidad" name="billete2000">
                    </div>
                </div>
                <div class="col text-center" style="align-items: center;">
                    <label for="billete1"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Billete $ 1,000 COP" src="../../img/billete1000.png" alt="Billete de $ 1.000" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <input onkeyup="dineroBilletes()" maxlength="3" type="text" id="billete1" class="align-middle form-control" placeholder="Ingrese Cantidad" name="billete1000">
                    </div>
                </div>

            </div>
            <!--  -->
            <p class="tituloSecciones">Monedas</p>
            <!-- Monedas 1,000 500 y 200 -->
            <div class="row">
                <div class="col text-center" style="align-items: center;">
                    <label for="moneda10"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 1,000 COP" src="../../img/moneda1000.png" alt="Moneda de $ 1.000" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <input onkeyup="dineroMonedas()" maxlength="3" type="text" id="moneda10" class="align-middle form-control" placeholder="Ingrese Cantidad" name="moneda1000">
                    </div>
                </div>
                <div class="col text-center" style="align-items: center;">
                    <label for="moneda5"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 500 COP" src="../../img/moneda500.png" alt="moneda de $ 500" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <input onkeyup="dineroMonedas()" maxlength="3" type="text" id="moneda5" class="align-middle form-control" placeholder="Ingrese Cantidad" name="moneda500">
                    </div>
                </div>
                <div class="col text-center" style="align-items: center;">
                    <label for="moneda2"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 200 COP" src="../../img/moneda200.png" alt="moneda de $ 200" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <input onkeyup="dineroMonedas()" maxlength="3" type="text" id="moneda2" class="align-middle form-control" placeholder="Ingrese Cantidad" name="moneda200">
                    </div>
                </div>

            </div>
            <!-- Moneda 100 y 50 -->
            <div class="row">
                <div class="col text-center" style="align-items: center;">
                    <label for="moneda1"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 100 COP" src="../../img/moneda100.png" alt="Moneda de $ 100" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <input onkeyup="dineroMonedas()" maxlength="3" type="text" id="moneda1" class="align-middle form-control" placeholder="Ingrese Cantidad" name="moneda100">
                    </div>
                </div>

                <div class="col text-center" style="align-items: center;">
                    <label for="moneda"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 50 COP" src="../../img/moneda50.png" alt="moneda de $ 50" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <input onkeyup="dineroMonedas()" maxlength="3" type="text" id="moneda" class="align-middle form-control" placeholder="Ingrese Cantidad" name="moneda50">
                    </div>
                </div>

                <div class="btnSubmit">
                    <button type="button" id="btnSubmit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><?php echo $btnArqueos ?>&nbsp;Verificar Arqueo</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verificar Arqueo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="moneda" class="form-label">Cantidad Total En Billetes</label>
                            <input maxlength="3" type="text" id="cantidadBilletes" name="cantidadTotalBilletes" readonly class="align-middle form-control" placeholder="Ingrese Cantidad">
                        </div>
                        <div class="col">
                            <label for="moneda" class="form-label">Cantidad Total En Monedas</label>
                            <input maxlength="3" type="text" id="cantidadMonedas" readonly class="align-middle form-control" placeholder="Ingrese Cantidad" name="cantidadTotalMonedas">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="moneda" class="form-label">Valor Total En Billetes</label>
                            <input maxlength="3" type="text" id="valorBilletes" readonly class="align-middle form-control" placeholder="Ingrese Cantidad" name="valorTotalBilletesF">
                            <input type="hidden" id="valorBilletesF" readonly class="align-middle form-control" placeholder="Ingrese Cantidad" name="valorTotalBilletes">

                        </div>
                        <div class="col">
                            <label for="moneda" class="form-label">Valor Total En Monedas</label>
                            <input maxlength="3" type="text" id="valorMonedas" readonly class="align-middle form-control" placeholder="Ingrese Cantidad" name="valorTotalMonedasF">
                            <input type="hidden" id="valorMonedasF" readonly class="align-middle form-control" placeholder="Ingrese Cantidad" name="valorTotalMonedas">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $cerrarSesion ?>Cerrar</button>
                    <button type="submit" class="btn btn-primary"><?php echo $btnRegistrar ?>&nbsp;Ingresar Arqueo</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script>

    $(document).ready(function () {
        $("#arqueoUsuarios").click(function () {
            $("#mensajeError").hide();
        })
    })

    $("#arqueoUsuarios").change(function() {
        if ($("#arqueoUsuarios option:selected").val() != 0) {
            $.ajax({
                type: "POST",
                data: "cajero=" + $("#arqueoUsuarios").val(),
                url: "../../ajax/validarUsuarioArqueo.php",
                success: function(data) {
                    if (data == 0) {
                        $("#documentoUsuarios").val($("#arqueoUsuarios option:selected").val());
                        $("#arqueoUsuarios").prop("disabled", true);
                        $("#arqueoUsuarios").css("cursor", "not-allowed");
                        $("#seccionArqueo").show();
                    } else {
                        $("#mensajeError").show();
                    }
                },
                error: function(data) {
                    console.log("ERROR: " + data);
                }
            })
        } else {
            $("#seccionArqueo").hide();
        }
    });

    $("#btnSubmit").click(function() {
        $("#billete100").prop('readonly', true);
        $("#billete50").prop('readonly', true);
        $("#billete20").prop('readonly', true);
        $("#billete10").prop('readonly', true);
        $("#billete5").prop('readonly', true);
        $("#billete2").prop('readonly', true);
        $("#billete1").prop('readonly', true);
        $("#moneda10").prop('readonly', true);
        $("#moneda5").prop('readonly', true);
        $("#moneda2").prop('readonly', true);
        $("#moneda1").prop('readonly', true);
        $("#moneda").prop('readonly', true);
    })

    function dineroBilletes() {

        //Valor de los billetes
        var billete100 = parseInt(document.getElementById("billete100").value);
        var billete50 = parseInt(document.getElementById("billete50").value);
        var billete20 = parseInt(document.getElementById("billete20").value);
        var billete10 = parseInt(document.getElementById("billete10").value);
        var billete5 = parseInt(document.getElementById("billete5").value);
        var billete2 = parseInt(document.getElementById("billete2").value);
        var billete1 = parseInt(document.getElementById("billete1").value);

        var cantidadBilletes = document.getElementById("cantidadBilletes");
        var totalBilletes = document.getElementById("valorBilletes");
        var totalBilletesF = document.getElementById("valorBilletesF");


        cantidadBilletes.value = new Intl.NumberFormat("de-DE").format(billete100 + billete50 + billete20 + billete10 + billete5 + billete2 + billete1);
        totalBilletes.value = "$ " + new Intl.NumberFormat("de-DE").format((billete100 * 100000) + (billete50 * 50000) + (billete20 * 20000) + (billete10 * 10000) + (billete5 * 5000) + (billete2 * 2000) + (billete1 * 1000));
        totalBilletesF.value = (billete100 * 100000) + (billete50 * 50000) + (billete20 * 20000) + (billete10 * 10000) + (billete5 * 5000) + (billete2 * 2000) + (billete1 * 1000)
    }

    function dineroMonedas() {

        var moneda10 = parseInt(document.getElementById("moneda10").value);
        var moneda5 = parseInt(document.getElementById("moneda5").value);
        var moneda2 = parseInt(document.getElementById("moneda2").value);
        var moneda1 = parseInt(document.getElementById("moneda1").value);
        var moneda = parseInt(document.getElementById("moneda").value);

        var cantidadMonedas = document.getElementById("cantidadMonedas");
        var valorMonedas = document.getElementById("valorMonedas");
        var valorMonedasF = document.getElementById("valorMonedasF");

        cantidadMonedas.value = new Intl.NumberFormat("de-DE").format(moneda10 + moneda5 + moneda2 + moneda1 + moneda);
        valorMonedas.value = "$ " + new Intl.NumberFormat("de-DE").format(((moneda10 * 1000) + (moneda5 * 500) + (moneda2 * 200) + (moneda1 * 100) + (moneda * 50)));
        valorMonedasF.value = (moneda10 * 1000) + (moneda5 * 500) + (moneda2 * 200) + (moneda1 * 100) + (moneda * 50);
    }
</script>
<?php require_once('../../estructura/footer.php') ?>