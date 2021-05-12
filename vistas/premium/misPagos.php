<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorEmpresas) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}

$campos = array('idPagos' => 'Id Pago', 'documentoUsuarios' => 'Documento Cajero', 'idArqueos' => 'Arqueo Id');
//Arcchivo en el que estamos trabajando
$index = 'misPagos';

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='" . $index . ".php?page=1&&nro=10'</script>";
}
?>

<p class="titulos">Consultar Arqueo</p>
<div class="buscador">
    <p class="tituloSecciones">Buscar</p>

    <form action="" method="POST">
        <div class="row">

            <div class="col-1"></div>
            <div class="col-3">
                <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control' id='buscadorSel'") ?>
            </div>

            <div class="col-6" id="submit">
                <input type="text" class="form-control" id="txtBuscador">
            </div>

            <div class="col-2" id="submit">
                <button type="submit" class="btn btn-primary btn-sm" name="submit" id=""><?php echo $btnBuscar ?>&nbsp;Buscar</button>
            </div>

            <?php if (isset($_POST['submit'])) { ?>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary btn-sm" name="submitLimpiar" id=""><?php echo $btnLimpiar ?>&nbsp;Limpiar</button>
                </div>
            <?php }  ?>
        </div>
    </form>
</div>

<div class="container-menu">
    <div class="cantidadPaginas">
        Mostrando &nbsp;
        <select name="" id="cantidadBusqueda" class="" onchange="enviarCantidadBusqueda('<?php echo $index ?>');">
            <?php foreach ($cantidadPaginacion as $key => $value) { ?>
                <?php
                if ($key == $_GET['nro']) {
                    $select = "selected='selected'";
                } else {
                    $select = "";
                }
                ?>
                <option <?php echo $select ?> value="<?php echo $key ?>"><?php echo $value ?></option>
            <?php } ?>
        </select>
        &nbsp;Registros
    </div>
    <div id="datosArqueos" class="row">

    </div>
</div>

<script>
    $(document).ready(function() {
        datosMisPagos();
    })

    $("#txtBuscador").keyup(function() {
        datosMisPagos();
    });

    $("#buscadorSel").change(function() {
        if ($("#buscadorSel").val() == "fechaRegistro") {
            $("#txtBuscador").prop("type", "date");
        } else {
            $("#txtBuscador").prop("type", "text");
            $("#txtBuscador").val("");
        }

    });
    //Buscar datos en el ajax
    function datosMisPagos() {
        $.ajax({
            type: "POST",
            url: "../../ajax/datosBuscarMisPagos.php",
            dataType: "json",
            data: "nro=" + <?php echo $_GET['nro']; ?> + "&&page=" + <?php echo $_GET['page'] ?> + "&&txtBuscar=" + $("#txtBuscador").val() + "&&campoBuscar=" + $("#buscadorSel").val(),
            success: function(dataTables) {
                console.log(dataTables);
                $("#datosArqueos").html(dataTables);
            },
            error: function(dataTables) {
                console.log("ERROR " + dataTables);
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
    }

</script>
<?php require_once('../../estructura/footer.php') ?>