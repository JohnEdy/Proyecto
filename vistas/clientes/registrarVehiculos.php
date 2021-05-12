<?php $menuClientes = 'clientes'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idCajeroEmpresas && $_SESSION['idRoles'] != $idAdministradorEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>

<p class="titulos">Registrar Vehículos</p>
<div class="container-menu">
  <form class="" method="POST" action="">
    <ul class="nav justify-content-end">
      <li class="nav-item align-middle">
        <a class="btn btn-primary btn-sm" onclick="mostrarBuscarDocumento();"><?php echo $btnVer ?>&nbsp;Propietario por Documento</a>
      </li>
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#ingresarMarcaArticulos"><?php echo $btnMas ?>&nbsp;Ingresar Marca</button>
      </li>
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarArticulos"><?php echo $btnEliminar ?>&nbsp;Eliminar Marca</button>
      </li>
    </ul>
    <?php if (isset($_GET['add']) && $_GET['add'] == 1 && !isset($_POST['submit'])) { ?>
      <?php echo $siRegistros ?>
    <?php } else if (isset($_GET['add']) && $_GET['add'] == 0 && !isset($_POST['submit'])) { ?>
      <?php echo $noRegistros ?>
    <?php } else if (isset($_GET['delete']) && $_GET['delete'] == 1 && !isset($_POST['submit'])) { ?>
      <?php echo $siEliminar ?>
    <?php } else if (isset($_GET['delete']) && $_GET['delete'] == 0 && !isset($_POST['submit'])) { ?>
      <?php echo $noEliminar ?>
    <?php } ?>
    <?php include_once('../../registros/validarVehiculos.php') ?>
    <div class="row">
      <div class="col-3">
        <label for="placaVehiculos" class="form-label">Placa *</label>
        <input type="text" name="placaVehiculos" class="form-control" id="placaVehiculos" maxlength="7" value="<?php if (isset($_POST['submit'])) {
                                                                                                                  echo $_POST['placaVehiculos'];
                                                                                                                } else {
                                                                                                                  echo @$_GET['placa'];
                                                                                                                } ?>" onkeypress="placa()">
      </div>
      <div class="col-5">
        <label for="tipoVehiculos" class="form-label">Tipo Vehículo *</label>
        <?php cargarSelect($conexion, "SELECT idTipoVehiculos, nombreTipoVehiculos FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreTipoVehiculos", 'tipoVehiculos', 'class="form-control" id="tipoVehiculos"') ?>
      </div>
      <div class="col-4">
        <label for="colorVehiculos" class="form-label">Color *<i class="bi bi-asterisk"></i></label>
        <input type="text" class="form-control" name="colorVehiculos" id="colorVehiculos" value="<?php if (isset($_POST['submit'])) {
                                                                                                    echo $_POST['colorVehiculos'];
                                                                                                  } ?>" maxlength="20">
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <label for="idMarcaVehiculos" class="form-label">Marca *<i class="bi bi-asterisk"></i></label>
        <?php cargarSelect($conexion, "SELECT idMarcas, nombreMarcas FROM marcas WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreMarcas", "idMarcaVehiculos", "class='form-control' id='idMarcaVehiculos'"); ?>
      </div>
      <div class="col-6">
        <label for="documentoUsuarios" class="form-label">Propietario *<i class="bi bi-asterisk"></i></label>
        <?php cargarSelect($conexion, "SELECT documentoUsuarios, CASE WHEN ISNULL(nombre1Usuarios) THEN documentoUsuarios ELSE nombre1Usuarios END, apellido1Usuarios FROM usuarios WHERE nitEmpresas = '$_SESSION[nitEmpresas]' AND idRoles = '$idClienteEmpresas' ORDER BY nombre1Usuarios", "documento1Usuarios", "class='form-control' id='clienteNombre' style='display: inline'"); ?>
        <input type="text" name="documento2Usuarios" id="clienteDocumento" style="display: none;" class='form-control'>
      </div>
    </div>
    <div class="btnSubmit">
      <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?>Registrar</button>
      <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </form>
</div>

<div class="modal fade" id="ingresarMarcaArticulos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Ingresar Marca de Vehículos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../acciones/agregarMarcas.php" class="row" method="POST">
          <div class="row">
            <div class="col-12">
              <label for="idParqueos" class="form-label">Descripción *</label>
              <input type="text" class="form-control" name="nombreMarcas" maxlength="40" value="<?php echo isset($_POST['submitMarcas']) ? $_POST['nombreMarcas'] : '' ?>" id="nombreMarcas" onkeyup="mostrarSubmit();" autocomplete="off">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="submitMarcas" id="btnSubmitMarcas" class="btn btn-primary" style="display: none;"><?php echo $btnRegistrar ?>Registrar</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
      </div>
    </div>
  </div>
</div>
<?php
$consultaMarca = "SELECT idMarcas, nombreMarcas FROM marcas WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreMarcas";
$ejecutarMarca = mysqli_query($conexion, $consultaMarca);
$fetchMarca    = mysqli_fetch_all($ejecutarMarca);
?>
<div class="modal fade" id="eliminarArticulos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Eliminar Articulos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-sm table-hover table-light" id="table" style="width: 100%;">
            <thead>
              <th>Id</th>
              <th>Nombre</th>
              <th>Eliminar</th>
            </thead>
            <tbody>
              <?php foreach ($fetchMarca as $key => $value) : ?>
                <tr>
                  <td><?php echo $value[0] ?></td>
                  <td><?php echo $value[1] ?></td>
                  <td style="text-align: center;">
                    <a href="../acciones/agregarMarcas.php?id=<?php echo $value[0] ?>&&eliminar=1" data-toggle="tooltip" title="Eliminar"><?php echo $btnEliminar ?></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
      </div>
    </div>
  </div>
</div>

<script>
  function mostrarSubmit() {
    var btnSubmit = document.getElementById("btnSubmitMarcas");
    var nombreArticulos = document.getElementById("nombreMarcas");

    if (nombreArticulos.value.length >= 1) {
      btnSubmit.style.display = 'inline';
    } else {
      btnSubmit.style.display = 'none';
    }
  }
</script>

<?php require_once('../../estructura/footer.php') ?>