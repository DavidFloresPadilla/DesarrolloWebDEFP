// David Eduardo Flores Padilla
// Jose Luis Bayo Mora
<?php
require_once "Producto.php";

function obtenerCatalogo() {
    return [
        new Producto("P01", "Teclado mecanico RGB", "Perifericos", 320.00, 12),
        new Producto("P02", "Mouse inalambrico", "Perifericos", 145.50, 6),
        new Producto("P03", "Monitor 24 pulgadas", "Pantallas", 1250.00, 5),
        new Producto("P04", "Monitor curvo 27 pulg.", "Pantallas", 2100.00, 0),
        new Producto("P05", "Disco solido 480 GB", "Almacenamiento", 380.00, 20),
        new Producto("P06", "Memoria USB 64 GB", "Almacenamiento", 75.00, 35),
        new Producto("P07", "Audifonos con microfono", "Perifericos", 210.00, 0),
        new Producto("P08", "Disco externo 1 TB", "Almacenamiento", 640.00, 8),
    ];
}

function buscarProducto(array $catalogo, $codigo) {
    foreach ($catalogo as $p) {
        if ($p->getCodigo() == $codigo) {
            return $p;
        }
    }
    return null;
}
