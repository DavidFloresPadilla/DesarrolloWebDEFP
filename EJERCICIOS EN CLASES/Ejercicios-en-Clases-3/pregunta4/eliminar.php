<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conexion->prepare("DELETE FROM libros WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: listar.php");
exit;
