<?php $menuMensajes = "mensajes" ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idAdministradorSistema && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php
//Arcchivo en el que estamos trabajando
$index = 'solicitudes';
//Campos para el buscador
$campos = array('idMensajes' => 'ID', 'fechaRegistro' => 'Fecha', 'estadoSolicitud' => 'Estado', 'documentoUsuarios' => 'Remitente');

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
  echo "<script>location.href='" . $index . ".php?page=1&&nro=10'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

if (isset($_POST['submit'])) {
  $txtBuscar = $_POST['buscador'];
  if (isset($_POST['idMensajes'])) {
    $condiciones = "AND mensajes.$_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ";
  } else if (isset($_POST['fechaRegistro'])) {
    $condiciones = "AND usuarios_mensajes.$_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ";
  } else if (isset($_POST['documentoUsuarios'])) {
    $condiciones = "AND mensajes.$_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ";
  } else if (isset($_POST['estadoSolicitud'])) {
    $condiciones = "AND usuarios_mensajes.$_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ";
  }
} else {
  $condiciones = '';
}

$consultaVerSolicitudes =     "SELECT
                                usuarios_mensajes.idMensajes,
                                usuarios_mensajes.estadoSolicitud,
                                mensajes.fechaRegistro,
                                usuarios.nombre1Usuarios,
                                usuarios.nombre2Usuarios,
                                usuarios.apellido1Usuarios,
                                usuarios.apellido2Usuarios
                              FROM
                                usuarios_mensajes
                                LEFT JOIN mensajes ON mensajes.idMensajes = usuarios_mensajes.idMensajes
                                LEFT JOIN usuarios ON usuarios.documentoUsuarios = mensajes.documentoUsuarios
                              WHERE
                                (
                                    usuarios_mensajes.documentoUsuarios = '$_SESSION[documentoUsuarios]'
                                ) /*AND(
                                    estadoSolicitud = '0' OR estadoSolicitud = '1'
                                )*/ $condiciones
                              ORDER BY
                                usuarios_mensajes.fechaRegistro
                                DESC
                              LIMIT $start, $nroRegistros";

$ejecutarVerSolicitudes = mysqli_query($conexion, $consultaVerSolicitudes);
$fetchMensajes = mysqli_fetch_all($ejecutarVerSolicitudes);
?>

<p class="titulos">Solicitudes</p>

<div class="buscador">
  <p class="tituloSecciones">Buscar</p>

  <form action="" method="POST">
    <div class="row">

      <div class="col-1"></div>
      <div class="col-3">
        <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control' id='buscador' onclick='opcionesSelect();'") ?>
      </div>

      <div class="col-4" id="idMensajes" style="display: none;">
        <input type="text" name="idMensajes" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['idMensajes'] : ''; ?>">
      </div>

      <div class="col-4" id="fechaRegistro" style="display: none;">
        <input type="text" class="form-control" name="fechaRegistro" id="datepicker" value="<?php if (isset($_POST['submit'])) {
                                                                                              echo $_POST['fechaRegistro'];
                                                                                            } else {
                                                                                              echo date("Y-m-d");
                                                                                            } ?>">
      </div>

      <div class="col-4" id="estadoSolicitud" style="display: none;">
        <?php cargarSelect('', $estadoMensajes, 'estadoSolicitud', "class='form-control'") ?>
      </div>

      <div class="col-4" id="documentoUsuarios" style="display: none;">
        <?php cargarSelect($conexion, 'SELECT documentoUsuarios, nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE idRoles = "' . $idAdministradorEmpresas . '"', 'documentoUsuarios', "class='form-control'") ?>
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
  <div class="table-responsive">
    <div class="cantidadPaginas">
      Mostrando &nbsp;
      <select name="" id="cantidadBusqueda" class="" onchange="enviarCantidadBusqueda('<?php echo $index ?>');">

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
        <th style="width: 5%">ID</th>
        <th style="width: 19%">Título</th>
        <th style="width: 19%">Estado</th>
        <th style="width: 19%">Remitente</th>
        <th style="width: 19%">Fecha envio</th>
        <th style="width: 19%">Acciones</th>
      </thead>
      <tbody>
        <?php if (empty($fetchMensajes)) { ?>

          <tr>
            <td colspan="6">
              <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
            </td>
          </tr>
        <?php } else { ?>

          <?php foreach ($fetchMensajes as $key => $value) : ?>
            <tr>
              <td style="width: 5%;"><?php echo $value[0] ?></td>
              <?php
              $consultaMensaje = "SELECT tituloMensajes FROM mensajes WHERE idMensajes = '$value[0]'";
              $ejecutarMensaje = mysqli_query($conexion, $consultaMensaje);
              $fetchMensaje = mysqli_fetch_row($ejecutarMensaje);
              ?>
              <td style="width: 28%;"><?php echo $fetchMensaje[0] ?></td>
              <td style="width: 15%;"><?php echo $estadoMensajes[$value[1]] ?></td>
              <td style="width: 5%;"><?php echo $value[3]." ".$value[4]." ".$value[5]." ".$value[6]?></td>
              <td style="width: 15%;"><?php echo $value[2] ?></td>
              <td style="width: 12%; text-align: center;">
                <?php if ($value[2] == 0 || $value[2] == 2) { ?>
                  <a href="responderSolicitudes.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Responder Solicitud"><?php echo $btnResponderSolicitud ?></a>
                <?php } ?>
                <a href="ver.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Ver Solicitud"><?php echo $btnVer ?></a>
              </td>
            </tr>
          <?php endforeach; ?>

        <?php } ?>
      </tbody>
      <tfoot class="table-dark">
        <th>ID</th>
        <th>Título</th>
        <th>Estado</th>
        <th>Remitente</th>
        <th>Fecha envio</th>
        <th>Acciones</th>
      </tfoot>
    </table>

    <?php paginacion($conexion, $consultaVerSolicitudes, $index, $_GET['page'], $nroRegistros); ?>

  </div>
</div>

<script>
  function opcionesSelect() {

    var select = document.getElementById("buscador").value;
    var idMensajes = document.getElementById("idMensajes").style;
    var fechaRegistro = document.getElementById("fechaRegistro").style;
    var estadoSolicitud = document.getElementById("estadoSolicitud").style;
    var documentoUsuarios = document.getElementById("documentoUsuarios").style;
    var submit = document.getElementById("submit").style;

    //idMensajes
    if (select == 'idMensajes') {
      idMensajes.display = 'inline';
      submit.display = 'inline';
    } else {
      idMensajes.display = 'none';
    }

    //tituloMensajes
    if (select == 'estadoSolicitud') {
      estadoSolicitud.display = 'inline';
      submit.display = 'inline';
    } else {
      estadoSolicitud.display = 'none';
    }

    //fechaRegistro
    if (select == 'fechaRegistro') {
      fechaRegistro.display = 'inline';
      submit.display = 'inline';
    } else {
      fechaRegistro.display = 'none';
    }

    //documentoUsuarios
    if (select == 'documentoUsuarios') {
      documentoUsuarios.display = 'inline';
      submit.display = 'inline';
    } else {
      documentoUsuarios.display = 'none';
    }

  }

  opcionesSelect();
</script>

<?php require_once('../../estructura/footer.php') ?>