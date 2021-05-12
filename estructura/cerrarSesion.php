<?php
session_start();

if ($_SESSION['validar'] == true) {
    session_destroy();
    header('refresh: 0.1, url=../vistas/sinSesion/index.php');
}
