<?php
include_once('conexion.php');
@session_start();
//Variable para el título de la página
@$titles = "SoftPark";

//Variable para los estados de los mensajes
//Estado mensaje: 0 = no leído. 1 = leído. 2 = respondido. 3 = respuesta
@$estadoMensajes     = array('0' => 'No leído', '1' => 'Leído', '2' => 'Respuesta No Leída', '3' => 'Respuesta Leída', '4' => 'Formulario Contactenos Sin Leer');
@$tipoVehiculos     = "SELECT idTipoVehiculos, nombreTipoVehiculos FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' ORDER BY nombreTipoVehiculos";
@$estadoParqueos     = array('1' => 'En Parqueadero', '2' => 'Próximo a Retirar', '3' => 'Retirado');
@$estadoEmpresas     = array('0' => 'Inhabilitada', '1' => 'Habilitada');
@$siNo               = array('-1' => 'N/A', '0' => 'No', '1' => 'Si');
@$nombreRoles        = array('1' => 'Administrador SoftPark', '2' => 'Administrador Empresa', '3' => 'Cajero Empresa', '4' => 'Cliente');
@$metodoPago         = array('1' => 'Mensual', '2' => 'Anual');
@$idMeses            = array('1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',);
@$medidasArticulos   = array('1' => 'Métros', '2' => 'Mililitros', '3' => 'Unidad(es)');
@$cantidadPaginacion = array('1' => '1', '5' => '5', '10' => '10', '20' => '20', '30' => '30', '90' => '90');

//Definos la motocicleta marcada para configuracion del sistema
//Tremos el vehiculo que esta marcado
@$marcadoVehiculo            = "SELECT CASE WHEN COUNT(idTipoVehiculos) = 0 THEN 'N' ELSE idTipoVehiculos END FROM tiposVehiculos WHERE nitEmpresas = '$_SESSION[nitEmpresas]' AND marcadoVehiculos = '1'";
@$ejecutarMarcado            = mysqli_query(@$conexion, @$marcadoVehiculo);
@$fetchMarcado               = mysqli_fetch_row(@$ejecutarMarcado);
@$idMotocicleta              = @$fetchMarcado[0];

//id del rol administrador
@$idAdministradorSistema     = '1';
@$idAdministradorEmpresas    = '2';
@$idCajeroEmpresas           = '3';
@$idClienteEmpresas          = '4';
@$nitParkingSoft             = '150.245.212-2';
@$documentoAdministrador     = '1088348388';
@$configHoras                = 'horasParametros';
@$configMeses                = 'mesesParametros';
@$configLavadas              = 'lavadaParametros';
@$configArticulos            = 'articulosParametros';
@$enlaceCorreos              = 'localhost/Proyecto/vistas/';
//@$enlaceCorreos              = 'softpark.epizy.com/vistas/';

//Mensaje de registros
@$siRegistros        = "<div class='alert alert-success'><b>Datos almacenados satisfactoriamente.</b></div>";
@$noRegistros        = "<div class='alert alert-danger'><b>Lo sentimos, su información no fue registrada.</b></div>";
@$siEliminar         = "<div class='alert alert-success'><b>Datos eliminados correctamente.</b></div>";
@$noEliminar         = "<div class='alert alert-danger'><b>Lo sentimos, la información no pudo se eliminada.</b></div>";
@$siEditar           = "<div class='alert alert-success'><b>Datos modificados correctamente.</b></div>";
@$noEditar           = "<div class='alert alert-danger'><b>Lo sentimos, la información no fue modificada.</b></div>";
@$siRetiros          = "<div class='alert alert-success'><b>Retiro de vehículo registrado correctamente.</b></div>";
@$noRetiros          = "<div class='alert alert-danger'><b>Su retiro no fue registrado.</b></div>";
@$noPermisos         = "<div class='alert alert-danger'><b>Lo sentimos, no posee permisos para acceder a esta opción.</b></div>";
@$preguntaEliminar   = "<b>¿Esta seguro de eliminar este registro? Recuerde que no podrá recuperar la información</b>";

