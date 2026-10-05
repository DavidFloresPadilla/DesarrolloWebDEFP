<?php
require_once 'estante.php';   
session_start();

$mensaje = '';
$op = isset($_GET['op']) ? $_GET['op'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'crear') {
        $cap = (int)($_POST['capacidad'] ?? 0);
        if ($cap > 0) {
            $_SESSION['estante'] = new Estante($cap);
            $mensaje = "Estante creado con capacidad $cap por nivel.";
        } else {
            $mensaje = "La capacidad debe ser mayor a 0.";
        }
    } elseif (!isset($_SESSION['estante'])) {
        $mensaje = "Primero debe crear el estante.";
    } elseif ($accion === 'insertar') {
        $mensaje = $_SESSION['estante']->insertar($_POST['nivel'] ?? 0, trim($_POST['elemento'] ?? ''));
    } elseif ($accion === 'quitar') {
        $mensaje = $_SESSION['estante']->quitar($_POST['nivel'] ?? 0);
    }
    $op = '';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú - Estante</title>
    <style>
        nav a { margin-right: 15px; }
        .msg { color: #c0392b; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Menú del Estante</h2>
    <nav>
        <a href="?op=crear">Crear Estante</a>
        <a href="?op=insertar">Insertar</a>
        <a href="?op=quitar">Quitar</a>
        <a href="?op=mostrar">Mostrar Estante</a>
    </nav>
    <hr>

    <?php if ($mensaje) echo "<p class='msg'>$mensaje</p>"; ?>

    <?php if ($op === 'crear'): ?>
        <form method="POST">
            <input type="hidden" name="accion" value="crear">
            <label>Capacidad máxima por nivel:
                <input type="number" name="capacidad" min="1" required>
            </label>
            <button type="submit">Crear</button>
        </form>

    <?php elseif ($op === 'insertar'): ?>
        <form method="POST">
            <input type="hidden" name="accion" value="insertar">
            <label>Nivel:
                <select name="nivel">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </label>
            <label>Elemento:
                <input type="text" name="elemento" required>
            </label>
            <button type="submit">Insertar</button>
        </form>

    <?php elseif ($op === 'quitar'): ?>
        <form method="POST">
            <input type="hidden" name="accion" value="quitar">
            <label>Nivel:
                <select name="nivel">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </label>
            <button type="submit">Quitar</button>
        </form>

    <?php elseif ($op === 'mostrar'): ?>
        <?php
        if (isset($_SESSION['estante'])) {
            $_SESSION['estante']->mostrarEstante();
        } else {
            echo "<p class='msg'>Primero debe crear el estante.</p>";
        }
        ?>
    <?php endif; ?>
</body>
</html>
