<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
require_once "proteger.php";
require_once "permiso.php";

$titulo    = "Nuevo paciente";
$subtitulo = "Nuevo paciente";
$activo    = "pacientes";
include "menu.php";

// Si insert.php devolvio un error, se recuperan los datos escritos
$v = $_SESSION["viejo"] ?? [];
unset($_SESSION["viejo"]);
?>
    <?php mostrarMensaje(); ?>
    <h2>Registrar un paciente</h2>

    <!-- Sin enctype="multipart/form-data", $_FILES llega vacio -->
    <form action="insert.php" method="post" enctype="multipart/form-data" class="panel">
        <div class="fila">
            <div class="campo">
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" maxlength="60" value="<?php echo e($v["nombres"] ?? ""); ?>" required>
            </div>
            <div class="campo">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" maxlength="60" value="<?php echo e($v["apellidos"] ?? ""); ?>" required>
            </div>
        </div>
        <div class="fila">
            <div class="campo">
                <label for="ci">Carnet de identidad</label>
                <input type="text" id="ci" name="ci" maxlength="20" value="<?php echo e($v["ci"] ?? ""); ?>" required>
            </div>
            <div class="campo">
                <label for="telefono">Telefono</label>
                <input type="text" id="telefono" name="telefono" maxlength="20" value="<?php echo e($v["telefono"] ?? ""); ?>">
            </div>
            <div class="campo">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo e($v["fecha_nacimiento"] ?? ""); ?>" required>
            </div>
        </div>
        <div class="campo">
            <label for="fotografia">Fotografia (jpg, jpeg, png o webp - maximo 2 MB)</label>
            <input type="file" id="fotografia" name="fotografia" accept=".jpg,.jpeg,.png,.webp">
        </div>
        <button type="submit" class="boton boton-ok">Guardar paciente</button>
        <a href="listar.php" class="boton boton-sec">Cancelar</a>
    </form>
</div>
<?php pie(); ?>