//Fecha actual
@$fechaRegistros = date("Y/m/d H:i:s");
//@$fechaRegistros = date("Y/m/d H:i:s");

//Iconos bootstrap
@$size   = "width='20' height='20'";

@$usuarios                  = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/><path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>&nbsp;';
@$btnRegistrarUsuarios      = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16"><path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/></svg>&nbsp;';
@$btnUsuarios               = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg>&nbsp;';
@$btnModifcarContraseña     = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16"><path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>&nbsp;';
@$cerrarSesion              = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/></svg>&nbsp;';
@$btnRoles                  = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-diagram-3-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zm-6 8A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm6 0A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm6 0a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1z"/></svg>&nbsp;';
@$btnAdministradores        = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/></svg>&nbsp;';
@$btnEditar                 = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>&nbsp;';
@$btnRegistrar              = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>&nbsp;';
@$btnInicio                 = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/><path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/></svg>&nbsp;';
@$btnSolicitudes            = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-chat-text-fill" viewBox="0 0 16 16"><path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z"/></svg>&nbsp;';
@$btnUsuarios               = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg>&nbsp;';
@$btnVerMisSolicitudes      = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/></svg>&nbsp;';
@$btnLeido                  = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16"><path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7l-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/><path d="M5.354 7.146l.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/></svg>&nbsp;';
@$btnVehiculos              = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16"><path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443l-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057L9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/></svg>&nbsp;';
@$btnConfiguraciones        = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16"><path d="M1 0L0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z"/></svg>&nbsp;';
@$btnParqueos               = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-file-ppt-fill" viewBox="0 0 16 16"><path d="M6.5 7a2 2 0 1 0 4 0 2 2 0 0 0-4 0z"/><path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM6.5 4.5v.264a3 3 0 1 1 0 4.472V12a.5.5 0 0 1-1 0V4.5a.5.5 0 0 1 1 0z"/></svg>&nbsp;';
@$btnEmpresas               = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/><path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/></svg>&nbsp;';
@$btnCrearSolicitudes       = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16"><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z"/></svg>&nbsp;';
@$btnVerSolicitudes         = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16"><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/></svg>&nbsp;';
@$btnRetirar                = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-reply-fill" viewBox="0 0 16 16"><path d="M5.921 11.9L1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z"/></svg>&nbsp;';
@$btnPagos                  = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16"><path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/><path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198l.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z"/></svg>&nbsp;';
@$btnFacturas               = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16"><path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z"/><path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/></svg>&nbsp;';
@$btnBuscar                 = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>&nbsp;';
@$btnLimpiar                = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-table" viewBox="0 0 16 16"><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/></svg>&nbsp;';
@$btnCajas                  = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' viewBox="0 0 512 512"><g><path d="m356 452h-200c-8.271 0-15 6.729-15 15v45h230v-45c0-8.271-6.729-15-15-15z"/><path d="m46 362v150h65v-45c0-24.813 20.187-45 45-45h200c24.813 0 45 20.187 45 45v45h65v-150z"/><path d="m256 232h-175v100h350v-145c0-24.813-20.187-45-45-45h-85c-24.813 0-45 20.187-45 45z"/><path d="m106 202h90v-52h60v-150h-210v150h60zm0-142h90v30h-90z"/></g></svg>&nbsp;';
@$btnArqueos                = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16"><path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/><path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/></svg>&nbsp;';
@$btnArticulos              = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-basket-fill" viewBox="0 0 16 16"><path d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3z"/></svg>&nbsp;';
@$btnRegistrarPagos         = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16"><path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/></svg>&nbsp;';
@$btnMas                    = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/></svg>&nbsp;';
@$btnMenos                  = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/></svg>&nbsp;';
@$btnCerrar                 = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/></svg>&nbsp;';
@$btnRegistrarArticulos     = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16"><path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/></svg>&nbsp;';
@$btnVerRegistros           = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-table" viewBox="0 0 16 16"><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/></svg>&nbsp;';
@$btnAnterior               = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/></svg>&nbsp;';
@$btnSiguiente              = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/></svg>@$nbps;';
@$btnParametrosGratis       = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-file-earmark-lock2-fill" viewBox="0 0 16 16"><path d="M7 7a1 1 0 0 1 2 0v1H7V7z"/><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM10 7v1.076c.54.166 1 .597 1 1.224v2.4c0 .816-.781 1.3-1.5 1.3h-3c-.719 0-1.5-.484-1.5-1.3V9.3c0-.627.46-1.058 1-1.224V7a2 2 0 1 1 4 0z"/></svg>&nbsp;';
@$btnAyuda                  = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>&nbsp;';
@$btnPremium                = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-credit-card-2-front-fill" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/></svg>&nbsp;';
//&nbsp;

