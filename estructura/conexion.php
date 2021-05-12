<?php


 $usuario = "root";
 $contrasena= "";
 $servidor= "localhost";
 $basededatos= "proyecto";


$conexion = mysqli_connect($servidor,$usuario,$contrasena,$basededatos) or die ("No se ha podido conectar al servidor de Base de datos");




?>