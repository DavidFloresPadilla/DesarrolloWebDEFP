<?php
$host = "localhost";
$user = "root";
$pass = "";
$bd   = "bd_biblioteca";

$conexion = new mysqli($host, $user, $pass, $bd);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");
