<?php include_once('../../estructura/variablesGlobales.php') ?>
<?php include_once('../../estructura/conexion.php') ?>
<?php
@session_start();
@$ahora = date("Y-n-j H:i:s");
@$_SESSION['fechaConexion'];
@$i = @$_GET['i'];

//Validamos, tiempo de sesión
if (empty(@$i) &&  @$i != 1 && @$menuIndex != 'index') {
  if (@$i != '1' && @$_SESSION['validar'] == true) {
    # code...
  } else {
    header('refresh: 0.1, url=../sinSesion/index.php');
  }

  if (@$archivo != 'usuario.php' && time() - @$_SESSION['fechaConexion'] > 900 && @$_SESSION['validar'] == true) {
    session_destroy();
    echo "<script>location.href='../sinSesion/index.php?login=1'</script>";
  }
}

//Creamos una consulta para mostrar el logo de la empresa que se logue, si el usuario lo desea. Si no, se muestra el logo de SoftPark
$sql = "SELECT imagen.rutaImagen FROM empresas INNER JOIN imagen ON empresas.idImagen = imagen.idImagen WHERE nitEmpresas = '$_SESSION[nitEmpresas]'";
$ejecutar = mysqli_query($conexion, $sql);
$log = mysqli_fetch_row($ejecutar);

if (!empty($log[0]) && $log[0] != NULL) {
  $rutaLogo = "../../" . $log[0];
} else {
  $rutaLogo = "../../img/softpark1.png";
}
@$_SESSION['fechaConexion'] = time();


//Creamos una consulta para verificar el pago del mes actual, y no aplica para los gratuitos id = 1
$sqlPago =  "SELECT
          COUNT(*),
          (SELECT idPlanes FROM empresas WHERE nitEmpresas = '$_SESSION[nitEmpresas]')
        FROM
          pagos
          INNER JOIN anho     ON pagos.idAnho         = anho.idAnho
          INNER JOIN meses    ON meses.idMes          = pagos.idMes
        WHERE
          pagos.nitEmpresas = '$_SESSION[nitEmpresas]' AND (
            anho.descripcionAnho LIKE '%" . date("Y") . "%' AND anho.nitEmpresas = '$_SESSION[nitEmpresas]'
          ) AND  meses.idMes = '" . date("n") . "'";

$ejecutar = mysqli_query($conexion, $sqlPago);
$fetch = mysqli_fetch_array($ejecutar);

if ($fetch[0] == 0 && $_SERVER['SCRIPT_FILENAME'] != '/opt/lampp/htdocs/Proyecto/vistas/premium/comprarPlanes.php' && $_SESSION['idRoles'] == $idAdministradorEmpresas && $fetch[1] != 1) {
  echo "<script>location.href='../premium/comprarPlanes.php?pag=1'</script>";
}
?>

<!Doctype html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- JQuery CSS -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/notification.css">

  <!-- JQuery Plugin TextArea -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../css/style.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="../../css/richtext.min.css">
  <script src="../../js/jquery.richtext.js"></script>
  <script src="http://blog.ikhuerta.com/jsDownload/dollar_get.js" type="text/javascript"></script>

  <!-- DataTables -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
  <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

  <link rel="shortcut icon" href="../../img/pestanha.ico" />

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    @media (max-width: 767px) {
      .navbar {
        margin-bottom: 90pt !important;
      }

      .d-flex {
        float: right !important;
        margin-right: 30pt;
      }
    }
  </style>
  <title><?php echo @$titles ?></title>
</head>

