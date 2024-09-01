Category: Go

Date: 01/08/2024

# Creando una API REST Simple en Go

Go (o Golang) es un lenguaje de programación robusto y eficiente que es especialmente adecuado para construir APIs gracias a su simplicidad y su alto rendimiento. En este artículo, te guiaré a través de los pasos para crear una API REST simple en Go.

## Prerrequisitos

Antes de comenzar, asegúrate de tener Go instalado en tu máquina. Si no lo tienes, puedes descargarlo desde [la página oficial de Go](https://golang.org/dl/).

## Estructura del Proyecto

Primero, crea un directorio para tu proyecto:

```bash
mkdir simple-api
cd simple-api
```

Luego, inicializa un nuevo módulo Go:

```bash
go mod init simple-api
```

## Paso 1: Crear el Servidor HTTP

Lo primero que haremos es crear un servidor HTTP básico utilizando el paquete `net/http` de Go.

### Código del Servidor

Crea un archivo llamado `main.go` y añade el siguiente código:

```go
package main

import (
    "encoding/json"
    "log"
    "net/http"
    "strconv"
)

type Item struct {
    ID   int    `json:"id"`
    Name string `json:"name"`
}

var items = []Item{
    {ID: 1, Name: "Item 1"},
    {ID: 2, Name: "Item 2"},
}

func main() {
    http.HandleFunc("/items", getItems)
    http.HandleFunc("/items/", getItemByID)
    http.HandleFunc("/items/add", addItem)

    log.Println("Server running on port 8080")
    log.Fatal(http.ListenAndServe(":8080", nil))
}
```

En este código, hemos creado un servidor básico que escucha en el puerto 8080. A continuación, añadiremos las funciones de controlador para manejar las diferentes rutas de nuestra API.

## Paso 2: Obtener Todos los Elementos

La primera función que vamos a implementar es `getItems`, que devolverá todos los elementos almacenados en la variable `items`.

### Código del Controlador

Añade la siguiente función a `main.go`:

```go
func getItems(w http.ResponseWriter, r *http.Request) {
    w.Header().Set("Content-Type", "application/json")
    json.NewEncoder(w).Encode(items)
}
```

Este controlador configura el encabezado de la respuesta como `application/json` y codifica la lista de `items` en formato JSON para enviarla al cliente.

## Paso 3: Obtener un Elemento por ID

Ahora, implementaremos una función para obtener un solo elemento por su ID.

### Código del Controlador

Añade la siguiente función a `main.go`:

```go
func getItemByID(w http.ResponseWriter, r *http.Request) {
    w.Header().Set("Content-Type", "application/json")
    idParam := r.URL.Path[len("/items/"):]
    id, err := strconv.Atoi(idParam)
    if err != nil {
        http.Error(w, "Invalid ID", http.StatusBadRequest)
        return
    }

    for _, item := range items {
        if item.ID == id {
            json.NewEncoder(w).Encode(item)
            return
        }
    }

    http.Error(w, "Item not found", http.StatusNotFound)
}
```

En este controlador, extraemos el ID de la URL, lo convertimos a un entero y buscamos el elemento correspondiente en la lista. Si lo encontramos, lo devolvemos en formato JSON; de lo contrario, enviamos un error 404.

## Paso 4: Añadir un Nuevo Elemento

Finalmente, implementaremos la funcionalidad para añadir un nuevo elemento a la lista.

### Código del Controlador

Añade la siguiente función a `main.go`:

```go
func addItem(w http.ResponseWriter, r *http.Request) {
    if r.Method != http.MethodPost {
        http.Error(w, "Invalid request method", http.StatusMethodNotAllowed)
        return
    }

    var newItem Item
    err := json.NewDecoder(r.Body).Decode(&newItem)
    if err != nil {
        http.Error(w, "Invalid input", http.StatusBadRequest)
        return
    }

    newItem.ID = len(items) + 1
    items = append(items, newItem)

    w.Header().Set("Content-Type", "application/json")
    json.NewEncoder(w).Encode(newItem)
}
```

Este controlador comprueba si la solicitud es de tipo `POST`, decodifica el cuerpo de la solicitud para obtener el nuevo elemento, le asigna un ID, lo añade a la lista de `items`, y luego devuelve el elemento añadido en formato JSON.

## Paso 5: Probar la API

Ahora que la API está completa, podemos ejecutarla y probarla utilizando `curl` o una herramienta como Postman.

### Ejecutar la API

En la terminal, ejecuta el servidor:

```bash
go run main.go
```

### Probar Endpoints

1. **Obtener todos los elementos:**

   ```bash
   curl http://localhost:8080/items
   ```

2. **Obtener un elemento por ID:**

   ```bash
   curl http://localhost:8080/items/1
   ```

3. **Añadir un nuevo elemento:**

   ```bash
   curl -X POST -d '{"name": "Item 3"}' http://localhost:8080/items/add
   ```

## Conclusión

Has creado una API REST básica en Go que puede obtener todos los elementos, obtener un elemento por su ID y añadir nuevos elementos. Go ofrece una forma eficiente y concisa de crear APIs RESTful, y este ejemplo es solo el comienzo. Puedes expandir esta API con funcionalidades como la eliminación o actualización de elementos, la autenticación, y mucho más.