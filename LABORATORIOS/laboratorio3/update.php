<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
require_once "proteger.php";
require_once "permiso.php";
require_once "conexion.php";
require_once "funciones.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar.php");
    exit();
}

$id               = (int)($_POST["id"] ?? 0);
$nombres          = trim($_POST["nombres"] ?? "");
$apellidos        = trim($_POST["apellidos"] ?? "");
$ci               = trim($_POST["ci"] ?? "");
$telefono         = trim($_POST["telefono"] ?? "");
$fecha_nacimiento = trim($_POST["fecha_nacimiento"] ?? "");
// basename(): el campo oculto viene del navegador, no se confia en rutas
$foto_actual      = basename(trim($_POST["foto_actual"] ?? ""));

function volverAlFormulario($mensaje, $id) {
    guardarMensaje($mensaje, "error");
    header("Location: form_editar.php?id=" . (int)$id);
    exit();
}

if (contar($conn, "SELECT COUNT(*) FROM pacientes WHERE id = ?", "i", [$id]) === 0) {
    guardarMensaje("El paciente solicitado no existe.", "error");
    header("Location: listar.php");
    exit();
}
if ($nombres === "" || $apellidos === "" || $ci === "" || $fecha_nacimiento === "") {
    volverAlFormulario("Complete nombres, apellidos, CI y fecha de nacimiento.", $id);
}
$f = DateTime::createFromFormat("Y-m-d", $fecha_nacimiento);
if (!$f || $f->format("Y-m-d") !== $fecha_nacimiento) {
    volverAlFormulario("La fecha de nacimiento no es valida.", $id);
}
// El CI no debe pertenecer a OTRO paciente
if (contar($conn, "SELECT COUNT(*) FROM pacientes WHERE ci = ? AND id <> ?", "si", [$ci, $id]) > 0) {
    volverAlFormulario("Ya existe otro paciente con el CI " . $ci . ".", $id);
}

// Si no se elige una nueva fotografia, se conserva la anterior (campo oculto foto_actual)
$foto = subirFotografia("fotografia");
if ($foto["error"] !== "") {
    volverAlFormulario($foto["error"], $id);
}
$fotografia = ($foto["nombre"] !== "") ? $foto["nombre"] : $foto_actual;

$sql  = "UPDATE pacientes
         SET fotografia = ?, nombres = ?, apellidos = ?, ci = ?, telefono = ?, fecha_nacimiento = ?
         WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $fotografia, $nombres, $apellidos, $ci, $telefono, $fecha_nacimiento, $id);
$stmt->execute();
$stmt->close();

guardarMensaje("Los datos de $nombres $apellidos se actualizaron correctamente.", "ok");
header("Location: listar.php");
exit();
?>
