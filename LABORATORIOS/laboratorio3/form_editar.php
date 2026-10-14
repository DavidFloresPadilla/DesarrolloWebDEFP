<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
require_once "proteger.php";
require_once "permiso.php";
require_once "conexion.php";
require_once "funciones.php";

$id = (int)($_GET["id"] ?? 0);

$stmt = $conn->prepare("SELECT id, fotografia, nombres, apellidos, ci, telefono, fecha_nacimiento FROM pacientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Si el id no existe, se regresa al listado con un aviso en lugar de romperse
if (!$p) {
    guardarMensaje("El paciente solicitado no existe.", "error");
    header("Location: listar.php");
    exit();
}

$titulo    = "Editar paciente";
$subtitulo = "Editar paciente";
$activo    = "pacientes";
include "menu.php";
?>
    <?php mostrarMensaje(); ?>
    <h2>Editar paciente</h2>

    <form action="update.php" method="post" enctype="multipart/form-data" class="panel">
        <input type="hidden" name="id" value="<?php echo (int)$p["id"]; ?>">
        <input type="hidden" name="foto_actual" value="<?php echo e($p["fotografia"]); ?>">

        <div class="fila">
            <div class="campo">
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" maxlength="60" value="<?php echo e($p["nombres"]); ?>" required>
            </div>
            <div class="campo">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" maxlength="60" value="<?php echo e($p["apellidos"]); ?>" required>
            </div>
        </div>
        <div class="fila">
            <div class="campo">
                <label for="ci">Carnet de identidad</label>
                <input type="text" id="ci" name="ci" maxlength="20" value="<?php echo e($p["ci"]); ?>" required>
            </div>
            <div class="campo">
                <label for="telefono">Telefono</label>
                <input type="text" id="telefono" name="telefono" maxlength="20" value="<?php echo e($p["telefono"]); ?>">
            </div>
            <div class="campo">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo e($p["fecha_nacimiento"]); ?>" required>
            </div>
        </div>
        <div class="fila">
            <div class="campo" style="flex: 0 0 auto;">
                <label>Fotografia actual</label>
                <?php echo dibujarFoto($p["fotografia"]); ?>
            </div>
            <div class="campo">
                <label for="fotografia">Cambiar fotografia (opcional - jpg, jpeg, png o webp, maximo 2 MB)</label>
                <input type="file" id="fotografia" name="fotografia" accept=".jpg,.jpeg,.png,.webp">
            </div>
        </div>
        <button type="submit" class="boton boton-ok">Guardar cambios</button>
        <a href="listar.php" class="boton boton-sec">Cancelar</a>
    </form>
</div>
<?php pie(); ?>
