<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
require_once "proteger.php";
require_once "conexion.php";

$titulo    = "Panel";
$subtitulo = "Panel principal";
$activo    = "panel";
include "menu.php";

// Indicadores con SELECT COUNT(*) (sentencias preparadas)
$totalPacientes = contar($conn, "SELECT COUNT(*) FROM pacientes");
$totalMedicos   = contar($conn, "SELECT COUNT(*) FROM medicos");
$pendientes     = contar($conn, "SELECT COUNT(*) FROM citas WHERE estado = ?", "s", ["pendiente"]);
$rol            = $_SESSION["rol"];
?>
    <?php mostrarMensaje(); ?>
    <h2>Bienvenido/a, <?php echo e($_SESSION["nombre"]); ?></h2>

    <div class="panel">
        <p>
            Correo: <strong><?php echo e($_SESSION["correo"]); ?></strong>
            &nbsp;|&nbsp; Rol: <span class="etiqueta et-<?php echo e($rol); ?>"><?php echo e($rol); ?></span>
        </p>
        <small>Identificador de la sesion: <?php echo e(session_id()); ?></small>
    </div>

    <h2>Resumen del consultorio</h2>
    <div class="tarjetas">
        <div class="tarjeta"><div class="numero"><?php echo $totalPacientes; ?></div><div class="texto">Pacientes registrados</div></div>
        <div class="tarjeta"><div class="numero"><?php echo $totalMedicos; ?></div><div class="texto">Medicos</div></div>
        <div class="tarjeta"><div class="numero"><?php echo $pendientes; ?></div><div class="texto">Citas pendientes</div></div>
    </div>
</div>
<?php pie(); ?>
