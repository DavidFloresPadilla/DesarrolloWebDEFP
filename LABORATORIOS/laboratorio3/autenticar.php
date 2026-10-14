<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
session_start();

// Solo se acepta el envio del formulario (POST)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form_login.php");
    exit();
}

require_once "conexion.php";

$correo = trim($_POST["correo"] ?? "");
$hash   = sha1($_POST["clave"] ?? "");   // se compara el resumen, nunca la clave en claro

// Sentencia preparada: nada de $_POST concatenado dentro del SQL
$sql  = "SELECT id, correo, nombre, rol FROM usuarios WHERE correo = ? AND clave = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $correo, $hash);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
    $usuario = $res->fetch_assoc();
    session_regenerate_id(true);   // nuevo identificador de sesion al ingresar
    $_SESSION["id"]     = $usuario["id"];
    $_SESSION["correo"] = $usuario["correo"];
    $_SESSION["nombre"] = $usuario["nombre"];
    $_SESSION["rol"]    = $usuario["rol"];
    header("Location: panel.php");
    exit();
}

// No se indica si fallo el correo o la contrasena
header("Location: form_login.php?error=1");
exit();
?>