// Botones para las acciones de las tablas
@$tamaño = "20";
@$width  = @$tamaño;
@$height = @$tamaño;
@$size   = "width='" . @$width . "' height='" . @$height . "'";

@$btnResponderSolicitud  = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-reply-fill" viewBox="0 0 16 16"><path d="M5.921 11.9L1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z"/></svg>';
@$btnVer                 = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>';
@$btnInhabilitar         = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/></svg>';
@$btnEliminar            = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16"><path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/></svg>';
@$btnFacturass           = '<svg xmlns="http://www.w3.org/2000/svg" ' . @$size . ' fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16"><path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z"/><path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/></svg>';

/****************************************
 *                                      *
 *             FUNCIONES                *
 *                                      *
 ****************************************/
//función para mostrar el mensaje según la validación del campo.
function validarCampos($txtValidar = 'vacio/caracteres/noExiste/seleccionar/email/igualPassword/numeros/noRegistrado/noImagen', $nombreCampo, $caracteres = null, $fecha = null, $email = null)
{

    if (empty(@$txtValidar) && empty(@$nombreCampo)) {
        echo "Error en la función";
        return false;
    }

    //Validamos un campo vacion
    if (@$txtValidar == 'vacio') {
        echo @$mensaje = "<div class='alert alert-danger'>Lo sentimos, <b>" . @$nombreCampo . "</b> no puede estar <b>vacío.</b></div>";
        return false;
        //Validamos la cantidad de caracteres de un campo
    } else if (@$txtValidar == 'caracteres') {
        echo @$mensaje =  "<div class='alert alert-danger'>Lo sentimos, <b>" . @$nombreCampo . "</b> sólo permite un màximo de <b>" . @$caracteres . " carácteres</b>.</div>";
        return false;
        //Validamos que un campo exista o no en la bd
    } else if (@$txtValidar == 'noExiste') {
        echo @$mensaje =  "<div class='alert alert-danger'>El/La <b>" . @$nombreCampo . "</b> que intenta registrar, <b> ya se encuentra registrado.</b>.</div>";
        return false;
        //Validamos que la fecha se haya ingresado correctamente
    } else if (@$txtValidar == 'seleccionar') {

        echo @$mensaje =  "<div class='alert alert-danger'>Lo sentimos, debe <b>seleccionar un(a) " . @$nombreCampo . "</b> válido.</b></div>";
        return false;

        //Validamos si el campo es de tipo email
    } else if (@$txtValidar == 'email') {

        if (empty(@$email)) {
            echo "error en la función";
            return false;
        }

        if (!filter_var(@$email, FILTER_VALIDATE_EMAIL)) {
            echo @$mensaje =  "<div class='alert alert-danger'>Lo sentimos, no ingreso un <b>" . @$nombreCampo . " válido.</b></div>";
            return false;
        }

        //Validamos que las contraseñas sean iguales o no
    } else if (@$txtValidar == 'igualPassword') {
        echo @$mensaje =  "<div class='alert alert-danger'>Lo sentimos, las <b>contraseña no coinciden</b>. Por favor, intente nuevamente.</div>";
        return false;
        //Validamos que un campo exista o no en la bd
    } else if (@$txtValidar == 'numeros') {
        echo @$mensaje =  "<div class='alert alert-danger'>El " . @$nombreCampo . " debe ser ingresado con <b>sólo números.</b></div>";
        return false;
        //Validamos que un campo exista o no en la bd
    } else if (@$txtValidar == 'noRegistrado') {
        echo @$mensaje =  "<div class='alert alert-danger'>Lo sentimos, este " . @$nombreCampo . " <b>no se encuentra registrado.</b></div>";
        return false;
        //Validamos que un campo exista o no en la bd
    } else if (@$txtValidar == 'noImagen') {
        echo @$mensaje =  "<div class='alert alert-danger'>Lo sentimos, no ha subido un(a) " . @$nombreCampo . " válida.</div>";
        return false;
        //Validamos que un campo exista o no en la bd
    } else {
        echo "Error en la función";
    }

    return "Fallo la función";
}

