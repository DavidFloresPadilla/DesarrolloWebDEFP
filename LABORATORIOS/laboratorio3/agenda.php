<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
require_once "proteger.php";
require_once "conexion.php";

$titulo    = "Agenda";
$subtitulo = "Agenda de citas";
$activo    = "agenda";
include "menu.php";

// El estado recibido se valida contra una lista; cualquier otro valor equivale a "Todos"
$estados = ["pendiente", "atendida", "cancelada"];
$estado  = $_GET["estado"] ?? "";
if (!in_array($estado, $estados, true)) {
    $estado = "";
}

// UNA sola consulta: citas + pacientes + medicos + especialidades (INNER JOIN con alias)
$sql = "SELECT c.fecha, c.hora,
               CONCAT(p.nombres, ' ', p.apellidos) AS paciente,
               CONCAT(m.nombres, ' ', m.apellidos) AS medico,
               e.nombre AS especialidad,
               c.motivo, c.estado
        FROM citas c
        INNER JOIN pacientes      p ON c.paciente_id = p.id
        INNER JOIN medicos        m ON c.medico_id = m.id
        INNER JOIN especialidades e ON m.especialidad_id = e.id";
if ($estado !== "") {
    $sql .= " WHERE c.estado = ?";
}
$sql .= " ORDER BY c.fecha, c.hora";

$stmt = $conn->prepare($sql);
if ($estado !== "") {
    $stmt->bind_param("s", $estado);
}
$stmt->execute();
$resultado = $stmt->get_result();
$total = $resultado->num_rows;
?>
    <?php mostrarMensaje(); ?>
    <h2>Agenda de citas (<?php echo $total; ?>)</h2>

    <form action="agenda.php" method="get" class="panel">
        <div class="barra">
            <div style="width:220px;">
                <label for="estado">Filtrar por estado</label>
                <select id="estado" name="estado">
                    <option value="">-- Todos --</option>
                    <?php foreach ($estados as $opcion) { ?>
                        <option value="<?php echo e($opcion); ?>" <?php echo $opcion === $estado ? "selected" : ""; ?>>
                            <?php echo e(ucfirst($opcion)); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="boton">Filtrar</button>
        </div>
    </form>

    <h3>Datos tomados de cuatro tablas relacionadas con INNER JOIN</h3>
    <?php if ($total === 0) { ?>
        <div class="aviso aviso-error">No hay citas con ese estado.</div>
    <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th><th>Hora</th><th>Paciente</th><th>Medico</th>
                    <th>Especialidad</th><th>Motivo</th><th>Estado</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($c = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo e(date("d/m/Y", strtotime($c["fecha"]))); ?></td>
                    <td><?php echo e(substr($c["hora"], 0, 5)); ?></td>
                    <td><?php echo e($c["paciente"]); ?></td>
                    <td><?php echo e($c["medico"]); ?></td>
                    <td><?php echo e($c["especialidad"]); ?></td>
                    <td><?php echo e($c["motivo"]); ?></td>
                    <td><span class="etiqueta et-<?php echo e($c["estado"]); ?>"><?php echo e($c["estado"]); ?></span></td>
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
