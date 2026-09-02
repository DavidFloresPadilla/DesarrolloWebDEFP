// David Eduardo Flores Padilla
// Jose Luis Bayo Mora

<?php
class Producto {
    private $codigo;
    private $nombre;
    private $categoria;
    private $precio;
    private $stock;

    public function __construct($codigo, $nombre, $categoria, $precio, $stock) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getPrecioConDescuento($porcentaje = 10) {
        $precioFinal = $this->precio - ($this->precio * $porcentaje / 100);
        return round($precioFinal, 2);
    }

    public function hayStock() {
        return $this->stock > 0;
    }

    public function mostrarTarjeta() {
        $html = "<div class='tarjeta'>";
        $html .= "<h3>" . htmlspecialchars($this->codigo) . "</h3>";
        $html .= "<p>" . htmlspecialchars($this->categoria) . "</p>";
        $html .= "<p>" . htmlspecialchars($this->nombre) . "</p>";
        $html .= "<p>Bs " . number_format($this->precio, 2) . "</p>";
        $html .= "<p>Con 10% de descuento: Bs " . number_format($this->getPrecioConDescuento(), 2) . "</p>";

        if ($this->hayStock()) {
            $html .= "<p>Stock disponible: " . $this->stock . " unidades</p>";
        } else {
            $html .= "<p class='agotado'>Agotado</p>";
        }

        $html .= "</div>";
        return $html;
    }
}
