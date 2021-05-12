<?php require_once('../../estructura/header.php') ?>
<?php
//Validamos los permisos de cada rol
if ($_SESSION['idRoles'] != $idClienteEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

//Consulta para traer los planes que puede el administrador de la empresa, registrar la misma
$sql            =   "SELECT
                        articulos.nombreArticulos,
                        articulos.presentacionArticulos,
                        articulos.medidaArticulos,
                        articulos.precioArticulos,
                        articulos.cantidadArticulos,
                        marcaArticulos.nombreMarcaArticulos,
                        imagen.rutaImagen,
                        articulos.idArticulos
                    FROM
                        articulos
                        INNER JOIN imagen ON imagen.idImagen = articulos.idImagen
                        INNER JOIN marcaArticulos ON marcaArticulos.idMarcaArticulos = articulos.marcaArticulos 
                    WHERE articulos.nitEmpresas = '$_SESSION[nitEmpresas]' AND articulos.cantidadArticulos > 0";
$ejecutar       = mysqli_query($conexion, $sql);
$articulos      = mysqli_fetch_all($ejecutar);

?>
<p class="titulos">Adquirir Artículos</p>
<div class="container-menu">
    <ul class="nav justify-content-end">
        <li class="nav-item align-middle">
            <button type="button" class="nav-link btn-primary btn btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarArticulos"><?php echo $btnRegistrarArticulos ?>&nbsp;Carrito: <span id="cantidadCarrito"></span> Artículos </button>
        </li>
    </ul>
    <?php if (isset($_GET['plan']) && $_GET['plan'] == 1) : ?>
        <div class="alert alert-success">Su modificación fue ingresada correctamente</div>
    <?php elseif (isset($_GET['plan']) && $_GET['plan'] == 0) : ?>
        <div class="alert alert-danger">Lo sentimos, surgió un error al realizar la comprar de su plan</div>
    <?php endif; ?>
    <?php if (isset($_GET['pag']) && $_GET['pag'] == 1) : ?>
        <div class="alert alert-danger">Lo sentimos, no ha ingresado un pago para el mes y año actuales</div>
    <?php endif; ?>
    <div class="row" style="align-items: center; text-align: center;">
        <?php foreach ($articulos as $articulo) : ?>
            <div class="col-3" style="margin-top: 10pt; margin-bottom: 10pt;">
                <div class="card" style="width: 18rem;">
                    <img src="../../<?php echo $articulo[6] ?>" class="card-img-top" alt="..." style="width: 200; height: 125pt;">
                    <div class="card-body">
                        <h5 class="card-title text-start"><?php echo $articulo[0] ?></h5>
                        <h3><?php echo "$ " . number_format($articulo[3]) ?> COP/U</h3>
                        <div class="card-text text-center">
                            <span>Información Artículo: </span><br>
                            <span><strong>Artículo:</strong> <?php echo $articulo[0] ?></span><br>
                            <span><strong>Marca:</strong> <?php echo $articulo[5] ?></span><br>
                            <span><strong>Presentación:</strong> <?php echo $articulo[1] . " " . $medidasArticulos[$articulo[2]] ?></span><br><br>
                            <span><strong>Cant. Disponible:</strong> <span id="cantDisponible-<?php echo $articulo[7] ?>"><?php echo $articulo[4] ?></span></span>
                        </div>
                        <div class="text-end" style="margin-top: 7pt;">
                            <input type="hidden" id="idArticuloCompra-<?php echo $articulo[7] ?>" value="<?php echo $articulo[7] ?>">
                            <button class="btn btn-primary" id="btnAgregarArticulo-<?php echo $articulo[7] ?>"><?php echo $btnMas ?>Al Carrito</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="eliminarArticulos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloSecciones" id="exampleModalLabel">Mis Artículos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="tablaMisArticulos" class="table-responsive">
                    <div class="alert alert-secondary">No ha ingresado artículos al carrito de compras</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" style="display: none;" id="btnCerrarCarrito" class="btn btn-primary">
                    <div class="spinner-border spinner-border-sm" role="status" id="iconCargar" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span id="iconRegistrar"><?php echo $btnRegistrar ?></span><span id="textoCerrar">Registrar</span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $btnCerrar ?>&nbsp;Salir</button>
            </div>
        </div>
    </div>
</div>

<script>
    let cantCarrito = 0;
    let cantiTotalArt = new Array();
    let idArticuloCierre = new Array();

    $(document).ready(function() {
        $("#cantidadCarrito").html(cantCarrito);
    });

    <?php foreach ($articulos as $articulo) : ?>
        //Creamos una variable de cantidad para cada árticulo
        let cantidadArticulo<?php echo $articulo[7] ?> = <?php echo $articulo[4] ?>;
        let articulo<?php echo $articulo[7] ?> = 1;
        //Para ejecutar el insert del carrito de compras
        $("#btnAgregarArticulo-<?php echo $articulo[7] ?>").click(function() {
            $.ajax({
                type: "POST",
                data: "idArticulo=" + $("#idArticuloCompra-<?php echo $articulo[7] ?>").val() + "&agregar=1",
                url: "../../ajax/datosCarritoCompras.php",
                success: function(data) {

                    $("#cantidadCarrito").text(cantCarrito = cantCarrito + articulo<?php echo $articulo[7] ?>);
                    articulo<?php echo $articulo[7] ?> = 0;

                    $("#cantDisponible-<?php echo $articulo[7] ?>").text(cantidadArticulo<?php echo $articulo[7] ?> = cantidadArticulo<?php echo $articulo[7] ?> - 1);

                    if (cantidadArticulo<?php echo $articulo[7] ?> == 0) {
                        $("#btnAgregarArticulo-<?php echo $articulo[7] ?>").prop("disabled", true);
                    }

                    if (cantCarrito >= 1) {
                        $("#btnCerrarCarrito").show();
                    }

                    $("#tablaMisArticulos").html(data);
                    $('#table').DataTable({
                        language: {
                            "lengthMenu": "Mostrar _MENU_ registros",
                            "zeroRecords": "No se encontraron resultados",
                            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sSearch": "Buscar:",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "sProcessing": "Procesando...",
                        }
                    });

                },
                error: function(data) {
                    alert("Error");
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 0) {
                    alert('Not connect: Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (textStatus === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (textStatus === 'timeout') {
                    alert('Time out error.');
                } else if (textStatus === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error: ' + jqXHR.responseText);
                }
            });
        });

        //Para eliminar cada artículo del carrito
        $("#tablaMisArticulos").on("click", "#btnEliminarArticulo-<?php echo $articulo[7] ?>", function() {
            $.ajax({
                type: "POST",
                data: "idArticulo=" + $("#idArtElim-<?php echo $articulo[7] ?>").val() + "&agregar=0",
                url: "../../ajax/datosCarritoCompras.php",
                success: function(data) {

                    $("#cantidadCarrito").text(cantCarrito = cantCarrito - 1);
                    articulo<?php echo $articulo[7] ?> = 1;

                    $("#cantDisponible-<?php echo $articulo[7] ?>").text(cantidadArticulo<?php echo $articulo[7] ?> = cantidadArticulo<?php echo $articulo[7] ?> + parseInt($("#elimCantidadCompra-<?php echo $articulo[7] ?>").text()));

                    if (cantidadArticulo<?php echo $articulo[7] ?> == 0) {
                        $("#btnAgregarArticulo-<?php echo $articulo[7] ?>").prop("disabled", true);
                    } else {
                        $("#btnAgregarArticulo-<?php echo $articulo[7] ?>").prop("disabled", false);
                    }

                    if (cantCarrito == 0) {
                        $("#btnCerrarCarrito").hide();
                    }

                    $("#tablaMisArticulos").html(data);
                    $('#table').DataTable({
                        language: {
                            "lengthMenu": "Mostrar _MENU_ registros",
                            "zeroRecords": "No se encontraron resultados",
                            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sSearch": "Buscar:",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "sProcessing": "Procesando...",
                        }
                    });
                },
                error: function(data) {
                    alert("Error");
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 0) {
                    alert('Not connect: Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (textStatus === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (textStatus === 'timeout') {
                    alert('Time out error.');
                } else if (textStatus === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error: ' + jqXHR.responseText);
                }
            });
        });
    <?php endforeach; ?>

    //Funcion para cerrar la compra y enviar los datos al parqueadero
    $("#btnCerrarCarrito").click(function() {
        $("#iconRegistrar").hide();
        $("#iconCargar").show();
        $("#textoCerrar").html("Por favor espere...");

        $("[name='cantiTotalArt']").each(function() {
            cantiTotalArt.push($(this).val());
        });

        $("[name='idArticuCierre']").each(function() {
            idArticuloCierre.push($(this).val());
        });

        $.ajax({
            type: "POST",
            data: "cantiTotalArt=" + cantiTotalArt + "&idArticuloCierre=" + idArticuloCierre,
            url: "../../ajax/datosCerrarCarrito.php",
            dataType: "json",
            success: function(data) {
                if (data[0] == 1) {
                    $("#tablaMisArticulos").html(data[1]);
                    $("#iconCargar").hide();
                    $("#iconRegistrar").show();
                    $("#textoCerrar").html("Éxito");
                    $("#btnCerrarCarrito").hide();
                    <?php foreach ($articulos as $articulo) : ?>
                        articulo<?php echo $articulo[7] ?> = 1;
                    <?php endforeach; ?>
                    cantCarrito = 0;
                    $("#cantidadCarrito").html(cantCarrito);
                }
            },
            error: function(data) {
                alert("Error");
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 0) {
                alert('Not connect: Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                alert('Time out error.');
            } else if (textStatus === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error: ' + jqXHR.responseText);
            }
        });
    });
</script>

<?php require_once('../../estructura/footer.php') ?>