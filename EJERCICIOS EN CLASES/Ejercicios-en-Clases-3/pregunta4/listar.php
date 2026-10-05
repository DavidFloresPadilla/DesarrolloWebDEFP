<?php
require_once 'conexion.php';
$resultado = $conexion->query("SELECT * FROM libros");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de libros</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-top: 10px; }
        th { background: #2C3E50; color: #fff; padding: 8px; }
        td { padding: 8px; border: 1px solid #ccc; }
        tr.par   { background: #F2F2F2; }
        tr.impar { background: #fff; }
    </style>
</head>
<body>
    <h2>Libros</h2>
    <a href="form-insertar.html">Nuevo Libro</a>

    <table>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Año</th>
            <th>Editorial</th>
            <th>Operación</th>
        </tr>
        <?php
        $i = 1;
        while ($f = $resultado->fetch_assoc()) {
            $clase = ($i % 2 == 0) ? 'par' : 'impar';
            echo "<tr class='$clase'>";
            echo "<td>" . htmlspecialchars($f['titulo']) . "</td>";
            echo "<td>" . htmlspecialchars($f['autor']) . "</td>";
            echo "<td>" . htmlspecialchars($f['anio']) . "</td>";
            echo "<td>" . htmlspecialchars($f['editorial']) . "</td>";
            echo "<td><a href='eliminar.php?id=" . (int)$f['id'] . "'>Eliminar</a></td>";
            echo "</tr>";
            $i++;
        }
        ?>
    </table>
</body>
</html>
