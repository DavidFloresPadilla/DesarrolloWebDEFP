<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2
  $servidor = "localhost";
  $usuario  = "root";
  $clave    = "";
  $bd       = "bd_consultorio26";
  $puerto   = 3306;

  $conn = new mysqli($servidor, $usuario, $clave, $bd, $puerto);

  if ($conn->connect_error) {
      die("Error de conexion: " . $conn->connect_error);
  }
  // utf8mb4 para que los acentos y la enie se vean bien
  $conn->set_charset("utf8mb4");
?>