//función para cargar los select
function cargarSelect($conexion, $sql = null, $name = null, $others = "", $idSelect = null, $estado = 0)
{
    //echo $sql;
    if ($sql == null) {
        return false;
    }

    if (!$conexion && !is_array($sql)) {
        echo "error en la conexión";
    }

    if ($name == null) {
        return false;
    }

    if ($idSelect != null) {
        $idOption = $idSelect;
    } else if (isset($_POST['submit'])) {
        $idOption = $_POST[$name];
    } else {
        $idOption = "";
    }

    if ($estado == '1') {
        $disable = 'disabled';
    } else {
        $disable = '';
    }

    //Para cuando vamos a crear un select desde un array
    if (is_array($sql)) {
        //echo "<script>alert('esto es un array')</script>";
        echo "<select name='" . $name . "' " . $others . " " . $disable . ">";
        echo "<option value=''>-- Seleccione --</option>";
        foreach ($sql as $key => $value) {
            if ($key === $_POST[$name]) {
                $select = "selected='selected'";
            } else {
                $select = "";
            }

            echo "<option " . $select . " value=" . $key . ">" . $value . "</option>";
        }
        echo "</select>";

        return false;
    } else {

        //Para ejecutar consultas SQL con dos o tres parametros, el primera parametro viene para el id del select y el segundo y tercer para el texto del select
        $ejecutarConsulta   = mysqli_query($conexion, $sql);
        $fetchConsultas     = mysqli_fetch_all($ejecutarConsulta);

        if ($ejecutarConsulta) {

            echo "<select name='" . $name . "' " . $others . " " . $disable . ">";
            echo "<option value=''>-- Seleccione --</option>";
            foreach ($fetchConsultas as $key => $value) {

                if ($value[0] === $idOption) {
                    $select = "selected='selected'";
                } else {
                    $select = "";
                }

                if (isset($value[1]) && isset($value[2])) {
                    $nombre = $value[1] . " " . $value[2];
                } else {
                    $nombre = $value[1];
                }

                echo "<option " . $select . " value=" . $value[0] . ">" . $nombre . "</option>";
            }
            echo "</select>";
        } else {
            echo "Error";
        }
    }
}

//Función para traer la ruta de la foto de perfil seleccionada por el usuario
function fotoPerfil($idFoto, $conexion)
{

    if (!is_numeric($idFoto)) {
        return false;
    }

    $consulta   = "SELECT rutaFotos FROM fotos WHERE idFotos = '$idFoto'";
    $ejecutar   = mysqli_query($conexion, $consulta);
    $fetch      = mysqli_fetch_array($ejecutar);

    return $fetch[0];
}

/**
 * Encripta un valor por transposición de valores
 *
 * param string $messagePlano
 *
 * return string
 */
