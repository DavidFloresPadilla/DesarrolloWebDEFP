<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
require_once "proteger.php";
require_once "conexion.php";

$titulo    = "Pacientes";
$subtitulo = "Registro de pacientes";
$activo    = "pacientes";
include "menu.php";

$esAdmin = ($_SESSION["rol"] === "admin");

// Busqueda: el patron va como PARAMETRO de la sentencia preparada
$buscar = trim($_GET["buscar"] ?? "");
$patron = "%" . $buscar . "%";

// Orden: la columna NO puede ir en bind_param, se valida contra una LISTA BLANCA
$permitidas = ["nombres", "apellidos", "ci", "fecha_nacimiento"];
$orden = $_GET["orden"] ?? "apellidos";
if (!in_array($orden, $permitidas, true)) {
    $orden = "apellidos";   // columna por defecto
}

$sql = "SELECT id, fotografia, nombres, apellidos, ci, telefono, fecha_nacimiento
        FROM pacientes
        WHERE nombres LIKE ? OR apellidos LIKE ? OR ci LIKE ?
        ORDER BY $orden, id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $patron, $patron, $patron);
$stmt->execute();
$resultado = $stmt->get_result();
$total = $resultado->num_rows;

$qBuscar = urlencode($buscar);
?>
    <?php mostrarMensaje(); ?>
    <h2>Pacientes (<?php echo $total; ?> encontrados)</h2>

    <form action="listar.php" method="get" class="panel">
        <label for="buscar">Buscar por nombre, apellido o CI</label>
        <div class="barra">
            <div style="flex:1; min-width:200px;">
                <input type="text" id="buscar" name="buscar" value="<?php echo e($buscar); ?>">
            </div>
            <input type="hidden" name="orden" value="<?php echo e($orden); ?>">
            <button type="submit" class="boton">Buscar</button>
            <a href="listar.php" class="boton boton-sec">Limpiar</a>
            <?php if ($esAdmin) { ?>
                <a href="form_insertar.php" class="boton boton-ok">Nuevo paciente</a>
            <?php } ?>
        </div>
    </form>

    <?php if ($total === 0) { ?>
        <div class="aviso aviso-error">No se encontraron pacientes<?php echo $buscar !== "" ? " para &laquo;" . e($buscar) . "&raquo;" : ""; ?>.</div>
    <?php } else { ?>
        <h3>Haga clic en el titulo de una columna para ordenar</h3>
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th><a href="listar.php?orden=nombres&amp;buscar=<?php echo $qBuscar; ?>">Nombres</a></th>
                    <th><a href="listar.php?orden=apellidos&amp;buscar=<?php echo $qBuscar; ?>">Apellidos</a></th>
                    <th><a href="listar.php?orden=ci&amp;buscar=<?php echo $qBuscar; ?>">CI</a></th>
                    <th>Telefono</th>
                    <th><a href="listar.php?orden=fecha_nacimiento&amp;buscar=<?php echo $qBuscar; ?>">Nacimiento</a></th>
                    <?php if ($esAdmin) { ?><th>Operaciones</th><?php } ?>
                </tr>
            </thead>
            <tbody>
            <?php while ($p = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo dibujarFoto($p["fotografia"]); ?></td>
                    <td><?php echo e($p["nombres"]); ?></td>
                    <td><?php echo e($p["apellidos"]); ?></td>
                    <td><?php echo e($p["ci"]); ?></td>
                    <td><?php echo e($p["telefono"]); ?></td>
                    <td><?php echo e(date("d/m/Y", strtotime($p["fecha_nacimiento"]))); ?></td>
                    <?php if ($esAdmin) { ?>
                    <td>
                        <a href="form_editar.php?id=<?php echo (int)$p["id"]; ?>" class="boton mini">Editar</a>
                        <a href="delete.php?id=<?php echo (int)$p["id"]; ?>" class="boton boton-no mini"
                           onclick="return confirm('Eliminar a este paciente?');">Eliminar</a>
                    </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>
<?php
$stmt->close();
$conn->close();
pie();
?>
