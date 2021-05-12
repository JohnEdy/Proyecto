<?php require_once("../../estructura/variablesGlobales.php") ?>
<?php require_once("../../estructura/conexion.php") ?>
<?php
if (!isset($_GET['nitEmpresas']) || empty($_GET['nitEmpresas'])) {
    echo "<script>window.location='../../index.html';</script>";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SoftPark</title>
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="estilos.css">
    <link rel="shortcut icon" href="../../img/pestanha.ico" />

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- JQuery CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- JQuery Plugin TextArea -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/richtext.min.css">
    <script src="../../js/jquery.richtext.js"></script>


</head>

<body>

    <form class="formulario" method="POST" action="" id="formRegistrarUsuario" onsubmit="return enviar();">
        <!-- ingresando datos al formulario de registro-->
        <div class="contenedor">
            <h1>Registra Tu Usuario</h1>

            <?php include_once("../../registros/registroGratisUsuario.php") ?>
            <div class="input-contenedor">
                <i class="fas fa-address-card icon"></i>
                <input type="text" name="documentoUsuarios" maxlength="15" id="documentoUsuarios" autocomplete="off" placeholder="Documento" onkeyup="errorDocumentoUsuarios();">
                <input type="hidden" name="nitEmpresas" value="<?php echo $_GET['nitEmpresas'] ?>">
            </div>
            <p class="errorInputs" id="errorDocumentoUsuarios"></p>
            <div class="input-contenedor">
                <i class="fas fa-address-card icon"></i>
                <input type="text" name="nombreUsuarios" maxlength="80" id="nombreUsuarios" autocomplete="off" placeholder="Nombre Completo" onblur="errorNombreUsuarios();" onkeyup="errorNombreUsuarios();">
                <input type="hidden" name="nitEmpresas" value="<?php echo $_GET['nitEmpresas'] ?>">
            </div>
            <p class="errorInputs" id="errorNombreUsuarios"></p>
            <div class="input-contenedor">
                <i class="fas fa-at icon"></i>
                <input type="email" name="emailUsuarios" id="emailUsuarios" autocomplete="off" placeholder="Correo Electrónico" maxlength="80" onblur="errorEmailUsuarios();" onkeyup="errorEmailUsuarios();">
            </div>
            <p class="errorInputs" id="errorEmailUsuarios"></p>
            <div class="input-contenedor">
                <i class="fas fa-phone icon"></i>
                <input type="text" placeholder="Celular" autocomplete="off" maxlength="10" name="celular1Usuarios" id="celular1Usuarios" onblur="errorCelular1Usuarios();" onkeyup="errorCelular1Usuarios();">
            </div>
            <p class="errorInputs" id="errorCelular1Usuarios"></p>
            <div class="input-contenedor">
                <i class="fas fa-lock icon"></i>
                <input type="password" placeholder="Contraseña" autocomplete="off" maxlength="20" name="passUsuarios" id="passUsuarios" onblur="errorPassUsuarios(); errorPassUsuarios1();" onkeyup="errorPassUsuarios(); errorPassUsuarios1();">
            </div>
            <p class="errorInputs" id="errorPassUsuarios"></p>
            <div class="input-contenedor">
                <i class="fas fa-lock icon"></i>
                <input type="password" placeholder="Confirme Contraseña" autocomplete="off" maxlength="80" name="passUsuarios1" id="passUsuarios1" onblur="errorPassUsuarios1(); errorPassUsuarios();" onkeyup="errorPassUsuarios1(); errorPassUsuarios();">
            </div>
            <p class="errorInputs" id="errorPassUsuarios1"></p>

            <input type="submit" name="submit" value="Login" class="button">
            <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad</p>
        </div>
    </form>

    <script src="../../js/errorRegistroUsuarioGratis.js"></script>
    <script>
        $("#documentoUsuarios").blur(function() {
            $.ajax({
                type: "POST",
                url: "../../ajax/datosClienteGratis.php",
                data: "txt=" + $("#documentoUsuarios").val(),
                success: function(result) {
                    console.log(result);
                    if (result > 0) {
                        $("#errorDocumentoUsuarios").css("color", "red");
                        $("#errorDocumentoUsuarios").html("<i class='fas fa-exclamation icon'></i>Este usuario ya existe");
                    }
                    //$("#datosBuscar").html(data);
                }
            })
        })

        // $(document).ready(function() {
        //     $("#formRegistrarUsuario").validate({
        //         rules: {
        //             documentoUsuarios : {
        //                 required: true,
        //                 maxlength: 
        //             },
        //             age: {
        //                 required: true,
        //                 number: true,
        //                 min: 18
        //             },
        //             email: {
        //                 required: true,
        //                 email: true
        //             },
        //             weight: {
        //                 required: {
        //                     depends: function(elem) {
        //                         return $("#age").val() > 50
        //                     }
        //                 },
        //                 number: true,
        //                 min: 0
        //             }
        //         }
        //     });
        // });
    </script>
</body>

</html>