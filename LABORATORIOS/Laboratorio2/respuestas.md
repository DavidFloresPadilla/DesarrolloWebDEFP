David Eduardo Flores Padilla
Jose Luis Bayo Mora
## 1. ¿Por qué el carrito se guarda en la sesión y no en una cookie?
Porque el carrito puede tener varios productos y crecer bastante, y las cookies
tienen un límite de tamaño unos 4KB mientras que la sesión no tiene
ese límite práctico ademas los datos de sesión se guardan en el servidor por
lo que son más seguros y una cookie vive en el navegador del usuario y podría
ser leída o modificada desde ahí.

## 2. ¿Qué ocurre si se llama a setcookie() después de haber impreso HTML?
Aparece el error "headers already sent". Las cookies viajan dentro de las
cabeceras de la respuesta HTTP y esas cabeceras deben enviarse
antes que cualquier contenido del cuerpo. si ya se
imprimió algo las cabeceras ya se enviaron y no se puede agregar una cookie.

## 3. Después de crear una cookie con setcookie(), ¿por qué $_COOKIE todavía no la contiene en esa misma petición?
Porque setcookie() solo prepara la cookie para que viaje en la respuesta HTTP
hacia el navegador. El navegador recién la guarda cuando recibe esa respuesta,
y la vuelve a enviar en la siguiente petición. Por eso el patrón correcto es
guardar la cookie y redirigir con header() + exit(), para que en la carga
siguiente $_COOKIE ya la tenga disponible.

## 4. ¿Qué error aparece si se hace unserialize() del carrito sin haber incluido antes la clase Carrito?

PHP muestra un warning indicando que la clase no existe, y unserialize()
devuelve un objeto de tipo __PHP_Incomplete_Class en lugar de un objeto
Carrito funcional. Al intentar llamar a un método de ese objeto (por ejemplo
agregar() o total()) se produce un error fatal, porque el objeto no tiene el
comportamiento de la clase Carrito.

## 5. Las propiedades de Producto son privadas: ¿qué sucede si desde index.php se intenta escribir $p->precio = 0?

PHP lanza un error fatal ("Cannot access private property"), porque una
propiedad privada solo puede leerse o modificarse desde dentro de la propia
clase. Esto es el encapsulamiento: obliga a que cualquier cambio pase por los
métodos públicos de la clase (getters, o algún método que valide el dato) en
vez de modificar el atributo directamente desde afuera.
