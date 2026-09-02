// David Eduardo Flores Padilla
// Jose Luis Bayo Mora

<?php
session_start();

require_once "inc/Producto.php";
require_once "inc/Carrito.php";
require_once "inc/catalogo.php";
require_once "inc/funciones.php";

if (isset($_GET["tema"])) {
    $temaElegido = $_GET["tema"] == "oscuro" ? "oscuro" : "claro";
    guardarTema($temaElegido);
    header("Location: tienda.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])) {
    $nombre = trim($_POST["nombre"]);
    if ($nombre != "") {
        guardarCliente($nombre);
        header("Location: tienda.php");
        exit();
    }
}
$cliente = obtenerCliente();
if ($cliente == "") {
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tienda</title>
        <link rel="stylesheet" href="../estilos.css">
    </head>
    <body>
        <header class="cabecera">
            <h1>Identificacion del cliente</h1>
        </header>
        <main class="contenedor">
            <p>Escriba su nombre. Se guardara en una cookie durante 7 dias.</p>
            <form method="post" class="formulario-filtro">
                <label for="nombre">Nombre del cliente</label>
                <input type="text" name="nombre" id="nombre">
                <button type="submit">Ingresar a la tienda</button>
            </form>
        </main>
        <footer class="pie">
            <p>Laboratorio 2 SIS 256</p>
        </footer>
    </body>
    </html>
    
    <?php
    exit();
}

$visitas = registrarVisita();
$carrito = obtenerCarrito();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo"])) {
    $codigo = $_POST["codigo"];
    $cantidad = isset($_POST["cantidad"]) ? (int) $_POST["cantidad"] : 1;

    $carrito->agregar($codigo, $cantidad);
    guardarCarrito($carrito);

    $catalogoTemp = obtenerCatalogo();
    $productoAgregado = buscarProducto($catalogoTemp, $codigo);
    $_SESSION["mensaje"] = "Se agrego \"" . $productoAgregado->getNombre() . "\" al carrito.";

    header("Location: tienda.php");
    exit();
}

$mensaje = "";
if (isset($_SESSION["mensaje"])) {
    $mensaje = $_SESSION["mensaje"];
    unset($_SESSION["mensaje"]);
}

$catalogo = obtenerCatalogo();
$tema = obtenerTema();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="tema-<?php echo htmlspecialchars($tema); ?>">

    <header class="cabecera">
        <div>
            <h1>Tienda</h1>
            <p>Ejercicio 2 - Cookies y sesiones en PHP</p>
        </div>
        <nav>
            <a href="carrito.php">Carrito (<?php echo $carrito->cantidadTotal(); ?>)</a>
            <a href="tienda.php?tema=<?php echo $tema == "claro" ? "oscuro" : "claro"; ?>">Tema <?php echo $tema == "claro" ? "oscuro" : "claro"; ?></a>
            <a href="salir.php">Salir</a>
        </nav>
    </header>
    <main class="contenedor">
        <?php if ($mensaje != ""): ?>
            <p class="mensaje"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>
        <h2>Hola <?php echo htmlspecialchars($cliente); ?></h2>
        <p>Esta es su visita numero <?php echo $visitas; ?> (dato guardado en la cookie <em>visitas</em>).</p>
        <p>Su carrito tiene <?php echo $carrito->cantidadTotal(); ?> articulo(s) y vive en la sesion <?php echo session_id(); ?>.</p>

        <h2>Productos disponibles</h2>
        <div class="galeria">
            <?php foreach ($catalogo as $p): ?>
                <div class="tarjeta">
                    <h3><?php echo htmlspecialchars($p->getCodigo()); ?></h3>
                    <p><?php echo htmlspecialchars($p->getCategoria()); ?></p>
                    <p><?php echo htmlspecialchars($p->getNombre()); ?></p>
                    <p>Bs <?php echo number_format($p->getPrecio(), 2); ?></p>

                    <?php if ($p->hayStock()): ?>
                        <form method="post" class="formulario-agregar">
                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($p->getCodigo()); ?>">
                            <input type="number" name="cantidad" value="1" min="1">
                            <button type="submit">Agregar</button>
                        </form>
                    <?php else: ?>
                        <p class="agotado">Agotado</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </main>
    <footer class="pie">
        <p>Laboratorio 2 SIS 256</p>
    </footer>

</body>
</html>
