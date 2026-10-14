<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
// Cabecera comun de las paginas privadas. Se incluye DESPUES de proteger.php.
// Variables opcionales antes del include: $titulo (titulo de pestana), $subtitulo, $activo (panel|pacientes|agenda)
require_once __DIR__ . "/funciones.php";
$titulo    = $titulo    ?? "Consultorio USFX";
$subtitulo = $subtitulo ?? "";
$activo    = $activo    ?? "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($titulo); ?> - Consultorio USFX</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header class="cabecera">
    <div>
        <h1>Consultorio USFX</h1>
        <p><?php echo e($subtitulo); ?></p>
    </div>
    <nav>
        <a href="panel.php"  class="<?php echo $activo === 'panel'     ? 'activo' : ''; ?>">Panel</a>
        <a href="listar.php" class="<?php echo $activo === 'pacientes' ? 'activo' : ''; ?>">Pacientes</a>
        <a href="agenda.php" class="<?php echo $activo === 'agenda'    ? 'activo' : ''; ?>">Agenda</a>
        <a href="cerrar_sesion.php">Salir (<?php echo e($_SESSION["nombre"] ?? ""); ?>)</a>
    </nav>
</header>
<div class="contenedor">
