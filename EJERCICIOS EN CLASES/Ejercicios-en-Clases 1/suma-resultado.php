<?php
    $n = $_POST["n"];
    $suma = 0;

    for($i = 1; $i <= $n; $i++)
        {
        $numero = $_POST["num" . $i];
        $suma = $suma + $numero;
        }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>
<body>
    <h1>La suma de los <?php echo $n; ?> números es: <?php echo $suma; ?></h1>
</body>
</html>
