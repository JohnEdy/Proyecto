<?php include_once('../../estructura/variablesGlobales.php') ?>
<?php include_once('../../estructura/conexion.php') ?>
<?php
@session_start();

if (@$_SESSION['validar'] == true || (isset($_GET['documento']))) {
  if (isset($_GET['documento']) && !empty($_GET['documento'])) {
    $documento = desencriptar($_GET['documento']);
    echo $control = 1;
  } else {
    $documento = $_SESSION['documentoUsuarios'];
    $control = 0;
  }
} else {
  header('refresh: 0.1, url=index.php');
}
?>

<!Doctype html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  <!-- CSS -->
  <!-- //<link rel="stylesheet" href="../../css/style.css"> -->
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="icon" type="image/png" href="../../img/pestanha.ico" />
  <link rel="stylesheet" href="style.css" />

  <title><?php echo $titles ?></title>

  <style>
    .alert {
      margin-top: 10pt;
      border-radius: 30pt;
    }

    .placaAlert {
      color: red;
      font-size: 8pt;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="#" class="sign-in-form" action="" method="POST">
          <h2 class="title">Modificar Contraseña</h2>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="passUsuarios1" id="" value="<?php echo (isset($_POST['submit'])) ? $_POST['passUsuarios1'] : '' ?>" maxlength="15" placeholder="Ingrese su nueva contraseña">
          </div>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="passUsuarios2" id="" value="<?php echo (isset($_POST['submit'])) ? $_POST['passUsuarios2'] : '' ?>" maxlength="15" placeholder="Confirme su contraseña">

          </div>

          <div style="align-items: center;">
            <input type="submit" name="submit" value="Confirmar" id="btnSubmit" onclick="spinner();" class="btn btn-primary btn-sm">
            <div class="spinner-border text-primary submitLogin" style="display: none" role="status" id="spinner">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>

          <p class="social-text">Síguenos en Nuestras Plataformas Dígitales</p>
          <div class="social-media">
            <a href="https://lm.facebook.com/l.php?u=https%3A%2F%2Ffb.me%2Fsoftpark24&h=AT2MMnHrA0Ypb5qrXRUMGiMig3_un3_0jifzZ-7YPb5xDTHBNH-v4ssnr43354-tbLRvrMJD3woJl8K4pdvHsk4Nq1J1UjylKpgM7lHF9OZ0DZOfLwDMZ5G8V2fkuxoow8g0ZQ" target="_blank" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://www.instagram.com/softpark000?r=nametag" target="_blank" class="social-icon">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </form>
        <?php
        if (isset($_POST['submit'])) {

          $pass1 = encriptar($_POST['passUsuarios1']);
          $pass2 = encriptar($_POST['passUsuarios2']);

          if (empty($pass1) || empty($pass2)) :
            echo "<div class='alert alert-danger'>No puede dejar información vacía.</div>";
            return false;
          endif;

          if ($pass1 === $pass2) {

            $consultaPass = "UPDATE usuarios SET passUsuarios = '" . $pass1 . "', passEstadoUsuarios = '0' WHERE documentoUsuarios = '$documento'";
            $ejecutarPass = mysqli_query($conexion, $consultaPass);

            if ($ejecutarPass) {

              if ($control == 1) {
                echo "<script>location.href='../sinSesion/index.php?pass=1'</script>";
              }

              //Validamos que el usuario no sea un administrador de empresas
              if ($_SESSION['idRoles'] == $idAdministradorEmpresas) {
                $consultaParametros = "SELECT COUNT(*) FROM parametros WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
                $ejecutarParametros = mysqli_query($conexion, $consultaParametros);
                $fetchParametros     = mysqli_fetch_array($ejecutarParametros);

                //Si es un administrador y no hay configuracion registrada, me lleva a realizarla
                if ($fetchParametros[0] == 0) {
                  echo "<script>location.href='../perfil/configuracion.php'</script>";
                  //Si estoy modifican una contraseña enviada por recuperaciòn, me lleva a iniciar sesion
                } else {
                  mysqli_close($conexion);
                  echo "<script>window.open('../inicio/inicio.php?pass=1')</script>";
                }
              } else {
                mysqli_close($conexion);
                header('refresh: 0.1, url=../inicio/inicio.php?pass=1');
              }
            }
          } else {
            //echo "<div class='alert alert-danger'>Lo sentimos, las contraseñas no coinciden.</div>";
            return false;
          }
        }
        ?>
        <form action="#" class="sign-up-form">
          <h2 class="title">Retira tu Vehículo</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Documento" />
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="placa" id="placaUsuario" onkeyup="placa();" pattern="[a-z]{1,15}" />
          </div>
          <span class="placaAlert"></span>

          <input type="submit" name="submitRetirar" class="btn" value="Ir a Retirar" />
          <p class="social-text">Sigenos en Nuestras Plataformas Digitales</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="">
          <h3></h3>
          <!-- <a class="btn transparent" href="../sinUsuario/usuario.php">
              
            </a> -->
        </div>
        <img src="../../img/softpark2.jpg" class="image" alt="" />
      </div>

      <div class="panel right-panel">
        <div class="content">
          <h3>¿Tienes un usuario?</h3>
          <p>
            Eres importante para nuetra compañia queremos que sigas trabajando con nosotros.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Inicia Sesión
          </button>
        </div>
        <img src="img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="app.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="https://rawcdn.githack.com/franz1628/validacionKeyCampo/bce0e442ee71a4cf8e5954c27b44bc88ff0a8eeb/validCampoFranz.js"></script>

</body>

</html>