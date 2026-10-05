<?php
require_once 'conexion.php';

$titulo    = $_POST['titulo'] ?? '';
$autor     = $_POST['autor'] ?? '';
$anio      = (int)($_POST['anio'] ?? 0);
$editorial = $_POST['editorial'] ?? '';

$stmt = $conexion->prepare("INSERT INTO libros (titulo, autor, anio, editorial) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $titulo, $autor, $anio, $editorial);
$stmt->execute();

header("Location: listar.php");
exit;