function encriptar($messagePlano)
{
    $len               = strlen($messagePlano);
    $messageEncriptado = "";
    for ($position = 0; $position < $len; $position++) {

        $clave             = (($len + $position) + 1);
        $clave             = (255 + $clave) % 255;
        $byteEncrypted     = substr($messagePlano, $position, 1);
        $asciiNum          = ord($byteEncrypted);
        $xored_byte        = $asciiNum ^ $clave;
        $encrypted_byte    = chr($xored_byte);
        $messageEncriptado .= $encrypted_byte;
    }

    return base64_encode($messageEncriptado);
};

/**
 * Desencripta un valor por trasposición de valores
 *
 * param $mesageEncriptadoBase64
 *
 * return string
 */
function desencriptar($mesageEncriptadoBase64)
{
    $mensage      = base64_decode($mesageEncriptadoBase64);
    $len          = strlen($mensage);
    $messagePlano = "";
    for ($position = 0; $position < $len; $position++) {
        $clave          = (($len + $position) + 1);
        $clave          = (255 + $clave) % 255;
        $byteEncrypted  = substr($mensage, $position, 1);
        $asciiNum       = ord($byteEncrypted);
        $xored_byte     = $asciiNum ^ $clave;
        $encrypted_byte = chr($xored_byte);
        $messagePlano   .= $encrypted_byte;
    }

    return $messagePlano;
}

/*
 *
 * Función para crear una alerta si hay o no mensajes de los clíentes
 *
 * */
function contadorMensajes($conexion, $estado)
{

    if (!is_numeric($estado)) {
        return false;
    }

    $consultaMensajes   = "SELECT COUNT(*) FROM usuarios_mensajes WHERE documentoUsuarios = '$_SESSION[documentoUsuarios]' AND estadoSolicitud = '0' ORDER BY fechaRegistro DESC";
    $ejecutarMensajes   = mysqli_query($conexion, $consultaMensajes);
    $rowMensajes        = mysqli_fetch_array($ejecutarMensajes);

    return $rowMensajes[0];
}

/*
 *
 * Función para mostrar los mensajes enviados
 *
 * */
function MostrarMensajes($conexion)
{

    if (!$conexion) {
        return false;
    }

    $consultaMensajes   = "SELECT mensajes.tituloMensajes, usuarios_mensajes.idMensajes FROM usuarios_mensajes INNER JOIN mensajes ON usuarios_mensajes.idMensajes = mensajes.idMensajes WHERE usuarios_mensajes.documentoUsuarios = '$_SESSION[documentoUsuarios]' AND usuarios_mensajes.estadoSolicitud = '0' ORDER BY usuarios_mensajes.fechaRegistro DESC";
    $ejecutarMensajes   = mysqli_query($conexion, $consultaMensajes);
    $rowMensajes        = mysqli_num_rows($ejecutarMensajes);

    if ($rowMensajes >= 1) {
        $fetchMensajes = mysqli_fetch_all($ejecutarMensajes);
        $i = 0;

        foreach ($fetchMensajes as $key => $value) {
            $i++;

            if ($i >= 6) {
                break;
            }

            echo "<li>";
            echo "<a class='dropdown-item' href='../solicitudes/ver.php?id=" . $value[1] . "'>" . $value[0] . "</a>";
            echo "</li>";
        }

        echo '<li class="dropdown-divider"></li>';
    } else {
        $class = "primary";
        return $class;
    }

    return "ERROR";
}

/*******
 *
 *
 * FUNCIÓN PARA GENERAR LOS CÓDIGOS DE LOS PARQUEOS
 *
 *
 */
