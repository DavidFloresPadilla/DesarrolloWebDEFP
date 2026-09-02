// David Eduardo Flores Padilla
// Jose Luis Bayo Mora
<?php
require_once "catalogo.php";

$categorias = obtenerCategorias();
$categoriaSeleccionada = $_GET["categoria"] ?? "";

if ($categoriaSeleccionada != "" && !isset($categorias[$categoriaSeleccionada])) {
    $categoriaSeleccionada = "";
}

$catalogo = obtenerCatalogo();
$productosFiltrados = filtrarPorCategoria($catalogo, $categoriaSeleccionada);
$stats = estadisticas($productosFiltrados);
$categoriasCatalogo = contarPorCategoria($catalogo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <header class="cabecera">
        <div>
            <h1>Catalogo</h1>
            <p>Ejercicio 1</p>
        </div>
    </header>
    <main class="contenedor">
        <section>
            <h2>1. Filtro de productos</h2>
            <form method="get" class="formulario-filtro">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria">
                    <option value="" <?php echo $categoriaSeleccionada == "" ? "selected" : ""; ?>>Todas las categorias</option>
                    <?php foreach ($categorias as $clave => $texto): ?>
                        <option value="<?php echo htmlspecialchars($clave); ?>" <?php echo $categoriaSeleccionada == $clave ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($texto); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Filtrar</button>
            </form>
        </section>
        <section>
            <h2>2. Productos (<?php echo count($productosFiltrados); ?> encontrados)</h2>
            <?php if (count($productosFiltrados) == 0): ?>
                <p>No se encontraron productos para esta categoria.</p>
            <?php else: ?>
                <div class="galeria">
                    <?php foreach ($productosFiltrados as $p): ?>
                        <?php echo $p->mostrarTarjeta(); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <section>
            <h2>3. Resumen calculado con funciones de arreglo</h2>
            <table>
                <tr><th>Indicador</th><th>Valor</th></tr>
                <tr><td>Productos listados</td><td><?php echo $stats["total"]; ?></td></tr>
                <tr><td>Unidades en stock</td><td><?php echo $stats["stock"]; ?></td></tr>
                <tr><td>Precio promedio</td><td>Bs <?php echo number_format($stats["promedio"], 2); ?></td></tr>
                <tr><td>Precio mas alto</td><td>Bs <?php echo number_format($stats["mayor"], 2); ?></td></tr>
                <tr><td>Precio mas bajo</td><td>Bs <?php echo number_format($stats["menor"], 2); ?></td></tr>
                <tr><td>Categorias del catalogo completo</td><td><?php echo count($categoriasCatalogo); ?></td></tr>
            </table>
            <h3>Contenido del arreglo GET</h3>
            <pre><?php print_r($_GET); ?></pre>
        </section>
    </main>
    <footer class="pie">
        <p>Laboratorio 2 Si256</p>
    </footer>

</body>
</html>
