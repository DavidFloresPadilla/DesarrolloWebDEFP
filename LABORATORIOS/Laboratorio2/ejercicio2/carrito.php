// David Eduardo Flores Padilla
// Jose Luis Bayo Mora

<?php
session_start();

require_once "inc/Producto.php";
require_once "inc/Carrito.php";
require_once "inc/catalogo.php";
require_once "inc/funciones.php";

$cliente = obtenerCliente();
if ($cliente == "") {
    header("Location: tienda.php");
    exit();
}

$catalogo = obtenerCatalogo();
$carrito = obtenerCarrito();

if (isset($_GET["quitar"])) {
    $carrito->quitar($_GET["quitar"]);
    guardarCarrito($carrito);
    header("Location: carrito.php");
    exit();
}

if (isset($_GET["vaciar"])) {
    $carrito->vaciar();
    guardarCarrito($carrito);
    header("Location: carrito.php");
    exit();
}
$tema = obtenerTema();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="tema-<?php echo htmlspecialchars($tema); ?>">

    <header class="cabecera">
        <div>
            <h1>Carrito</h1>
            <p>Contenido guardado en la sesion</p>
        </div>
        <nav>
            <a href="tienda.php">Seguir comprando</a>
            <a href="salir.php">Salir</a>
        </nav>
    </header>
    <main class="contenedor">
        <h2>Compra de <?php echo htmlspecialchars($cliente); ?></h2>
        <?php if ($carrito->estaVacio()): ?>
            <p>El carrito esta vacio.</p>
        <?php else: ?>
            <h3>Detalle del carrito</h3>
            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Accion</th>
                </tr>
                <?php foreach ($carrito->getItems() as $codigo => $cantidad): ?>
                    <?php $producto = buscarProducto($catalogo, $codigo); ?>
                    <?php if ($producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($codigo); ?></td>
                            <td><?php echo htmlspecialchars($producto->getNombre()); ?></td>
                            <td>Bs <?php echo number_format($producto->getPrecio(), 2); ?></td>
                            <td><?php echo $cantidad; ?></td>
                            <td>Bs <?php echo number_format($producto->getPrecio() * $cantidad, 2); ?></td>
                            <td><a href="carrito.php?quitar=<?php echo htmlspecialchars($codigo); ?>">Quitar</a></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4">TOTAL A PAGAR (<?php echo $carrito->cantidadTotal(); ?> articulos)</td>
                    <td colspan="2">Bs <?php echo number_format($carrito->total($catalogo), 2); ?></td>
                </tr>
            </table>
            <p><a href="carrito.php?vaciar=1">Vaciar carrito</a></p>
        <?php endif; ?>

        <h2>Comprobacion de sesiones y cookies</h2>

        <h3>Identificador de la sesion</h3>
        <pre><?php echo session_id(); ?></pre>

        <h3>Contenido de $_SESSION</h3>
        <pre><?php print_r($_SESSION); ?></pre>

        <h3>Contenido de $_COOKIE</h3>
        <pre><?php print_r($_COOKIE); ?></pre>

    </main>

    <footer class="pie">
        <p>Laboratorio 2 SIS 256</p>
    </footer>

</body>
</html>
