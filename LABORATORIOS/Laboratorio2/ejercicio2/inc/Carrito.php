// David Eduardo Flores Padilla
// Jose Luis Bayo Mora
<?php
class Carrito {
    private $items;

    public function __construct() {
        $this->items = [];
    }

    public function agregar($codigo, $cantidad = 1) {
        if ($cantidad < 1) {
            $cantidad = 1;
        }
        if (isset($this->items[$codigo])) {
            $this->items[$codigo] += $cantidad;
        } else {
            $this->items[$codigo] = $cantidad;
        }
    }

    public function quitar($codigo) {
        unset($this->items[$codigo]);
    }

    public function vaciar() {
        $this->items = [];
    }

    public function getItems() {
        return $this->items;
    }

    public function estaVacio() {
        return count($this->items) == 0;
    }

    public function cantidadTotal() {
        return array_sum($this->items);
    }

    public function total(array $catalogo) {
        $total = 0;
        foreach ($this->items as $codigo => $cantidad) {
            foreach ($catalogo as $p) {
                if ($p->getCodigo() == $codigo) {
                    $total += $p->getPrecio() * $cantidad;
                }
            }
        }
        return round($total, 2);
    }
}
