<?php
class Pizarra {
    public $palabra;
    public $color;
    public $color_fondo;

    function __construct($palabra, $color, $color_fondo) {
        $this->palabra = $palabra;
        $this->color = $color;
        $this->color_fondo = $color_fondo;
    }

    function triangulo() {
        $n = strlen($this->palabra);
        echo "<table border='1' cellspacing='0' cellpadding='10'>";
        for($i = 1; $i <= $n; $i++)
            {
            echo "<tr>";
            for($j = 1; $j <= $n; $j++)
                {
                if($j <= $i)
                    {
                    $letra = $this->palabra[$j - 1];
                    echo "<td style='color:{$this->color}; background-color:{$this->color_fondo}; text-align:center;'>$letra</td>";
                    }
                else
                    {
                    echo "<td></td>";
                    }
                }
            echo "</tr>";
            }
        echo "</table>";
    }
}
?>
