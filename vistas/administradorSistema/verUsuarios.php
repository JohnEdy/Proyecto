<?php @$menuAdministradoresSis = 'administradoresSis'; ?>
<?php @$menuAdministradores = 'administradores'; ?>
<?php require_once('../../estructura/header.php') ?>
<?php
if ($_SESSION['idRoles'] != $idAdministradorSistema) {
    echo "<script>location.href='../inicio/inicio.php?perm=1'</script>";
}
?>
<?php

//Arcchivo en el que estamos trabajando
$index = 'verUsuarios';
//Campos para el buscador
$campos = array('documentoUsuarios' => 'ID', 'idRoles' => 'Rol', 'nitEmpresas' => 'Empresa');

//Volvemos un get para el paginador
if (!isset($_GET['page'])) {
    echo "<script>location.href='" . $index . ".php?page=1&&nro=10'</script>";
}

//Damos los valores de paginación
$nroRegistros = $_GET['nro'];
$start = ($_GET['page'] - 1) * $nroRegistros;

if (isset($_POST['submit'])) {
    $txtBuscar = $_POST['buscador'];
    $condiciones = "AND usuarios.$_POST[buscador] LIKE '%$_POST[$txtBuscar]%' ";
} else {
    $condiciones = '';
}

//Consulta según el rol
if ($_SESSION['idRoles'] == $idAdministradorEmpresas) {
    $consulta   = "SELECT usuarios.documentoUsuarios, usuarios.nombre1Usuarios, usuarios.nombre2Usuarios, usuarios.apellido1Usuarios, usuarios.apellido2Usuarios, roles.nombreRoles, empresas.nombreEmpresas, usuarios.celular1Usuarios FROM usuarios INNER JOIN empresas ON empresas.nitEmpresas = usuarios.nitEmpresas INNER JOIN roles ON roles.idRoles = usuarios.idRoles WHERE usuarios.nitEmpresas = '$_SESSION[nitEmpresas]' AND NOT usuarios.documentoUsuarios = '$_SESSION[documentoUsuarios]' " . $condiciones . " ORDER BY usuarios.nombre1Usuarios LIMIT $start, $nroRegistros";
} else {
    $consulta   = "SELECT usuarios.documentoUsuarios, usuarios.nombre1Usuarios, usuarios.nombre2Usuarios, usuarios.apellido1Usuarios, usuarios.apellido2Usuarios, roles.nombreRoles, empresas.nombreEmpresas, usuarios.celular1Usuarios FROM usuarios INNER JOIN empresas ON empresas.nitEmpresas = usuarios.nitEmpresas INNER JOIN roles ON roles.idRoles = usuarios.idRoles WHERE usuarios.idRoles = $idAdministradorEmpresas " . $condiciones . " ORDER BY usuarios.nombre1Usuarios LIMIT $start, $nroRegistros";
}

$ejecutar   = mysqli_query($conexion, $consulta);
$fetch      = mysqli_fetch_all($ejecutar);
?>

<p class="titulos">Usuarios Registrados</p>
<div class="buscador">
    <p class="tituloSecciones">Buscar</p>

    <form action="" method="POST">
        <div class="row">

            <div class="col-1"></div>
            <div class="col-3">
                <?php cargarSelect($conexion, $campos, 'buscador', "class='form-control' id='buscador' onclick='opcionesSelect();'") ?>
            </div>

            <div class="col-4" id="documentoUsuarios" style="display: none;">
                <input type="text" name="documentoUsuarios" class="form-control" value="<?php echo isset($_POST['submit']) ? @$_POST['usuarios.documentoUsuarios'] : ''; ?>">
            </div>

            <div class="col-4" id="idRoles" style="display: none;">
                <?php
                if ($_SESSION['idRoles'] == $idAdministradorSistema) {
                    $sql = "SELECT idRoles, nombreRoles FROM roles";
                } else {
                    $sql = "SELECT idRoles, nombreRoles FROM roles WHERE NOT idRoles = '1'";
                }
                ?>
                <?php cargarSelect($conexion, $sql, 'idRoles', "class='form-control' id='buscador' onclick='opcionesSelect();'") ?>
            </div>

            <div class="col-4" id="nitEmpresas" style="display: none;">
                <?php cargarSelect('', $estadoMensajes, 'nitEmpresas', "class='form-control'") ?>
            </div>

            <div class="col-2" id="submit" style="display: none;">
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
    <?php if (@$_GET['elim'] == 1) { ?>
        <?php echo $siEliminar ?>
    <?php } ?>
    <div class="table-responsive">
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

        <table class="table table-sm table-hover table-light" style="width: 100%;">
            <thead class="table-dark">
                <th style="width: 16.6%">Documento</th>
                <th style="width: 16.6%">Nombre</th>
                <th style="width: 16.6%">Rol</th>
                <th style="width: 16.6%">Empresa</th>
                <th style="width: 16.6%">Celular</th>
                <th style="width: 16.6%">Acciones</th>
            </thead>
            <tbody>
                <?php if (empty($fetch)) { ?>

                    <tr>
                        <td colspan="6">
                            <div style="text-align: center;" class="alert-secondary">No se encontraron resultados</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($fetch as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] . " " . $value[2] . " " . $value[3] . " " . $value[4] ?></td>
                            <td><?php echo $value[5] ?></td>
                            <td><?php echo $value[6] ?></td>
                            <td><?php echo $value[7] ?></td>
                            <td style='text-align: center; '>
                                <a href="../administradores/verEmpresa.php?id=<?php echo $value[0] ?>" data-toggle="tooltip" title="Eliminar Usuario" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $value[0] ?>"><?php echo $btnEliminar ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
            <tfoot class="table-dark">
                <th>Documento</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Empresa</th>
                <th>Celular</th>
                <th>Acciones</th>
            </tfoot>
        </table>
        <?php paginacion($conexion, $consulta, $index, $_GET['page'], $nroRegistros); ?>

    </div>
</div>
<?php foreach ($fetch as $key => $value) : ?>
    <div class="modal fade" id="exampleModal-<?php echo $value[0] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger"><?php echo $preguntaEliminar ?></div>
                    <p class="subtitulos">Usuario A Eliminar: </p>
                    <p class="informacion"><?php echo $value[1] . " " . $value[2] . " " . $value[3] . " " . $value[4] ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $cerrarSesion ?>Cerrar</button>
                    <a type="button" class="btn btn-primary" href="../acciones/eliminarUsuarios.php?id=<?php echo $value[0] ?>"><?php echo $btnEliminar ?>&nbsp;Eliminar Usuario</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    function opcionesSelect() {

        var select = document.getElementById("buscador").value;
        var submit = document.getElementById("submit").style;

        var documentoUsuarios = document.getElementById("documentoUsuarios").style;
        var idRoles = document.getElementById("idRoles").style;
        var nombreEmpresas = document.getElementById("nitEmpresas").style;

        //documentoUsuarios
        if (select == 'documentoUsuarios') {
            documentoUsuarios.display = 'inline';
            submit.display = 'inline';
        } else {
            documentoUsuarios.display = 'none';
        }

        //idRoles
        if (select == 'idRoles') {
            idRoles.display = 'inline';
            submit.display = 'inline';
        } else {
            idRoles.display = 'none';
        }

        //nombreEmpresas
        if (select == 'nitEmpresas') {
            nombreEmpresas.display = 'inline';
            submit.display = 'inline';
        } else {
            nombreEmpresas.display = 'none';
        }

    }

    opcionesSelect();
</script>

<?php require_once('../../estructura/footer.php') ?>