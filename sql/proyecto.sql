-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-04-2021 a las 17:51:07
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arqueos`
--

CREATE TABLE `arqueos` (
  `idArqueos` int(11) NOT NULL,
  `billete100Arqueos` int(3) NOT NULL,
  `billete50Arqueos` int(3) NOT NULL,
  `billete20Arqueos` int(3) NOT NULL,
  `billete10Arqueos` int(3) NOT NULL,
  `billete5Arqueos` int(3) NOT NULL,
  `billete2Arqueos` int(3) NOT NULL,
  `billete1Arqueos` int(3) NOT NULL,
  `moneda100Arqueos` int(3) NOT NULL,
  `moneda50Arqueos` int(3) NOT NULL,
  `moneda20Arqueos` int(3) NOT NULL,
  `moneda10Arqueos` int(3) NOT NULL,
  `moneda5Arqueos` int(3) NOT NULL,
  `documentoUsuarios` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `cantidadTotalBilletes` int(11) NOT NULL,
  `cantidadTotalMonedas` int(11) NOT NULL,
  `valorTotalBilletes` int(11) NOT NULL,
  `valorTotalMonedas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `arqueos`
--

INSERT INTO `arqueos` (`idArqueos`, `billete100Arqueos`, `billete50Arqueos`, `billete20Arqueos`, `billete10Arqueos`, `billete5Arqueos`, `billete2Arqueos`, `billete1Arqueos`, `moneda100Arqueos`, `moneda50Arqueos`, `moneda20Arqueos`, `moneda10Arqueos`, `moneda5Arqueos`, `documentoUsuarios`, `nitEmpresas`, `fechaRegistro`, `cantidadTotalBilletes`, `cantidadTotalMonedas`, `valorTotalBilletes`, `valorTotalMonedas`) VALUES
(1, 999, 999, 999, 999, 999, 999, 999, 999, 999, 999, 999, 999, '1254515245', '152.214.231-6', '2021-04-13 00:22:19', 7, 5, 187812000, 1848150),
(2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1254515245', '152.214.231-6', '2021-04-13 00:38:59', 0, 0, 0, 0),
(3, 0, 0, 0, 0, 0, 0, 1, 1, 2, 0, 0, 0, '1254515245', '152.214.231-6', '2021-04-13 00:41:44', 1, 3, 1000, 2000),
(4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 55, 54, 5, '1254515245', '152.214.231-6', '2021-04-14 18:20:01', 35, 124, 940000, 24150),
(5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '50505050', '152.214.231-6', '2021-04-16 00:07:28', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `idArticulos` int(11) NOT NULL,
  `nombreArticulos` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `presentacionArticulos` int(5) NOT NULL,
  `medidaArticulos` int(3) NOT NULL,
  `precioArticulos` int(10) NOT NULL,
  `codigoArticulos` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `cantidadArticulos` int(11) NOT NULL,
  `marcaArticulos` int(3) NOT NULL,
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `registroPor` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fechaRegistro` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`idArticulos`, `nombreArticulos`, `presentacionArticulos`, `medidaArticulos`, `precioArticulos`, `codigoArticulos`, `cantidadArticulos`, `marcaArticulos`, `nitEmpresas`, `registroPor`, `fechaRegistro`) VALUES
(1, 'Carpa', 1, 3, 1000, '6464654564', 2, 1, '152.214.231-6', '24694000', '2021-03-18 21:43:58'),
(2, 'Carpa Roja', 1, 3, 4000, '56464654564', 18, 1, '152.214.231-6', '24694000', '2021-03-20 17:18:15'),
(3, 'Gaseosa ', 700, 2, 2000, '5644564564', 9, 2, '152.214.231-6', '24694000', '2021-03-20 15:30:21'),
(4, 'Bombones de chocolate', 100, 1, 3000, '55646465465', 16, 1, '152.214.231-6', '24694000', '2021-03-20 15:43:05'),
(5, 'asdgasdgasdgasdg', 250, 1, 25000, 'F6ASDFGA4SDG65ASD4', 24, 2, '152.214.231-6', '24694000', '2021-04-12 13:52:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulosVentas`
--

CREATE TABLE `articulosVentas` (
  `idVenta` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `cantidadVentas` int(11) NOT NULL,
  `fechaVentas` datetime NOT NULL,
  `idCabecera` int(11) NOT NULL,
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulosVentas`
--

INSERT INTO `articulosVentas` (`idVenta`, `idArticulo`, `cantidadVentas`, `fechaVentas`, `idCabecera`, `nitEmpresas`) VALUES
(1, 4, 1, '2021-03-20 18:41:59', 1, '152.214.231-6'),
(2, 2, 1, '2021-03-20 18:41:59', 1, '152.214.231-6'),
(3, 1, 1, '2021-03-20 18:41:59', 1, '152.214.231-6'),
(4, 4, 5, '2021-03-20 18:41:59', 2, '152.214.231-6'),
(5, 1, 2, '2021-03-20 18:41:59', 2, '152.214.231-6'),
(6, 3, 1, '2021-03-20 18:41:59', 2, '152.214.231-6'),
(7, 1, 1, '2021-04-12 13:52:24', 3, '152.214.231-6'),
(8, 1, 1, '2021-04-12 13:52:24', 3, '152.214.231-6'),
(9, 4, 1, '2021-04-12 13:54:54', 5, '152.214.231-6'),
(10, 3, 1, '2021-04-12 13:54:54', 5, '152.214.231-6'),
(11, 5, 1, '2021-04-12 13:54:54', 5, '152.214.231-6'),
(12, 4, 1, '2021-04-12 13:54:54', 5, '152.214.231-6'),
(13, 5, 1, '2021-04-12 13:54:54', 5, '152.214.231-6'),
(14, 1, 1, '2021-04-12 13:54:54', 5, '152.214.231-6'),
(15, 4, 1, '2021-04-13 00:40:54', 6, '152.214.231-6'),
(16, 5, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(17, 4, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(18, 4, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(19, 5, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(20, 5, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(21, 4, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(22, 1, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(23, 3, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(24, 4, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(25, 2, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(26, 3, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(27, 5, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(28, 4, 1, '2021-04-14 17:11:12', 7, '152.214.231-6'),
(29, 1, 1, '2021-04-14 17:11:12', 7, '152.214.231-6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cabeceraVentas`
--

CREATE TABLE `cabeceraVentas` (
  `idCabecera` int(11) NOT NULL,
  `documentoUsuarios` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaRegistro` datetime NOT NULL,
  `precioCabecera` int(10) DEFAULT NULL,
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `registroPor` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cabeceraVentas`
--

INSERT INTO `cabeceraVentas` (`idCabecera`, `documentoUsuarios`, `fechaRegistro`, `precioCabecera`, `nitEmpresas`, `registroPor`) VALUES
(1, '', '2021-03-20 18:41:59', 8000, '152.214.231-6', ''),
(2, '00000001', '2021-03-20 18:41:59', 19000, '152.214.231-6', ''),
(3, '', '2021-04-12 13:52:24', 1000, '152.214.231-6', '24694000'),
(4, '', '2021-04-12 13:52:24', NULL, '152.214.231-6', '24694000'),
(5, '00000001', '2021-04-12 13:54:54', 59000, '152.214.231-6', '24694000'),
(6, '', '2021-04-13 00:40:54', 3000, '152.214.231-6', '24694000'),
(7, '', '2021-04-14 17:11:12', 125000, '152.214.231-6', '24694000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `idDepartamentos` int(11) NOT NULL,
  `nombreDepartamentos` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`idDepartamentos`, `nombreDepartamentos`) VALUES
(1, 'Amazonas'),
(2, 'Antioquia'),
(3, 'Arauca'),
(4, 'Atlántico'),
(5, 'Bolívar'),
(6, 'Boyacá'),
(7, 'Caldas'),
(8, 'Caquetá'),
(9, 'Casanare'),
(10, 'Cauca'),
(11, 'Cesar'),
(12, 'Chocó'),
(13, 'Córdoba'),
(14, 'Cundinamarca'),
(15, 'Güainia'),
(16, 'Guaviare'),
(17, 'Huila'),
(18, 'La Guajira'),
(19, 'Magdalena'),
(20, 'Meta'),
(21, 'Nariño'),
(22, 'Norte de Santander'),
(23, 'Putumayo'),
(24, 'Quindo'),
(25, 'Risaralda'),
(26, 'San Andrés y Providencia'),
(27, 'Santander'),
(28, 'Sucre'),
(29, 'Tolima'),
(30, 'Valle del Cauca'),
(31, 'Vaupés'),
(32, 'Vichada'),
(33, 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombreEmpresas` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `telefonoCelularEmpresa` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `telefonoFijoEmpresas` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `direccionEmpresas` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `valorServicioEmpresas` int(10) NOT NULL,
  `registroCreadoPor` int(11) NOT NULL,
  `fechaCreacionRegistro` datetime NOT NULL,
  `estadoEmpresas` int(1) NOT NULL DEFAULT 1,
  `paisEmpresas` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `municipioEmpresas` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `departamentoEmpresas` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefonoCelular2Empresas` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `permisosMeses` int(1) NOT NULL DEFAULT 0,
  `permisosLavada` int(1) NOT NULL DEFAULT 0,
  `permisosArticulos` int(1) NOT NULL DEFAULT 0,
  `gratisEmpresas` int(1) NOT NULL DEFAULT 0,
  `idImagen` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`nitEmpresas`, `nombreEmpresas`, `telefonoCelularEmpresa`, `telefonoFijoEmpresas`, `direccionEmpresas`, `valorServicioEmpresas`, `registroCreadoPor`, `fechaCreacionRegistro`, `estadoEmpresas`, `paisEmpresas`, `municipioEmpresas`, `departamentoEmpresas`, `telefonoCelular2Empresas`, `permisosMeses`, `permisosLavada`, `permisosArticulos`, `gratisEmpresas`, `idImagen`) VALUES
('150.245.212-2', 'SoftPark', '3054028864', '', 'Mz 34 Cs 3 Mirador de Llano Grande', 450, 1088348388, '2021-03-06 05:11:02', 1, '52', '888', '25', '', 1, 1, 1, 0, 0),
('152.214.231-6', 'Parqueadero la 7a', '3054028864', '', 'Mz 34 Cs 3 Mirador de Llano Grande', 450000, 24694000, '2021-03-06 05:13:28', 1, '52', '888', '25', '', 1, 1, 1, 0, 1),
('546-744-454.4', 'Pruebas Cantidad Registros', '3024586578', '0', 'asdfsgagdag', 78645645, 1088348388, '2021-03-18 17:18:48', 1, '52', '641', '17', '0', 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `idFotos` int(11) NOT NULL,
  `rutaFotos` text COLLATE utf8_spanish_ci NOT NULL,
  `fechaRegistroFotos` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`idFotos`, `rutaFotos`, `fechaRegistroFotos`) VALUES
(1, '../../img/usuario.png', '2021-02-12'),
(2, '../../img/usuario2.png', '2021-02-13'),
(3, '../../img/usuario64-3.png', '2021-02-14'),
(4, '../../img/usuario64-4.png', '2021-02-14'),
(5, '../../img/usuario64-5.png', '2021-02-14'),
(6, '../../img/usuario64-6.png', '2021-02-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialMes`
--

CREATE TABLE `historialMes` (
  `idHistMes` int(11) NOT NULL,
  `placaVehiculos` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `descripcionHistMes` text COLLATE utf8_spanish_ci NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `registroPor` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idParqueos` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `historialMes`
--

INSERT INTO `historialMes` (`idHistMes`, `placaVehiculos`, `descripcionHistMes`, `fechaRegistro`, `registroPor`, `nitEmpresas`, `idParqueos`) VALUES
(1, 'FFF-FFF', 'Ingreso A Parqueadero', '2021-04-12 13:51:31', '24694000', '152.214.231-6', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `idImagen` int(11) NOT NULL,
  `rutaImagen` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`idImagen`, `rutaImagen`) VALUES
(1, '../configuracionAdmin/imgUpload/imgLogo_1.png'),
(2, 'imgUpload/img_2.png'),
(3, 'imgUpload/img_3.png'),
(4, 'imgUpload/img_4.png'),
(5, 'imgUpload/img_5.png'),
(6, 'imgUpload/img_6.png'),
(7, 'imgUpload/img_7.png'),
(8, 'imgUpload/img_8.png'),
(9, 'imgUpload/img_9.png'),
(10, 'imgUpload/img_10.png'),
(11, 'imgUpload/img_11.png'),
(12, 'imgUpload/img_12.png'),
(13, 'imgUpload/img_13.png'),
(14, 'imgUpload/img_14.php'),
(15, 'imgUpload/img_15.php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcaArticulos`
--

CREATE TABLE `marcaArticulos` (
  `idMarcaArticulos` int(11) NOT NULL,
  `nombreMarcaArticulos` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nitEmpresas` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `marcaArticulos`
--

INSERT INTO `marcaArticulos` (`idMarcaArticulos`, `nombreMarcaArticulos`, `nitEmpresas`) VALUES
(1, 'Gato', '152.214.231-6'),
(2, 'Coca-Cola', '152.214.231-6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `idMarcas` int(11) NOT NULL,
  `nombreMarcas` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`idMarcas`, `nombreMarcas`, `nitEmpresas`) VALUES
(1, 'Ninguna', '152.214.231-6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `idMensajes` int(11) NOT NULL,
  `tituloMensajes` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `descripcionMensajes` text COLLATE utf8_spanish_ci NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `documentoUsuarios` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `estadoMensaje` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`idMensajes`, `tituloMensajes`, `descripcionMensajes`, `fechaRegistro`, `documentoUsuarios`, `estadoMensaje`) VALUES
(1, 'hggasdgasdghasdg', '<p>ashadfhadfhadfhadfshadfh<br></p>', '2021-04-12 13:51:49', '24694000', 1),
(2, 'Prueba Solicitudes', '<p>dgdsgasdgasdgasdghasdgasd</p>', '2021-04-12 20:16:36', '24694000', 1),
(3, 'Prueba Solicitudes', '<p>ahdafhfdahadfhadadh</p>', '2021-04-13 14:26:10', '1088348388', 0),
(4, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>rhrehaerh</p>', '2021-04-13 15:12:20', '666', 4),
(5, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>rhrehaerh</p>', '2021-04-13 15:13:00', '666', 4),
(6, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>rhrehaerh</p>', '2021-04-13 15:13:06', '666', 4),
(7, 'Prueba Contactenos', '<p>Nombre cliente: <strong>Cesar</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>asdgasgasdgasdgsadgasdgasdgsad</p>', '2021-04-13 15:14:23', '666', 4),
(8, 'Prueba Contactenos', '<p>Nombre cliente: <strong>Cesar</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>asdgasgasdgasdgsadgasdgasdgsad</p>', '2021-04-13 15:14:27', '666', 4),
(9, 'Prueba Contactenos', '<p>Nombre cliente: <strong>Cesar</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>asdgasgasdgasdgsadgasdgasdgsad</p>', '2021-04-13 15:18:10', '666', 4),
(10, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>safsa</p>', '2021-04-13 15:23:55', '666666666', 4),
(11, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>safsa</p>', '2021-04-13 15:23:57', '666666666', 4),
(12, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>safsa</p>', '2021-04-13 15:23:58', '666666666', 4),
(13, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>safsaasfsadf</p>', '2021-04-13 15:24:00', '666666666', 4),
(14, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>safsaasfsadf</p>', '2021-04-13 15:24:01', '666666666', 4),
(15, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>safsaasfsadf</p>', '2021-04-13 15:24:01', '666666666', 4),
(16, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>safsaasfsadf</p>', '2021-04-13 15:24:03', '666666666', 4),
(17, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>safsaasfsadf</p>', '2021-04-13 15:24:03', '666666666', 4),
(18, 'Prueba Contacnto', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>safsaasfsadf</p>', '2021-04-13 15:24:03', '666666666', 4),
(19, 'Prueba Contactenos', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>asgasgasdgasdg</p>', '2021-04-13 15:24:53', '666666666', 4),
(20, 'Prueba Contactenos', '<p>Nombre cliente: <strong>parqueosoft</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>asgasgasdgasdg</p>', '2021-04-13 15:24:54', '666666666', 4),
(21, 'Prueba Contacnto', '<p>Nombre cliente: <strong>Cesar</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>yuklyukrykr</p>', '2021-04-13 15:26:01', '666666666', 4),
(22, 'Prueba Formulario', '<p>Nombre cliente: <strong>Cesar Trujillo</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>poasjdglashgñsadbfsadhgñoasd</p>', '2021-04-13 18:43:32', '666666666', 4),
(23, 'Prueba Formulario', '<p>Nombre cliente: <strong>Cesar Trujillo</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>poasjdglashgñsadbfsadhgñoasd</p>', '2021-04-13 18:43:34', '666666666', 4),
(24, 'Prueba Formulario', '<p>Nombre cliente: <strong>Cesar Trujillo</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>poasjdglashgñsadbfsadhgñoasd</p>', '2021-04-13 18:43:36', '666666666', 4),
(25, 'Prueba Formulario', '<p>Nombre cliente: <strong>Cesar Trujillo</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>poasjdglashgñsadbfsadhgñoasd</p>', '2021-04-13 18:43:39', '666666666', 4),
(26, 'Prueba Formulario', '<p>Nombre cliente: <strong>Cesar Trujillo</strong><br> y correo electrónico: <strong>trujillogarciac2@gmail.com</strong><br><br>poasjdglashgñsadbfsadhgñoasd</p>', '2021-04-13 18:43:42', '666666666', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `idMunicipios` int(11) NOT NULL,
  `idDepartamentos` int(11) NOT NULL,
  `nombreMunicipios` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`idMunicipios`, `idDepartamentos`, `nombreMunicipios`) VALUES
(1, 1, 'Leticia'),
(2, 1, 'Puerto Nariño'),
(3, 2, 'Abejorral'),
(4, 2, 'Abriaquí'),
(5, 2, 'Alejandria'),
(6, 2, 'Amagá'),
(7, 2, 'Amalfi'),
(8, 2, 'Andes'),
(9, 2, 'Angelópolis'),
(10, 2, 'Angostura'),
(11, 2, 'Anorí'),
(12, 2, 'Anzá'),
(13, 2, 'Apartadó'),
(14, 2, 'Arboletes'),
(15, 2, 'Argelia'),
(16, 2, 'Armenia'),
(17, 2, 'Barbosa'),
(18, 2, 'Bello'),
(19, 2, 'Belmira'),
(20, 2, 'Betania'),
(21, 2, 'Betulia'),
(22, 2, 'Bolívar'),
(23, 2, 'Briceño'),
(24, 2, 'Burítica'),
(25, 2, 'Caicedo'),
(26, 2, 'Caldas'),
(27, 2, 'Campamento'),
(28, 2, 'Caracolí'),
(29, 2, 'Caramanta'),
(30, 2, 'Carepa'),
(31, 2, 'Carmen de Viboral'),
(32, 2, 'Carolina'),
(33, 2, 'Caucasia'),
(34, 2, 'Cañasgordas'),
(35, 2, 'Chigorodó'),
(36, 2, 'Cisneros'),
(37, 2, 'Cocorná'),
(38, 2, 'Concepción'),
(39, 2, 'Concordia'),
(40, 2, 'Copacabana'),
(41, 2, 'Cáceres'),
(42, 2, 'Dabeiba'),
(43, 2, 'Don Matías'),
(44, 2, 'Ebéjico'),
(45, 2, 'El Bagre'),
(46, 2, 'Entrerríos'),
(47, 2, 'Envigado'),
(48, 2, 'Fredonia'),
(49, 2, 'Frontino'),
(50, 2, 'Giraldo'),
(51, 2, 'Girardota'),
(52, 2, 'Granada'),
(53, 2, 'Guadalupe'),
(54, 2, 'Guarne'),
(55, 2, 'Guatapé'),
(56, 2, 'Gómez Plata'),
(57, 2, 'Heliconia'),
(58, 2, 'Hispania'),
(59, 2, 'Itagüí'),
(60, 2, 'Ituango'),
(61, 2, 'Jardín'),
(62, 2, 'Jericó'),
(63, 2, 'La Ceja'),
(64, 2, 'La Estrella'),
(65, 2, 'La Pintada'),
(66, 2, 'La Unión'),
(67, 2, 'Liborina'),
(68, 2, 'Maceo'),
(69, 2, 'Marinilla'),
(70, 2, 'Medellín'),
(71, 2, 'Montebello'),
(72, 2, 'Murindó'),
(73, 2, 'Mutatá'),
(74, 2, 'Nariño'),
(75, 2, 'Nechí'),
(76, 2, 'Necoclí'),
(77, 2, 'Olaya'),
(78, 2, 'Peque'),
(79, 2, 'Peñol'),
(80, 2, 'Pueblorrico'),
(81, 2, 'Puerto Berrío'),
(82, 2, 'Puerto Nare'),
(83, 2, 'Puerto Triunfo'),
(84, 2, 'Remedios'),
(85, 2, 'Retiro'),
(86, 2, 'Ríonegro'),
(87, 2, 'Sabanalarga'),
(88, 2, 'Sabaneta'),
(89, 2, 'Salgar'),
(90, 2, 'San Andrés de Cuerquía'),
(91, 2, 'San Carlos'),
(92, 2, 'San Francisco'),
(93, 2, 'San Jerónimo'),
(94, 2, 'San José de Montaña'),
(95, 2, 'San Juan de Urabá'),
(96, 2, 'San Luís'),
(97, 2, 'San Pedro'),
(98, 2, 'San Pedro de Urabá'),
(99, 2, 'San Rafael'),
(100, 2, 'San Roque'),
(101, 2, 'San Vicente'),
(102, 2, 'Santa Bárbara'),
(103, 2, 'Santa Fé de Antioquia'),
(104, 2, 'Santa Rosa de Osos'),
(105, 2, 'Santo Domingo'),
(106, 2, 'Santuario'),
(107, 2, 'Segovia'),
(108, 2, 'Sonsón'),
(109, 2, 'Sopetrán'),
(110, 2, 'Tarazá'),
(111, 2, 'Tarso'),
(112, 2, 'Titiribí'),
(113, 2, 'Toledo'),
(114, 2, 'Turbo'),
(115, 2, 'Támesis'),
(116, 2, 'Uramita'),
(117, 2, 'Urrao'),
(118, 2, 'Valdivia'),
(119, 2, 'Valparaiso'),
(120, 2, 'Vegachí'),
(121, 2, 'Venecia'),
(122, 2, 'Vigía del Fuerte'),
(123, 2, 'Yalí'),
(124, 2, 'Yarumal'),
(125, 2, 'Yolombó'),
(126, 2, 'Yondó (Casabe)'),
(127, 2, 'Zaragoza'),
(128, 3, 'Arauca'),
(129, 3, 'Arauquita'),
(130, 3, 'Cravo Norte'),
(131, 3, 'Fortúl'),
(132, 3, 'Puerto Rondón'),
(133, 3, 'Saravena'),
(134, 3, 'Tame'),
(135, 4, 'Baranoa'),
(136, 4, 'Barranquilla'),
(137, 4, 'Campo de la Cruz'),
(138, 4, 'Candelaria'),
(139, 4, 'Galapa'),
(140, 4, 'Juan de Acosta'),
(141, 4, 'Luruaco'),
(142, 4, 'Malambo'),
(143, 4, 'Manatí'),
(144, 4, 'Palmar de Varela'),
(145, 4, 'Piojo'),
(146, 4, 'Polonuevo'),
(147, 4, 'Ponedera'),
(148, 4, 'Puerto Colombia'),
(149, 4, 'Repelón'),
(150, 4, 'Sabanagrande'),
(151, 4, 'Sabanalarga'),
(152, 4, 'Santa Lucía'),
(153, 4, 'Santo Tomás'),
(154, 4, 'Soledad'),
(155, 4, 'Suan'),
(156, 4, 'Tubará'),
(157, 4, 'Usiacuri'),
(158, 5, 'Achí'),
(159, 5, 'Altos del Rosario'),
(160, 5, 'Arenal'),
(161, 5, 'Arjona'),
(162, 5, 'Arroyohondo'),
(163, 5, 'Barranco de Loba'),
(164, 5, 'Calamar'),
(165, 5, 'Cantagallo'),
(166, 5, 'Cartagena'),
(167, 5, 'Cicuco'),
(168, 5, 'Clemencia'),
(169, 5, 'Córdoba'),
(170, 5, 'El Carmen de Bolívar'),
(171, 5, 'El Guamo'),
(172, 5, 'El Peñon'),
(173, 5, 'Hatillo de Loba'),
(174, 5, 'Magangué'),
(175, 5, 'Mahates'),
(176, 5, 'Margarita'),
(177, 5, 'María la Baja'),
(178, 5, 'Mompós'),
(179, 5, 'Montecristo'),
(180, 5, 'Morales'),
(181, 5, 'Norosí'),
(182, 5, 'Pinillos'),
(183, 5, 'Regidor'),
(184, 5, 'Río Viejo'),
(185, 5, 'San Cristobal'),
(186, 5, 'San Estanislao'),
(187, 5, 'San Fernando'),
(188, 5, 'San Jacinto'),
(189, 5, 'San Jacinto del Cauca'),
(190, 5, 'San Juan de Nepomuceno'),
(191, 5, 'San Martín de Loba'),
(192, 5, 'San Pablo'),
(193, 5, 'Santa Catalina'),
(194, 5, 'Santa Rosa '),
(195, 5, 'Santa Rosa del Sur'),
(196, 5, 'Simití'),
(197, 5, 'Soplaviento'),
(198, 5, 'Talaigua Nuevo'),
(199, 5, 'Tiquisio (Puerto Rico)'),
(200, 5, 'Turbaco'),
(201, 5, 'Turbaná'),
(202, 5, 'Villanueva'),
(203, 5, 'Zambrano'),
(204, 6, 'Almeida'),
(205, 6, 'Aquitania'),
(206, 6, 'Arcabuco'),
(207, 6, 'Belén'),
(208, 6, 'Berbeo'),
(209, 6, 'Beteitiva'),
(210, 6, 'Boavita'),
(211, 6, 'Boyacá'),
(212, 6, 'Briceño'),
(213, 6, 'Buenavista'),
(214, 6, 'Busbanza'),
(215, 6, 'Caldas'),
(216, 6, 'Campohermoso'),
(217, 6, 'Cerinza'),
(218, 6, 'Chinavita'),
(219, 6, 'Chiquinquirá'),
(220, 6, 'Chiscas'),
(221, 6, 'Chita'),
(222, 6, 'Chitaraque'),
(223, 6, 'Chivatá'),
(224, 6, 'Chíquiza'),
(225, 6, 'Chívor'),
(226, 6, 'Ciénaga'),
(227, 6, 'Coper'),
(228, 6, 'Corrales'),
(229, 6, 'Covarachía'),
(230, 6, 'Cubará'),
(231, 6, 'Cucaita'),
(232, 6, 'Cuitiva'),
(233, 6, 'Cómbita'),
(234, 6, 'Duitama'),
(235, 6, 'El Cocuy'),
(236, 6, 'El Espino'),
(237, 6, 'Firavitoba'),
(238, 6, 'Floresta'),
(239, 6, 'Gachantivá'),
(240, 6, 'Garagoa'),
(241, 6, 'Guacamayas'),
(242, 6, 'Guateque'),
(243, 6, 'Guayatá'),
(244, 6, 'Guicán'),
(245, 6, 'Gámeza'),
(246, 6, 'Izá'),
(247, 6, 'Jenesano'),
(248, 6, 'Jericó'),
(249, 6, 'La Capilla'),
(250, 6, 'La Uvita'),
(251, 6, 'La Victoria'),
(252, 6, 'Labranzagrande'),
(253, 6, 'Macanal'),
(254, 6, 'Maripí'),
(255, 6, 'Miraflores'),
(256, 6, 'Mongua'),
(257, 6, 'Monguí'),
(258, 6, 'Moniquirá'),
(259, 6, 'Motavita'),
(260, 6, 'Muzo'),
(261, 6, 'Nobsa'),
(262, 6, 'Nuevo Colón'),
(263, 6, 'Oicatá'),
(264, 6, 'Otanche'),
(265, 6, 'Pachavita'),
(266, 6, 'Paipa'),
(267, 6, 'Pajarito'),
(268, 6, 'Panqueba'),
(269, 6, 'Pauna'),
(270, 6, 'Paya'),
(271, 6, 'Paz de Río'),
(272, 6, 'Pesca'),
(273, 6, 'Pisva'),
(274, 6, 'Puerto Boyacá'),
(275, 6, 'Páez'),
(276, 6, 'Quipama'),
(277, 6, 'Ramiriquí'),
(278, 6, 'Rondón'),
(279, 6, 'Ráquira'),
(280, 6, 'Saboyá'),
(281, 6, 'Samacá'),
(282, 6, 'San Eduardo'),
(283, 6, 'San José de Pare'),
(284, 6, 'San Luís de Gaceno'),
(285, 6, 'San Mateo'),
(286, 6, 'San Miguel de Sema'),
(287, 6, 'San Pablo de Borbur'),
(288, 6, 'Santa María'),
(289, 6, 'Santa Rosa de Viterbo'),
(290, 6, 'Santa Sofía'),
(291, 6, 'Santana'),
(292, 6, 'Sativanorte'),
(293, 6, 'Sativasur'),
(294, 6, 'Siachoque'),
(295, 6, 'Soatá'),
(296, 6, 'Socha'),
(297, 6, 'Socotá'),
(298, 6, 'Sogamoso'),
(299, 6, 'Somondoco'),
(300, 6, 'Sora'),
(301, 6, 'Soracá'),
(302, 6, 'Sotaquirá'),
(303, 6, 'Susacón'),
(304, 6, 'Sutamarchán'),
(305, 6, 'Sutatenza'),
(306, 6, 'Sáchica'),
(307, 6, 'Tasco'),
(308, 6, 'Tenza'),
(309, 6, 'Tibaná'),
(310, 6, 'Tibasosa'),
(311, 6, 'Tinjacá'),
(312, 6, 'Tipacoque'),
(313, 6, 'Toca'),
(314, 6, 'Toguí'),
(315, 6, 'Topagá'),
(316, 6, 'Tota'),
(317, 6, 'Tunja'),
(318, 6, 'Tunungua'),
(319, 6, 'Turmequé'),
(320, 6, 'Tuta'),
(321, 6, 'Tutasá'),
(322, 6, 'Ventaquemada'),
(323, 6, 'Villa de Leiva'),
(324, 6, 'Viracachá'),
(325, 6, 'Zetaquirá'),
(326, 6, 'Úmbita'),
(327, 7, 'Aguadas'),
(328, 7, 'Anserma'),
(329, 7, 'Aranzazu'),
(330, 7, 'Belalcázar'),
(331, 7, 'Chinchiná'),
(332, 7, 'Filadelfia'),
(333, 7, 'La Dorada'),
(334, 7, 'La Merced'),
(335, 7, 'La Victoria'),
(336, 7, 'Manizales'),
(337, 7, 'Manzanares'),
(338, 7, 'Marmato'),
(339, 7, 'Marquetalia'),
(340, 7, 'Marulanda'),
(341, 7, 'Neira'),
(342, 7, 'Norcasia'),
(343, 7, 'Palestina'),
(344, 7, 'Pensilvania'),
(345, 7, 'Pácora'),
(346, 7, 'Risaralda'),
(347, 7, 'Río Sucio'),
(348, 7, 'Salamina'),
(349, 7, 'Samaná'),
(350, 7, 'San José'),
(351, 7, 'Supía'),
(352, 7, 'Villamaría'),
(353, 7, 'Viterbo'),
(354, 8, 'Albania'),
(355, 8, 'Belén de los Andaquíes'),
(356, 8, 'Cartagena del Chairá'),
(357, 8, 'Curillo'),
(358, 8, 'El Doncello'),
(359, 8, 'El Paujil'),
(360, 8, 'Florencia'),
(361, 8, 'La Montañita'),
(362, 8, 'Milán'),
(363, 8, 'Morelia'),
(364, 8, 'Puerto Rico'),
(365, 8, 'San José del Fragua'),
(366, 8, 'San Vicente del Caguán'),
(367, 8, 'Solano'),
(368, 8, 'Solita'),
(369, 8, 'Valparaiso'),
(370, 9, 'Aguazul'),
(371, 9, 'Chámeza'),
(372, 9, 'Hato Corozal'),
(373, 9, 'La Salina'),
(374, 9, 'Maní'),
(375, 9, 'Monterrey'),
(376, 9, 'Nunchía'),
(377, 9, 'Orocué'),
(378, 9, 'Paz de Ariporo'),
(379, 9, 'Pore'),
(380, 9, 'Recetor'),
(381, 9, 'Sabanalarga'),
(382, 9, 'San Luís de Palenque'),
(383, 9, 'Sácama'),
(384, 9, 'Tauramena'),
(385, 9, 'Trinidad'),
(386, 9, 'Támara'),
(387, 9, 'Villanueva'),
(388, 9, 'Yopal'),
(389, 10, 'Almaguer'),
(390, 10, 'Argelia'),
(391, 10, 'Balboa'),
(392, 10, 'Bolívar'),
(393, 10, 'Buenos Aires'),
(394, 10, 'Cajibío'),
(395, 10, 'Caldono'),
(396, 10, 'Caloto'),
(397, 10, 'Corinto'),
(398, 10, 'El Tambo'),
(399, 10, 'Florencia'),
(400, 10, 'Guachené'),
(401, 10, 'Guapí'),
(402, 10, 'Inzá'),
(403, 10, 'Jambaló'),
(404, 10, 'La Sierra'),
(405, 10, 'La Vega'),
(406, 10, 'López (Micay)'),
(407, 10, 'Mercaderes'),
(408, 10, 'Miranda'),
(409, 10, 'Morales'),
(410, 10, 'Padilla'),
(411, 10, 'Patía (El Bordo)'),
(412, 10, 'Piamonte'),
(413, 10, 'Piendamó'),
(414, 10, 'Popayán'),
(415, 10, 'Puerto Tejada'),
(416, 10, 'Puracé (Coconuco)'),
(417, 10, 'Páez (Belalcazar)'),
(418, 10, 'Rosas'),
(419, 10, 'San Sebastián'),
(420, 10, 'Santa Rosa'),
(421, 10, 'Santander de Quilichao'),
(422, 10, 'Silvia'),
(423, 10, 'Sotara (Paispamba)'),
(424, 10, 'Sucre'),
(425, 10, 'Suárez'),
(426, 10, 'Timbiquí'),
(427, 10, 'Timbío'),
(428, 10, 'Toribío'),
(429, 10, 'Totoró'),
(430, 10, 'Villa Rica'),
(431, 11, 'Aguachica'),
(432, 11, 'Agustín Codazzi'),
(433, 11, 'Astrea'),
(434, 11, 'Becerríl'),
(435, 11, 'Bosconia'),
(436, 11, 'Chimichagua'),
(437, 11, 'Chiriguaná'),
(438, 11, 'Curumaní'),
(439, 11, 'El Copey'),
(440, 11, 'El Paso'),
(441, 11, 'Gamarra'),
(442, 11, 'Gonzalez'),
(443, 11, 'La Gloria'),
(444, 11, 'La Jagua de Ibirico'),
(445, 11, 'La Paz (Robles)'),
(446, 11, 'Manaure Balcón del Cesar'),
(447, 11, 'Pailitas'),
(448, 11, 'Pelaya'),
(449, 11, 'Pueblo Bello'),
(450, 11, 'Río de oro'),
(451, 11, 'San Alberto'),
(452, 11, 'San Diego'),
(453, 11, 'San Martín'),
(454, 11, 'Tamalameque'),
(455, 11, 'Valledupar'),
(456, 12, 'Acandí'),
(457, 12, 'Alto Baudó (Pie de Pato)'),
(458, 12, 'Atrato (Yuto)'),
(459, 12, 'Bagadó'),
(460, 12, 'Bahía Solano (Mútis)'),
(461, 12, 'Bajo Baudó (Pizarro)'),
(462, 12, 'Belén de Bajirá'),
(463, 12, 'Bojayá (Bellavista)'),
(464, 12, 'Cantón de San Pablo'),
(465, 12, 'Carmen del Darién (CURBARADÓ)'),
(466, 12, 'Condoto'),
(467, 12, 'Cértegui'),
(468, 12, 'El Carmen de Atrato'),
(469, 12, 'Istmina'),
(470, 12, 'Juradó'),
(471, 12, 'Lloró'),
(472, 12, 'Medio Atrato'),
(473, 12, 'Medio Baudó'),
(474, 12, 'Medio San Juan (ANDAGOYA)'),
(475, 12, 'Novita'),
(476, 12, 'Nuquí'),
(477, 12, 'Quibdó'),
(478, 12, 'Río Iró'),
(479, 12, 'Río Quito'),
(480, 12, 'Ríosucio'),
(481, 12, 'San José del Palmar'),
(482, 12, 'Santa Genoveva de Docorodó'),
(483, 12, 'Sipí'),
(484, 12, 'Tadó'),
(485, 12, 'Unguía'),
(486, 12, 'Unión Panamericana (ÁNIMAS)'),
(487, 13, 'Ayapel'),
(488, 13, 'Buenavista'),
(489, 13, 'Canalete'),
(490, 13, 'Cereté'),
(491, 13, 'Chimá'),
(492, 13, 'Chinú'),
(493, 13, 'Ciénaga de Oro'),
(494, 13, 'Cotorra'),
(495, 13, 'La Apartada y La Frontera'),
(496, 13, 'Lorica'),
(497, 13, 'Los Córdobas'),
(498, 13, 'Momil'),
(499, 13, 'Montelíbano'),
(500, 13, 'Monteria'),
(501, 13, 'Moñitos'),
(502, 13, 'Planeta Rica'),
(503, 13, 'Pueblo Nuevo'),
(504, 13, 'Puerto Escondido'),
(505, 13, 'Puerto Libertador'),
(506, 13, 'Purísima'),
(507, 13, 'Sahagún'),
(508, 13, 'San Andrés Sotavento'),
(509, 13, 'San Antero'),
(510, 13, 'San Bernardo del Viento'),
(511, 13, 'San Carlos'),
(512, 13, 'San José de Uré'),
(513, 13, 'San Pelayo'),
(514, 13, 'Tierralta'),
(515, 13, 'Tuchín'),
(516, 13, 'Valencia'),
(517, 14, 'Agua de Dios'),
(518, 14, 'Albán'),
(519, 14, 'Anapoima'),
(520, 14, 'Anolaima'),
(521, 14, 'Apulo'),
(522, 14, 'Arbeláez'),
(523, 14, 'Beltrán'),
(524, 14, 'Bituima'),
(525, 14, 'Bogotá D.C.'),
(526, 14, 'Bojacá'),
(527, 14, 'Cabrera'),
(528, 14, 'Cachipay'),
(529, 14, 'Cajicá'),
(530, 14, 'Caparrapí'),
(531, 14, 'Carmen de Carupa'),
(532, 14, 'Chaguaní'),
(533, 14, 'Chipaque'),
(534, 14, 'Choachí'),
(535, 14, 'Chocontá'),
(536, 14, 'Chía'),
(537, 14, 'Cogua'),
(538, 14, 'Cota'),
(539, 14, 'Cucunubá'),
(540, 14, 'Cáqueza'),
(541, 14, 'El Colegio'),
(542, 14, 'El Peñón'),
(543, 14, 'El Rosal'),
(544, 14, 'Facatativá'),
(545, 14, 'Fosca'),
(546, 14, 'Funza'),
(547, 14, 'Fusagasugá'),
(548, 14, 'Fómeque'),
(549, 14, 'Fúquene'),
(550, 14, 'Gachalá'),
(551, 14, 'Gachancipá'),
(552, 14, 'Gachetá'),
(553, 14, 'Gama'),
(554, 14, 'Girardot'),
(555, 14, 'Granada'),
(556, 14, 'Guachetá'),
(557, 14, 'Guaduas'),
(558, 14, 'Guasca'),
(559, 14, 'Guataquí'),
(560, 14, 'Guatavita'),
(561, 14, 'Guayabal de Siquima'),
(562, 14, 'Guayabetal'),
(563, 14, 'Gutiérrez'),
(564, 14, 'Jerusalén'),
(565, 14, 'Junín'),
(566, 14, 'La Calera'),
(567, 14, 'La Mesa'),
(568, 14, 'La Palma'),
(569, 14, 'La Peña'),
(570, 14, 'La Vega'),
(571, 14, 'Lenguazaque'),
(572, 14, 'Machetá'),
(573, 14, 'Madrid'),
(574, 14, 'Manta'),
(575, 14, 'Medina'),
(576, 14, 'Mosquera'),
(577, 14, 'Nariño'),
(578, 14, 'Nemocón'),
(579, 14, 'Nilo'),
(580, 14, 'Nimaima'),
(581, 14, 'Nocaima'),
(582, 14, 'Pacho'),
(583, 14, 'Paime'),
(584, 14, 'Pandi'),
(585, 14, 'Paratebueno'),
(586, 14, 'Pasca'),
(587, 14, 'Puerto Salgar'),
(588, 14, 'Pulí'),
(589, 14, 'Quebradanegra'),
(590, 14, 'Quetame'),
(591, 14, 'Quipile'),
(592, 14, 'Ricaurte'),
(593, 14, 'San Antonio de Tequendama'),
(594, 14, 'San Bernardo'),
(595, 14, 'San Cayetano'),
(596, 14, 'San Francisco'),
(597, 14, 'San Juan de Río Seco'),
(598, 14, 'Sasaima'),
(599, 14, 'Sesquilé'),
(600, 14, 'Sibaté'),
(601, 14, 'Silvania'),
(602, 14, 'Simijaca'),
(603, 14, 'Soacha'),
(604, 14, 'Sopó'),
(605, 14, 'Subachoque'),
(606, 14, 'Suesca'),
(607, 14, 'Supatá'),
(608, 14, 'Susa'),
(609, 14, 'Sutatausa'),
(610, 14, 'Tabio'),
(611, 14, 'Tausa'),
(612, 14, 'Tena'),
(613, 14, 'Tenjo'),
(614, 14, 'Tibacuy'),
(615, 14, 'Tibirita'),
(616, 14, 'Tocaima'),
(617, 14, 'Tocancipá'),
(618, 14, 'Topaipí'),
(619, 14, 'Ubalá'),
(620, 14, 'Ubaque'),
(621, 14, 'Ubaté'),
(622, 14, 'Une'),
(623, 14, 'Venecia (Ospina Pérez)'),
(624, 14, 'Vergara'),
(625, 14, 'Viani'),
(626, 14, 'Villagómez'),
(627, 14, 'Villapinzón'),
(628, 14, 'Villeta'),
(629, 14, 'Viotá'),
(630, 14, 'Yacopí'),
(631, 14, 'Zipacón'),
(632, 14, 'Zipaquirá'),
(633, 14, 'Útica'),
(634, 15, 'Inírida'),
(635, 16, 'Calamar'),
(636, 16, 'El Retorno'),
(637, 16, 'Miraflores'),
(638, 16, 'San José del Guaviare'),
(639, 17, 'Acevedo'),
(640, 17, 'Agrado'),
(641, 17, 'Aipe'),
(642, 17, 'Algeciras'),
(643, 17, 'Altamira'),
(644, 17, 'Baraya'),
(645, 17, 'Campoalegre'),
(646, 17, 'Colombia'),
(647, 17, 'Elías'),
(648, 17, 'Garzón'),
(649, 17, 'Gigante'),
(650, 17, 'Guadalupe'),
(651, 17, 'Hobo'),
(652, 17, 'Isnos'),
(653, 17, 'La Argentina'),
(654, 17, 'La Plata'),
(655, 17, 'Neiva'),
(656, 17, 'Nátaga'),
(657, 17, 'Oporapa'),
(658, 17, 'Paicol'),
(659, 17, 'Palermo'),
(660, 17, 'Palestina'),
(661, 17, 'Pital'),
(662, 17, 'Pitalito'),
(663, 17, 'Rivera'),
(664, 17, 'Saladoblanco'),
(665, 17, 'San Agustín'),
(666, 17, 'Santa María'),
(667, 17, 'Suaza'),
(668, 17, 'Tarqui'),
(669, 17, 'Tello'),
(670, 17, 'Teruel'),
(671, 17, 'Tesalia'),
(672, 17, 'Timaná'),
(673, 17, 'Villavieja'),
(674, 17, 'Yaguará'),
(675, 17, 'Íquira'),
(676, 18, 'Albania'),
(677, 18, 'Barrancas'),
(678, 18, 'Dibulla'),
(679, 18, 'Distracción'),
(680, 18, 'El Molino'),
(681, 18, 'Fonseca'),
(682, 18, 'Hatonuevo'),
(683, 18, 'La Jagua del Pilar'),
(684, 18, 'Maicao'),
(685, 18, 'Manaure'),
(686, 18, 'Riohacha'),
(687, 18, 'San Juan del Cesar'),
(688, 18, 'Uribia'),
(689, 18, 'Urumita'),
(690, 18, 'Villanueva'),
(691, 19, 'Algarrobo'),
(692, 19, 'Aracataca'),
(693, 19, 'Ariguaní (El Difícil)'),
(694, 19, 'Cerro San Antonio'),
(695, 19, 'Chivolo'),
(696, 19, 'Ciénaga'),
(697, 19, 'Concordia'),
(698, 19, 'El Banco'),
(699, 19, 'El Piñon'),
(700, 19, 'El Retén'),
(701, 19, 'Fundación'),
(702, 19, 'Guamal'),
(703, 19, 'Nueva Granada'),
(704, 19, 'Pedraza'),
(705, 19, 'Pijiño'),
(706, 19, 'Pivijay'),
(707, 19, 'Plato'),
(708, 19, 'Puebloviejo'),
(709, 19, 'Remolino'),
(710, 19, 'Sabanas de San Angel (SAN ANGE'),
(711, 19, 'Salamina'),
(712, 19, 'San Sebastián de Buenavista'),
(713, 19, 'San Zenón'),
(714, 19, 'Santa Ana'),
(715, 19, 'Santa Bárbara de Pinto'),
(716, 19, 'Santa Marta'),
(717, 19, 'Sitionuevo'),
(718, 19, 'Tenerife'),
(719, 19, 'Zapayán (PUNTA DE PIEDRAS)'),
(720, 19, 'Zona Bananera (PRADO - SEVILLA'),
(721, 20, 'Acacías'),
(722, 20, 'Barranca de Upía'),
(723, 20, 'Cabuyaro'),
(724, 20, 'Castilla la Nueva'),
(725, 20, 'Cubarral'),
(726, 20, 'Cumaral'),
(727, 20, 'El Calvario'),
(728, 20, 'El Castillo'),
(729, 20, 'El Dorado'),
(730, 20, 'Fuente de Oro'),
(731, 20, 'Granada'),
(732, 20, 'Guamal'),
(733, 20, 'La Macarena'),
(734, 20, 'Lejanías'),
(735, 20, 'Mapiripan'),
(736, 20, 'Mesetas'),
(737, 20, 'Puerto Concordia'),
(738, 20, 'Puerto Gaitán'),
(739, 20, 'Puerto Lleras'),
(740, 20, 'Puerto López'),
(741, 20, 'Puerto Rico'),
(742, 20, 'Restrepo'),
(743, 20, 'San Carlos de Guaroa'),
(744, 20, 'San Juan de Arama'),
(745, 20, 'San Juanito'),
(746, 20, 'San Martín'),
(747, 20, 'Uribe'),
(748, 20, 'Villavicencio'),
(749, 20, 'Vista Hermosa'),
(750, 21, 'Albán (San José)'),
(751, 21, 'Aldana'),
(752, 21, 'Ancuya'),
(753, 21, 'Arboleda (Berruecos)'),
(754, 21, 'Barbacoas'),
(755, 21, 'Belén'),
(756, 21, 'Buesaco'),
(757, 21, 'Chachaguí'),
(758, 21, 'Colón (Génova)'),
(759, 21, 'Consaca'),
(760, 21, 'Contadero'),
(761, 21, 'Cuaspud (Carlosama)'),
(762, 21, 'Cumbal'),
(763, 21, 'Cumbitara'),
(764, 21, 'Córdoba'),
(765, 21, 'El Charco'),
(766, 21, 'El Peñol'),
(767, 21, 'El Rosario'),
(768, 21, 'El Tablón de Gómez'),
(769, 21, 'El Tambo'),
(770, 21, 'Francisco Pizarro'),
(771, 21, 'Funes'),
(772, 21, 'Guachavés'),
(773, 21, 'Guachucal'),
(774, 21, 'Guaitarilla'),
(775, 21, 'Gualmatán'),
(776, 21, 'Iles'),
(777, 21, 'Imúes'),
(778, 21, 'Ipiales'),
(779, 21, 'La Cruz'),
(780, 21, 'La Florida'),
(781, 21, 'La Llanada'),
(782, 21, 'La Tola'),
(783, 21, 'La Unión'),
(784, 21, 'Leiva'),
(785, 21, 'Linares'),
(786, 21, 'Magüi (Payán)'),
(787, 21, 'Mallama (Piedrancha)'),
(788, 21, 'Mosquera'),
(789, 21, 'Nariño'),
(790, 21, 'Olaya Herrera'),
(791, 21, 'Ospina'),
(792, 21, 'Policarpa'),
(793, 21, 'Potosí'),
(794, 21, 'Providencia'),
(795, 21, 'Puerres'),
(796, 21, 'Pupiales'),
(797, 21, 'Ricaurte'),
(798, 21, 'Roberto Payán (San José)'),
(799, 21, 'Samaniego'),
(800, 21, 'San Bernardo'),
(801, 21, 'San Juan de Pasto'),
(802, 21, 'San Lorenzo'),
(803, 21, 'San Pablo'),
(804, 21, 'San Pedro de Cartago'),
(805, 21, 'Sandoná'),
(806, 21, 'Santa Bárbara (Iscuandé)'),
(807, 21, 'Sapuyes'),
(808, 21, 'Sotomayor (Los Andes)'),
(809, 21, 'Taminango'),
(810, 21, 'Tangua'),
(811, 21, 'Tumaco'),
(812, 21, 'Túquerres'),
(813, 21, 'Yacuanquer'),
(814, 22, 'Arboledas'),
(815, 22, 'Bochalema'),
(816, 22, 'Bucarasica'),
(817, 22, 'Chinácota'),
(818, 22, 'Chitagá'),
(819, 22, 'Convención'),
(820, 22, 'Cucutilla'),
(821, 22, 'Cáchira'),
(822, 22, 'Cácota'),
(823, 22, 'Cúcuta'),
(824, 22, 'Durania'),
(825, 22, 'El Carmen'),
(826, 22, 'El Tarra'),
(827, 22, 'El Zulia'),
(828, 22, 'Gramalote'),
(829, 22, 'Hacarí'),
(830, 22, 'Herrán'),
(831, 22, 'La Esperanza'),
(832, 22, 'La Playa'),
(833, 22, 'Labateca'),
(834, 22, 'Los Patios'),
(835, 22, 'Lourdes'),
(836, 22, 'Mutiscua'),
(837, 22, 'Ocaña'),
(838, 22, 'Pamplona'),
(839, 22, 'Pamplonita'),
(840, 22, 'Puerto Santander'),
(841, 22, 'Ragonvalia'),
(842, 22, 'Salazar'),
(843, 22, 'San Calixto'),
(844, 22, 'San Cayetano'),
(845, 22, 'Santiago'),
(846, 22, 'Sardinata'),
(847, 22, 'Silos'),
(848, 22, 'Teorama'),
(849, 22, 'Tibú'),
(850, 22, 'Toledo'),
(851, 22, 'Villa Caro'),
(852, 22, 'Villa del Rosario'),
(853, 22, 'Ábrego'),
(854, 23, 'Colón'),
(855, 23, 'Mocoa'),
(856, 23, 'Orito'),
(857, 23, 'Puerto Asís'),
(858, 23, 'Puerto Caicedo'),
(859, 23, 'Puerto Guzmán'),
(860, 23, 'Puerto Leguízamo'),
(861, 23, 'San Francisco'),
(862, 23, 'San Miguel'),
(863, 23, 'Santiago'),
(864, 23, 'Sibundoy'),
(865, 23, 'Valle del Guamuez'),
(866, 23, 'Villagarzón'),
(867, 24, 'Armenia'),
(868, 24, 'Buenavista'),
(869, 24, 'Calarcá'),
(870, 24, 'Circasia'),
(871, 24, 'Cordobá'),
(872, 24, 'Filandia'),
(873, 24, 'Génova'),
(874, 24, 'La Tebaida'),
(875, 24, 'Montenegro'),
(876, 24, 'Pijao'),
(877, 24, 'Quimbaya'),
(878, 24, 'Salento'),
(879, 25, 'Apía'),
(880, 25, 'Balboa'),
(881, 25, 'Belén de Umbría'),
(882, 25, 'Dos Quebradas'),
(883, 25, 'Guática'),
(884, 25, 'La Celia'),
(885, 25, 'La Virginia'),
(886, 25, 'Marsella'),
(887, 25, 'Mistrató'),
(888, 25, 'Pereira'),
(889, 25, 'Pueblo Rico'),
(890, 25, 'Quinchía'),
(891, 25, 'Santa Rosa de Cabal'),
(892, 25, 'Santuario'),
(893, 26, 'Providencia'),
(894, 27, 'Aguada'),
(895, 27, 'Albania'),
(896, 27, 'Aratoca'),
(897, 27, 'Barbosa'),
(898, 27, 'Barichara'),
(899, 27, 'Barrancabermeja'),
(900, 27, 'Betulia'),
(901, 27, 'Bolívar'),
(902, 27, 'Bucaramanga'),
(903, 27, 'Cabrera'),
(904, 27, 'California'),
(905, 27, 'Capitanejo'),
(906, 27, 'Carcasí'),
(907, 27, 'Cepita'),
(908, 27, 'Cerrito'),
(909, 27, 'Charalá'),
(910, 27, 'Charta'),
(911, 27, 'Chima'),
(912, 27, 'Chipatá'),
(913, 27, 'Cimitarra'),
(914, 27, 'Concepción'),
(915, 27, 'Confines'),
(916, 27, 'Contratación'),
(917, 27, 'Coromoro'),
(918, 27, 'Curití'),
(919, 27, 'El Carmen'),
(920, 27, 'El Guacamayo'),
(921, 27, 'El Peñon'),
(922, 27, 'El Playón'),
(923, 27, 'Encino'),
(924, 27, 'Enciso'),
(925, 27, 'Floridablanca'),
(926, 27, 'Florián'),
(927, 27, 'Galán'),
(928, 27, 'Girón'),
(929, 27, 'Guaca'),
(930, 27, 'Guadalupe'),
(931, 27, 'Guapota'),
(932, 27, 'Guavatá'),
(933, 27, 'Guepsa'),
(934, 27, 'Gámbita'),
(935, 27, 'Hato'),
(936, 27, 'Jesús María'),
(937, 27, 'Jordán'),
(938, 27, 'La Belleza'),
(939, 27, 'La Paz'),
(940, 27, 'Landázuri'),
(941, 27, 'Lebrija'),
(942, 27, 'Los Santos'),
(943, 27, 'Macaravita'),
(944, 27, 'Matanza'),
(945, 27, 'Mogotes'),
(946, 27, 'Molagavita'),
(947, 27, 'Málaga'),
(948, 27, 'Ocamonte'),
(949, 27, 'Oiba'),
(950, 27, 'Onzaga'),
(951, 27, 'Palmar'),
(952, 27, 'Palmas del Socorro'),
(953, 27, 'Pie de Cuesta'),
(954, 27, 'Pinchote'),
(955, 27, 'Puente Nacional'),
(956, 27, 'Puerto Parra'),
(957, 27, 'Puerto Wilches'),
(958, 27, 'Páramo'),
(959, 27, 'Rio Negro'),
(960, 27, 'Sabana de Torres'),
(961, 27, 'San Andrés'),
(962, 27, 'San Benito'),
(963, 27, 'San Gíl'),
(964, 27, 'San Joaquín'),
(965, 27, 'San José de Miranda'),
(966, 27, 'San Miguel'),
(967, 27, 'San Vicente del Chucurí'),
(968, 27, 'Santa Bárbara'),
(969, 27, 'Santa Helena del Opón'),
(970, 27, 'Simacota'),
(971, 27, 'Socorro'),
(972, 27, 'Suaita'),
(973, 27, 'Sucre'),
(974, 27, 'Suratá'),
(975, 27, 'Tona'),
(976, 27, 'Valle de San José'),
(977, 27, 'Vetas'),
(978, 27, 'Villanueva'),
(979, 27, 'Vélez'),
(980, 27, 'Zapatoca'),
(981, 28, 'Buenavista'),
(982, 28, 'Caimito'),
(983, 28, 'Chalán'),
(984, 28, 'Colosó (Ricaurte)'),
(985, 28, 'Corozal'),
(986, 28, 'Coveñas'),
(987, 28, 'El Roble'),
(988, 28, 'Galeras (Nueva Granada)'),
(989, 28, 'Guaranda'),
(990, 28, 'La Unión'),
(991, 28, 'Los Palmitos'),
(992, 28, 'Majagual'),
(993, 28, 'Morroa'),
(994, 28, 'Ovejas'),
(995, 28, 'Palmito'),
(996, 28, 'Sampués'),
(997, 28, 'San Benito Abad'),
(998, 28, 'San Juan de Betulia'),
(999, 28, 'San Marcos'),
(1000, 28, 'San Onofre'),
(1001, 28, 'San Pedro'),
(1002, 28, 'Sincelejo'),
(1003, 28, 'Sincé'),
(1004, 28, 'Sucre'),
(1005, 28, 'Tolú'),
(1006, 28, 'Tolú Viejo'),
(1007, 29, 'Alpujarra'),
(1008, 29, 'Alvarado'),
(1009, 29, 'Ambalema'),
(1010, 29, 'Anzoátegui'),
(1011, 29, 'Armero (Guayabal)'),
(1012, 29, 'Ataco'),
(1013, 29, 'Cajamarca'),
(1014, 29, 'Carmen de Apicalá'),
(1015, 29, 'Casabianca'),
(1016, 29, 'Chaparral'),
(1017, 29, 'Coello'),
(1018, 29, 'Coyaima'),
(1019, 29, 'Cunday'),
(1020, 29, 'Dolores'),
(1021, 29, 'Espinal'),
(1022, 29, 'Falan'),
(1023, 29, 'Flandes'),
(1024, 29, 'Fresno'),
(1025, 29, 'Guamo'),
(1026, 29, 'Herveo'),
(1027, 29, 'Honda'),
(1028, 29, 'Ibagué'),
(1029, 29, 'Icononzo'),
(1030, 29, 'Lérida'),
(1031, 29, 'Líbano'),
(1032, 29, 'Mariquita'),
(1033, 29, 'Melgar'),
(1034, 29, 'Murillo'),
(1035, 29, 'Natagaima'),
(1036, 29, 'Ortega'),
(1037, 29, 'Palocabildo'),
(1038, 29, 'Piedras'),
(1039, 29, 'Planadas'),
(1040, 29, 'Prado'),
(1041, 29, 'Purificación'),
(1042, 29, 'Rioblanco'),
(1043, 29, 'Roncesvalles'),
(1044, 29, 'Rovira'),
(1045, 29, 'Saldaña'),
(1046, 29, 'San Antonio'),
(1047, 29, 'San Luis'),
(1048, 29, 'Santa Isabel'),
(1049, 29, 'Suárez'),
(1050, 29, 'Valle de San Juan'),
(1051, 29, 'Venadillo'),
(1052, 29, 'Villahermosa'),
(1053, 29, 'Villarrica'),
(1054, 30, 'Alcalá'),
(1055, 30, 'Andalucía'),
(1056, 30, 'Ansermanuevo'),
(1057, 30, 'Argelia'),
(1058, 30, 'Bolívar'),
(1059, 30, 'Buenaventura'),
(1060, 30, 'Buga'),
(1061, 30, 'Bugalagrande'),
(1062, 30, 'Caicedonia'),
(1063, 30, 'Calima (Darién)'),
(1064, 30, 'Calí'),
(1065, 30, 'Candelaria'),
(1066, 30, 'Cartago'),
(1067, 30, 'Dagua'),
(1068, 30, 'El Cairo'),
(1069, 30, 'El Cerrito'),
(1070, 30, 'El Dovio'),
(1071, 30, 'El Águila'),
(1072, 30, 'Florida'),
(1073, 30, 'Ginebra'),
(1074, 30, 'Guacarí'),
(1075, 30, 'Jamundí'),
(1076, 30, 'La Cumbre'),
(1077, 30, 'La Unión'),
(1078, 30, 'La Victoria'),
(1079, 30, 'Obando'),
(1080, 30, 'Palmira'),
(1081, 30, 'Pradera'),
(1082, 30, 'Restrepo'),
(1083, 30, 'Riofrío'),
(1084, 30, 'Roldanillo'),
(1085, 30, 'San Pedro'),
(1086, 30, 'Sevilla'),
(1087, 30, 'Toro'),
(1088, 30, 'Trujillo'),
(1089, 30, 'Tulúa'),
(1090, 30, 'Ulloa'),
(1091, 30, 'Versalles'),
(1092, 30, 'Vijes'),
(1093, 30, 'Yotoco'),
(1094, 30, 'Yumbo'),
(1095, 30, 'Zarzal'),
(1096, 31, 'Carurú'),
(1097, 31, 'Mitú'),
(1098, 31, 'Taraira'),
(1099, 32, 'Cumaribo'),
(1100, 32, 'La Primavera'),
(1101, 32, 'Puerto Carreño'),
(1102, 32, 'Santa Rosalía'),
(1103, 0, 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idPagos` int(11) NOT NULL,
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idMesPagos` int(2) NOT NULL,
  `idPlanes` int(10) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `registroPor` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `estadoPagos` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`idPagos`, `nitEmpresas`, `idMesPagos`, `idPlanes`, `fechaRegistro`, `registroPor`, `estadoPagos`) VALUES
(1, '152.214.231-6', 2, 0, '2021-03-13 23:25:59', '1088348388', 0),
(2, '152.214.231-6', 3, 0, '2021-03-13 23:25:59', '1088348388', 0),
(3, '152.214.231-6', 4, 2, '2021-03-14 00:41:31', '1088348388', 0),
(4, '152.214.231-6', 5, 2, '2021-03-14 00:47:18', '1088348388', 0),
(5, '152.214.231-6', 6, 2, '2021-03-14 00:47:53', '1088348388', 0),
(6, '152.214.231-6', 7, 2, '2021-03-14 00:48:34', '1088348388', 0),
(7, '152.214.231-6', 8, 3, '2021-03-14 00:48:50', '1088348388', 0),
(8, '152.214.231-6', 9, 3, '2021-03-15 16:22:33', '1088348388', 0),
(9, '152.214.231-6', 12, 2, '2021-03-18 16:23:35', '1088348388', 0),
(10, '546-744-454.4', 1, 2, '2021-03-18 21:34:33', '1088348388', 0),
(11, '546-744-454.4', 2, 2, '2021-03-18 21:44:48', '1088348388', 0),
(12, '546-744-454.4', 3, 3, '2021-03-18 21:45:43', '1088348388', 0),
(13, '152.214.231-6', 11, 3, '2021-03-20 23:46:17', '1088348388', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int(11) UNSIGNED NOT NULL,
  `code` smallint(6) DEFAULT NULL,
  `iso3166a1` char(2) DEFAULT NULL,
  `iso3166a2` char(3) DEFAULT NULL,
  `nombre` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `code`, `iso3166a1`, `iso3166a2`, `nombre`) VALUES
(1, 4, 'AF', 'AFG', 'Afganistán'),
(2, 248, 'AX', 'ALA', 'Islas Gland'),
(3, 8, 'AL', 'ALB', 'Albania'),
(4, 276, 'DE', 'DEU', 'Alemania'),
(5, 20, 'AD', 'AND', 'Andorra'),
(6, 24, 'AO', 'AGO', 'Angola'),
(7, 660, 'AI', 'AIA', 'Anguilla'),
(8, 10, 'AQ', 'ATA', 'Antártida'),
(9, 28, 'AG', 'ATG', 'Antigua y Barbuda'),
(10, 530, 'AN', 'ANT', 'Antillas Holandesas'),
(11, 682, 'SA', 'SAU', 'Arabia Saudí'),
(12, 12, 'DZ', 'DZA', 'Argelia'),
(13, 32, 'AR', 'ARG', 'Argentina'),
(14, 51, 'AM', 'ARM', 'Armenia'),
(15, 533, 'AW', 'ABW', 'Aruba'),
(16, 36, 'AU', 'AUS', 'Australia'),
(17, 40, 'AT', 'AUT', 'Austria'),
(18, 31, 'AZ', 'AZE', 'Azerbaiyán'),
(19, 44, 'BS', 'BHS', 'Bahamas'),
(20, 48, 'BH', 'BHR', 'Bahréin'),
(21, 50, 'BD', 'BGD', 'Bangladesh'),
(22, 52, 'BB', 'BRB', 'Barbados'),
(23, 112, 'BY', 'BLR', 'Bielorrusia'),
(24, 56, 'BE', 'BEL', 'Bélgica'),
(25, 84, 'BZ', 'BLZ', 'Belice'),
(26, 204, 'BJ', 'BEN', 'Benin'),
(27, 60, 'BM', 'BMU', 'Bermudas'),
(28, 64, 'BT', 'BTN', 'Bhután'),
(29, 68, 'BO', 'BOL', 'Bolivia'),
(30, 70, 'BA', 'BIH', 'Bosnia y Herzegovina'),
(31, 72, 'BW', 'BWA', 'Botsuana'),
(32, 74, 'BV', 'BVT', 'Isla Bouvet'),
(33, 76, 'BR', 'BRA', 'Brasil'),
(34, 96, 'BN', 'BRN', 'Brunéi'),
(35, 100, 'BG', 'BGR', 'Bulgaria'),
(36, 854, 'BF', 'BFA', 'Burkina Faso'),
(37, 108, 'BI', 'BDI', 'Burundi'),
(38, 132, 'CV', 'CPV', 'Cabo Verde'),
(39, 136, 'KY', 'CYM', 'Islas Caimán'),
(40, 116, 'KH', 'KHM', 'Camboya'),
(41, 120, 'CM', 'CMR', 'Camerún'),
(42, 124, 'CA', 'CAN', 'Canadá'),
(43, 140, 'CF', 'CAF', 'República Centroafricana'),
(44, 148, 'TD', 'TCD', 'Chad'),
(45, 203, 'CZ', 'CZE', 'República Checa'),
(46, 152, 'CL', 'CHL', 'Chile'),
(47, 156, 'CN', 'CHN', 'China'),
(48, 196, 'CY', 'CYP', 'Chipre'),
(49, 162, 'CX', 'CXR', 'Isla de Navidad'),
(50, 336, 'VA', 'VAT', 'Ciudad del Vaticano'),
(51, 166, 'CC', 'CCK', 'Islas Cocos'),
(52, 170, 'CO', 'COL', 'Colombia'),
(53, 174, 'KM', 'COM', 'Comoras'),
(54, 180, 'CD', 'COD', 'República Democrática del Congo'),
(55, 178, 'CG', 'COG', 'Congo'),
(56, 184, 'CK', 'COK', 'Islas Cook'),
(57, 408, 'KP', 'PRK', 'Corea del Norte'),
(58, 410, 'KR', 'KOR', 'Corea del Sur'),
(59, 384, 'CI', 'CIV', 'Costa de Marfil'),
(60, 188, 'CR', 'CRI', 'Costa Rica'),
(61, 191, 'HR', 'HRV', 'Croacia'),
(62, 192, 'CU', 'CUB', 'Cuba'),
(63, 208, 'DK', 'DNK', 'Dinamarca'),
(64, 212, 'DM', 'DMA', 'Dominica'),
(65, 214, 'DO', 'DOM', 'República Dominicana'),
(66, 218, 'EC', 'ECU', 'Ecuador'),
(67, 818, 'EG', 'EGY', 'Egipto'),
(68, 222, 'SV', 'SLV', 'El Salvador'),
(69, 784, 'AE', 'ARE', 'Emiratos Árabes Unidos'),
(70, 232, 'ER', 'ERI', 'Eritrea'),
(71, 703, 'SK', 'SVK', 'Eslovaquia'),
(72, 705, 'SI', 'SVN', 'Eslovenia'),
(73, 724, 'ES', 'ESP', 'España'),
(74, 581, 'UM', 'UMI', 'Islas ultramarinas de Estados Unidos'),
(75, 840, 'US', 'USA', 'Estados Unidos'),
(76, 233, 'EE', 'EST', 'Estonia'),
(77, 231, 'ET', 'ETH', 'Etiopía'),
(78, 234, 'FO', 'FRO', 'Islas Feroe'),
(79, 608, 'PH', 'PHL', 'Filipinas'),
(80, 246, 'FI', 'FIN', 'Finlandia'),
(81, 242, 'FJ', 'FJI', 'Fiyi'),
(82, 250, 'FR', 'FRA', 'Francia'),
(83, 266, 'GA', 'GAB', 'Gabón'),
(84, 270, 'GM', 'GMB', 'Gambia'),
(85, 268, 'GE', 'GEO', 'Georgia'),
(86, 239, 'GS', 'SGS', 'Islas Georgias del Sur y Sandwich del Sur'),
(87, 288, 'GH', 'GHA', 'Ghana'),
(88, 292, 'GI', 'GIB', 'Gibraltar'),
(89, 308, 'GD', 'GRD', 'Granada'),
(90, 300, 'GR', 'GRC', 'Grecia'),
(91, 304, 'GL', 'GRL', 'Groenlandia'),
(92, 312, 'GP', 'GLP', 'Guadalupe'),
(93, 316, 'GU', 'GUM', 'Guam'),
(94, 320, 'GT', 'GTM', 'Guatemala'),
(95, 254, 'GF', 'GUF', 'Guayana Francesa'),
(96, 324, 'GN', 'GIN', 'Guinea'),
(97, 226, 'GQ', 'GNQ', 'Guinea Ecuatorial'),
(98, 624, 'GW', 'GNB', 'Guinea-Bissau'),
(99, 328, 'GY', 'GUY', 'Guyana'),
(100, 332, 'HT', 'HTI', 'Haití'),
(101, 334, 'HM', 'HMD', 'Islas Heard y McDonald'),
(102, 340, 'HN', 'HND', 'Honduras'),
(103, 344, 'HK', 'HKG', 'Hong Kong'),
(104, 348, 'HU', 'HUN', 'Hungría'),
(105, 356, 'IN', 'IND', 'India'),
(106, 360, 'ID', 'IDN', 'Indonesia'),
(107, 364, 'IR', 'IRN', 'Irán'),
(108, 368, 'IQ', 'IRQ', 'Iraq'),
(109, 372, 'IE', 'IRL', 'Irlanda'),
(110, 352, 'IS', 'ISL', 'Islandia'),
(111, 376, 'IL', 'ISR', 'Israel'),
(112, 380, 'IT', 'ITA', 'Italia'),
(113, 388, 'JM', 'JAM', 'Jamaica'),
(114, 392, 'JP', 'JPN', 'Japón'),
(115, 400, 'JO', 'JOR', 'Jordania'),
(116, 398, 'KZ', 'KAZ', 'Kazajstán'),
(117, 404, 'KE', 'KEN', 'Kenia'),
(118, 417, 'KG', 'KGZ', 'Kirguistán'),
(119, 296, 'KI', 'KIR', 'Kiribati'),
(120, 414, 'KW', 'KWT', 'Kuwait'),
(121, 418, 'LA', 'LAO', 'Laos'),
(122, 426, 'LS', 'LSO', 'Lesotho'),
(123, 428, 'LV', 'LVA', 'Letonia'),
(124, 422, 'LB', 'LBN', 'Líbano'),
(125, 430, 'LR', 'LBR', 'Liberia'),
(126, 434, 'LY', 'LBY', 'Libia'),
(127, 438, 'LI', 'LIE', 'Liechtenstein'),
(128, 440, 'LT', 'LTU', 'Lituania'),
(129, 442, 'LU', 'LUX', 'Luxemburgo'),
(130, 446, 'MO', 'MAC', 'Macao'),
(131, 807, 'MK', 'MKD', 'ARY Macedonia'),
(132, 450, 'MG', 'MDG', 'Madagascar'),
(133, 458, 'MY', 'MYS', 'Malasia'),
(134, 454, 'MW', 'MWI', 'Malawi'),
(135, 462, 'MV', 'MDV', 'Maldivas'),
(136, 466, 'ML', 'MLI', 'Malí'),
(137, 470, 'MT', 'MLT', 'Malta'),
(138, 238, 'FK', 'FLK', 'Islas Malvinas'),
(139, 580, 'MP', 'MNP', 'Islas Marianas del Norte'),
(140, 504, 'MA', 'MAR', 'Marruecos'),
(141, 584, 'MH', 'MHL', 'Islas Marshall'),
(142, 474, 'MQ', 'MTQ', 'Martinica'),
(143, 480, 'MU', 'MUS', 'Mauricio'),
(144, 478, 'MR', 'MRT', 'Mauritania'),
(145, 175, 'YT', 'MYT', 'Mayotte'),
(146, 484, 'MX', 'MEX', 'México'),
(147, 583, 'FM', 'FSM', 'Micronesia'),
(148, 498, 'MD', 'MDA', 'Moldavia'),
(149, 492, 'MC', 'MCO', 'Mónaco'),
(150, 496, 'MN', 'MNG', 'Mongolia'),
(151, 500, 'MS', 'MSR', 'Montserrat'),
(152, 508, 'MZ', 'MOZ', 'Mozambique'),
(153, 104, 'MM', 'MMR', 'Myanmar'),
(154, 516, 'NA', 'NAM', 'Namibia'),
(155, 520, 'NR', 'NRU', 'Nauru'),
(156, 524, 'NP', 'NPL', 'Nepal'),
(157, 558, 'NI', 'NIC', 'Nicaragua'),
(158, 562, 'NE', 'NER', 'Níger'),
(159, 566, 'NG', 'NGA', 'Nigeria'),
(160, 570, 'NU', 'NIU', 'Niue'),
(161, 574, 'NF', 'NFK', 'Isla Norfolk'),
(162, 578, 'NO', 'NOR', 'Noruega'),
(163, 540, 'NC', 'NCL', 'Nueva Caledonia'),
(164, 554, 'NZ', 'NZL', 'Nueva Zelanda'),
(165, 512, 'OM', 'OMN', 'Omán'),
(166, 528, 'NL', 'NLD', 'Países Bajos'),
(167, 586, 'PK', 'PAK', 'Pakistán'),
(168, 585, 'PW', 'PLW', 'Palau'),
(169, 275, 'PS', 'PSE', 'Palestina'),
(170, 591, 'PA', 'PAN', 'Panamá'),
(171, 598, 'PG', 'PNG', 'Papúa Nueva Guinea'),
(172, 600, 'PY', 'PRY', 'Paraguay'),
(173, 604, 'PE', 'PER', 'Perú'),
(174, 612, 'PN', 'PCN', 'Islas Pitcairn'),
(175, 258, 'PF', 'PYF', 'Polinesia Francesa'),
(176, 616, 'PL', 'POL', 'Polonia'),
(177, 620, 'PT', 'PRT', 'Portugal'),
(178, 630, 'PR', 'PRI', 'Puerto Rico'),
(179, 634, 'QA', 'QAT', 'Qatar'),
(180, 826, 'GB', 'GBR', 'Reino Unido'),
(181, 638, 'RE', 'REU', 'Reunión'),
(182, 646, 'RW', 'RWA', 'Ruanda'),
(183, 642, 'RO', 'ROU', 'Rumania'),
(184, 643, 'RU', 'RUS', 'Rusia'),
(185, 732, 'EH', 'ESH', 'Sahara Occidental'),
(186, 90, 'SB', 'SLB', 'Islas Salomón'),
(187, 882, 'WS', 'WSM', 'Samoa'),
(188, 16, 'AS', 'ASM', 'Samoa Americana'),
(189, 659, 'KN', 'KNA', 'San Cristóbal y Nevis'),
(190, 674, 'SM', 'SMR', 'San Marino'),
(191, 666, 'PM', 'SPM', 'San Pedro y Miquelón'),
(192, 670, 'VC', 'VCT', 'San Vicente y las Granadinas'),
(193, 654, 'SH', 'SHN', 'Santa Helena'),
(194, 662, 'LC', 'LCA', 'Santa Lucía'),
(195, 678, 'ST', 'STP', 'Santo Tomé y Príncipe'),
(196, 686, 'SN', 'SEN', 'Senegal'),
(197, 891, 'CS', 'SCG', 'Serbia y Montenegro'),
(198, 690, 'SC', 'SYC', 'Seychelles'),
(199, 694, 'SL', 'SLE', 'Sierra Leona'),
(200, 702, 'SG', 'SGP', 'Singapur'),
(201, 760, 'SY', 'SYR', 'Siria'),
(202, 706, 'SO', 'SOM', 'Somalia'),
(203, 144, 'LK', 'LKA', 'Sri Lanka'),
(204, 748, 'SZ', 'SWZ', 'Suazilandia'),
(205, 710, 'ZA', 'ZAF', 'Sudáfrica'),
(206, 736, 'SD', 'SDN', 'Sudán'),
(207, 752, 'SE', 'SWE', 'Suecia'),
(208, 756, 'CH', 'CHE', 'Suiza'),
(209, 740, 'SR', 'SUR', 'Surinam'),
(210, 744, 'SJ', 'SJM', 'Svalbard y Jan Mayen'),
(211, 764, 'TH', 'THA', 'Tailandia'),
(212, 158, 'TW', 'TWN', 'Taiwán'),
(213, 834, 'TZ', 'TZA', 'Tanzania'),
(214, 762, 'TJ', 'TJK', 'Tayikistán'),
(215, 86, 'IO', 'IOT', 'Territorio Británico del Océano Índico'),
(216, 260, 'TF', 'ATF', 'Territorios Australes Franceses'),
(217, 626, 'TL', 'TLS', 'Timor Oriental'),
(218, 768, 'TG', 'TGO', 'Togo'),
(219, 772, 'TK', 'TKL', 'Tokelau'),
(220, 776, 'TO', 'TON', 'Tonga'),
(221, 780, 'TT', 'TTO', 'Trinidad y Tobago'),
(222, 788, 'TN', 'TUN', 'Túnez'),
(223, 796, 'TC', 'TCA', 'Islas Turcas y Caicos'),
(224, 795, 'TM', 'TKM', 'Turkmenistán'),
(225, 792, 'TR', 'TUR', 'Turquía'),
(226, 798, 'TV', 'TUV', 'Tuvalu'),
(227, 804, 'UA', 'UKR', 'Ucrania'),
(228, 800, 'UG', 'UGA', 'Uganda'),
(229, 858, 'UY', 'URY', 'Uruguay'),
(230, 860, 'UZ', 'UZB', 'Uzbekistán'),
(231, 548, 'VU', 'VUT', 'Vanuatu'),
(232, 862, 'VE', 'VEN', 'Venezuela'),
(233, 704, 'VN', 'VNM', 'Vietnam'),
(234, 92, 'VG', 'VGB', 'Islas Vírgenes Británicas'),
(235, 850, 'VI', 'VIR', 'Islas Vírgenes de los Estados Unidos'),
(236, 876, 'WF', 'WLF', 'Wallis y Futuna'),
(237, 887, 'YE', 'YEM', 'Yemen'),
(238, 262, 'DJ', 'DJI', 'Yibuti'),
(239, 894, 'ZM', 'ZMB', 'Zambia'),
(240, 716, 'ZW', 'ZWE', 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE `parametros` (
  `idParametros` int(11) NOT NULL,
  `valorHoraMotosParametros` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valorHoraAutosParametros` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `horasParametros` int(1) DEFAULT NULL,
  `mesesParametros` int(1) DEFAULT NULL,
  `articulosParametros` int(1) DEFAULT NULL,
  `lavadaParametros` int(1) DEFAULT NULL,
  `lavadaMotosParametros` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lavadaAutosParametros` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mesesAutosParametros` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mesesMotosParametros` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `registradoPor` int(11) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`idParametros`, `valorHoraMotosParametros`, `valorHoraAutosParametros`, `horasParametros`, `mesesParametros`, `articulosParametros`, `lavadaParametros`, `lavadaMotosParametros`, `lavadaAutosParametros`, `mesesAutosParametros`, `mesesMotosParametros`, `registradoPor`, `fechaRegistro`, `nitEmpresas`) VALUES
(1, '5000', '1000', 1, 1, 1, 1, '5555', '4444', '2000', '5000', 24694000, '2021-03-13 15:01:05', '152.214.231-6'),
(2, '1000', '2500', 0, 0, 0, 0, '55555', '5000', '40000', '3000', 11111, '2021-03-18 17:20:13', '546-744-454.4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parqueos`
--

CREATE TABLE `parqueos` (
  `idParqueos` int(11) NOT NULL,
  `documentoUsuarios` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `placaVehiculos` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `horaIngresoParqueos` time DEFAULT NULL,
  `horaSalidaParqueos` time DEFAULT '00:00:00',
  `pagoServiciosParqueos` int(11) DEFAULT NULL,
  `codigoRetiroParqueos` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estadoParqueos` int(1) DEFAULT 1,
  `nitEmpresas` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `registroPor` int(11) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `cantidadCascos` int(1) DEFAULT NULL,
  `casilleroCascos` varchar(3) COLLATE utf8_spanish_ci DEFAULT 'N/A',
  `horaServicioParqueos` int(3) DEFAULT 0,
  `diaParqueos` date NOT NULL,
  `lavadaParqueos` int(1) NOT NULL DEFAULT 0,
  `mensualidadParqueos` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `idPlanes` int(11) NOT NULL,
  `descripcionPlanes` text COLLATE utf8_spanish_ci NOT NULL,
  `nombrePlanes` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `precioPlanes` int(11) NOT NULL,
  `registroPor` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fechaRegistros` datetime NOT NULL,
  `idImagen` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`idPlanes`, `descripcionPlanes`, `nombrePlanes`, `precioPlanes`, `registroPor`, `fechaRegistros`, `idImagen`) VALUES
(4, '<p>asdgasdgsdgsadgasdg</p>', 'Gratuito', 0, '1088348388', '2021-04-15 21:47:09', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `idRespuestas` int(11) NOT NULL,
  `idSolicitud` int(11) NOT NULL,
  `idRespuesta` int(11) NOT NULL,
  `fechaRegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`idRespuestas`, `idSolicitud`, `idRespuesta`, `fechaRegistro`) VALUES
(1, 2, 3, '2021-04-13 14:26:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRoles` int(11) NOT NULL,
  `nombreRoles` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `descripcionRoles` text COLLATE utf8_spanish_ci NOT NULL,
  `activarRegistro` int(1) NOT NULL DEFAULT 1,
  `registradoPorUsuarios` int(11) NOT NULL,
  `fechaRegistro` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRoles`, `nombreRoles`, `descripcionRoles`, `activarRegistro`, `registradoPorUsuarios`, `fechaRegistro`) VALUES
(1, 'Admin Sistema', 'Es el encargado del software y de la empresa que presta el servicio del software', 1, 1088348388, '2021-03-12 18:14:13'),
(2, 'Administrador Empres', 'Es el encargado en su defecto, de cada parqueadero', 1, 1088348388, '2021-03-12 18:14:13'),
(3, 'Cajero Empresas', 'Es el encargado en los parqueaderos, de realizar el proceso de registro, ventas  y demás', 1, 1088348388, '2021-03-12 18:15:53'),
(4, 'Cliente Empresas', 'Es el cliente final, es decir, los clientes de los parqueaderos', 1, 1088348388, '2021-03-12 18:16:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonios`
--

CREATE TABLE `testimonios` (
  `idTestimonios` int(11) NOT NULL,
  `cargoTestimonios` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idImagen` int(11) NOT NULL,
  `descripcionTestimonios` text COLLATE utf8_spanish_ci NOT NULL,
  `documentoUsuarios` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fechaRegistros` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `testimonios`
--

INSERT INTO `testimonios` (`idTestimonios`, `cargoTestimonios`, `idImagen`, `descripcionTestimonios`, `documentoUsuarios`, `fechaRegistros`) VALUES
(6, 'Desarrollador Back-End', 15, '<p>Esta es la segunda prueba</p>', '11114444', '2021-04-15 22:58:57'),
(5, 'Prueba Editar', 13, '<p>dbdgbdbsdbs<zsdb< p=\"\"></zsdb<></p>', '1088348388', '2021-04-15 22:09:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `documentoUsuarios` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `passUsuarios` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaRegistroUsuarios` datetime DEFAULT NULL,
  `nombre1Usuarios` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `emailUsuarios` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idRoles` int(11) NOT NULL,
  `nombre2Usuarios` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido1Usuarios` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido2Usuarios` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaNacimientoUsuarios` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `passDefectoUsuarios` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL,
  `passEstadoUsuarios` int(1) NOT NULL DEFAULT 1,
  `idFotoUsuarios` int(11) NOT NULL DEFAULT 1,
  `nitEmpresas` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fijoUsuarios` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `celular1Usuarios` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `celular2Usuarios` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccionUsuarios` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `estadoCorreo` int(1) NOT NULL DEFAULT 0,
  `hashUsuario` text COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`documentoUsuarios`, `passUsuarios`, `fechaRegistroUsuarios`, `nombre1Usuarios`, `emailUsuarios`, `idRoles`, `nombre2Usuarios`, `apellido1Usuarios`, `apellido2Usuarios`, `fechaNacimientoUsuarios`, `passDefectoUsuarios`, `passEstadoUsuarios`, `idFotoUsuarios`, `nitEmpresas`, `fijoUsuarios`, `celular1Usuarios`, `celular2Usuarios`, `direccionUsuarios`, `estadoCorreo`, `hashUsuario`) VALUES
('00000000', '0000', '2021-03-16 14:47:15', NULL, NULL, 4, NULL, NULL, NULL, NULL, '0000', 1, 1, '152.214.231-6', NULL, '3054028864', NULL, NULL, 0, ''),
('00000001', '0001', '2021-03-16 14:47:48', 'Pruebas', 'Pruebas', 4, 'Preubas', 'Preubas', 'Pruebas', NULL, '0001', 1, 1, '152.214.231-6', NULL, '3054028864', NULL, NULL, 0, ''),
('001', '1', '2021-03-16 14:48:35', NULL, NULL, 4, NULL, NULL, NULL, NULL, '1', 1, 1, '152.214.231-6', NULL, '3054028864', NULL, NULL, 0, ''),
('1088348388', 'NDQ0PA==', '2021-03-12 18:11:03', 'Cesar', 'trujillogarciac2@gmail.com', 1, '', 'Trujillo', '', '2021-03-25', '8388', 0, 4, '150.245.212-2', '', '3054028864', '3054028864', 'Mz 34 Casa 3 Mirador de Llano Grande', 1, ''),
('108834838ff', '38ff', '2021-03-18 20:30:21', NULL, NULL, 4, NULL, NULL, NULL, NULL, '38ff', 1, 1, '546-744-454.4', NULL, '3054028864', NULL, NULL, 0, ''),
('108854', '8854', '2021-03-18 17:25:11', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8854', 1, 1, '546-744-454.4', NULL, '3054028864', NULL, NULL, 0, ''),
('1088544', '8544', '2021-03-20 13:13:04', 'Pruebas', NULL, 4, NULL, NULL, NULL, NULL, '8544', 1, 1, '152.214.231-6', NULL, '3054028864', NULL, NULL, 0, ''),
('11111', 'NDQ0PA==', '2021-03-18 17:19:41', 'Pruebas', 'fsafsaf@gmail.com', 2, '', 'Registros', '', '2021-03-18', '1111', 0, 1, '546-744-454.4', '', '3054028864', '', '', 0, ''),
('11114444', 'NDQ0PA==', '2021-04-15 22:32:59', 'Camilo', 'trujillogarciac2@gmail.com', 1, '', 'Ortíz', '', '2021-04-15', '4444', 0, 1, '150.245.212-2', '', '3054028864', '', '', 1, 'BSQyGwsQcMyP29fP9WDI.VNc4ooIunFqmMG'),
('123456', 'NDQ0PA==', '2021-03-20 12:22:12', 'Login', 'sadfasfsa@gmail.com', 2, '', 'Login', '', '2021-03-20', '3456', 0, 5, '546-744-454.4', '', '3054028864', '', '', 0, ''),
('123456789', '6789', '2021-03-16 14:23:55', 'Prueba', NULL, 8, NULL, NULL, NULL, NULL, '6789', 1, 1, '152.214.231-6', NULL, '3054028864', NULL, NULL, 0, ''),
('1254515245', '5245', '2021-04-12 13:37:35', 'Prueba', 'trujillogarciac2@gmail.com', 3, '', 'Todo', '', '2021-04-12', '5245', 1, 1, '152.214.231-6', '', '3054028864', '', '', 0, '.ietCKp44uBFslZg1dx6rj6HvyEj0Vk7kyl'),
('222222', '2222', '2021-03-18 17:24:22', NULL, NULL, 4, NULL, NULL, NULL, NULL, '2222', 1, 1, '546-744-454.4', NULL, '2455654545', NULL, NULL, 0, ''),
('24694000', 'NDQ0PA==', '2021-03-13 14:57:53', 'Administrador', 'trujillo@gmail.com', 2, '', 'Empresa', '', '2021-02-24', '4000', 0, 4, '152.214.231-6', '0363512585', '3054028864', '', '', 1, ''),
('456789', '6789', '2021-03-16 14:45:04', NULL, NULL, 4, NULL, NULL, NULL, NULL, '6789', 1, 1, '152.214.231-6', NULL, '3054028864', NULL, NULL, 0, ''),
('50505050', '5050', '2021-04-16 00:07:03', 'Prueba', 'catrujillo@unitecnica.net', 3, '', 'Arqueos', '', '2021-04-16', '5050', 1, 1, '152.214.231-6', '', '3054028864', '', '', 0, 'ovCQmOi5Qk1m1rKlOoEPitrPJNjz7HuPSsR'),
('5897899445', '9445', '2021-03-18 20:49:21', NULL, NULL, 4, NULL, NULL, NULL, NULL, '9445', 1, 1, '546-744-454.4', NULL, '1123654564', NULL, NULL, 0, ''),
('666666666', '6666', '2021-04-13 15:21:30', 'Pagina', 'softpark24@gmail.com', 4, 'Web', 'Formulario', 'Contactenos', '2021-04-13', '6666', 1, 1, '150.245.212-2', '', '3054028864', '', '', 0, '9H4mxZUg8THMGoYXQcoRyIl1pV.bAVA6nNp'),
('88888', '8888', '2021-03-18 17:22:30', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8888', 1, 1, '546-744-454.4', NULL, '3054028864', NULL, NULL, 0, ''),
('98746545646', '5646', '2021-03-18 21:16:41', NULL, NULL, 4, NULL, NULL, NULL, NULL, '5646', 1, 1, '546-744-454.4', NULL, '65456456', NULL, NULL, 0, ''),
('df123456788', '6788', '2021-03-18 20:30:03', NULL, NULL, 4, NULL, NULL, NULL, NULL, '6788', 1, 1, '546-744-454.4', NULL, '3054028864', NULL, NULL, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_mensajes`
--

CREATE TABLE `usuarios_mensajes` (
  `idSolicitudes` int(11) NOT NULL,
  `documentoUsuarios` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `idMensajes` int(11) NOT NULL,
  `estadoSolicitud` int(1) NOT NULL DEFAULT 0,
  `fechaRegistro` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios_mensajes`
--

INSERT INTO `usuarios_mensajes` (`idSolicitudes`, `documentoUsuarios`, `idMensajes`, `estadoSolicitud`, `fechaRegistro`) VALUES
(1, '1088348388', 1, 1, '2021-04-12 13:51:49'),
(2, '1088348388', 2, 1, '2021-04-12 20:16:36'),
(3, '24694000', 3, 2, '2021-04-13 14:26:10'),
(4, '1088348388', 4, 1, '2021-04-13 15:12:20'),
(5, '1088348388', 5, 1, '2021-04-13 15:13:00'),
(6, '1088348388', 6, 1, '2021-04-13 15:13:06'),
(7, '1088348388', 7, 1, '2021-04-13 15:14:23'),
(8, '1088348388', 8, 1, '2021-04-13 15:14:27'),
(9, '1088348388', 9, 1, '2021-04-13 15:18:10'),
(10, '666666666', 10, 0, '2021-04-13 15:23:55'),
(11, '666666666', 11, 0, '2021-04-13 15:23:57'),
(12, '666666666', 12, 0, '2021-04-13 15:23:58'),
(13, '666666666', 13, 0, '2021-04-13 15:24:00'),
(14, '666666666', 14, 0, '2021-04-13 15:24:01'),
(15, '666666666', 15, 0, '2021-04-13 15:24:01'),
(16, '666666666', 16, 0, '2021-04-13 15:24:03'),
(17, '666666666', 17, 0, '2021-04-13 15:24:03'),
(18, '666666666', 18, 0, '2021-04-13 15:24:03'),
(19, '1088348388', 19, 1, '2021-04-13 15:24:53'),
(20, '1088348388', 20, 1, '2021-04-13 15:24:54'),
(21, '1088348388', 21, 1, '2021-04-13 15:26:01'),
(22, '1088348388', 22, 1, '2021-04-13 18:43:32'),
(23, '1088348388', 23, 1, '2021-04-13 18:43:34'),
(24, '1088348388', 24, 1, '2021-04-13 18:43:36'),
(25, '1088348388', 25, 1, '2021-04-13 18:43:39'),
(26, '1088348388', 26, 1, '2021-04-13 18:43:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `idVehiculos` int(11) NOT NULL,
  `placaVehiculos` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `colorVehiculos` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `marcaVehiculos` int(2) DEFAULT NULL,
  `registradoPor` int(11) DEFAULT NULL,
  `fechaRegistros` datetime DEFAULT NULL,
  `empresaRegistros` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `documentoUsuarios` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipoVehiculos` int(1) NOT NULL,
  `controlVehiculos` int(11) NOT NULL DEFAULT 0,
  `nitEmpresas` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `lavadaParqueos` int(1) NOT NULL DEFAULT 0,
  `mensualidadParqueos` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`idVehiculos`, `placaVehiculos`, `colorVehiculos`, `marcaVehiculos`, `registradoPor`, `fechaRegistros`, `empresaRegistros`, `documentoUsuarios`, `tipoVehiculos`, `controlVehiculos`, `nitEmpresas`, `lavadaParqueos`, `mensualidadParqueos`) VALUES
(2, 'RLB-48E', NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, '152.214.231-6', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arqueos`
--
ALTER TABLE `arqueos`
  ADD PRIMARY KEY (`idArqueos`);

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`idArticulos`);

--
-- Indices de la tabla `articulosVentas`
--
ALTER TABLE `articulosVentas`
  ADD PRIMARY KEY (`idVenta`);

--
-- Indices de la tabla `cabeceraVentas`
--
ALTER TABLE `cabeceraVentas`
  ADD PRIMARY KEY (`idCabecera`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`idDepartamentos`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`nitEmpresas`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`idFotos`);

--
-- Indices de la tabla `historialMes`
--
ALTER TABLE `historialMes`
  ADD PRIMARY KEY (`idHistMes`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`idImagen`);

--
-- Indices de la tabla `marcaArticulos`
--
ALTER TABLE `marcaArticulos`
  ADD PRIMARY KEY (`idMarcaArticulos`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idMarcas`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`idMensajes`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`idMunicipios`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idPagos`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD PRIMARY KEY (`idParametros`);

--
-- Indices de la tabla `parqueos`
--
ALTER TABLE `parqueos`
  ADD PRIMARY KEY (`idParqueos`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`idPlanes`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`idRespuestas`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRoles`);

--
-- Indices de la tabla `testimonios`
--
ALTER TABLE `testimonios`
  ADD PRIMARY KEY (`idTestimonios`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`documentoUsuarios`);

--
-- Indices de la tabla `usuarios_mensajes`
--
ALTER TABLE `usuarios_mensajes`
  ADD PRIMARY KEY (`idSolicitudes`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`idVehiculos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `arqueos`
--
ALTER TABLE `arqueos`
  MODIFY `idArqueos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `idArticulos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `articulosVentas`
--
ALTER TABLE `articulosVentas`
  MODIFY `idVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `cabeceraVentas`
--
ALTER TABLE `cabeceraVentas`
  MODIFY `idCabecera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `idDepartamentos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `idFotos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `historialMes`
--
ALTER TABLE `historialMes`
  MODIFY `idHistMes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `idImagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `marcaArticulos`
--
ALTER TABLE `marcaArticulos`
  MODIFY `idMarcaArticulos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `idMarcas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `idMensajes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `idMunicipios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1104;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idPagos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT de la tabla `parametros`
--
ALTER TABLE `parametros`
  MODIFY `idParametros` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `parqueos`
--
ALTER TABLE `parqueos`
  MODIFY `idParqueos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `idPlanes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `idRespuestas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRoles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `testimonios`
--
ALTER TABLE `testimonios`
  MODIFY `idTestimonios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios_mensajes`
--
ALTER TABLE `usuarios_mensajes`
  MODIFY `idSolicitudes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `idVehiculos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
