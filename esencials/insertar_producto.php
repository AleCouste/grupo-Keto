<?php
// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió el formulario por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario de forma segura
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $imagen = $conn->real_escape_string($_POST['imagen']);
    $precio = $conn->real_escape_string($_POST['precio']);
    $categoria = $conn->real_escape_string($_POST['categoria']);

    // Agregar "imagenes/" al inicio del nombre de imagen si no lo tiene
    if (strpos($imagen, 'imagenes/') !== 0) {
        $imagen = 'imagenes/' . $imagen;
    }

    // Consulta SQL sin stock
    $sql = "INSERT INTO productos (nombre, descripcion, imagen, precio, categoria)
            VALUES ('$nombre', '$descripcion', '$imagen', '$precio', '$categoria')";

    if ($conn->query($sql) === TRUE) {
        // Redirigir si todo sale bien
        header("Location: productos.php");
        exit;
    } else {
        echo "Error al insertar el producto: " . $conn->error;
    }
}

// Cerrar conexión
$conn->close();
?>

