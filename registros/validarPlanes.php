<?php


if (isset($_POST['submit'])) {

    // print_r($_POST);
    // return false;
    $contadorErrores = 0;
    $sql        = "SELECT idImagen FROM imagen ORDER BY idImagen DESC";
    $ejecutar   = mysqli_query($conexion, $sql);
    $idImagen   = mysqli_fetch_row($ejecutar);
    @$idImagen  = $idImagen[0] + 1;
    $tipo       = explode(".", $_FILES['imgPlanes']['name']);

    //Campos de texto
    @$nombrePlanes          = $_POST['nombrePlanes'];
    @$precioPlanes          = $_POST['precioPlanes'];
    @$descripcionPlanes     = $_POST['descripcionPlanes'];
    @$updatePlanes          = $_POST['update'];
    @$cantidadParqueosHoras = $_POST['cantidadParqueosHoras'];
    @$cantidadParqueosMeses = $_POST['cantidadParqueosMeses'];
    @$cantidadArticulos     = $_POST['cantidadArticulos'];

    //Creamos los valores de la imagen
    @$tamañoImg          = $_FILES['imgPlanes']['size'];
    @$tipoImg            = $_FILES['imgPlanes']['type'];
    @$tmpImg             = $_FILES['imgPlanes']['tmp_name'];
    @$nombreImg          = $_FILES['imgPlanes']['name'];
    @$errorImg           = $_FILES['imgPlanes']['error'];
    @$rutaImg            = "estructura/img/img_" . $idImagen . "." . $tipo[1];
    @$idImagenEdi        = $_POST['idImagenEdi']; //Valor para eliminar la img anterior
    @$rutaImagenId       = $_POST['rutaImagenId']; //Valor para eliminar la img anterior

    //Válidamos el campo del título
    if (empty($nombrePlanes)) {
        validarCampos('vacio', 'Título');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($nombrePlanes) > $C = 15) {
        validarCampos('caracteres', 'Título', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Válidamos el campo del precio
    if ($precioPlanes == "") {
        validarCampos('vacio', 'Valor');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($precioPlanes) >= $C = 11) {
        validarCampos('caracteres', 'Valor', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($precioPlanes)) {
        validarCampos('numeros', 'Valor');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos la imagen con su tipo y peso
    if ($_FILES['imgPlanes']['error'] == 4 && $updatePlanes == 0) {
        validarCampos('noImagen', 'Imagen');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!validarTipoImg($tipoImg) && $updatePlanes == 0) {
        echo "<div class='alert alert-danger'>Lo sentimos, el formato de la imagen no es válido. Se permiten archivos PNG y JPG</b> válida.</div>";
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ($tamañoImg > 5242880 && $updatePlanes == 0) {
        echo "<div class='alert alert-danger'>Lo sentimos, el peso de la imagen no puede superar los 5MB</b> válida.</div>";
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el primer campo de horas
    if (empty($cantidadParqueosHoras)) {
        validarCampos('vacio', 'Cantidad Horas');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($cantidadParqueosHoras)) {
        validarCampos('numeros', 'Cantidad Horas');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el segundo campo de meses
    if (empty($cantidadParqueosMeses)) {
        validarCampos('vacio', 'Cantidad Meses');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($cantidadParqueosMeses)) {
        validarCampos('numeros', 'Cantidad Meses');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos el segundo campo de meses
    if (empty($cantidadArticulos)) {
        validarCampos('vacio', 'Cantidad Artículos');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!is_numeric($cantidadArticulos)) {
        validarCampos('numeros', 'Cantidad Artículos');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Válidamos el campo del precio
    if ($descripcionPlanes == "<p><br></p>") {
        validarCampos('vacio', 'Descripción');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    if ($contadorErrores == 0 && $updatePlanes == 0) {
        if (move_uploaded_file($tmpImg, "../../" . $rutaImg)) {

            $sql =  "INSERT INTO planes(
                        descripcionPlanes,
                        nombrePlanes,
                        precioPlanes,
                        registroPor,
                        fechaRegistros,
                        idImagen,
                        cantidadParqueosHoras,
                        cantidadParqueosMeses,
                        cantidadArticulos
                    )
                    VALUES(
                        '$descripcionPlanes',
                        '$nombrePlanes',
                        '$precioPlanes',
                        '$_SESSION[documentoUsuarios]',
                        '$fechaRegistros',
                        '$idImagen',
                        '$cantidadParqueosHoras',
                        '$cantidadParqueosMeses',
                        '$cantidadArticulos'
                    )";

            $ruta       = "INSERT INTO imagen (rutaImagen) VALUES ('$rutaImg')";

            $guardar    = mysqli_query($conexion, $ruta);
            $ejecutar   = mysqli_query($conexion, $sql);

            // COndicional para verificar la subida del fichero
            if ($ejecutar && $guardar) {
                echo $siRegistros;
            } else {
                echo $noRegistros;
            }
        } else {
            echo $noRegistros;
        }
    } else if ($contadorErrores == 0 && $updatePlanes == 1) {

        $idPlanes = $_POST['idPlanes'];

        //Validamos si se subió un archivo para editar
        if ($_FILES['imgPlanes']['error'] == 0 && !empty($nombreImg)) {
            if (move_uploaded_file($tmpImg, "../../" . $rutaImg)) {
                //Eliminamos el archivo anterior
                unlink("../../" . $rutaImagenId);
                $rutaImg = $rutaImg;

                $sql        = "DELETE FROM imagen WHERE idImagen = '$idImagenEdi'";
                $ejecutar   = mysqli_query($conexion, $sql);

                $ruta       = "INSERT INTO imagen (rutaImagen) VALUES ('$rutaImg')";
                $guardar    = mysqli_query($conexion, $ruta);
            }
        } else {
            $idImagen   = $idImagenEdi;
            $rutaImg    = $rutaImagenId;
            $guardar    = true;
        }

        //Actualizar datos
        $sql        =   "UPDATE
                            planes
                        SET
                            nombrePlanes            = ' $nombrePlanes',
                            descripcionPlanes       = '$descripcionPlanes',
                            precioPlanes            = '$precioPlanes',
                            idImagen                = '$idImagen',
                            registroPor             = '$_SESSION[documentoUsuarios]',
                            fechaRegistros          = '$fechaRegistros',
                            cantidadParqueosHoras   = '$cantidadParqueosHoras',
                            cantidadParqueosMeses   = '$cantidadParqueosMeses',
                            cantidadArticulos       = '$cantidadArticulos'
                        WHERE
                            idPlanes = '$idPlanes'";
        $ejecutar   = mysqli_query($conexion, $sql);



        if ($ejecutar && $guardar) {
            echo $siEditar;
        } else {
            echo $noEditar;
        }
    }
}