function generarCodigo($conexion, $longitud, $id, $factura = 1)
{
    $key        = '';
    $pattern    = '1234567890aeiouAEIOU';
    $max        = strlen($pattern) - 1;
    for ($i = 0; $i < $longitud; $i++) $key .= $pattern{
        mt_rand(0, $max)};

    $consultaCodigo = "SELECT codigoRetiroParqueos FROM parqueos WHERE codigoRetiroParqueos = '$key' AND estadoParqueos = '1'";
    $ejecutarCodigo = mysqli_query($conexion, $consultaCodigo);
    $rowCodigo      = mysqli_num_rows($ejecutarCodigo);

    if ($rowCodigo >= 1) {
        $key        = '';
        $pattern    = '1234567890aeiouAEIOU';
        $max        = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++) {
            $key .= $pattern{
                mt_rand(0, $max)};
        };
    }

    $codigo = encriptar($key);

    //Si el estado facturo es uno me pasa el estadoParqueos a 2 si no, a 1
    if ($factura == 0) {
        $consulta = "UPDATE `parqueos` SET `codigoRetiroParqueos` = '$codigo', `estadoParqueos` = '1' WHERE `idParqueos` = '$id'";
    } else {
        $consulta = "UPDATE `parqueos` SET `codigoRetiroParqueos` = '$codigo', `estadoParqueos` = '2' WHERE `idParqueos` = '$id'";
    }
    $ejecutar = mysqli_query($conexion, $consulta);

    if ($ejecutar) {
        return true;
    } else {
        return false;
    }
}

/*
 *
 *
 * FUNCIÓN PARA REVISAR SI ESTA O NO ACTIVADA LA OPCIÓN DE CONFIGURACIÓN
 *
 *
*/
function otrosServicios($conexion, $empresa, $campo)
{
    $consulta           = "SELECT $campo FROM parametros WHERE nitEmpresas = '$empresa'";
    $ejecutarConsulta   = mysqli_query($conexion, $consulta);
    $fetchConsultas     = mysqli_fetch_array($ejecutarConsulta);

    if (@$fetchConsultas[$campo] == 1) {
        return true;
    }

    return false;
}


/*
 *
 *
 * FUNCIÓN PARA DETECTAR SI ES UN MÓVIL O UNA PC
 *
 *
 * */
function movilPC()
{
    $tablet_browser = 0;
    $mobile_browser = 0;
    $body_class = 'desktop';

    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $tablet_browser++;
        $body_class = "tablet";
    }

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
        $body_class = "mobile";
    }

    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
        $mobile_browser++;
        $body_class = "mobile";
    }

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
        'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
        'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-'
    );

    if (in_array($mobile_ua, $mobile_agents)) {
        $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
        $mobile_browser++;
        //Check for tablets on opera mini alternative headers
        $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
            $tablet_browser++;
        }
    }
    if ($tablet_browser > 0) {
        // Si es tablet has lo que necesites
        return $dispositivo = 'tablet';
    } else if ($mobile_browser > 0) {
        // Si es dispositivo mobil has lo que necesites
        return $dispositivo = 'movil';
    } else {
        // Si es ordenador de escritorio has lo que necesites
        return $dispositivo = 'pc';
    }
}


/*
 *
 *
 * FUNCIÓN PARA REALIZAR PAGINACIÓN
 *
 *
 **/
