<?php
include_once('estructura/conexion.php');

//Carga de planes
$sql = "SELECT * FROM planes INNER JOIN imagen ON planes.idImagen = imagen.idImagen";
$ejecutar = mysqli_query($conexion, $sql);

if ($ejecutar) {
  $planes = mysqli_fetch_all($ejecutar);
} else {
  $planes = '';
}

//Cargamos testimonios
$sql =  "SELECT
          testimonios.cargoTestimonios,
          testimonios.descripcionTestimonios,
          usuarios.nombre1Usuarios,
          usuarios.apellido1Usuarios,
          imagen.rutaImagen,
          empresas.nombreEmpresas
        FROM
          testimonios
          INNER JOIN usuarios ON usuarios.documentoUsuarios = testimonios.documentoUsuarios
          INNER JOIN imagen   ON imagen.idImagen            = testimonios.idImagen
          INNER JOIN empresas on empresas.nitEmpresas       = testimonios.nitEmpresas";
$ejecutarTest = mysqli_query($conexion, $sql);
$t = 0;

if ($ejecutarTest) {
  $testimonios = mysqli_fetch_all($ejecutarTest);
} else {
  $testimonios = "";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SoftPark</title>
  <meta name="description" content="Sitio web de la empresa de software para parqueadero SoftPark">
  <meta name="keywords" content="parqueadero, software, utilidad">

  <!-- Facebook Opengraph integration: https://developers.facebook.com/docs/sharing/opengraph -->
  <meta property="og:title" content="">
  <meta property="og:image" content="">
  <meta property="og:url" content="">
  <meta property="og:site_name" content="">
  <meta property="og:description" content="">

  <!-- Twitter Cards integration: https://dev.twitter.com/cards/  -->
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="">
  <meta name="twitter:title" content="">
  <meta name="twitter:description" content="">
  <meta name="twitter:image" content="">

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,300|Raleway:300,400,900,700italic,700,300,600">
  <link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/animate.css">
  <link rel="stylesheet" type="text/css" href="css/stylePrincipal.css">
  <link href="https://fonts.googleapis.com/css?family=Raleway+Dots" rel="stylesheet" type="text/css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>

  <link rel="shortcut icon" href="img/pestanha.ico" />

</head>

<body>

  <div class="loader"></div>
  <div id="myDiv">
    <!--HEADER-->
    <div class="header">
      <div class="bg-color">

        <header id="main-header">
          <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a href="index.html"><img src="img/softpark1.png" width="200"></a>
              </div>
              <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                  <li class="active"><a href="#main-header">Inicio</a></li>
                  <li class=""><a href="#feature">Nosotros</a></li>
                  <li class=""><a href="#service">Servicio</a></li>
                  <li class=""><a href="#portfolio">Portfolio</a></li>
                  <li class=""><a href="#testimonial">Equipo</a></li>
                  <li class=""><a href="#blog">Planes</a></li>
                  <li class=""><a href="#contact">Contacto</a></li>
                </ul>
              </div>
            </div>
          </nav>
        </header>

        <div class="wrapper">
          <div class="container">
            <div class="row">
              <div class="banner-info text-center wow fadeIn delay-05s">
                <h1 class="bnr-title">Sistema Web de Parqueo<span></span></h1>
                <h2 class="bnr-sub-title">Buscamos utilidad y eficacia</h2>
                <p class="bnr-para">Somos una empresa especializada en el desarrollo de software, principalmente en entornos de programación<br> La experiencia acumulada durante todos estos años y el uso de una programación basada en una arquitectura de componentes en php <br>SoftPark es una empresa de Consultoría y Servicios de Tecnologías</p>
                <div class="brn-btn">
                  <a href="vistas/loginRegistro/registrarEmpresa.php" class="btn btn-more" target="_blank">Registrarse</a>
                  <a href="vistas/sinSesion/index.php" class="btn btn-more" target="_blank">Iniciar Sesión</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ HEADER-->

    <section id="feature" class="section-padding wow fadeIn delay-05s">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="wrap-item text-center">
              <div class="item-img">
                <img src="img/aliado.png" width="200">
              </div>
              <h3 class="pad-bt15">Somos tu aliado</h3>
              <p>Nos preocupamos por ejecutar proyectos bajo los mejores estándares de innovación y calidad, para brindar a nuestros clientes una experiencia exitosa</p>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="wrap-item text-center">
              <div class="item-img">
                <img src="img/programador.png" width="150">
              </div>
              <h3 class="pad-bt15">Perfil de usuarios</h3>
              <p>Ingreso al sistema por cuentas de usuario con su respectiva contraseña, permisos, historial de ingresos al sistema, notificación por correo electrónico de inicio de sesión y cierres de caja</p>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="wrap-item text-center">
              <div class="item-img">
                <img src="img/caja-registradora.png" width="150">
              </div>
              <h3 class="pad-bt15">Registros de caja</h3>
              <p>Balances de Caja claros y detallados por empleado que permiten hacer cierres de caja por categorías o completos. Reportes de forma resumida, detallada por placa o por tarifa.</p>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="wrap-item text-center">
              <div class="item-img">
                <img src="img/candado.png" width="150">
              </div>
              <h3 class="pad-bt15">Sitio Seguro</h3>
              <p>Através de una comunicación cifrada, están aumentando cada vez más, y eso es bueno. Existen muchas razones para ello, siendo las principales la seguridad, la confidencialidad y la privacidad.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="service" class="section-padding wow fadeInUp delay-05s">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="service-title pad-bt15">¿QUÉ HACEMOS?</h2>
            <p class="sub-title pad-bt15"> Este Software permite agilizar y controlar el acceso de los vehículos a su parqueadero. Su uso y aprendizaje es sencillo, proporciona una variada gama de funciones que ayuda a los usuarios a aumentar su productividad, teniendo en cuenta que es un programa muy completo y sus funciones están integradas en una interfaz de fácil uso..</p>
            <hr class="bottom-line">
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="service-item">
              <h3><span>S</span>oftware de Parqueadero</h3>
              <p>Mediante tecnologías de diseño, experiencias de usuarios y desarrollo de software trabajamos en la creación digital, desarrollos de sitios web, aplicaciones webs y aplicaciones móviles.</p>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="service-item">
              <h3><span>R</span>egistros en la web</h3>
              <p>Parking es un software para la administración básica y avanzada de parqueaderos bajo tecnología Web</p>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12"></div>
        </div>
      </div>
    </section>

    <section id="portfolio" class="section-padding wow fadeInUp delay-05s">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="service-title pad-bt15">NUESTRo PRODUCTO</h2>
            <p class="sub-title pad-bt15">APLICATIVO WEB PARA LOS PARQUEADEROS DONDE ESTOS PUEDAN TENER SU INFORMACIÓN MÁS CENTRALIZADA Y ORGANIZADA</p>
            <hr class="bottom-line">
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 portfolio-item padding-right-zero mr-btn-15">
            <figure>
              <img src="img/inicio.PNG" class="img-responsive">
              <figcaption>
                <p>Iniciar Sesión, para softPark sirve como puente con el usuario para que interactúe con el hardware a través esta herramienta de facil uso</p>
              </figcaption>
            </figure>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 portfolio-item padding-right-zero mr-btn-15">
            <figure>
              <img src="img/empresa.PNG" class="img-responsive">
              <figcaption>
                <!-- <h2>Registre su Empresa</h2>-->
                <p>La aplicaciones web te permite tener una app que será accesible desde cualquier navegador en cualquier dispositivo. Además, al contrario de lo que sucede con las aplicaciones está, no requieren descarga.</p>
              </figcaption>
            </figure>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 portfolio-item padding-right-zero mr-btn-15">
            <figure>
              <img src="img/retiro.PNG" class="img-responsive">
              <figcaption>
                <p>Retiro Vehicular Se debe validar los datos de entrada y de salida del sistema para garantizar que es el usuario registrado.Los requisitos de seguridad deben ser identificados y consensuados antes de ejecutar la salida del sistemas de informacion.
                </p>
              </figcaption>
            </figure>
          </div>
        </div>
      </div>
    </section>

    <section id="testimonial" class="wow fadeInUp delay-05s">
      <div class="bg-testicolor">
        <div class="container section-padding">
          <div class="row">
            <div class="testimonial-item">
              <ul class="bxslider">
                <?php foreach ($testimonios as $key => $value) { ?>
                  <li>
                    <blockquote>
                      <img src="<?php echo $value[4] ?>" class="rounded-circle" style="width: 50pt !important; height: 50pt !important;">
                      <p><?php echo $value[1] ?></p>
                    </blockquote>
                    <small><?php echo $value[2] . " " . $value[3] . ", " . $value[0] . " - " . $value[5] ?></small>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="blog" class="section-padding wow fadeInUp delay-05s">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="service-title pad-bt15">Planes de uso de la plataforma web</h2>
            <p class="sub-title pad-bt15">Aquí podrá leer las características de cada uno de nuestros Planes de uso y decidir la mejor opción para su empresa. Puede usar la línea, una vez que haya decidido el Plan de su preferencia y agregar alguna de nuestras opciones de Capacitación remota o presencial.</p>
            <hr class="bottom-line">
          </div>
          <?php foreach ($planes as $key => $value) {
            $t++;
            if ($t == 4) {
              break;
            }
          ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="blog-sec">
                <div class="blog-img">
                  <a href="">
                    <img alt="Imagen Plan" style="width: 300px; height: 250px;" src="<?php echo $value[12] ?>" class="img-responsive">
                  </a>
                </div>
                <div class="blog-info">
                  <p style="font-weight: bold; text-align: center; font-size: 20pt;"><?php echo "$ " . number_format($value[3]) . " COP" ?></p>
                  <h2><?php echo $value[2] ?></h2>
                  <p>
                    <?php echo $value[1] ?>
                  </p>
                  <a href="" class="read-more"></a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
  </div>
  </section>

  <section id="contact" class="section-padding wow fadeInUp delay-05s">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center white">
          <h2 class="service-title pad-bt15">MANTENTE EN CONTACTO CON NOSOTROS</h2>
          <p class="sub-title pad-bt15">¿Quieres ponerte en contacto con nosotros? ¡Nos encantaría Estas son las opciones que tienes para hacerlo<br>Contacta con el equipo de asistencia técnica</p>
          <hr class="bottom-line white-bg">
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="loction-info white">
            <p><i class="fa fa-map-marker fa-fw pull-left fa-2x"></i>Av 30 de Agosto N° 30-47<br>Pereira, Risaralda</p>
            <p><i class="fa fa-envelope-o fa-fw pull-left fa-2x"></i>ctrujillo@unitecnica.net</p>
            <p><i class="fa fa-phone fa-fw pull-left fa-2x"></i>+57 3054028864</p>
            <p><img src="img/softpark1.png" style="border: 0pt; height: 40pt;" alt=""></p>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="contact-form">
            <div id="mensajeEnviado" style="color: green; font-weight: bold; margin-bottom: 10pt; display: none;">Tu mensaje fue enviado correctamente.</div>
            <div id="mensajeError" style="color: red; font-weight: bold; margin-bottom: 10pt; display: none;">Lo sentimos, hubo error con tú mensaje. Intenta nuevamente.</div>
            <form action="contactform/contactForm.php" method="POST" role="form" class="contactForm">
              <div class="col-md-6 padding-right-zero">
                <div class="form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Tu Nombre" data-rule="minlen:4" data-msg="Por favor, ingresa un nombre de más de 4 carácteres" />
                  <div class="validation"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Tu Correo Electrónico" data-rule="email" data-msg="Por favor, ingrese un correo válido" />
                  <div class="validation"></div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" data-rule="minlen:4" data-msg="Por favor, ingrese un asunto de mínimo 8 carácteres" />
                  <div class="validation"></div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Por favor escribe algo para nosotros" placeholder="Mensaje" id="message"></textarea>
                  <div class="validation"></div>
                </div>
                <button id="btnContact" type="submit" class="btn btn-primary btn-submit">Enviar</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="container-bar">
    <!--inicio de la seccion de las redes sociales-->
    <input type="checkbox" id="btn-social">
    <label for="btn-social" class="fa fa-play"></label>
    <div class="icon-social">
      <a href="https://lm.facebook.com/l.php?u=https%3A%2F%2Ffb.me%2Fsoftpark24&h=AT2MMnHrA0Ypb5qrXRUMGiMig3_un3_0jifzZ-7YPb5xDTHBNH-v4ssnr43354-tbLRvrMJD3woJl8K4pdvHsk4Nq1J1UjylKpgM7lHF9OZ0DZOfLwDMZ5G8V2fkuxoow8g0ZQ" target="_blank" class="fa fa-facebook">
        <span id="title">Facebook</span>
      </a>
      <a href="https://www.instagram.com/softpark000?r=nametag" target="_blank" class="fa fa-instagram">
        <span id="title">Instagram</span>
      </a>
      <a href="https://api.whatsapp.com/send?phone=573054028864" target="_blank" class="fa fa-whatsapp">
        <span id="title">Whatsapp</span>
      </a>
    </div>
  </div>
  <footer id="footer">
    <div class="container">
      <div class="row text-center">
        <p>&copy;Copyrights © | todos los derechos | Reservados</p>
        <div class="credits">
          <a href="#">SoftPark</a>
        </div>
      </div>
    </div>
  </footer>
  <!---->
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.easing.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/wow.js"></script>
  <script src="js/jquery.bxslider.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="contactform/contactform.js"></script>
  <script>
    $("#btnContact").click(function() {
      $.ajax({
        data: "name=" + $("#name").val() + "&&email=" + $("#email").val() + "&&subject=" + $("#subject").val() + "&&message=" + $("#message").val(),
        type: "POST",
        url: "ajax/datosFormularioContactenos.php",
        success: function(response) {
          if (response == 1) {
            $("#btnContact").prop("disabled", true);
            $("#mensajeEnviado").show();
            $("#mensajeError").hide();
          } else if (response == 0) {
            $("#mensajeError").show();
            $("#mensajeEnviado").hide();
          }
        },
        error: function(response) {
          console.log("Error: " + response);
        }
      });
    })
  </script>

</body>

</html>