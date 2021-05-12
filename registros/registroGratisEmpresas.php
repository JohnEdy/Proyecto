<?php
include_once('../../estructura/variablesGlobales.php');
include_once('../../estructura/conexion.php');

if (isset($_POST['submit'])) {

    $nitEmpresas                = $_POST['nitEmpresas'];
    $nombreEmpresas             = $_POST['nombreEmpresas'];
    $telefonoCelularEmpresa     = $_POST['telefonoCelularEmpresa'];
    $paisEmpresas               = $_POST['paisEmpresas'];
    $documentoUsuarios          = $_POST['documentoUsuarios'];
    $emailUsuarios              = $_POST['emailUsuarios'];
    $celular1Usuarios           = $_POST['celular1Usuarios'];
    $passUsuarios               = $_POST['passUsuarios'];
    $nombreUsuarios             = $_POST['nombreUsuarios'];
    $nombre                     = explode(" ", $nombreUsuarios);

    $sqlNit                     = "SELECT COUNT(*) FROM empresas WHERE nitEmpresas = '$nitEmpresas'";
    $query                      = mysqli_query($conexion, $sqlNit);
    $row                        = mysqli_fetch_array($query);

    @$nombre1Usuarios    = $nombre[0];
    @$nombre2Usuarios    = $nombre[1];
    @$apellido1Usuarios  = $nombre[2];
    @$apellido1Usuarios  = $nombre[3];
    $passUsuarios        = encriptar($passUsuarios);

    $hashUsuario = generarHash();

    if ($row[0] > 0) {
        echo '<div class="alert alert-danger">Lo sentimos, la empresa ya se encuentra registrada</div>';
        return false;
    } else {
        if (!empty($nitEmpresas) && !empty($nombreEmpresas) && !empty($telefonoCelularEmpresa) && !empty($paisEmpresas) && !empty($documentoUsuarios) && !empty($emailUsuarios) && !empty($celular1Usuarios) && !empty($passUsuarios) && !empty($nombreUsuarios)) {

            //Insertamos los datos de la empresa
            $sql = "SELECT idPlanes FROM planes WHERE marcadoPlanes = '1'";
            $ejecutar = mysqli_query($conexion, $sql);
            $idPlan = mysqli_fetch_row($ejecutar);

            $sqlInsert =    "INSERT INTO `empresas`(
                                `nitEmpresas`,
                                `nombreEmpresas`,
                                `telefonoCelularEmpresa`,
                                `registroCreadoPor`,
                                `fechaCreacionRegistro`,
                                `paisEmpresas`,
                                `permisosMeses`,
                                `permisosLavada`,
                                `permisosArticulos`,
                                `idPlanes`
                            )
                            VALUES(
                                '$nitEmpresas',
                                '$nombreEmpresas',
                                '$telefonoCelularEmpresa',
                                '0',
                                '$fechaRegistros',
                                '$paisEmpresas',
                                '0',
                                '0',
                                '0',
                                '$idPlan[0]'
                            )";

            $queryInsert = mysqli_query($conexion, $sqlInsert);

            //Insertamos los datos del usuario
            $sql =  "INSERT INTO `usuarios`(
                `documentoUsuarios`,
                `passUsuarios`,
                `fechaRegistroUsuarios`,
                `nombre1Usuarios`,
                `emailUsuarios`,
                `idRoles`,
                `nombre2Usuarios`,
                `apellido1Usuarios`,
                `apellido2Usuarios`,
                `passEstadoUsuarios`,
                `idFotoUsuarios`,
                `nitEmpresas`,
                `celular1Usuarios`,
                hashUsuario
            )
            VALUES(
                '$documentoUsuarios',
                '$passUsuarios',
                '$fechaRegistros',
                '$nombre1Usuarios',
                '$emailUsuarios',
                '2',
                '$nombre2Usuarios',
                '$apellido1Usuarios',
                '$apellido1Usuarios',
                '0',
                '1',
                '$nitEmpresas',
                '$celular1Usuarios',
                '$hashUsuario'
            )";

            $sqlQuery = mysqli_query($conexion, $sql);

            if (!$sqlQuery) {
                echo "error de usuarios: ".$sql;
            }

            if (!$queryInsert) {
                echo "error de EMPRESAS: ".$sqlInsert;
            }

            if ($queryInsert && $sqlQuery) {
                echo '<div class="alert alert-success">Información registrada correctamente. Válida tu correo electrónico para confirmar tu usuario. En breve se le direccionara a iniciar sesión"</div>';

                $asunto     = "Validación de Registro SoftPark";
                $mensaje    = "<h1 style='text-align: center;'>Señor (a) " . $nombreUsuarios . ", Soft  Park le da la bienvenida</h1>
                                <p style='text-align: left; font-weight: bold'>Sus Datos:</p>
                                <div style='text-align: center;'>
                                    <p><span style='font-weight: bold'>Su documento: </span>" . $documentoUsuarios . "<span></span></p>
                                    <p><span style='font-weight: bold'>Su nombre: </span>" . $nombreUsuarios . "<span></span></p>
                                    <p><span style='font-weight: bold'>Sus nùmeros de contacto: </span>" . $celular1Usuarios . "<span></span></p>
                                    <br>
                                    <p>Lo invitamos a validar su correo dando click en el siguiente botón: </p>
                                    <p><a href='" . $enlaceCorreos . "sinSesion/validarCorreo.php?hash=" . $hashUsuario . "&&documento=" . $documentoUsuarios . "' style='background-color: #edc847; border-radius: 5pt; padding: 5pt; font-weight: bold; text-decoration: none; color: black;'>Confirmar Correo Electrónico</a></p>
                                </div>
                                <p>Sus datos han sido registrados satisfactoriamente.</p>
                                <br>
                                <br>
                                <p style='text-align: left; font-weight: bold; font-size: 8pt; text-decoration: none;'>Si al dar click en el boton, no lo redirecciona automaticamente. Copie y pegue el siguiente enlacen en su navegador: " . $enlaceCorreos . "sinSesion/validarCorreo.php?hash=" . $hashUsuario . "&&documento=" . $documentoUsuarios . "</p>";

                enviarCorreo($emailUsuarios, $nombreUsuarios, $mensaje, $asunto);

                echo "<script>window.location.href = '../sinSesion/index.php?usu=1';</script>";
            } else {
                echo '<div class="alert alert-danger">Lo sentimos, su información no fue registrada. Intente nuevamente</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Debe ingresar todos los campos</div>';
            return false;
        }
    }
}
