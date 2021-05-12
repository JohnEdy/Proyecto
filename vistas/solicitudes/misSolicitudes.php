<?php $menuMensajes = "mensajes" ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
  echo "<script>location.href='misSolicitudes.php?page=1&&nro=10'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

if (isset($_POST['submit'])) {
  $txtBuscar = $_POST['buscador'];
  $condiciones = "AND $_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ORDER BY $txtBuscar";
} else {
  $condiciones = 'ORDER BY fechaRegistro DESC';
}

$consultaVerSolicitudes = "SELECT * FROM mensajes WHERE documentoUsuarios = '$_SESSION[documentoUsuarios]' AND estadoMensaje = '1' $condiciones LIMIT $start, $nroRegistros";
$ejecutarVerSolicitudes = mysqli_query($conexion, $consultaVerSolicitudes);
@$rowVerSolicitudes = mysqli_num_rows($ejecutarVerSolicitudes);
@$fetchMensajes = mysqli_fetch_all($ejecutarVerSolicitudes);

$campos = array('tituloMensajes' => 'Título', 'fechaRegistro' => 'Fecha', 'estadoMensaje' => 'Estado');
?>
<p class="titulos">Mis Solicitudes</p>
<div class="buscador">
  <p class="tituloSecciones">Buscar</p>
  <form action="" method="POST">
    <div class="row">
      <div class="col-1"></div>
      <div class="col-3">
        <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control' id='buscador' onclick='opcionesSelect();'") ?>
      </div>
      <div class="col-4" id="tituloMensajes" style="display: none;">
        <input type="text" name="tituloMensajes" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['tituloMensajes'] : ''; ?>">
      </div>
      <div class="col-4" id="fechaRegistro" style="display: none;">
        <input type="text" class="form-control" name="fechaRegistro" id="datepicker" value="<?php if (isset($_POST['submit'])) {
                                                                                              echo $_POST['fechaRegistro'];
                                                                                            } else {
                                                                                              echo date("Y-m-d");
                                                                                            } ?>">
      </div>
      <div class="col-4" id="estadoMensaje" style="display: none;">
        <?php cargarSelect('', $estadoMensajes, 'estadoMensaje', "class='form-control'") ?>
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

<div class="container-menu">
  <?php if (@$_GET['elim'] == 1) { ?>
    <?php echo $siEliminar ?>
  <?php } ?>
  <div class="table-responsive">
    <div class="cantidadPaginas">
      Mostrando &nbsp;
      <select name="" id="cantidadBusqueda" class="" onchange="enviarCantidadBusqueda('misSolicitudes');">
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

    <table class="table table-sm table-hover table-light">
      <thead class="table-dark">
        <th>ID</th>
        <th>Título</th>
        <th>Estado</th>
        <th>Fecha envio</th>
        <th>Acciones</th>
      </thead>
      <tbody>
        <?php if (empty($fetchMensajes)) { ?>
          <tr>
            <td colspan="5">
              <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
            </td>
          </tr>
        <?php } else { ?>
          <?php foreach (@$fetchMensajes as $key => $value) : ?>
            <tr>
              <td style="width: 5%;"><?php echo $value[0] ?></td>
              <td style="width: 28%;"><?php echo $value[1] ?></td>
              <?php
              $consultaEstado = "SELECT estadoSolicitud FROM usuarios_mensajes WHERE idMensajes = '$value[0]'";
              $ejecutarEstado = mysqli_query($conexion, $consultaEstado);
              $fetchEstado = mysqli_fetch_array($ejecutarEstado);
              ?>

              <td style="width: 15%;"><?php echo $estadoMensajes[$fetchEstado[0]] ?></td>
              <td style="width: 15%;"><?php echo $value[3] ?></td>
              <td style="width: 12%; text-align: center;">
                <?php if ($value[2] == 0 || $value[2] == 2) { ?>
                  <a href="responderSolicitudes.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Responder Solicitud"><?php echo $btnResponderSolicitud ?></a>
                <?php } ?>
                <a href="ver.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Ver Solicitud"><?php echo $btnVer ?></a>
                <a href="" data-toggle="tooltip" title="Eliminar Solicitud" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $value[0] ?>"><?php echo $btnEliminar ?></a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php } ?>
      </tbody>
      <tfoot class="table-dark">
        <th>ID</th>
        <th>Título</th>
        <th>Estado</th>
        <th>Fecha envio</th>
        <th>Acciones</th>
      </tfoot>
    </table>

    <?php paginacion($conexion, $consultaVerSolicitudes, 'misSolicitudes', @$_GET['page'], $nroRegistros); ?>
  </div>
</div>

<!-- MODALES PARA ELIMINAR LA SOLICITUD -->
<?php foreach (@$fetchMensajes as $key => $value) : ?>
  <div class="modal fade" id="exampleModal-<?php echo $value[0] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Eliminar Solicitud #<?php echo $value[0] ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger"><?php echo $preguntaEliminar ?></div>
          <p class="subtitulos">Título de la solicitud a Eliminar: </p>
          <p class="informacion"><?php echo $value[1] ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $cerrarSesion ?>Cerrar</button>
          <a type="button" class="btn btn-primary" href="../eliminar/eliminarSolicitudes.php?id=<?php echo $value[0] ?>"><?php echo $btnEliminar ?>&nbsp;Eliminar Solicitud</a>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<script>
  function opcionesSelect() {

    var select = document.getElementById("buscador").value;
    var tituloMensajes = document.getElementById("tituloMensajes").style;
    var fechaRegistro = document.getElementById("fechaRegistro").style;
    var estadoMensaje = document.getElementById("estadoMensaje").style;
    var submit = document.getElementById("submit").style;

    //tituloMensajes
    if (select == 'tituloMensajes') {
      tituloMensajes.display = 'inline';
      submit.display = 'inline';
    } else {
      tituloMensajes.display = 'none';
    }

    //tituloMensajes
    if (select == 'estadoMensaje') {
      estadoMensaje.display = 'inline';
      submit.display = 'inline';
    } else {
      estadoMensaje.display = 'none';
    }

    //fechaRegistro
    if (select == 'fechaRegistro') {
      fechaRegistro.display = 'inline';
      submit.display = 'inline';
    } else {
      fechaRegistro.display = 'none';
    }

  }

  opcionesSelect();
</script>


<?php require_once('../../estructura/footer.php') ?>