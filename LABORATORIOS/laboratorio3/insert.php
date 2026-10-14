<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
require_once "proteger.php";
require_once "permiso.php";
require_once "conexion.php";
require_once "funciones.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar.php");
    exit();
}

$nombres          = trim($_POST["nombres"] ?? "");
$apellidos        = trim($_POST["apellidos"] ?? "");
$ci               = trim($_POST["ci"] ?? "");
$telefono         = trim($_POST["telefono"] ?? "");
$fecha_nacimiento = trim($_POST["fecha_nacimiento"] ?? "");

// Vuelve al formulario con el aviso y conservando lo escrito
function volverAlFormulario($mensaje) {
    $_SESSION["viejo"] = [
        "nombres"          => $_POST["nombres"] ?? "",
        "apellidos"        => $_POST["apellidos"] ?? "",
        "ci"               => $_POST["ci"] ?? "",
        "telefono"         => $_POST["telefono"] ?? "",
        "fecha_nacimiento" => $_POST["fecha_nacimiento"] ?? "",
    ];
    guardarMensaje($mensaje, "error");
    header("Location: form_insertar.php");
    exit();
}

if ($nombres === "" || $apellidos === "" || $ci === "" || $fecha_nacimiento === "") {
    volverAlFormulario("Complete nombres, apellidos, CI y fecha de nacimiento.");
}
$f = DateTime::createFromFormat("Y-m-d", $fecha_nacimiento);
if (!$f || $f->format("Y-m-d") !== $fecha_nacimiento) {
    volverAlFormulario("La fecha de nacimiento no es valida.");
}

// El CI no debe repetirse
if (contar($conn, "SELECT COUNT(*) FROM pacientes WHERE ci = ?", "s", [$ci]) > 0) {
    volverAlFormulario("Ya existe un paciente con el CI " . $ci . ".");
}

// Fotografia (opcional): valida tipo y tamano, genera nombre unico y la guarda
$foto = subirFotografia("fotografia");
if ($foto["error"] !== "") {
    volverAlFormulario($foto["error"]);
}

$sql  = "INSERT INTO pacientes (fotografia, nombres, apellidos, ci, telefono, fecha_nacimiento)
         VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $foto["nombre"], $nombres, $apellidos, $ci, $telefono, $fecha_nacimiento);
$stmt->execute();
$stmt->close();

// Patron procesar -> redirigir: F5 ya no repite el alta
guardarMensaje("El paciente $nombres $apellidos se registro correctamente.", "ok");
header("Location: listar.php");
exit();
?>
