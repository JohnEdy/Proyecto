<?php $menuMensajes = "mensajes" ?>
<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idAdministradorEmpresas && $_SESSION['idRoles'] != $idAdministradorSistema && $_SESSION['idRoles'] != $idCajeroEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>

<?php
if (!empty($_GET['id'])) {
  //Estado mensaje: 0 = no leído. 1 = leído. 2 = respondido. 3 = respuesta
  //Obtenemos el documento del cliente que envio el mensaje
  $consultaMensajes = "SELECT * FROM mensajes WHERE idMensajes = $_GET[id]";
  $ejecutarMensajes = mysqli_query($conexion, $consultaMensajes);
  $fetchMensajes = mysqli_fetch_row($ejecutarMensajes);

  $readonly = 'readonly';
} else {
  $readonly = '';
}
?>

<p class="titulos"><?php if (empty($_GET['id'])) {
                      echo "Solicitud";
                    } else {
                      echo "Responder";
                    } ?></p>
<div class="container-menu">
  <form class="" method="POST" action="">
    <?php include_once('../../registros/validarSolicitudes.php') ?>
    <div class="row">
      <label for="tituloMensajes" class="form-label">Título *</label>
      <input <?php echo $readonly ?> type="text" class="form-control" name="tituloMensajes" id="tituloMensajes" value="<?php if (isset($_POST['submit'])) {
                                                                                                                          echo $_POST['tituloMensajes'];
                                                                                                                        } else if (!empty($_GET['id'])) {
                                                                                                                          echo $fetchMensajes['1'];
                                                                                                                        } ?>" maxlength="30">
      <?php if (empty($_GET['id'])) : ?>
        <input type="hidden" name="estadoMensajes" value="0">
      <?php else : ?>
        <input type="hidden" name="estadoMensajes" value="2">
      <?php endif; ?>
    </div>
    <div class="row">
      <label for="tituloMensajes" class="form-label">Destinatario *</label>
      <?php if (isset($_GET['id'])) { ?>
        <?php echo cargarSelect($conexion, "SELECT documentoUsuarios, nombre1Usuarios, apellido1Usuarios FROM usuarios ", "s", "class='form-control'", $fetchMensajes[4], '1') ?>
        <input type="hidden" name="destinatarioMensajes" value="<?php echo $fetchMensajes[4] ?>">
      <?php } else if ($_SESSION['idRoles'] == $idAdministradorSistema) { ?>
        <?php echo cargarSelect($conexion, "SELECT documentoUsuarios, nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE idRoles = '$idAdministradorEmpresas' ORDER BY nombre1Usuarios", "destinatarioMensajes", "class='form-control'") ?>
      <?php } else { ?>
        <?php echo cargarSelect($conexion, "SELECT documentoUsuarios, nombre1Usuarios, apellido1Usuarios FROM usuarios WHERE (NOT documentoUsuarios = '$_SESSION[documentoUsuarios]' AND nitEmpresas = '$_SESSION[nitEmpresas]' OR nitEmpresas = '$nitParkingSoft') AND (idRoles = '$idAdministradorSistema' OR idRoles = '$idCajeroEmpresas') ORDER BY nombre1Usuarios", "destinatarioMensajes", "class='form-control'") ?>
      <?php } ?>
    </div>
    <div class="row">
      <label for="nitEmpresas" class="form-label">Mensaje *</label>
      <textarea name="descripcionMensajes" class="content"><?php if (isset($_POST['submit'])) {
                                                              echo $_POST['descripcionMensajes'];
                                                            } ?></textarea>
    </div>
    <div class="btnSubmit">
      <button type="submit" name="submit" id="btnSubmit" onclick="spinner();" class="btn btn-primary"><?php echo $btnRegistrar ?><?php if (isset($_GET['id'])) {
                                                                                                                                    echo "Responder Solicitud";
                                                                                                                                  } else {
                                                                                                                                    echo "Crear Solicitud";
                                                                                                                                  } ?></button>
      <div class="spinner-border text-primary" style="display: none; margin-right: auto; margin-left: auto;" role="status" id="spinner"></div>
      <span class="visually-hidden">Loading...</span>
    </div>
  </form>
</div>

<?php require_once('../../estructura/footer.php') ?>