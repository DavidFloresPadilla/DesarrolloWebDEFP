// David Eduardo Flores Padilla
// Jose Luis Bayo Mora

<?php
function guardarCliente($nombre) {
    setcookie("cliente", $nombre, time() + (7 * 24 * 60 * 60), "/");
}

function obtenerCliente() {
    return $_COOKIE["cliente"] ?? "";
}

function registrarVisita() {
    if (!isset($_SESSION["visita_contada"])) {
        $visitas = isset($_COOKIE["visitas"]) ? (int) $_COOKIE["visitas"] : 0;
        $visitas++;
        setcookie("visitas", $visitas, time() + (365 * 24 * 60 * 60), "/");
        $_SESSION["visita_contada"] = true;
        return $visitas;
    }
    return $_COOKIE["visitas"] ?? 1;
}

function guardarTema($tema) {
    setcookie("tema", $tema, time() + (30 * 24 * 60 * 60), "/");
}

function obtenerTema() {
    return $_COOKIE["tema"] ?? "claro";
}

function guardarCarrito(Carrito $carrito) {
    $_SESSION["carrito"] = serialize($carrito);
}

function obtenerCarrito() {
    if (isset($_SESSION["carrito"])) {
        return unserialize($_SESSION["carrito"]);
    }
    return new Carrito();
}
