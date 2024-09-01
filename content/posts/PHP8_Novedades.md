Category: PHP

Date: 15/09/2022

# PHP 8: Nuevas Funciones y Mejoras

PHP 8, lanzado el 26 de noviembre de 2020, es una de las actualizaciones más significativas en la historia de PHP. Introduce una serie de nuevas características, optimizaciones y mejoras que mejoran tanto el rendimiento como la legibilidad del código. A continuación, se describen algunas de las adiciones más importantes en PHP 8 junto con ejemplos de código para ilustrarlas.

## 1. Compilador Just-In-Time (JIT)

Una de las características más esperadas en PHP 8 es el compilador Just-In-Time (JIT). Este compilador mejora significativamente el rendimiento al compilar partes del código directamente en instrucciones de CPU, en lugar de interpretarlas. 

### Ejemplo de código

Aunque el JIT no afecta directamente al código que escribes, aquí hay un ejemplo para ilustrar cómo funciona a nivel interno:

```php
function calcular($iteraciones) {
    $total = 0;
    for ($i = 0; $i < $iteraciones; $i++) {
        $total += sqrt($i);
    }
    return $total;
}

echo calcular(1000000);
```

En PHP 8, este código se ejecutará más rápido gracias al JIT.

## 2. Expresiones `match`

La nueva expresión `match` es una alternativa más potente y concisa al `switch`. A diferencia de `switch`, `match` es una expresión, lo que significa que devuelve un valor.

### Ejemplo de código

```php
$estado = 'b';

$resultado = match ($estado) {
    'a' => 'Estado A',
    'b' => 'Estado B',
    'c' => 'Estado C',
    default => 'Estado desconocido',
};

echo $resultado; // Imprime "Estado B"
```

## 3. Tipos de retorno de unión (`Union Types`)

PHP 8 permite declarar múltiples tipos de retorno usando la sintaxis de unión. Esto es útil cuando una función puede devolver más de un tipo de valor.

### Ejemplo de código

```php
function calcularArea(mixed $figura): int|float {
    if ($figura instanceof Circulo) {
        return pi() * $figura->radio ** 2;
    } elseif ($figura instanceof Cuadrado) {
        return $figura->lado * $figura->lado;
    }
    return 0;
}

class Circulo {
    public function __construct(public float $radio) {}
}

class Cuadrado {
    public function __construct(public float $lado) {}
}

$circulo = new Circulo(5);
echo calcularArea($circulo); // Devuelve 78.539816339745

$cuadrado = new Cuadrado(4);
echo calcularArea($cuadrado); // Devuelve 16
```

## 4. Atributos (Anotaciones)

Los atributos permiten agregar metadatos al código sin necesidad de utilizar comentarios `docblock` o parseadores externos. Los atributos pueden ser utilizados, por ejemplo, para especificar la validación o los requisitos de seguridad.

### Ejemplo de código

```php
#[Route('/home', methods: ['GET'])]
function home() {
    // Lógica de la ruta
}
```

## 5. Constructor de propiedades (`Constructor Property Promotion`)

Esta característica permite declarar y inicializar propiedades de clase directamente en la firma del constructor, reduciendo el código repetitivo.

### Ejemplo de código

```php
class Usuario {
    public function __construct(
        private string $nombre,
        private string $email
    ) {}
}

$usuario = new Usuario('Juan', 'juan@example.com');
```

## 6. Nullsafe Operator

El operador `nullsafe` (`?->`) simplifica el acceso a propiedades o métodos de objetos que podrían ser nulos, evitando las comunes verificaciones de null.

### Ejemplo de código

```php
$cliente = obtenerCliente(123);

$nombre = $cliente?->getPerfil()?->getNombre();
```

En este ejemplo, si `$cliente` o `getPerfil()` devuelven null, `$nombre` también será null, y no se lanzará ningún error.

## 7. Comparaciones más seguras

PHP 8 incluye comparaciones numéricas más seguras y consistentes. Anteriormente, ciertas comparaciones podían dar resultados inesperados debido a cómo PHP manejaba la conversión de tipos.

### Ejemplo de código

```php
echo 0 == 'foo'; // En PHP 7 devolvería true, en PHP 8 devuelve false
```

## 8. Sintaxis de funciones `str_contains()`, `str_starts_with()`, y `str_ends_with()`

Estas funciones simplifican las operaciones comunes de manipulación de strings.

### Ejemplo de código

```php
$cadena = "Hola, mundo";

echo str_contains($cadena, 'mundo'); // Devuelve true
echo str_starts_with($cadena, 'Hola'); // Devuelve true
echo str_ends_with($cadena, 'mundo'); // Devuelve true
```

## Conclusión

PHP 8 introduce una serie de mejoras que hacen que el lenguaje sea más rápido, seguro y fácil de usar. Desde el compilador JIT hasta las nuevas características del lenguaje como `match` y los tipos de retorno de unión, PHP 8 ofrece a los desarrolladores herramientas poderosas para escribir código más limpio y eficiente. Esta actualización es un paso adelante significativo para PHP, consolidando su posición como uno de los lenguajes más populares para el desarrollo web.