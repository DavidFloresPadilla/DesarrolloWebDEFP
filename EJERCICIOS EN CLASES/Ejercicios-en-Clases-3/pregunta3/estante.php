<?php
class Estante
{
    public $nivel1 = [];
    public $nivel2 = [];
    public $nivel3 = [];
    public $capacidad;

    public function __construct($capacidad)
    {
        $this->capacidad = (int)$capacidad;
        $this->nivel1 = [];
        $this->nivel2 = [];
        $this->nivel3 = [];
    }
    
    private function nombreNivel($nivel)
    {
        return in_array((int)$nivel, [1, 2, 3]) ? 'nivel' . (int)$nivel : null;
    }

    public function insertar($nivel, $elemento)
    {
        $prop = $this->nombreNivel($nivel);
        if ($prop === null) {
            return "Nivel inválido.";
        }
        if (count($this->$prop) >= $this->capacidad) {
            return "Nivel $nivel lleno";
        }
        array_push($this->$prop, $elemento);
        return "Elemento '" . htmlspecialchars($elemento) . "' insertado en el nivel $nivel.";
    }

    public function quitar($nivel)
    {
        $prop = $this->nombreNivel($nivel);
        if ($prop === null) {
            return "Nivel inválido.";
        }
        if (count($this->$prop) == 0) {
            return "El nivel $nivel está vacío.";
        }
        $quitado = array_pop($this->$prop);
        return "Se quitó '" . htmlspecialchars($quitado) . "' del nivel $nivel.";
    }

    public function mostrarEstante()
    {
        $colores = [3 => '#8EA9DB', 2 => '#FFC000', 1 => '#00B050'];
        echo "<table border='1' style='border-collapse:collapse; text-align:center;'>";
        for ($n = 3; $n >= 1; $n--) {
            $prop = 'nivel' . $n;
            echo "<tr>";
            echo "<td style='background:#D9D9D9; font-weight:bold; padding:8px 14px;'>Nivel $n</td>";
            for ($i = 0; $i < $this->capacidad; $i++) {
                if (isset($this->$prop[$i])) {
                    echo "<td style='background:{$colores[$n]}; padding:8px 14px;'>"
                        . htmlspecialchars($this->$prop[$i]) . "</td>";
                } else {
                    echo "<td style='background:#fff; padding:8px 14px; min-width:50px;'>&nbsp;</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}
