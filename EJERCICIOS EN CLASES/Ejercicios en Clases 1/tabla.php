<?php
    $operacion = $_POST["operacion"];
    $n = $_POST["n"];

    if($operacion == "suma")
        {
        $titulo = "Tabla de Suma";
        }
    elseif($operacion == "resta")
        {
        $titulo = "Tabla de Resta";
        }
    elseif($operacion == "multiplicacion")
        {
        $titulo = "Tabla de Multiplicación";
        }
    else
        {
        $titulo = "Tabla de División";
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
                        echo "<td></td>";
                        }
                    elseif($fila == 0)
                        {
                        echo "<td><b>$columna</b></td>";
                        }
                    elseif($columna == 0)
                        {
                        echo "<td><b>$fila</b></td>";
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
                            $resultado = round($fila / $columna, 2);
                            }
                        echo "<td>$resultado</td>";
                        }
                    }
                echo "</tr>";
                }
        ?>
    </table>
</body>
</html>
