<?php

if (isset($_GET['edit']) AND $_GET['edit'] == 1) {
    echo $siEditar;
}

if (isset($_POST['submit'])) {

    @$contadorErrores = 0;
    @$sql        = "SELECT idImagen FROM imagen ORDER BY idImagen DESC";
    @$ejecutar   = mysqli_query($conexion, $sql);
    @$idImagen   = mysqli_fetch_row($ejecutar);
    @$idImagen   = $idImagen[0] + 1;
    @$tipo = explode(".", $_FILES['imgTestimonios']['name']);

    //Campos de texto
    @$cargoTestimonios          = $_POST['cargoTestimonios'];
    @$descripcionTestimonios    = $_POST['descripcionTestimonios'];

    //Creamos los valores de la imagen
    @$tamañoImg          = $_FILES['imgTestimonios']['size'];
    @$tipoImg            = $_FILES['imgTestimonios']['type'];
    @$tmpImg             = $_FILES['imgTestimonios']['tmp_name'];
    @$nombreImg          = $_FILES['imgTestimonios']['name'];
    @$errorImg           = $_FILES['imgTestimonios']['error'];
    @$rutaImg            = "estructura/img/img_" . $idImagen . "." . $tipo[1];
    @$idImagenEdi        = $_POST['idImagenEdi']; //Valor para eliminar la img anterior
    @$rutaImagenId       = $_POST['rutaImagenId']; //Valor para eliminar la img anterior

    //Válidamos el campo del precio
    if ($cargoTestimonios == "") {
        validarCampos('vacio', 'Cargo');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (strlen($cargoTestimonios) >= $C = 50) {
        validarCampos('caracteres', 'Cargo', $C);
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Validamos la imagen con su tipo y peso
    if (@$_FILES['imgTestimonios']['error'] == 4 && $updateTestimonios == 0) {
        validarCampos('noImagen', 'Imagen');
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if (!validarTipoImg($tipoImg) && $updateTestimonios == 0) {
        echo "<div class='alert alert-danger'>Lo sentimos, el formato de la imagen no es válido. Se permiten archivos PNG y JPG</b> válida.</div>";
        $contadorErrores = $contadorErrores + 1;
        return false;
    } else if ($tamañoImg > 5242880 && $updateTestimonios == 0) {
        echo "<div class='alert alert-danger'>Lo sentimos, el peso de la imagen no puede superar los 5MB</b> válida.</div>";
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    //Válidamos el campo del precio
    if ($descripcionTestimonios == "<p><br></p>") {
        validarCampos('vacio', 'Descripción');
        $contadorErrores = $contadorErrores + 1;
        return false;
    }

    if ($contadorErrores == 0 && $updateTestimonios == 0) {
        if (move_uploaded_file($tmpImg, "../../".$rutaImg)) {
            $sql =  "INSERT INTO testimonios (
                        cargoTestimonios,
                        idImagen,
                        descripcionTestimonios,
                        nitEmpresas,
                        fechaRegistros,
                        documentoUsuarios
                    )
                    VALUES(
                        '$cargoTestimonios',
                        '$idImagen',
                        '$descripcionTestimonios',
                        '$_SESSION[nitEmpresas]',
                        '$fechaRegistros',
                        '$_SESSION[documentoUsuarios]'
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
    } else if ($contadorErrores == 0 && $updateTestimonios == 1) {

        //Validamos si se subió un archivo para editar
        if (@$_FILES['imgTestimonios']['error'] == 0 && !empty($nombreImg)) {
            if (move_uploaded_file($tmpImg, "../../".$rutaImg)) {
                //Eliminamos el archivo anterior
                unlink("../../".$rutaImagenId);
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
                            testimonios
                        SET
                            cargoTestimonios        = '$cargoTestimonios',
                            idImagen                = '$idImagen',
                            descripcionTestimonios  = '$descripcionTestimonios',
                            fechaRegistros          = '$fechaRegistros'
                        WHERE
                            nitEmpresas       = '$_SESSION[nitEmpresas]'";
        $ejecutar   = mysqli_query($conexion, $sql);

        if ($ejecutar && $guardar) {
            echo "<script>window.location.href = 'testimonios.php?edit=1'</script>";
        } else {
            echo $noEditar;
        }
    }
}