function paginacion($conexion, $sql, $index = null, $page, $nroRegistros, $id = NULL, $ajax = 0)
{

    $sql = explode('LIMIT', $sql);

    if (!isset($sql[1])) {
        $sql[0] = $sql[0] . " LIMIT $page, $nroRegistros";
    }

    $sql = $sql[0];

    $btnAnterior            = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/></svg>';
    $btnSiguiente           = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/></svg>';

    if ($nroRegistros == 0) {
        $nroRegistros = 10;
    }

    if (!$conexion) {
        // echo "<script>alert('No hay conexion')</script>";
        return false;
    }

    if ($index == null) {
        return false;
    }

    if (empty($sql)) {
        return false;
    }

    $ejecutar = mysqli_query($conexion, $sql) or die("Consultas");
    $totalRegistros = COUNT(mysqli_fetch_all($ejecutar));
    $cantidadRegistros = ceil($totalRegistros / $nroRegistros);

    //Anterior
    if ($page == 0 || $page == 1) {
        $antDisable = 'disabled';
    } else {
        $antDisable = '';
    }
    $ant = $page - 1;

    //Siguiente
    if ($page == $cantidadRegistros || $cantidadRegistros == 0) {
        $sigDisable = 'disabled';
    } else {
        $sigDisable = '';
    }
    $sig = $page + 1;


    if (($nroRegistros * $page) >= $totalRegistros) {
        $mostrar = $totalRegistros;
    } else {
        $mostrar = $nroRegistros * $page;
    }

    if ($id != NULL && is_numeric($id)) {
        $id = "&&id=$id";
    } else {
        $id = "";
    }

    //echo '<div class="row">';
    $nav = '<nav aria-label="Page navigation example" class="">';
    if ($totalRegistros != 0) {
        $nav = $nav . "<p style='text-align: center;'>Mostrando $mostrar registros de $totalRegistros en total</p>";
    }

    $nav = $nav . '<ul class="pagination justify-content-center">';
    if ($page != 1) {
        $nav = $nav . '<li class="page-item ' . $antDisable . '">';
        $nav = $nav . '<a class="page-link" href="' . $index . '.php?page=' . $ant . '&&nro=' . $nroRegistros . '' . $id . '" tabindex="-1" aria-disabled="true">';
        $nav = $nav . $btnAnterior;
        $nav = $nav . '</a>';
        $nav = $nav . '</li>';
    }

    if ($cantidadRegistros >= 1) {
        for ($i = 1; $i <= $cantidadRegistros; $i++) {
            if ($page == $i) {
                $active = 'active';
            } else {
                $active = '';
            }
            $nav = $nav . '<li class="page-item ' . $active . '">';
            $nav = $nav . '<a class="page-link" href="' . $index . '.php?page=' . $i . '&&nro=' . $nroRegistros . '' . $id . '">';
            $nav = $nav . $i;
            $nav = $nav . '</a>';
            $nav = $nav . '</li>';
        }
    } else {
        $nav = $nav . '<li class="page-item active">';
        $nav = $nav . '<a class="page-link" href="' . $index . '.php?page=1&&nro=' . $nroRegistros . '' . $id . '">';
        $nav = $nav . 1;
        $nav = $nav . '</a>';
        $nav = $nav . '</li>';
    }

    if ($page < $cantidadRegistros) {
        $nav = $nav . '<li class="page-item ' . $sigDisable . '">';
        $nav = $nav . '<a class="page-link" href="' . $index . '.php?page=' . $sig . '&&nro=' . $nroRegistros . '' . $id . '">';
        $nav = $nav . $btnSiguiente;
        $nav = $nav . '</a>';
        $nav = $nav . '</li>';
    }

    $nav = $nav . '</ul>';
    $nav = $nav . '</nav>';
    //echo '</div>';
    if ($ajax == 0) {
        echo $nav;
    } else {
        return $nav;
    }
}

/*
 *
 *
 * PARA VERIFICAR SI UNA EMPRESA ES DE PAGO O ES GRATUITA
 *
 *
 **/
function empresaGratuita($conexion, $nitEmpresas)
{

    $sql        = "SELECT gratisEmpresas FROM empresas WHERE nitEmpresas = '$nitEmpresas'";
    $ejecutar   = mysqli_query($conexion, $sql);
    $fetch      = mysqli_fetch_row($ejecutar);

    if ($fetch[0] == 1) {
        return false;
    } else {
        return true;
    }
}

/*
 *
 *
 * PARA VERIFICAR SI UNA EMPRESA ES DE PAGO O ES GRATUITA
 *
 *
 **/
function validarTipoImg($tipo)
{

    if ($tipo == 'image/png') {
        return true;
    }

    if ($tipo == 'image/jpg') {
        return true;
    }

    if ($tipo == 'image/jpeg') {
        return true;
    }
}


