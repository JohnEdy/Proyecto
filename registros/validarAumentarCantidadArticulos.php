<?php

if (isset($_POST['submit'])) {

    if (!empty($_POST['cantidadArticulos']) && is_numeric($_POST['cantidadArticulos'])) {
        $consulta = "UPDATE `articulos` SET `cantidadArticulos` = '$_POST[cantidadArticulos]', `fechaRegistro` = '$fechaRegistros' WHERE `idArticulos` = '$fetch[0]'";
        $ejecutar = mysqli_query($conexion, $consulta);

        if ($ejecutar) {
            echo $siEditar;
        } else {
            echo $noEditar;
        }
    } else {
        echo $noEditar;
    }
}
