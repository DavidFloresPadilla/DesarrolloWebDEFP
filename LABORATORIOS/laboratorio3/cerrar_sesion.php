<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
session_start();
$_SESSION = [];
session_destroy();
header("Location: form_login.php");
exit();
?>
