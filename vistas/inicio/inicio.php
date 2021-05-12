<?php $menuInicio = 'inicio'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
$consulta   = "SELECT nombreEmpresas FROM empresas WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutar   = mysqli_query($conexion, $consulta);
$fetch      = mysqli_fetch_row($ejecutar);
?>
<p class="titulos"></p>
<div class="container-menu">
    <?php if (isset($_GET['perm']) && $_GET['perm'] == 1) {
        echo $noPermisos;
    } ?>

    <?php if (isset($_GET['pass']) && $_GET['pass'] == 1) { ?>
        <div class="alert alert-success alertLogin">Contraseña modificada correctamente.</div>
    <?php } ?>

    <p class="tituloSecciones" style="text-align: center;">Bienvenido (a)</p>
    <p style="text-align: center;"><?php echo $_SESSION['nombreUsuarios'] ?></p>
    <p class="tituloSecciones" style="text-align: center;">Usted es: </p>
    <p style="text-align: center;"><?php echo $nombreRoles[$_SESSION['idRoles']] ?></p>
    <p class="tituloSecciones" style="text-align: center;">Pertenece a la empresa: </p>
    <p style="text-align: center;"><?php echo $fetch[0] ?></p>
</div>

<?php require_once('../../estructura/footer.php') ?>