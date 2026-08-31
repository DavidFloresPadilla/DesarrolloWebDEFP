<?php
    require_once('pizarra.php');
    session_start();

    if(isset($_POST["palabra"]))
        {
        $pizarra = new Pizarra($_POST["palabra"], $_POST["color"], $_POST["color_fondo"]);
        $_SESSION["pizarra"] = $pizarra;
        }

    if(isset($_GET["opcion"]) && $_GET["opcion"] == "triangulo")
        {
        $pizarra = $_SESSION["pizarra"];
        }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Pizarra</title>
</head>
<body>
    <h1>Menú</h1>
    <a href="menu3.php?opcion=triangulo">Triángulo</a>

    <?php
        if(isset($_GET["opcion"]) && $_GET["opcion"] == "triangulo")
            {
            echo "<h2>Triángulo de la palabra: " . $pizarra->palabra . "</h2>";
            $pizarra->triangulo();
            }
    ?>
</body>
</html>
