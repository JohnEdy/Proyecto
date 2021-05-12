<?php

//Revisamos datos de la empresa para mostrar en el footer
$sqlEmpresas  = "SELECT
                  empresas.nombreEmpresas,
                  planes.nombrePlanes,
                  planes.cantidadParqueosHoras,
                  planes.cantidadParqueosMeses,
                  planes.cantidadArticulos,
                  (
                    SELECT
                        COUNT(*)
                    FROM
                        parqueos
                    WHERE
                        (
                            nitEmpresas = '$_SESSION[nitEmpresas]'
                        ) AND(
                            parqueos.estadoParqueos = '1' OR parqueos.estadoParqueos = '2'
                        ) AND parqueos.mensualidadParqueos = '0'
                  ) AS 'registrosHoras',
                  (
                    SELECT
                        COUNT(*)
                    FROM
                        parqueos
                    WHERE
                        (
                            nitEmpresas = '$_SESSION[nitEmpresas]'
                        ) AND(
                            parqueos.estadoParqueos = '1' OR parqueos.estadoParqueos = '2'
                        ) AND parqueos.mensualidadParqueos = '1'
                  ) AS 'registrosMes',
                  (
                    SELECT
                      COUNT(*)
                    FROM
                      articulos
                    WHERE nitEmpresas = '$_SESSION[nitEmpresas]'
                  ) AS 'registroArticulos'
                  FROM
                  empresas
                  LEFT JOIN planes ON planes.idPlanes = empresas.idPlanes
                  WHERE
                  empresas.nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutar     = mysqli_query($conexion, $sqlEmpresas);
$fetch        = mysqli_fetch_assoc($ejecutar);

//Revisamos que si haya registrado al menos un plan para mostrarle a los clientes en la página web esto para los administradores del sistema
@$sqlPlanes      = "SELECT COUNT(*) FROM planes";
@$ejecutarPlanes = mysqli_query($conexion, $sqlPlanes);
@$rowPlanes      = mysqli_fetch_row($ejecutarPlanes);

$archivoActual = basename($_SERVER['PHP_SELF']);

if ($rowPlanes[0] == 0 && $archivoActual != 'planes.php' && $_SESSION['idRoles'] == $idAdministradorSistema) { ?>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
    <div id="liveToast" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 10pt">
      <div class="toast-header" style="background-color: #ffd26b !important; border-top-left-radius: 10pt; border-top-right-radius: 10pt">
        <img src="../../img/softpark1.png" class="rounded me-2" style="width: 40pt;">
        <!-- bd-placeholder-img rounded me-2 -->
        <strong class="me-auto">SoftPark</strong>
        <small></small>
        <button type="button" class="btn-close btnCerrar" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body" style="margin-left: 10pt">
        SoftPark te informa que el sitio web no posee planes registrados actualmente.
        <div class="mt-2 pt-2 border-top">
          <a type="button" href="../configuracionSistema/planes.php" class="btn btn-primary btn-sm">Ingresar Plan&nbsp;<?php echo $btnRegistrar ?></a>
          <button type="button" class="btn btn-secondary btn-sm btnCerrar" data-bs-dismiss="toast">Cerrar&nbsp;<?php echo $btnCerrar ?></button>
        </div>
      </div>
    </div>
  </div>
<?php };

if (contadorMensajes($conexion, '0') > 0 && $archivoActual != 'solicitudes.php') { ?>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
    <div id="liveToast" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 10pt">
      <div class="toast-header" style="background-color: #ffd26b !important; border-top-left-radius: 10pt; border-top-right-radius: 10pt">
        <img src="../../img/softpark1.png" class="rounded me-2" style="width: 40pt;">
        <!-- bd-placeholder-img rounded me-2 -->
        <strong class="me-auto">SoftPark</strong>
        <small></small>
        <button type="button" class="btn-close btnCerrar" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body" style="margin-left: 10pt">
        SoftPark le informa que al momento usted tiene <?php echo contadorMensajes(@$conexion, '0') ?> solicitud(es) sin leer.
        <div class="mt-2 pt-2 border-top">
          <a type="button" href="../solicitudes/solicitudes.php" class="btn btn-primary btn-sm">Revisar Solicitudes&nbsp;<?php echo $btnRegistrar ?></a>
          <button type="button" class="btn btn-secondary btn-sm btnCerrar" data-bs-dismiss="toast">Cerrar&nbsp;<?php echo $btnCerrar ?></button>
        </div>
      </div>
    </div>
  </div>
  <!-- BOTONES PARA LOS ADMINSITRADORES DE LAS EMPRESAS -->
<?php } ?>

