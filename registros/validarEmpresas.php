<?php
$contadorErrores = 0;
if (isset($_GET['edit']) && $_GET['edit'] == 1) {
    echo $siEditar;
}

if (isset($_POST['submit'])) {

    @$nitEmpresas               = $_POST['nitEmpresas'];
    @$nombreEmpresas            = $_POST['nombreEmpresas'];
    @$direccionEmpresas         = $_POST['direccionEmpresas'];
    @$telefonoFijoEmpresas      = $_POST['telefonoFijoEmpresas'];
    @$telefonoCelularEmpresas   = $_POST['telefonoCelularEmpresas'];
    @$registroPor               = $_SESSION['documentoUsuarios'];
    @$paisEmpresas              = $_POST['paisEmpresas'];
    @$departamentoEmpresas      = $_POST['departamentoEmpresas'];
    @$municipioEmpresas         = $_POST['municipioEmpresas'];
    @$telefonoCelular2Empresas  = $_POST['telefonoCelular2Empresas'];


    //Validamos el campo nit de la empresa
    @$consultarEmpresas    = "SELECT * FROM empresas WHERE nitEmpresas = '".$nitEmpresas."'";
    @$ejecutaEmpresas      = mysqli_query($conexion, $consultarEmpresas);
    @$contadorEmpresas     = mysqli_num_rows($ejecutaEmpresas);

    if (empty($nitEmpresas)) {
        validarCampos('vacio', 'Nit');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ($update == 0 && $contadorEmpresas >= 1) {
        validarCampos('noExiste', 'Nit');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ((strlen($nitEmpresas) > $C = 20) && $update == 0) {
        validarCampos('caracteres', 'Nit', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo nombre de la empresa
    if (empty($nombreEmpresas)) {
        validarCampos('vacio', 'Nombre de la empresa');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($nombreEmpresas) > $C = 80) {
        validarCampos('caracteres', 'Nombre de la empresa', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el país
    if (empty($paisEmpresas)) {
        validarCampos('vacio', 'País');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el departamento
    if (empty($departamentoEmpresas)) {
        validarCampos('vacio', 'Departamento');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el municipio
    if (empty($municipioEmpresas)) {
        validarCampos('vacio', 'Ciudad');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo dirección
    if (empty($direccionEmpresas)) {
        validarCampos('vacio', 'Dirección');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($direccionEmpresas) > $C = 50) {
        validarCampos('caracteres', 'Dirección', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo telefóno fijo
    if (empty($telefonoFijoEmpresas)) {

    } else if (strlen($telefonoFijoEmpresas) > $C = 10) {
        validarCampos('caracteres', 'Telefóno Fijo', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($telefonoFijoEmpresas)) {
        validarCampos('numeros', 'Telefóno Fijo');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo dirección
    if (empty($telefonoCelularEmpresas)) {
        validarCampos('vacio', 'Celular 1');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($telefonoCelularEmpresas) > $C = 10) {
        validarCampos('caracteres', 'Celular 1', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($telefonoCelularEmpresas)) {
        validarCampos('numeros', 'Celular 1');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el campo dirección
    if (empty($telefonoCelular2Empresas)) {

    } else if (strlen($telefonoCelular2Empresas) > $C = 10) {
        validarCampos('caracteres', 'Celular 2', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($telefonoCelular2Empresas)) {
        validarCampos('numeros', 'Celular 2');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Si estamos realizando una consulta una modificación de un registro, validamos las contraseñas.
    if ($update == '1') {

        //Validamos la imagen
        @$errorImg      = $_FILES['idImagen']['error'];
        @$nombreImg     = $_FILES['idImagen']['name'];
        @$tmpNameImg    = $_FILES['idImagen']['tmp_name'];
        @$idImagenEdi   = $_POST['idImagenEdi'];
        @$rutaImagenEdi = "../../".$_POST['rutaImagenEdi'];

        if ($errorImg == 0 && !empty($nombreImg) && !empty($tmpNameImg)) {
            $sql        = "SELECT idImagen FROM imagen ORDER BY idImagen DESC";
            $ejecutar   = mysqli_query($conexion, $sql);
            $idImagen   = mysqli_fetch_row($ejecutar);
            @$idImagen  = $idImagen[0] + 1;

            $tipo       = explode(".", $nombreImg);
            $rutaImg    = "estructura/img/img_".$idImagen.".".$tipo[1];
            //Validamos la imagen con su tipo y peso
            if (!validarTipoImg($_FILES['idImagen']['type'])) {
                echo "<div class='alert alert-danger'>Lo sentimos, el formato de la imagen no es válido. Se permiten archivos PNG y JPG</b> válida.</div>";
                $contadorErrores = $contadorErrores + 1;
                return false;
            } else if ($_FILES['idImagen']['size'] > 5242880) {
                echo "<div class='alert alert-danger'>Lo sentimos, el peso de la imagen no puede superar los 5MB</b> válida.</div>";
                $contadorErrores = $contadorErrores + 1;
                return false;
            }

            $editarImg = 1;
        } else {
            $tipo       = "";
            $rutaImg    = "";
            $idImagen   = $idImagenEdi;
            $editarImg  = 0;
        }
    }

    //Despuès de verificar todo el formulario, contamos que no hayan errores y procedemos a registrar
    if ($contadorErrores == 0) {

        if ($update == 0) {
            $insert =   "INSERT INTO `empresas`(
                            `nitEmpresas`,
                            `nombreEmpresas`,
                            `telefonoCelularEmpresa`,
                            `telefonoFijoEmpresas`,
                            `direccionEmpresas`,
                            `registroCreadoPor`,
                            `fechaCreacionRegistro`,
                            `paisEmpresas`,
                            `municipioEmpresas`,
                            `departamentoEmpresas`,
                            `telefonoCelular2Empresas`
                        )
                        VALUES(
                            '$nitEmpresas',
                            '$nombreEmpresas',
                            '$telefonoCelularEmpresas',
                            '$telefonoFijoEmpresas',
                            '$direccionEmpresas',
                            '$registroPor',
                            '$fechaRegistros',
                            '$paisEmpresas',
                            '$municipioEmpresas',
                            '$departamentoEmpresas',
                            '$telefonoCelular2Empresas'
                        )";

            $ejecutarInsert = mysqli_query($conexion, $insert);

            if ($ejecutarInsert) {
                echo $siRegistros;
            } else {
                echo $noRegistros;
            }

        } else if ($update == 1) {
            if ($editarImg == 1) {
                if (move_uploaded_file($tmpNameImg, "../../".$rutaImg)) {
                    //Eliminamos el archivo anterior
                    @unlink($rutaImagenEdi);
                    $rutaImg = $rutaImg;

                    $sql        = "DELETE FROM imagen WHERE idImagen = '$idImagenEdi'";
                    $ejecutar   = mysqli_query($conexion, $sql);

                    $ruta       = "INSERT INTO imagen (rutaImagen) VALUES ('$rutaImg')";
                    $guardar    = mysqli_query($conexion, $ruta);
                }
            }

            $sql =  "UPDATE
                        empresas
                    SET
                        nombreEmpresas              = '$nombreEmpresas',
                        direccionEmpresas           = '$direccionEmpresas',
                        telefonoFijoEmpresas        = '$telefonoFijoEmpresas',
                        telefonoCelularEmpresa      = '$telefonoCelularEmpresas',
                        registroCreadoPor           = '$registroPor',
                        paisEmpresas                = '$paisEmpresas',
                        departamentoEmpresas        = '$departamentoEmpresas',
                        municipioEmpresas           = '$municipioEmpresas',
                        telefonoCelular2Empresas    = '$telefonoCelular2Empresas',
                        idImagen                    = '$idImagen'
                    WHERE
                        nitEmpresas = '$nitEmpresas'";

            $registrar = mysqli_query($conexion, $sql);

            if ($registrar) {
                echo $siEditar;
                if ($editarImg == 1) {
                    echo "<script>window.location.href = 'miEmpresa.php?edit=1&&nit=".$nitEmpresas."'</script>";
                }

            } else {
                echo $noEditar;
            }

        }
    }
}