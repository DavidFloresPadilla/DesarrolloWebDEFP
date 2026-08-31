<?php
    $operacion = $_POST["operacion"];
    $n = $_POST["n"];

    if($operacion == "suma")
        {
        $titulo = "Tabla de Suma";
        $simbolo = "+";
        }
    elseif($operacion == "resta")
        {
        $titulo = "Tabla de Resta";
        $simbolo = "-";
        }
    elseif($operacion == "multiplicacion")
        {
        $titulo = "Tabla de Multiplicación";
        $simbolo = "*";
        }
    else
        {
        $titulo = "Tabla de División";
        $simbolo = "/";
        }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
</head>
<body>
    <h1><?php echo $titulo; ?></h1>
    <table border="1" cellspacing="0" cellpadding="10">
        <?php
            for($fila = 0; $fila <= $n; $fila++)
                {
                echo "<tr>";
                for($columna = 0; $columna <= $n; $columna++)
                    {
                    if($fila == 0 && $columna == 0)
                        {
                        echo "<td style='background-color:#D9D9D9; font-weight:bold; text-align:center;'>$simbolo</td>";
                        }
                    elseif($fila == 0)
                        {
                        echo "<td style='background-color:#D9D9D9; font-weight:bold; text-align:center;'>$columna</td>";
                        }
                    elseif($columna == 0)
                        {
                        echo "<td style='background-color:#D9D9D9; font-weight:bold; text-align:center;'>$fila</td>";
                        }
                    else
                        {
                        if($operacion == "suma")
                            {
                            $resultado = $fila + $columna;
                            }
                        elseif($operacion == "resta")
                            {
                            $resultado = $fila - $columna;
                            }
                        elseif($operacion == "multiplicacion")
                            {
                            $resultado = $fila * $columna;
                            }
                        else
                            {
                            $resultado = number_format($fila / $columna, 2);
                            }
                        echo "<td style='text-align:center;'>$resultado</td>";
                        }
                    }
                echo "</tr>";
                }
        ?>
    </table>
</body>
</html>