<?php if ($idMotocicleta == 'N' && $_SESSION['nitEmpresas'] != $nitParkingSoft) { ?>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
    <div id="liveToast" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 10pt">
      <div class="toast-header" style="background-color: #ffd26b !important; border-top-left-radius: 10pt; border-top-right-radius: 10pt">
        <img src="../../img/softpark1.png" class="rounded me-2" style="width: 40pt;">
        <!-- bd-placeholder-img rounded me-2 -->
        <strong class="me-auto">SoftPark</strong>
        <small></small>
        <button type="button" class="btn-close btnCerrar" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body" style="margin-left: 10pt">
        SoftPark le informa que al momento usted no ha marcado una motocicleta.
        <div class="mt-2 pt-2 border-top">
          <a type="button" href="../perfil/configuracion.php" class="btn btn-primary btn-sm">Ir a Configuración&nbsp;<?php echo $btnRegistrar ?></a>
          <button type="button" class="btn btn-secondary btn-sm btnCerrar" data-bs-dismiss="toast">Cerrar&nbsp;<?php echo $btnCerrar ?></button>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<div class="footer">
  <div class="">
    <div class="row">
      <div class="col-3" style="font-size: 10pt;">
        <b>Usuarios:</b> <?php echo $_SESSION['nombreUsuarios'] ?><br>
        <b>Empresa:</b> <?php echo $fetch['nombreEmpresas'] ?><br>
        <b>Rol:</b> <?php echo $nombreRoles[$_SESSION['idRoles']] ?>
      </div>
      <div class="col-6" style="text-align: center;">
        ©2021. Todos los derechos reservados. ParkingSoft <br>Aplicación realizada por SoftPark <br>
        <img src="../../img/softpark1.png" style="border: 0pt; height: 40pt;" alt=""><br>
        <?php if ($_SESSION['idRoles'] == $idAdministradorEmpresas) { ?>
          <a href="https://lm.facebook.com/l.php?u=https%3A%2F%2Ffb.me%2Fsoftpark24&h=AT2MMnHrA0Ypb5qrXRUMGiMig3_un3_0jifzZ-7YPb5xDTHBNH-v4ssnr43354-tbLRvrMJD3woJl8K4pdvHsk4Nq1J1UjylKpgM7lHF9OZ0DZOfLwDMZ5G8V2fkuxoow8g0ZQ" target="_blank" data-toggle="tooltip" title="Facebook"><img src="../../img/logoFacebook.png" alt=""></a>&nbsp;&nbsp;
          <a href="https://www.instagram.com/softpark000?r=nametag" target="_blank" data-toggle="tooltip" title="Instagram"><img src="../../img/logoInstagram.png" alt=""></a>&nbsp;&nbsp;
        <?php } ?>

      </div>
      <div class="col-3" style="text-align: center; font-size: 10pt;">
        <?php if ($_SESSION['idRoles'] == $idAdministradorEmpresas) { ?>
          <b>Plan Actual:</b> <?php echo $fetch['nombrePlanes'] ?><br>
          <b>Disp. Cantidad Registros Horas:</b> <?php echo ($fetch['cantidadParqueosHoras'] - $fetch['registrosHoras']) ?><br>
          <b>Disp. Cantidad Registros Meses:</b> <?php echo ($fetch['cantidadParqueosMeses'] - $fetch['registrosMes']) ?><br>
          <b>Disp. Cantidad Registros Artículos:</b> <?php echo ($fetch['cantidadArticulos'] - $fetch['registroArticulos']) ?><br>
        <?php } else { ?>
          <a href="https://lm.facebook.com/l.php?u=https%3A%2F%2Ffb.me%2Fsoftpark24&h=AT2MMnHrA0Ypb5qrXRUMGiMig3_un3_0jifzZ-7YPb5xDTHBNH-v4ssnr43354-tbLRvrMJD3woJl8K4pdvHsk4Nq1J1UjylKpgM7lHF9OZ0DZOfLwDMZ5G8V2fkuxoow8g0ZQ" target="_blank" data-toggle="tooltip" title="Facebook"><img src="../../img/logoFacebook.png" alt=""></a>&nbsp;&nbsp;
          <a href="https://www.instagram.com/softpark000?r=nametag" target="_blank" data-toggle="tooltip" title="Instagram"><img src="../../img/logoInstagram.png" alt=""></a>&nbsp;&nbsp;
        <?php } ?>
      </div>
    </div>
  </div>
</div>
</body>
<?php
if (isset($conexion)) {
  mysqli_close($conexion);
}
?>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script language="javascript" type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/localization/messages_es.js"></script>
<script>
  $(function() {
    $("#datepicker").datepicker({
      dateFormat: 'yy-mm-dd',
      maxDate: 0
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('.content').richText({
      toggleCode: false
    });
  });

  $('#myTab a').on('click', function(e) {
    e.preventDefault()
    $(this).tab('show')
  })


  $(document).ready(function() {
    $('#table').DataTable({
      language: {
        "lengthMenu": "Mostrar _MENU_ registros",
        "zeroRecords": "No se encontraron resultados",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar:",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
        "sProcessing": "Procesando...",
      }
    });
  });

  $(document).ready(function() {
    $("#liveToast").addClass("showing");
    $("#liveToast").addClass("show");
  })

  $(".btnCerrar").click(function() {
    $("#liveToast").removeClass("show");
    $("#liveToast").addClass("hide");
  })
</script>

<!-- Propio -->
<script src="../../js/main.js"></script>

</html>