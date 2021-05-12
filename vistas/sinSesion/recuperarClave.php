<!Doctype html>
<html lang="es">

<head>

    <?php include_once('../../estructura/variablesGlobales.php') ?>
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
                <?php require_once('../../registros/validarLogin.php') ?>
                <form action="../../registros/recuperarClave.php" class="sign-in-form" method="POST">
                    <h2 class="title">Recuperar Contraseña</h2>

                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" class="input100" name="documentoUsuarios" maxlength="14" placeholder="Documento" autocomplete="off">
                    </div>

                    <div style="align-items: center;" class="container-login100-form-btn">
                        <button type="submit" name="submitLogin" value="" id="btnSubmit" onclick="spinner();" class="btn btn-primary">Recuperar Clave</button>
                        <div class="spinner-border text-primary submitLogin" style="display: none" role="status" id="spinner">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <a style="font-size: 9pt; text-decoration:none; color: black;" href="index.php">¿Ya posees un usuario? Inicia Sesión</a>
                    <span class="social-text">Síguenos en Nuestras Plataformas Dígitales</span>
                    <div class="social-media">
                        <a href="https://lm.facebook.com/l.php?u=https%3A%2F%2Ffb.me%2Fsoftpark24&h=AT2MMnHrA0Ypb5qrXRUMGiMig3_un3_0jifzZ-7YPb5xDTHBNH-v4ssnr43354-tbLRvrMJD3woJl8K4pdvHsk4Nq1J1UjylKpgM7lHF9OZ0DZOfLwDMZ5G8V2fkuxoow8g0ZQ" target="_blank" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/softpark000?r=nametag" target="_blank" class="social-icon">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </form>

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
                    <h3>¿Desea Retirar su vehículo?</h3>
                    <a class="btn transparent" href="../sinUsuario/usuario.php">
                        Retirar
                    </a>
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