/*
 *
 *
 * FUNCION PARA ENVIO DE CORREOS
 *
 *
 **/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function enviarCorreo($correoDestion, $personaDestino, $cuerpoMensaje, $asuntoCorreo, $html = true)
{
    $cuerpoMensaje = $cuerpoMensaje .   "<div style='text-align: LEFT; font-size: 10pt'>
                                            <p>__________________________________________________________________________________________</p>
                                            <p>Este correo elecrónico ah sido generado automaticamente, si desea más información, pueden ingresar al sitio web www.softpark.epizy.com.</p>
                                            <p style='font-weight: bold;'>CLAUSULA DE CONFIDENCIALIDAD</p>
                                            <p>La información que aquí se encuentra es para uso único del propietario de este correo.</p>
                                        </div>";
    $mail = new PHPMailer(true);

    try {
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Sacar esta línea para no mostrar salida debug
        $mail->isSMTP();
        $mail->Host         = 'smtp.gmail.com';  // Host de conexión SMTP
        $mail->SMTPAuth     = true;
        $mail->Username     = 'softpark24@gmail.com';                 // Usuario SMTP
        $mail->Password     = 'D4t0s2021';                           // Password SMTP
        $mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;                            // Activar seguridad TLS
        $mail->Port         = 587;                                    // Puerto SMTP
        //$mail->Port = 587;                                    // Puerto SMTP

        #$mail->SMTPOptions = ['ssl'=> ['allow_self_signed' => true]];  // Descomentar si el servidor SMTP tiene un certificado autofirmado
        #$mail->SMTPSecure = false;				// Descomentar si se requiere desactivar cifrado (se suele usar en conjunto con la siguiente línea)
        #$mail->SMTPAutoTLS = false;			// Descomentar si se requiere desactivar completamente TLS (sin cifrado)

        $mail->setFrom('softpark24@gmail.com', 'SoftPark');        // Mail del remitente
        $mail->addAddress($correoDestion, $personaDestino);     // Mail del destinatario

        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');

        $mail->isHTML($html);
        $mail->Subject = $asuntoCorreo;  // Asunto del mensaje
        $mail->Body    = $cuerpoMensaje;    // Contenido del mensaje (acepta HTML)
        //$mail->AltBody = 'Este es el contenido del mensaje en texto plano';    // Contenido del mensaje alternativo (texto plano)

        $mail->send();
        return true;
    } catch (Exception $e) {

        return false;
        $mail->ErrorInfo;
    }
}

/*
 *
 *
 * FUNCION PARA CREAR CODIGO ALEATORIO PARA LOS CORREOS
 *
 **/
function generarHash($strength = 35)
{

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-.';

    $input_length = strlen($permitted_chars);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}


/******
 *
 * FUNCION PARA REGISTRAR EL HISTORIAL DE UN PARQUEO MENSUAL
 */
function registrarHistParqueo($conexion, $placaVehiculos, $descripcion)
{
    if (!$conexion) {
        return false;
    }

    if (empty($placaVehiculos)) {
        return false;
    }

    if (empty($descripcion)) {
        return false;
    }

    $fechaRegistro = date("Y/m/d H:i:s");

    $idSql =   "SELECT CASE WHEN
                        ISNULL(MAX(idParqueos)) THEN '1' ELSE MAX(idParqueos) + 1
                    END
                    FROM
                        parqueos";

    $idP = mysqli_fetch_row(mysqli_query($conexion, $idSql));

    $sqlHist =  "INSERT INTO
                    historialMes (
                        idParqueos,
                        placaVehiculos,
                        registroPor,
                        fechaRegistro,
                        nitEmpresas,
                        descripcionHistMes
                    )
                VALUES
                    (
                        '$idP[0]',
                        '$placaVehiculos',
                        '$_SESSION[documentoUsuarios]',
                        '$fechaRegistro',
                        '$_SESSION[nitEmpresas]',
                        '$descripcion'
                    )";
    $insertarHist = mysqli_query($conexion, $sqlHist);
}
