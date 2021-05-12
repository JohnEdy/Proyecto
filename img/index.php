<?php require_once('estructura/variablesGlobales.php') ?>
<?php if (movilPC() == 'movil') { ?>
  <style>
    .navbar {
      flex-direction: column;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      text-align: center;
      display: none;
      order: 1;
    }

    .navbarMenu {
      display: none !important;
    }

    .navbar-collapse {
      flex-direction: column;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      text-align: center;
      display: none;
      order: 1;
    }

    .nav {
      flex-direction: column;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      text-align: center;
      display: none;
      order: 1;
    }

    .forms {
      align-items: center;
      text-align: center;
    }

    .logoHeader {
      display: none;
    }

    header .navbar {
      display: none;
    }

  </style>

  <div class="collapse" id="navbarToggleExternalContent">
    <div class="p-4" style="background-color: #fff4db;">
      
    </div>
  </div>
  <nav class="navbar navbar-dark" style="background-color: #fff4db;">
    <div class="container-fluid">
      <button class="navbar-toggler" style="background-color: #4e4e4e" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <button class="navbar-toggler" type="button">
        <a type="button" href="vistas/sinSesion/index.php" class="dropdown-item btn btn-sm btn-danger"><?php echo $usuarios ?>Iniciar Sesión</a>
      </button>
    </div>
  </nav>
<?php } ?>

<!Doctype html>
<html lang="es">
  <head>
    <?php include_once('estructura/variablesGlobales.php') ?>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

    <title><?php echo $titles ?></title>
  </head>
  <body class="bgImage">

    <nav class="navbar navbarMenu navbar-expand-lg navbar-light">
      <div class="container-fluid">
      <a href="inicio.php"><img class="nav-link" style="border: 0pt;" src="img/sofPark.png" width="50" height="50" alt="Logo"></a>
        <div class="collapse navbar-collapse justify-content-center" id="navbarTogglerDemo03" style="width: auto">
          <div>
            <ul class=" me-auto mb-2 mb-lg-0 nav nav-pills">
              <li class="nav-item">
                <a class="nav-link items <?php if($menuInicio == 'inicio') { echo "items-active"; } ?> btn-sm" href="../../index.php"><?php echo $btnInicio ?>Inicio</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="navbar-collapse collapse" id="navbarTogglerDemo03" style="width: auto;">
          <a type="button" href="vistas/sinSesion/index.php" class="btn btn-outline-primary btn-sm"><?php echo $usuarios ?>Iniciar Sesión</a>
        </div>
      </div>
    </nav>
<div class="container">

</div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script src="js/main.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

  </body>
</html>


