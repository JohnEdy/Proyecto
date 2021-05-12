<?php $menuParqueos = 'parqueos'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idCajeroEmpresas) {
  echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
//Buscamos el id para el parqueo a registrar
$consultaParqueos = "SELECT MAX(idParqueosEmpresa) FROM parqueos WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarParqueos = mysqli_query($conexion, $consultaParqueos);
$fetchParqueos = mysqli_fetch_array($ejecutarParqueos);

$id = @$fetchParqueos[0] + 1;

//Si esta activado el parametro lavada, se modifica el nùmero de las columnas
if (otrosServicios($conexion, $_SESSION['nitEmpresas'], 'lavadaParametros')) {
  $col = '3';
} else {
  $col = '4';
}

$parqueoMensualidad = 0;

//Traemos los tipos de vehiculos registrados
$datosTipos     = "SELECT * FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarTipos  = mysqli_query($conexion, $datosTipos);
$datosVehiculos = mysqli_fetch_all($ejecutarTipos);


//Realizamos la consulta para validar si quedan disponibles màs registros
$sql = "SELECT
          planes.cantidadParqueosHoras,
          (
            SELECT
                COUNT(*)
            FROM
                parqueos
            WHERE
                (nitEmpresas = '$_SESSION[nitEmpresas]') AND(
                    estadoParqueos = '1' OR estadoParqueos = '2'
                ) AND(mensualidadParqueos = '0')
          ) AS 'cantidadHoras'
          FROM
            empresas
            INNER JOIN planes ON planes.idPlanes = empresas.idPlanes
          WHERE
            empresas.nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutarHoras = mysqli_query($conexion, $sql);
$cantidadRegistros = mysqli_fetch_assoc($ejecutarHoras);

$vehiculos = $tipoVehiculos;
?>
<p class="titulos">Registrar Parqueo</p>

<div class="container-menu">
  <?php if ($cantidadRegistros['cantidadHoras'] >= $cantidadRegistros['cantidadParqueosHoras']) { ?>
    <div class="alert alert-danger">Lo sentimos, ha cumplido con la cantidad permitida para los Parqueaderos por Hora</div>
  <?php } else { ?>
    <form action="" class="" method="POST" action="">
      <?php include_once('../../registros/validarParqueoHoras.php') ?>
      <ul class="nav justify-content-end">
        <li class="nav-item align-middle">
          <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarArticulos"><?php echo $btnVehiculos ?>&nbsp;Tipo Vehículos</button>
        </li>
        <li class="nav-item align-middle">
          <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#propietarioVehiculos"><?php echo $btnUsuarios ?>&nbsp;Propietarios</button>
        </li>
      </ul>

      <div class="row">
        <div class="col-1">
          <label for="idParqueos" class="form-label">Id</label>
          <input type="text" class="form-control" readonly name="idParqueos" id="colorVehiculos" value="<?php echo $id ?>" maxlength="20">
          <input type="hidden" name="mensualidadParqueos" value="0">
        </div>

        <div class="col-2">
          <label for="placaVehiculos" class="form-label">Placa Vehículos *</label>
          <input type="text" class="form-control" onkeyup="placa()" name="placaVehiculos" id="placaVehiculos" value="<?php echo (isset($_POST['submit'])) ? $_POST['placaVehiculos'] : '' ?>" maxlength="7">
        </div>

        <div class="col-3">
          <label for="placaVehiculos" class="form-label">Tipo Vehículos *</label>
          <?php echo cargarSelect($conexion, "SELECT idTipoVehiculos, nombreTipoVehiculos FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreTipoVehiculos", "tipoVehiculos", "class='form-control' id='tipoVehiculos'") ?>
        </div>

        <div class="col-2">
          <label for="documentoUsuarios" class="form-label">Fecha Parqueo: </label>
          <input type="text" readonly class="form-control" value="<?php echo date("d/m/Y") ?>" id="documentoUsuarios" maxlength="20">
        </div>

        <div class="col-2">
          <label for="horaParqueos" class="form-label">Hora Ingreso</label>
          <input type="text" class="form-control" name="horaParqueos" value="<?php echo (isset($_POST['submit'])) ? $_POST['horaParqueos'] : date("H:i:s") ?>" id="horaParqueos">
        </div>

        <div class="col-2">
          <label for="idParqueos" class="form-label">Cascos</label>
          <?php
          if (isset($_POST['submit']) && @$_POST['cantidadCascos'] == 0) {
            $checked0 = 'checked';
          } else if (isset($_POST['submit']) && $_POST['cantidadCascos'] == 1) {
            $checked1 = 'checked';
          } else if (isset($_POST['submit']) && $_POST['cantidadCascos'] == 2) {
            $checked2 = 'checked';
          } else {
            $checked0 = 'checked';
          }
          ?>
          <div class="row">
            <div class="col">
              <input type="radio" disabled class="form-check-input" <?php echo @$checked0 ?> name="cantidadCascos" id="cantidadCascos0" value="0" maxlength="20"><label for="cantidadCascos0">&nbsp;N/A</label>
            </div>
            <div class="col">
              <input type="radio" disabled class="form-check-input" <?php echo @$checked1 ?> name="cantidadCascos" id="cantidadCascos1" value="1" maxlength="20"><label for="cantidadCascos1">&nbsp;1</label>
            </div>
            <div class="col">
              <input type="radio" disabled class="form-check-input" <?php echo @$checked2 ?> name="cantidadCascos" id="cantidadCascos2" value="2" maxlength="20"><label for="cantidadCascos2">&nbsp;2</label>
            </div>
          </div>
        </div>

      </div>
      <div class="row">

        <div class="col">
          <label for="casilleroCascos" class="form-label">Nª Casillero</label>
          <input type="text" disabled name="casilleroCascos" id="casilleroCascos" class="form-control" value="<?php echo (isset($_POST['submit'])) ? @$_POST['casilleroCascos'] : '' ?>">
        </div>

        <div class="col">
          <label for="casilleroCascos" class="form-label">Retirar Por: </label>
          <?php
          //Validamos que checkbox estan activos y los marcamos
          if (isset($_POST['submit']) && @$_POST['enviarFactura'] == 1) {
            $enviarFactura = 'checked';
          } else {
            $enviarFactura = '';
          }

          if (isset($_POST['submit']) && @$_POST['imprimirFactura'] == 1) {
            $imprimirFactura = 'checked';
          } else {
            $imprimirFactura = '';
          }
          ?>

          <div class="row">
            <div class="col">
              <input class="form-check-input" type="checkbox" value="1" id="enviarFactura" <?php echo $enviarFactura ?> name="enviarFactura">
              <label for="enviarFactura">Correo</label>
            </div>
            <div class="col">
              <input class="form-check-input" type="checkbox" value="1" id="imprimirFactura" <?php echo $imprimirFactura ?> name="imprimirFactura">
              <label for="imprimirFactura">Fáctura</label>
            </div>
          </div>
        </div>

        <div class="col" style="display: none;" id="correoEnviar">
          <label for="emailUsuarios" class="form-label">Correo Electrónico</label>
          <input type="text" class="form-control" name="emailUsuarios" value="<?php echo (isset($_POST['submit'])) ? $_POST['emailUsuarios'] : '' ?>" id="emailUsuarios">
        </div>

        <?php if (otrosServicios($conexion, $_SESSION['nitEmpresas'], 'lavadaParametros')) { ?>
          <div class="col">
            <label for="lavadaVehiculos" class="form-label">¿Incluir Lavada?</label>
            <?php
            if (isset($_POST['submit']) && $_POST['lavadaParqueos'] == 1) {
              $checkedLavada1 = 'checked';
            } else if (isset($_POST['submit']) && $_POST['lavadaParqueos'] == 2) {
              $checkedLavada2 = 'checked';
            } else {
              $checkedLavada2 = 'checked';
            }
            ?>

            <div class="row">
              <div class="col">
                <input type="radio" class="form-check-input" <?php echo @$checkedLavada1 ?> value="1" id="lavadaParqueos1" name="lavadaParqueos">
                <label for="lavadaParqueos1">Sí</label>
              </div>
              <div class="col">
                <input type="radio" class="form-check-input" <?php echo @$checkedLavada2 ?> value="0" id="lavadaParqueos2" name="lavadaParqueos">
                <label for="lavadaParqueos2">No</label>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>

      <div class="btnSubmit">
        <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
        <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </form>
  <?php } ?>

</div>

<!-- Modales -->
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
                  <input type="hidden" name="archivoActual" value="parqueos/<?php echo basename(__FILE__) ?>">
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

<div class="modal fade" id="propietarioVehiculos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Ingresar Propietarios</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../acciones/registrarPropietarios.php" method="POST" id="frmPropietarios">
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
              <label for="documentoUsuarios" class="form-label">Documento *</label>
              <input autocomplete="off" type="text" class="form-control" name="documentoUsuarios" id="documentoPropietarios">
              <div id="mensaje_documentoPropietarios" style="color: red; font-size: 10pt; font-weight: bold;"></div>
            </div>
            <div class="col-6">
              <label for="emailUsuarios" class="form-label">Correo Electrónico *</label>
              <input autocomplete="off" type="email" class="form-control" name="emailUsuarios" id="emailPropietarios">
              <div id="mensaje_emailPropietarios" style="color: red; font-size: 10pt; font-weight: bold;"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <label for="nombre1Usuarios" class="form-label">Primer Nombre *</label>
              <input autocomplete="off" type="text" class="form-control" name="nombre1Usuarios" id="nombre1Propietarios">
              <div id="mensaje_nombre1Propietarios" style="color: red; font-size: 10pt; font-weight: bold;"></div>
            </div>
            <div class="col-3">
              <label for="nombre2Usuarios" class="form-label">Segundo Nombre</label>
              <input autocomplete="off" type="text" class="form-control" name="nombre2Usuarios" id="nombre2Propietarios">
            </div>
            <div class="col-3">
              <label for="apellido1Usuarios" class="form-label">Primer Apellido *</label>
              <input autocomplete="off" type="text" class="form-control" name="apellido1Usuarios" id="apellido1Propietarios">
              <div id="mensaje_apellido1Propietarios" style="color: red; font-size: 10pt; font-weight: bold;"></div>
            </div>
            <div class="col-3">
              <label for="apellido2Usuarios" class="form-label">Segundo Apellido</label>
              <input autocomplete="off" type="text" class="form-control" name="apellido2Usuarios" id="apellido2Propietarios">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="archivoActual" value="<?php echo basename(__FILE__) ?>">
          <button type="submit" style="display: none;" name="submitPropietarios" id="btnSubmitPropietario" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../../js/jquery-3.1.1.min.js"></script>
<script src="../../js/validarParqueosHoras.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    mostrarCorreo();
    cargarValoresTipoVehiculo();
  });

  $("#placaVehiculos").keyup(function() {
    cargarValoresTipoVehiculo();
  });

  function cargarValoresTipoVehiculo() {
    $.ajax({
      type: "POST",
      url: "../../ajax/datosTipoVehiculos.php",
      data: "placa=" + $("#placaVehiculos").val(),
      dataType: "json",
      success: function(tipoVehiculos) {
        console.log(tipoVehiculos);
        //Agregamos los datos del ajax al selec
        $("#tipoVehiculos").html(tipoVehiculos[0]);

        //Validamos que si se hayan encontrado los datos correctamente
        if (tipoVehiculos[2] == 1) {
          $("#tipoVehiculos").css('cursor', 'not-allowed');
          $("#tipoVehiculos").attr('readonly', 'readonly');
        } else {
          $("#tipoVehiculos").css('cursor', 'default');
          $("#tipoVehiculos").removeAttr('readonly');
        }

        //Validamos el tipo de vehiculo seleccionado
        if (tipoVehiculos[1] != <?php echo $idMotocicleta ?>) {
          $("#casilleroCascos").prop("disabled", true);
          $("#cantidadCascos0").prop("disabled", true);
          $("#cantidadCascos1").prop("disabled", true);
          $("#cantidadCascos2").prop("disabled", true);
        } else {
          $("#casilleroCascos").prop("disabled", false);
          $("#cantidadCascos0").prop("disabled", false);
          $("#cantidadCascos1").prop("disabled", false);
          $("#cantidadCascos2").prop("disabled", false);
        };
      },
      error: function(tipoVehiculos) {
        console.log(tipoVehiculos);
      }
    })
  }

  function mostrarCorreo() {
    if ($("#enviarFactura").prop("checked")) {
      $("#correoEnviar").show();
    } else {
      $("#correoEnviar").hide();
    }
  }

  $("#tipoVehiculos").change(function() {
    if ($("#tipoVehiculos option:selected").val() != <?php echo $idMotocicleta ?>) {
      $("#casilleroCascos").prop("disabled", true);
      $("#cantidadCascos0").prop("disabled", true);
      $("#cantidadCascos1").prop("disabled", true);
      $("#cantidadCascos2").prop("disabled", true);
    } else {
      $("#casilleroCascos").prop("disabled", false);
      $("#cantidadCascos0").prop("disabled", false);
      $("#cantidadCascos1").prop("disabled", false);
      $("#cantidadCascos2").prop("disabled", false);
    }
  });
</script>

<script>
  $("#home-tab").click(function() {
    $("#btnSubmitModal").show();
  })

  $("#profile-tab").click(function() {
    $("#btnSubmitModal").hide();
  })

  $("#tipoVehiculos").change(function() {
    if ($("#tipoVehiculos").val() == <?php echo $idMotocicleta ?>) {
      $("#cantidadCascos0").prop("disabled", false);
      $("#cantidadCascos1").prop("disabled", false);
      $("#cantidadCascos2").prop("disabled", false);
      $("#casilleroCascos").prop("disabled", false);
    } else {
      $("#cantidadCascos0").prop("disabled", true);
      $("#cantidadCascos1").prop("disabled", true);
      $("#cantidadCascos2").prop("disabled", true);
      $("#casilleroCascos").prop("disabled", true);
    };
  })

  $("#enviarFactura").change(function() {
    mostrarCorreo();
  })
</script>
<?php require_once('../../estructura/footer.php') ?>