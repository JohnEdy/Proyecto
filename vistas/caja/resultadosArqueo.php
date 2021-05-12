<?php $menuArqueos = 'arqueos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php if (empty($_GET['id'])) { ?>
    <script>location.href='../caja/registrarArqueo.php'</script>
<?php } ?>
<?php
$diaHoy = DATE("Y-m-d");
$consulta   =   "SELECT
                    *,
                    (
                    SELECT
                        CASE WHEN ISNULL(pagoServiciosParqueos) THEN 0 ELSE SUM(pagoServiciosParqueos) END
                    FROM
                        parqueos
                    WHERE
                        registroPor = '24694000' AND fechaRegistro LIKE '%$diaHoy%'
                ) AS 'pagoServiciosParqueos',
                (
                    SELECT
                        CASE WHEN ISNULL(precioCabecera) THEN 0 ELSE SUM(precioCabecera) END
                    FROM
                        cabeceraVentas
                    WHERE
                        registroPor = '24694000' AND fechaRegistro LIKE '%$diaHoy%'
                ) AS 'precioCabecera',
                usuarios.nombre1Usuarios AS 'nombre',
                usuarios.apellido1Usuarios AS 'apellido'
                FROM
                    arqueos
                    INNER JOIN usuarios ON usuarios.documentoUsuarios = arqueos.documentoUsuarios
                WHERE
                    arqueos.nitEmpresas = '$_SESSION[nitEmpresas]' AND arqueos.fechaRegistro LIKE '%$diaHoy%' AND arqueos.idArqueos = '$_GET[id]'";

