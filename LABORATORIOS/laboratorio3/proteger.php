<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
// AUTENTICACION: exige que exista una sesion iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["correo"])) {
    header("Location: form_login.php?error=2");
    exit();
}
?>
