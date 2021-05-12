<?php
$contadorErrores = 0;

//Para ingresar la marca desde el modal
if (isset($_POST['submitArticulos'])) {
    $nombreArticulos = $_POST['nombreArticulos'];

    $consultaArticulos = "INSERT INTO marcaArticulos (nombreMarcaArticulos, nitEmpresas) VALUES ('$nombreArticulos', '$_SESSION[nitEmpresas]') ";
    $ejecutarArticulos = mysqli_query($conexion, $consultaArticulos);

    if ($ejecutarArticulos) {
        echo $siRegistros;
    } else {
        echo $noRegistros;
    }
}

//Para eliminar Marca de articulos
if (isset($_GET['eliminar']) && $_GET['eliminar'] == 1) {
    include('../estructura/conexion.php');
    echo $id = $_GET['id'];

    $consultaEliminar   = "DELETE FROM marcaArticulos WHERE idMarcaArticulos = '$id'";
    $eliminar          = mysqli_query($conexion, $consultaEliminar) or die("Cnsulta");

    if ($eliminar) {
        echo "<script>location.href='../vistas/articulos/registrarArticulos.php?eliminado=1'</script>";
    }
}

if (@$_GET['eliminado'] == 1) {
    echo $siEliminar;
}

//Para guardar y verificar la información principal, la del artículo
if (isset($_POST['submit'])) {

    //Variables de texto
    @$nombreArticulos       = $_POST['nombreArticulos'];
    @$cantidadArticulos     = $_POST['cantidadArticulos'];
    @$codigoArticulos       = $_POST['codigoArticulos'];
    @$medidaArticulos       = $_POST['medidaArticulos'];
    @$marcaArticulos        = $_POST['marcaArticulos'];
    @$presentacionArticulos = $_POST['presentacionArticulos'];
    @$precioArticulos       = $_POST['precioArticulos'];

    //Validamos la imagen
    @$errorImg      = $_FILES['imagenArticulos']['error'];
    @$nombreImg     = $_FILES['imagenArticulos']['name'];
    @$tmpNameImg    = $_FILES['imagenArticulos']['tmp_name'];

    $sql        = "SELECT idImagen FROM imagen ORDER BY idImagen DESC";
    $ejecutar   = mysqli_query($conexion, $sql);
    $idImagen   = mysqli_fetch_row($ejecutar);
    @$idImagen  = $idImagen[0] + 1;

    $tipo       = explode(".", $nombreImg);
    $rutaImg    = "estructura/img/img_" . $idImagen . "." . $tipo[1];

    //Guardamos el código por si contiene letras, en mayúscula
    @$codigoArticulos = strtoupper($codigoArticulos);

    //Verificamos si el vehículao ya está registrado
    @$consultaArticulos = "SELECT * FROM articulos WHERE codigoArticulos = '$codigoArticulos'";
    @$ejecutarArticulos = mysqli_query($conexion, $consultaArticulos);
    @$rowArticulos      = mysqli_num_rows($ejecutarArticulos);

    //Hacemos las validaciones
    //Descripcion - Nombre
    if (empty($nombreArticulos)) {
        validarCampos('vacio', 'Nombre');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($nombreArticulos) > $C = 40) {
        validarCampos('caracteres', 'Nombre', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validar Precio
    if (empty($precioArticulos)) {
        validarCampos('vacio', 'Valor');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($precioArticulos)) {
        validarCampos('numeros', 'Valor');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($precioArticulos) > $C = 11) {
        validarCampos('caracteres', 'Valor', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Cantidad
    if (empty($cantidadArticulos)) {
        validarCampos('vacio', 'Cantidad');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($cantidadArticulos)) {
        validarCampos('numeros', 'Cantidad');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($cantidadArticulos) > $C = 11) {
        validarCampos('caracteres', 'Cantidad', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Código de barras
    if (empty($codigoArticulos)) {
        validarCampos('vacio', 'Codigo de Barras');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } elseif (strlen($codigoArticulos) > $C = 20) {
        validarCampos('caracteres', 'Codigo de Barras', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } elseif ($rowArticulos >= 1) {
        validarCampos('noExiste', 'Codigo de Barras');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Presentación
    if (empty($presentacionArticulos)) {
        validarCampos('vacio', 'Presentación');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($presentacionArticulos) > $C = 5) {
        validarCampos('caracteres', 'Presentación', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($presentacionArticulos)) {
        validarCampos('numeros', 'Presentación');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Medida
    if (empty($medidaArticulos)) {
        validarCampos('seleccionar', 'Medida');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Marca
    if (empty($marcaArticulos)) {
        validarCampos('seleccionar', 'Marca');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos la imagen con su tipo y peso
    if (!validarTipoImg($_FILES['imagenArticulos']['type'])) {
        echo "<div class='alert alert-danger'>Lo sentimos, el formato de la imagen no es válido. Se permiten archivos PNG y JPG</b> válida.</div>";
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ($_FILES['imagenArticulos']['size'] > 5242880) {
        echo "<div class='alert alert-danger'>Lo sentimos, el peso de la imagen no puede superar los 5MB</b> válida.</div>";
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    if ($contadorErrores == 0) {

        $consulta           =   "INSERT INTO `articulos`(
                                        `nombreArticulos`,
                                        `presentacionArticulos`,
                                        `medidaArticulos`,
                                        `codigoArticulos`,
                                        `cantidadArticulos`,
                                        `marcaArticulos`,
                                        `nitEmpresas`,
                                        `registroPor`,
                                        `fechaRegistro`,
                                        `precioArticulos`,
                                        cantidadEntrada,
                                        idImagen,
                                        idArticulosEmpresas
                                    )
                                    VALUES(
                                        '$nombreArticulos',
                                        '$presentacionArticulos',
                                        '$medidaArticulos',
                                        '$codigoArticulos',
                                        '$cantidadArticulos',
                                        '$marcaArticulos',
                                        '$_SESSION[nitEmpresas]',
                                        '$_SESSION[documentoUsuarios]',
                                        '$fechaRegistros',
                                        '$precioArticulos',
                                        '$cantidadArticulos',
                                        '$idImagen',
                                        '$id'
                                    )";
        $ejecutarConsulta   = mysqli_query($conexion, $consulta);

        if (move_uploaded_file($tmpNameImg, "../../" . $rutaImg)) {
            $ruta       = "INSERT INTO imagen (rutaImagen) VALUES ('$rutaImg')";
            $guardar    = mysqli_query($conexion, $ruta);
        }

        if ($ejecutarConsulta && $guardar) {
            echo $siRegistros;
        } else {
            echo $noRegistros;
        }
    }
}
