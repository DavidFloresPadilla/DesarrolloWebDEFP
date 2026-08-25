<?php
    $n = $_GET["n"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar números</title>
</head>
<body>
    <h1>Ingresa los <?php echo $n; ?> números</h1>
    <form method="post" action="suma-resultado.php">
        <input type="hidden" name="n" value="<?php echo $n; ?>">
        <?php
            for($i = 1; $i <= $n; $i++)
                {
                echo "<label>Número $i:</label>";
                echo "<input type='number' name='num$i'><br>";
                }
        ?>
        <input type="submit" value="Sumar">
    </form>
</body>
</html>