<body class="bgImage">
  <!-- Menù de navegación -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="http://www.softpark.epizy.com" target="_blank"><img class="nav-link" style="border: 0pt; height: 50pt;" src="<?php echo $rutaLogo ?>" alt="ParkingSoft"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" style=" background: #4e4e4e;">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <!-- Menu de Inicio -->
          <li class="nav-item">
            <a class="nav-link items <?php if (@$menuInicio == 'inicio') {
                                        echo "items-active";
                                      } ?> btn-sm" href="../inicio/inicio.php"><?php echo @$btnInicio ?>Inicio</a>
          </li>
          <!-- Menu de Administradores -->
          <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idAdministradorEmpresas) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php echo (@$menuAdministradores == 'administradores') ? "items-active" : '' ?> items" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$btnAdministradores ?>Administradores
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="../administradorEmpresas/consultarParqueos.php"><?php echo @$btnParqueos ?>Consultar Parqueos</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../administradorEmpresas/verVehiculos.php"><?php echo @$btnVehiculos; ?>Consultar Vehículos</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../administradorEmpresas/registrarClientes.php"><?php echo @$btnRegistrarUsuarios; ?>Registrar Usuario</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../administradorEmpresas/verUsuarios.php"><?php echo @$usuarios; ?>Ver Usuarios</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../administradorEmpresas/testimonios.php"><?php echo @$btnUsuarios; ?>Testimonios</a>
                </li>
              </ul>
            </li>
          <?php } ?>
          <!-- Menu de Admin Sistema -->
          <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idAdministradorSistema) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php echo (@$menuAdministradoresSis == 'administradoresSis') ? "items-active" : '' ?> items" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$btnAdministradores ?>Admin Sistema
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="../administradorSistema/consultarEmpresas.php"><?php echo @$btnEmpresas; ?>Consultar Empresas</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../administradorSistema/registrarEmpresas.php"><?php echo @$btnEmpresas; ?>Registrar Empresa</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../administradorSistema/registrarClientes.php"><?php echo @$btnRegistrarUsuarios; ?>Registrar Usuario</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../administradorSistema/verUsuarios.php"><?php echo @$usuarios; ?>Ver Usuarios</a>
                </li>
              </ul>
            </li>
          <?php } ?>
          <!-- Menu de Caja -->
          <?php if (@$archivo != 'usuario.php' && (@$_SESSION['idRoles'] == @$idAdministradorEmpresas || @$_SESSION['idRoles'] == @$idCajeroEmpresas)) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php echo (@$menuArqueos == 'arqueos') ? "items-active" : '' ?> items" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$btnCajas ?>Caja
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idAdministradorEmpresas) { ?>
                  <li>
                    <a class="dropdown-item" href="../caja/registrarArqueo.php"><?php echo @$btnArqueos; ?>Registrar Arqueo</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="../caja/consultarArqueo.php"><?php echo @$btnArqueos; ?>Consultar Arqueo</a>
                  </li>
                <?php } ?>
                <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idCajeroEmpresas) { ?>
                  <li>
                    <a class="dropdown-item" href="../caja/registrarArqueo.php"><?php echo @$cerrarSesion; ?>Cierre de Caja</a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <!-- Menu de Clientes -->
          <?php if (@$archivo != 'usuario.php' && (@$_SESSION['idRoles'] == @$idAdministradorEmpresas || @$_SESSION['idRoles'] == @$idCajeroEmpresas)) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php echo (@$menuClientes == 'clientes') ? "items-active" : '' ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$usuarios ?>Clientes
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="../clientes/registrarVehiculos.php"><?php echo @$btnVehiculos; ?>Registrar Vehículo</a>
                </li>
                <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idCajeroEmpresas) { ?>
                  <li>
                    <a class="dropdown-item" href="../clientes/registrarClientes.php"><?php echo @$btnRegistrarUsuarios; ?>Registrar Usuario</a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <!-- Menu de información -->
          <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idClienteEmpresas) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php if (@$menuInformación == 'informacion') {
                                                                echo "items-active";
                                                              } ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$btnUsuarios ?>Información
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="../parqueos/parqueo.php"><?php echo @$btnParqueos; ?>Consultar Parqueo</a>
                </li>
              </ul>
            </li>
          <?php } ?>
          <!-- Menu de Parqueos -->
          <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idAdministradorEmpresas || @$_SESSION['idRoles'] == @$idCajeroEmpresas) { ?>
            <?php if (otrosServicios(@$conexion, @$_SESSION['nitEmpresas'], @$configHoras) || otrosServicios(@$conexion, @$_SESSION['nitEmpresas'], @$configMeses)) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link items btn-sm dropdown-toggle <?php echo (@$menuParqueos == 'parqueos') ? "items-active" : '' ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo @$btnParqueos ?>Parqueos
                </a>
                <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                  <?php if (@$archivo != 'usuario.php' && otrosServicios(@$conexion, @$_SESSION['nitEmpresas'], @$configHoras)) { ?>
                    <li>
                      <a class="dropdown-item" href="../parqueos/registrarParqueos.php"><?php echo @$btnParqueos; ?>Registrar Parqueos</a>
                    </li>
                  <?php } ?>
                  <?php if (@$archivo != 'usuario.php' && otrosServicios(@$conexion, @$_SESSION['nitEmpresas'], @$configMeses)) { ?>
                    <li>
                      <a class="dropdown-item" href="../parqueos/registrarParqueosMes.php"><?php echo @$btnParqueos; ?>Registrar Parqueo Por Mes</a>
                    </li>
                  <?php } ?>
                  <li>
                    <a href="../parqueos/retirarVehiculos.php" class="dropdown-item"><?php echo @$btnRetirar ?>Retirar Vehículo</a>
                  </li>
                </ul>
              </li>
            <?php } ?>
          <?php } ?>
          <!-- Menu de Pagos -->
          <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idAdministradorSistema) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php if (@$menuPagos == 'pagos') {
                                                                echo "items-active";
                                                              } ?> items" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$btnRegistrarPagos ?>Pagos
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="../pagos/registrarPagos.php"><?php echo @$btnMas; ?>Ingresar Pagos</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pagos/consultarPlanes.php"><?php echo @$btnVer; ?>Consultar Pagos</a>
                </li>
              </ul>
            </li>
          <?php } ?>
          <!-- Menu de solicitudes -->
          <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] != @$idClienteEmpresas) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php echo (@$menuMensajes == "mensajes") ? "items-active" : '' ?> items" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$btnSolicitudes ?>Solicitudes
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <?php if (@$_SESSION['idRoles'] == @$idCajeroEmpresas || @$_SESSION['idRoles'] == @$idAdministradorSistema) { ?>
                  <li>
                    <a class="dropdown-item" href="../solicitudes/solicitudes.php"><?php echo @$btnVerSolicitudes; ?>Solicitudes</a>
                  </li>
                <?php } ?>
                <?php if (@$_SESSION['idRoles'] == @$idAdministradorSistema || @$_SESSION['idRoles'] == @$idAdministradorEmpresas) { ?>
                  <li>
                    <a class="dropdown-item" href="../solicitudes/responderSolicitudes.php"><?php echo @$btnCrearSolicitudes; ?>Crear Solicitud</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="../solicitudes/misSolicitudes.php"><?php echo @$btnVerMisSolicitudes; ?>Mis Solicitudes</a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <!-- Menu de ARTÍCULOS -->
          <?php if (@$archivo != 'usuario.php' && otrosServicios(@$conexion, @$_SESSION['nitEmpresas'], @$configArticulos) && $_SESSION['idRoles'] != $idClienteEmpresas) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php echo (@$menuArtículos == 'articulos') ? "items-active" : '' ?> items" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$btnArticulos ?>Artículos
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="../articulos/registrarArticulos.php"><?php echo @$btnRegistrarArticulos; ?>Registrar Artículos</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../articulos/consultarArticulos.php"><?php echo @$btnVerRegistros; ?>Consultar Artículos</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../articulos/ventasArticulos.php"><?php echo @$btnRegistrarArticulos; ?>Registrar Ventas</a>
                </li>
                <?php if (@$_SESSION['idRoles'] == @$idAdministradorEmpresas) { ?>
                  <li>
                    <a class="dropdown-item" href="../articulos/verVentas.php"><?php echo @$btnVerRegistros; ?>Ventas Articulos</a>
                  </li>
                <?php } ?>

              </ul>
            </li>
          <?php } ?>
          <!-- Menu de ARTÍCULOS para clientes-->
          <?php if (@$archivo != 'usuario.php' && otrosServicios(@$conexion, @$_SESSION['nitEmpresas'], @$configArticulos) && $_SESSION['idRoles'] == $idClienteEmpresas) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php echo (@$menuArtículos == 'articulos') ? "items-active" : '' ?> items" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$btnArticulos ?>Artículos
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="../articulos/realizarCompras.php"><?php echo @$btnRegistrarArticulos; ?>Realizar Compras</a>
                </li>
              </ul>
            </li>
          <?php } ?>
          <!-- Menu de CONFIGURACION -->
          <?php if ($_SESSION['idRoles'] == $idAdministradorSistema) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link items btn-sm dropdown-toggle <?php echo (@$menuConfigAdmin == 'configAdmin') ? "items-active" : '' ?> items" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo @$btnConfiguraciones ?>Configuración
              </a>
              <ul class="dropdown-menu" style="border-radius: 10pt;" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="../configuracionSistema/planes.php"><?php echo @$btnRegistrarArticulos; ?>Planes</a>
                </li>
              </ul>
            </li><?php require_once('../../estructura/header.php') ?>
          <?php } ?>
        </ul>
        <?php if (@$_SESSION['idRoles'] == @$idAdministradorEmpresas) { ?>
          <div class="navbar-collapse d-flex" id="navbarTogglerDemo03" style="width: 11%;">
            <a class="btn btn-sm btn-primary" href="../premium/comprarPlanes.php"><?php echo $btnPremium ?>Adquirir Planes</a>
          </div>
        <?php } ?>
        <div class="navbar-collapse d-flex" id="navbarTogglerDemo03" style="width: 8%;">
          <!-- Botones para los administradores del sistema, para revisar las solicitudes -->
          <?php if (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idAdministradorSistema) { ?>
            <section class="btn-group">
              <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <a href="#" class="notification">
                  <img src="<?php echo fotoPerfil(@$_SESSION['idPerfil'], @$conexion) ?>" class="rounded-circle rounded-sm" style="width: 40pt;">
                  <?php if (@$archivo != 'usuario.php' && contadorMensajes(@$conexion, '0') >= 1) { ?>
                    <span class="badge"><?php echo contadorMensajes(@$conexion, '0') ?></span>
                  <?php }; ?>
                </a>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php if (@$archivo != 'usuario.php' && contadorMensajes(@$conexion, '0') >= 1) { ?>
                  <?php MostrarMensajes(@$conexion, '0') ?>
                <?php }; ?>
                <li><a href="../perfil/modificar.php?id=<?php echo @$_SESSION['documentoUsuarios']; ?>" class="dropdown-item" type="button"><?php echo @$btnUsuarios ?>Perfil</a></li>
                <li><a href="../perfil/miEmpresa.php?nit=<?php echo $_SESSION['nitEmpresas'] ?>" class="dropdown-item" type="button"><?php echo @$btnEmpresas ?>Mi Empresa</a></li>
                <li class="dropdown-divider"></li>
                <li><a type="button" href="../../estructura/cerrarSesion.php" class="dropdown-item"><?php echo @$cerrarSesion ?>Cerrar Sesión</a></li>
              </ul>
            </section>
            <!-- BOTONES PARA LOS ADMINSITRADORES DE LAS EMPRESAS -->
          <?php } elseif (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idAdministradorEmpresas) { ?>
            <section class="btn-group">
              <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <a href="#" class="notification">
                  <img src="<?php echo fotoPerfil(@$_SESSION['idPerfil'], @$conexion) ?>" class="rounded-circle rounded-sm" style="width: 40pt;">
                  <?php if (@$archivo != 'usuario.php' && contadorMensajes(@$conexion, '2') >= 1) { ?>
                    <span class="badge"><?php echo contadorMensajes(@$conexion, '2') ?></span>
                  <?php }; ?>
                </a>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php if (@$archivo != 'usuario.php' && contadorMensajes(@$conexion, '2') >= 1) { ?>
                  <?php MostrarMensajes(@$conexion, '2') ?>
                <?php }; ?>
                <li><a href="../perfil/modificar.php?id=<?php echo @$_SESSION['documentoUsuarios']; ?>" class="dropdown-item" type="button"><?php echo @$btnUsuarios ?>Perfil</a></li>
                <li><a href="../perfil/configuracion.php" class="dropdown-item" type="button"><?php echo @$btnConfiguraciones ?>Configuración</a></li>
                <li><a href="../perfil/miEmpresa.php?nit=<?php echo $_SESSION['nitEmpresas'] ?>" class="dropdown-item" type="button"><?php echo @$btnEmpresas ?>Mi Empresa</a></li>
                <li class="dropdown-divider"></li>
                <li><a type="button" href="../../estructura/cerrarSesion.php" class="dropdown-item"><?php echo @$cerrarSesion ?>Cerrar Sesión</a></li>
              </ul>
            </section>
            <!-- PERFIL DE LOS CAJEROS -->
          <?php } elseif (@$archivo != 'usuario.php' && @$_SESSION['idRoles'] == @$idClienteEmpresas) { ?>
            <section class="btn-group">
              <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <a href="#" class="notification">
                  <img src="<?php echo fotoPerfil(@$_SESSION['idPerfil'], @$conexion) ?>" class="rounded-circle rounded-sm" style="width: 40pt;">
                  <?php if (@$archivo != 'usuario.php' && contadorMensajes(@$conexion, '2') >= 1) { ?>
                    <span class="badge"><?php echo contadorMensajes(@$conexion, '2') ?></span>
                  <?php }; ?>
                </a>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php if (@$archivo != 'usuario.php' && contadorMensajes(@$conexion, '2') >= 1) { ?>
                  <?php MostrarMensajes(@$conexion, '2') ?>
                  <li class="dropdown-divider"></li>
                <?php }; ?>
                <li><a href="../perfil/modificar.php?id=<?php echo @$_SESSION['documentoUsuarios']; ?>" class="dropdown-item" type="button"><?php echo @$btnUsuarios ?>Perfil</a></li>
                <li class="dropdown-divider"></li>
                <li><a type="button" href="../../estructura/cerrarSesion.php" class="dropdown-item"><?php echo @$cerrarSesion ?>Cerrar Sesión</a></li>
              </ul>
            </section>
            <!-- PERFIL DE LOS CLIENTES -->
          <?php } else { ?>
            <section class="btn-group">
              <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <a href="#" class="notification">
                  <img src="<?php echo fotoPerfil(@$_SESSION['idPerfil'], @$conexion) ?>" class="rounded-circle rounded-sm" style="width: 40pt;">
                </a>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a href="../perfil/modificar.php?id=<?php echo @$_SESSION['documentoUsuarios']; ?>" class="dropdown-item" type="button"><?php echo @$btnUsuarios ?>Perfil</a></li>
                <li class="dropdown-divider"></li>
                <li><a type="button" href="../../estructura/cerrarSesion.php" class="dropdown-item"><?php echo @$cerrarSesion ?>Cerrar Sesión</a></li>
              </ul>
            </section>

          <?php } ?>
        </div>
      </div>
    </div>
  </nav>