$ejecutar   = mysqli_query($conexion, $consulta);
$fetch      = mysqli_fetch_assoc($ejecutar);
?>
<p class="titulos">Resultados Arqueo</p>
<div class="container-menu">
    <div id="seccionArqueo">
        <div style="text-align: center;">
            <h5 for="">El cajero <?php echo $fetch['nombre']." ".$fetch['apellido'] ?> debe tener un total de $ <?php echo number_format($fetch['pagoServiciosParqueos'] + $fetch['precioCabecera']) ?> COP en caja</h5>
        </div>
        <div style="text-align: center;">
            <h5 for="">y su resultado final del arqueo da un <strong>total de <?php echo "$ " . number_format($fetch['valorTotalMonedas'] + $fetch['valorTotalBilletes']) ?></strong> en caja y como <?php echo ($fetch['valorTotalMonedas'] + $fetch['valorTotalBilletes']) >= ($fetch['pagoServiciosParqueos'] + $fetch['precioCabecera']) ? ' <b>Sobrante  tenemos el valor de $ ' . number_format(($fetch['valorTotalMonedas'] + $fetch['valorTotalBilletes']) - ($fetch['pagoServiciosParqueos'] + $fetch['precioCabecera'])) . "</b>" : 'Faltante  ' . number_format(($fetch['valorTotalMonedas'] + $fetch['valorTotalBilletes']) - ($fetch['pagoServiciosParqueos'] + $fetch['precioCabecera'])) . "</b>" . number_format(($fetch['valorTotalMonedas'] + $fetch['valorTotalBilletes']) - ($fetch['pagoServiciosParqueos'] + $fetch['precioCabecera'])) . "</b>" ?></h5>
        </div>
        <p class="tituloSecciones btn" style="text-align: center; align-items: center;">Billetes&nbsp;&nbsp; <span class="btn btn-primary btn-sm" id="mostrarBilletes"><?php echo $btnMas ?></span><span class="btn btn-primary btn-sm" id="ocultarBilletes" style="display: none;"><?php echo $btnMenos ?></span></p>

        <!-- Billetes 100,000  50,000 y 20,000-->
        <div class="row" id="seccionBilletes" style="display: none;">
            <div class="col text-center" style="align-items: center;">
                <label for="billete100"><img style="border-radius: 10pt;" src="../../img/billete100.jpg" alt="Billete de $ 100.000" class="billete" data-bs-toggle="tooltip" title="Billete $ 100,000 COP"></label>
                <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                    <p><span style="font-weight: bold;"><?php echo $fetch['billete100Arqueos'] ?></span>&nbsp;Billete(s) de $ 100,000 COP</p>
                </div>
            </div>
            <div class="col text-center" style="align-items: center;">
                <label for="billete50"><img style="border-radius: 10pt;" src="../../img/billete50000.png" alt="Billete de $ 50.000" class="billete" data-bs-toggle="tooltip" title="Billete $ 50,000 COP"></label>
                <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                    <p><span style="font-weight: bold;"><?php echo $fetch['billete50Arqueos'] ?></span>&nbsp;Billete(s) de $ 50,000 COP</p>
                </div>
            </div>
            <div class="col text-center" style="align-items: center;">
                <label for="billete20"><img style="border-radius: 10pt;" src="../../img/billete20000.png" alt="Billete de $ 20.000" class="billete" data-bs-toggle="tooltip" title="Billete $ 20,000 COP"></label>
                <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                    <p><span style="font-weight: bold;"><?php echo $fetch['billete20Arqueos'] ?></span>&nbsp;Billete(s) de $ 20,000 COP</p>
                </div>
            </div>
            <div class="col text-center" style="align-items: center;">
                <label for="billete10"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Billete $ 10,000 COP" src="../../img/billete10000.png" alt="Billete de $ 10.000" class="billete"></label>
                <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                    <p><span style="font-weight: bold;"><?php echo $fetch['billete10Arqueos'] ?></span>&nbsp;Billete(s) de $ 10,000 COP</p>
                </div>
            </div>
            <!-- Billetes 10,000 5,000  2,000 1,000-->
            <div class="row">
                <div class="col text-center" style="align-items: center;">
                    <label for="billete5"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Billete $ 5,000 COP" src="../../img/billete5000.jpg" alt="Billete de $ 5.000" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <p><span style="font-weight: bold;"><?php echo $fetch['billete5Arqueos'] ?></span>&nbsp;Billete(s) de $ 5,000 COP</p>
                    </div>
                </div>
                <div class="col text-center" style="align-items: center;">
                    <label for="billete2"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Billete $ 2,000 COP" src="../../img/billete2000.jpg" alt="Billete de $ 20.000" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <p><span style="font-weight: bold;"><?php echo $fetch['billete2Arqueos'] ?></span>&nbsp;Billete(s) de $ 2,000 COP</p>
                    </div>
                </div>
                <div class="col text-center" style="align-items: center;">
                    <label for="billete1"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Billete $ 1,000 COP" src="../../img/billete1000.png" alt="Billete de $ 1.000" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <p><span style="font-weight: bold;"><?php echo $fetch['billete1Arqueos'] ?></span>&nbsp;Billete(s) de $ 1,000 COP</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="text-align: center;">
            <label for="">Se encuentra la cantidad de <strong><?php echo $fetch['cantidadTotalBilletes'] ?> billetes</strong>, para un <strong>total de <?php echo "$ " . number_format($fetch['valorTotalBilletes']) ?></strong>
            </label>
        </div>

        <p class="tituloSecciones btn" style="text-align: center; align-items: center;">Monedas&nbsp;&nbsp; <span class="btn btn-primary btn-sm" id="mostrarMonedas"><?php echo $btnMas ?></span><span class="btn btn-primary btn-sm" id="ocultarMonedas" style="display: none;"><?php echo $btnMenos ?></span></p>

        <!-- Monedas 1,000 500 y 200 -->
        <div id="seccionMonedas" style="display: none;">
            <div class="row">
                <div class="col text-center" style="align-items: center;">
                    <label for="moneda10"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 1,000 COP" src="../../img/moneda1000.png" alt="Moneda de $ 1.000" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <p><span style="font-weight: bold;"><?php echo $fetch['moneda100Arqueos'] ?></span>&nbsp;Monedas(s) de $ 1,000 COP</p>
                    </div>
                </div>
                <div class="col text-center" style="align-items: center;">
                    <label for="moneda5"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 500 COP" src="../../img/moneda500.png" alt="moneda de $ 500" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <p><span style="font-weight: bold;"><?php echo $fetch['moneda50Arqueos'] ?></span>&nbsp;Monedas(s) de $ 500 COP</p>
                    </div>
                </div>
                <div class="col text-center" style="align-items: center;">
                    <label for="moneda2"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 200 COP" src="../../img/moneda200.png" alt="moneda de $ 200" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <p><span style="font-weight: bold;"><?php echo $fetch['moneda20Arqueos'] ?></span>&nbsp;Monedas(s) de $ 200 COP</p>
                    </div>
                </div>
            </div>
            <!-- Moneda 100 y 50 -->
            <div class="row">
                <div class="col text-center" style="align-items: center;">
                    <label for="moneda1"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 100 COP" src="../../img/moneda100.png" alt="Moneda de $ 100" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <p><span style="font-weight: bold;"><?php echo $fetch['moneda10Arqueos'] ?></span>&nbsp;Monedas(s) de $ 100 COP</p>
                    </div>
                </div>

                <div class="col text-center" style="align-items: center;">
                    <label for="moneda"><img style="border-radius: 10pt;" data-bs-toggle="tooltip" title="Moneda $ 50 COP" src="../../img/moneda50.png" alt="moneda de $ 50" class="billete"></label>
                    <div style="margin-left: 20%; margin-right: 20%; margin-top: 15pt; margin-bottom: 15pt;">
                        <p><span style="font-weight: bold;"><?php echo $fetch['moneda5Arqueos'] ?></span>&nbsp;Monedas(s) de $ 50 COP</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="text-align: center;">
            <label for="">Se encuentra la cantidad de <strong><?php echo $fetch['cantidadTotalMonedas'] ?> monedas</strong>, para un <strong>total de <?php echo "$ " . number_format($fetch['valorTotalMonedas']) ?></strong>
        </div>
        <div class="btnSubmit">
            <a type="button" href="../caja/registrarArqueo.php" id="btnSubmit" class="btn btn-primary"><?php echo $btnAnterior ?>&nbsp;Volver A Arqueos</a>
        </div>
    </div>
</div>

<script>
    $("#mostrarBilletes").click(function() {
        $("#seccionBilletes").show(1000, "linear");
        $("#ocultarBilletes").show();
        $("#mostrarBilletes").hide();
    })

    $("#ocultarBilletes").click(function() {
        $("#seccionBilletes").hide(1000, "linear");
        $("#ocultarBilletes").hide();
        $("#mostrarBilletes").show();
    })

    $("#mostrarMonedas").click(function() {
        $("#seccionMonedas").show(1000, "linear");
        $("#ocultarMonedas").show();
        $("#mostrarMonedas").hide();
    })

    $("#ocultarMonedas").click(function() {
        $("#seccionMonedas").hide(1000, "linear");
        $("#ocultarMonedas").hide();
        $("#mostrarMonedas").show();
    })
</script>
<?php require_once('../../estructura/footer.php') ?>