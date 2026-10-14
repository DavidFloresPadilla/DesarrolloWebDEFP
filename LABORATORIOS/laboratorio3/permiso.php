<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
// AUTORIZACION: solo el rol admin puede continuar (se incluye despues de proteger.php)
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    $rol = $_SESSION["rol"] ?? "desconocido";
    $_SESSION["mensaje"]      = "Su rol (" . $rol . ") no tiene permiso para realizar esa accion.";
    $_SESSION["mensaje_tipo"] = "error";
    header("Location: listar.php");
    exit();
}
?>
