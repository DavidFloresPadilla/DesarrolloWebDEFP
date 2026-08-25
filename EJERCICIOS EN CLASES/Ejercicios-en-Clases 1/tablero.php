<?php
    $filas = $_GET["filas"];
    $columnas = $_GET["columnas"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero de ajedrez</title>
</head>
<body>
    <h1>Tablero de <?php echo $filas; ?> x <?php echo $columnas; ?></h1>
    <table border="1" cellspacing="0" cellpadding="20">
        <?php
            for($i = 1; $i <= $filas; $i++)
                {
                echo "<tr>";
                for($j = 1; $j <= $columnas; $j++)
                    {
                    if(($i + $j) % 2 == 0)
                        {
                        echo "<td style='background-color:#333;'></td>";
                        }
                    else
                        {
                        echo "<td style='background-color:#eee;'></td>";
                        }
                    }
                echo "</tr>";
                }
        ?>
    </table>
</body>
</html>
