# Laboratorio 3 — PHP con base de datos y autenticación
**Materia:** SIS 256 — Tecnología y Desarrollo Web
**Integrantes:** NOMBRE_INTEGRANTE_1 y NOMBRE_INTEGRANTE_2

## Preguntas de análisis

### 1. ¿Por qué la contraseña se guarda con `sha1()` y por qué `autenticar.php` no "descifra" nada?
`sha1()` es una función de resumen (hash): convierte la clave en una cadena de 40 caracteres y **no se puede revertir**. En la base de datos solo está el resumen de `123` (`40bd0015...`). Al ingresar, `autenticar.php` aplica `sha1()` a lo que escribió el usuario y compara los dos resúmenes en el `WHERE correo = ? AND clave = ?`. Si coinciden, la clave era la correcta; nunca se recupera la clave original.

### 2. ¿Por qué se usan sentencias preparadas (`prepare`, `bind_param`, `execute`) y no se concatena `$_POST` en el SQL?
Porque la sentencia se compila primero con marcadores `?` y los datos viajan aparte: el motor los trata siempre como **valores**, nunca como código SQL. Esto evita la inyección SQL; por ejemplo, escribir `' OR '1'='1` en el correo sería buscado como un correo literal y no alteraría la consulta.

### 3. ¿Qué diferencia hay entre `proteger.php` y `permiso.php` (autenticación frente a autorización)?
- **Autenticación** (`proteger.php`): responde *¿quién eres?* Verifica que exista `$_SESSION["correo"]`; si no hay sesión, redirige al login.
- **Autorización** (`permiso.php`): responde *¿qué puedes hacer?* Verifica que `$_SESSION["rol"]` sea `admin`; si es `user`, lo devuelve al listado con un aviso.
Un usuario puede estar autenticado y aun así no estar autorizado (el rol `user` solo consulta).

### 4. ¿Por qué no basta con ocultar los botones "Editar" y "Eliminar" al rol `user`?
Ocultar un botón solo cambia lo que se dibuja; cualquiera puede escribir a mano la URL (`delete.php?id=3`, `form_insertar.php`). La seguridad real está en el servidor: `form_insertar`, `insert`, `form_editar`, `update` y `delete` incluyen `proteger.php` y `permiso.php`, de modo que la petición se rechaza aunque no exista el botón (Figura 4 de la guía).

### 5. ¿Por qué el mensaje de error del login no dice si falló el correo o la contraseña?
Si el sistema dijera "el correo no existe", un atacante podría probar correos hasta descubrir cuáles están registrados y luego atacar solo las claves. Con un mensaje genérico ("Correo o contraseña incorrectos") no obtiene esa información.

### 6. ¿Por qué el `ORDER BY` se valida con una lista blanca (`in_array`) y no con `bind_param`?
`bind_param` solo puede sustituir **valores**; un nombre de columna enviado como parámetro se interpretaría como un texto entre comillas y no ordenaría nada. Como el nombre de la columna sí debe ir dentro de la cadena SQL, hay que asegurarse de que sea uno de los permitidos (`nombres`, `apellidos`, `ci`, `fecha_nacimiento`). Si llega cualquier otro valor se usa la columna por defecto, evitando inyección por el parámetro `orden`.

### 7. ¿Para qué sirve el patrón *procesar → redirigir* (`header()` + `exit`)?
Después de un `POST` (alta, edición, eliminación) el script redirige con `header("Location: listar.php")` y termina con `exit()`. Así el navegador queda en una página cargada por `GET`; si el usuario presiona **F5** solo recarga el listado y **no repite** la operación (no se inserta dos veces el mismo paciente). El `exit()` evita que el resto del script siga ejecutándose tras la redirección. El resultado se comunica con un mensaje guardado en la sesión.

### 8. ¿Por qué el formulario de alta necesita `enctype="multipart/form-data"`?
Sin ese atributo el navegador envía solo texto y `$_FILES` llega vacío. Con `multipart/form-data` el archivo viaja en el cuerpo de la petición y PHP lo deja en una carpeta temporal (`tmp_name`) para que `move_uploaded_file()` lo guarde.

### 9. ¿Qué validaciones hace `subirFotografia()` y por qué el nombre se genera con `uniqid()`?
Comprueba: (a) si no se eligió archivo (`UPLOAD_ERR_NO_FILE`) no es error y el paciente se guarda sin foto; (b) tamaño máximo de 2 MB; (c) extensión dentro de `jpg`, `jpeg`, `png`, `webp`, además de verificar con `getimagesize()` que el contenido sea realmente una imagen; (d) nombre único; (e) guardado con `move_uploaded_file()`. El nombre `uniqid() . "." . extensión` evita que dos archivos con el mismo nombre se sobrescriban y que se use el nombre original (que podría traer caracteres peligrosos). La función devuelve un arreglo con `nombre` y `error` para distinguir claramente ambos casos.

### 10. ¿Por qué `delete.php` consulta primero las citas del paciente?
Porque `citas.paciente_id` es una clave foránea hacia `pacientes`. Borrar un paciente con citas dejaría registros huérfanos (o MySQL lanzaría un error de integridad). `delete.php` cuenta las citas con una sentencia preparada y, si hay alguna, **no borra** y explica el motivo al usuario (Figura 9).

### 11. ¿Qué ventaja tiene usar `INNER JOIN` con alias en `agenda.php`?
Una sola consulta trae los datos de las cuatro tablas relacionadas (`citas`, `pacientes`, `medicos`, `especialidades`), en lugar de hacer una consulta por fila. Los alias (`c`, `p`, `m`, `e`) acortan la escritura y desambiguan columnas con el mismo nombre (`nombres`, `apellidos`, `id`). `INNER JOIN` devuelve solo las filas que tienen correspondencia en todas las tablas.

### 12. ¿Para qué se usa `htmlspecialchars()` al imprimir datos de la base?
Para convertir caracteres como `<`, `>` y `"` en entidades HTML. Si un nombre contuviera `<script>...</script>`, se mostraría como texto y no se ejecutaría (previene XSS). Todos los datos que salen de la base se imprimen a través de la función `e()`, que envuelve a `htmlspecialchars()`.
