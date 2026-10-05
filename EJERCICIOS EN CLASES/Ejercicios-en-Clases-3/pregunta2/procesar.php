<?php
$cadena = isset($_GET['cadena']) ? $_GET['cadena'] : '';
$n      = isset($_GET['n']) ? max(0, (int)$_GET['n']) : 0;

$letras = preg_split('//u', $cadena, -1, PREG_SPLIT_NO_EMPTY);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <style>
        table.letras { border-collapse: collapse; margin: 10px 0; }
        table.letras td {
            width: 45px; height: 40px; text-align: center;
            font-weight: bold; color: #fff; border: 1px solid #333;
        }
        .rojo     { background: red; }
        .amarillo { background: gold; color: #000 !important; }
        .verde    { background: green; }
        pre { background: #f4f4f4; padding: 10px; }
    </style>
</head>
<body>
    <h2>Resultado</h2>

    <h3>a) Cadena separada</h3>
    <pre><?php
        echo "Cadena original: " . htmlspecialchars($cadena) . "\n";
        echo "Cadena separada: " . htmlspecialchars(implode(str_repeat('-', $n), $letras));
    ?></pre>

    <h3>b) Tabla de letras</h3>
    <table class="letras">
        <tr>
        <?php
        $clases = ['rojo', 'amarillo', 'verde'];
        foreach ($letras as $i => $letra) {
            $clase = $clases[$i % 3];
            echo "<td class=\"$clase\">" . htmlspecialchars($letra) . "</td>";
        }
        ?>
        </tr>
    </table>

    <h3>c) Cadena invertida</h3>
    <p><?php echo htmlspecialchars(implode('', array_reverse($letras))); ?></p>

    <p><a href="pregunta2.html">Volver</a></p>
</body>
</html>
