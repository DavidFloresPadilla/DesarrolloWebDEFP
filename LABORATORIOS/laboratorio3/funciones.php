<?php // Integrantes: NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2

/** Escapa un dato antes de imprimirlo en HTML. */
function e($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, "UTF-8");
}

/** Deja un mensaje en la sesion para mostrarlo en la siguiente pagina. $tipo: ok | error */
function guardarMensaje($texto, $tipo = "ok") {
    $_SESSION["mensaje"]      = $texto;
    $_SESSION["mensaje_tipo"] = $tipo;
}

/** Imprime (y consume) el mensaje guardado en la sesion, si existe. */
function mostrarMensaje() {
    if (!empty($_SESSION["mensaje"])) {
        $clase = ($_SESSION["mensaje_tipo"] ?? "ok") === "error" ? "aviso aviso-error" : "aviso";
        echo '<div class="' . $clase . '">' . e($_SESSION["mensaje"]) . '</div>';
    }
    unset($_SESSION["mensaje"], $_SESSION["mensaje_tipo"]);
}

/** Ejecuta un SELECT COUNT(*) con sentencia preparada y devuelve el entero. */
function contar($conn, $sql, $tipos = "", $params = []) {
    $stmt = $conn->prepare($sql);
    if ($tipos !== "") {
        $stmt->bind_param($tipos, ...$params);
    }
    $stmt->execute();
    $fila = $stmt->get_result()->fetch_row();
    $stmt->close();
    return (int)$fila[0];
}

/** Dibuja la fotografia del paciente o el recuadro "S/F" si no tiene. */
function dibujarFoto($archivo) {
    $archivo = basename((string)$archivo);
    if ($archivo !== "" && file_exists(__DIR__ . "/images/" . $archivo)) {
        return '<img class="foto" src="images/' . e($archivo) . '" alt="Fotografia">';
    }
    return '<div class="sinfoto">S/F</div>';
}

/** Cierra la pagina privada con el pie comun. */
function pie() {
    echo '<div class="pie">SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga</div>';
    echo '</body></html>';
}

/**
 * Valida y guarda la fotografia subida en $_FILES[$campo].
 * Devuelve un arreglo: ["nombre" => nombre generado o "" si no hubo archivo,
 *                       "error"  => mensaje de error o "" si todo salio bien].
 */
function subirFotografia($campo) {
    $resultado = ["nombre" => "", "error" => ""];

    // 1) El usuario no eligio archivo: no es un error, el paciente se guarda sin foto
    if (!isset($_FILES[$campo]) || $_FILES[$campo]["error"] === UPLOAD_ERR_NO_FILE) {
        return $resultado;
    }
    $archivo = $_FILES[$campo];

    if ($archivo["error"] === UPLOAD_ERR_INI_SIZE || $archivo["error"] === UPLOAD_ERR_FORM_SIZE) {
        $resultado["error"] = "La fotografia supera el tamano maximo de 2 MB.";
        return $resultado;
    }
    if ($archivo["error"] !== UPLOAD_ERR_OK) {
        $resultado["error"] = "No se pudo subir la fotografia (codigo " . (int)$archivo["error"] . ").";
        return $resultado;
    }

    // 2) Tamano maximo 2 MB
    if ($archivo["size"] > 2 * 1024 * 1024) {
        $resultado["error"] = "La fotografia supera el tamano maximo de 2 MB.";
        return $resultado;
    }

    // 3) Extension permitida
    $extension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));
    if (!in_array($extension, ["jpg", "jpeg", "png", "webp"], true)) {
        $resultado["error"] = "Formato no permitido. Use jpg, jpeg, png o webp.";
        return $resultado;
    }

    // 3b) Ademas de la extension, el contenido debe ser realmente una imagen
    if (@getimagesize($archivo["tmp_name"]) === false) {
        $resultado["error"] = "El archivo no es una imagen valida.";
        return $resultado;
    }

    // 4) Nombre unico para que dos archivos con el mismo nombre no se pisen
    $nuevo = uniqid() . "." . $extension;

    // 5) Guardado real
    if (!move_uploaded_file($archivo["tmp_name"], __DIR__ . "/images/" . $nuevo)) {
        $resultado["error"] = "No se pudo guardar la fotografia en el servidor.";
        return $resultado;
    }

    $resultado["nombre"] = $nuevo;
    return $resultado;
}
?>
