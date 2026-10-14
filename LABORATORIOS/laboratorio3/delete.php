<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
require_once "proteger.php";
require_once "permiso.php";
require_once "conexion.php";
require_once "funciones.php";

$id = (int)($_GET["id"] ?? 0);

if (contar($conn, "SELECT COUNT(*) FROM pacientes WHERE id = ?", "i", [$id]) === 0) {
    guardarMensaje("El paciente solicitado no existe.", "error");
    header("Location: listar.php");
    exit();
}

// Control de integridad: si tiene citas, la clave foranea no permite borrarlo
$citas = contar($conn, "SELECT COUNT(*) FROM citas WHERE paciente_id = ?", "i", [$id]);
if ($citas > 0) {
    guardarMensaje("No se puede eliminar: el paciente tiene $citas cita(s) registrada(s).", "error");
    header("Location: listar.php");
    exit();
}

$stmt = $conn->prepare("DELETE FROM pacientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

guardarMensaje("El paciente se elimino correctamente.", "ok");
header("Location: listar.php");
exit();
?>
