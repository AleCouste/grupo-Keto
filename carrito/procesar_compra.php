<?php
header('Content-Type: application/json');

// Recibir carrito desde fetch
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!isset($data['carrito']) || empty($data['carrito'])) {
    echo json_encode(["error" => "Carrito vacío"]);
    exit;
}

// Normalizar carrito (puede venir como objeto o como ID simple)
$carrito = $data['carrito'];
$productosProcesados = [];
$total = 0;

// Conexión DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Conexión fallida"]);
    exit;
}

foreach ($carrito as $item) {
    // Si viene como objeto {id, precio, nombre}
    $id = is_array($item) && isset($item['id']) ? intval($item['id']) : intval($item);

    if ($id <= 0) continue;

    // Buscar el producto en la DB (opcional: podrías confiar en el objeto)
    $sql = "SELECT * FROM productos WHERE id = $id LIMIT 1";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();

        // Precio del objeto tiene prioridad sobre la DB
        $precio = (is_array($item) && isset($item['precio'])) ? floatval($item['precio']) : floatval($row['precio']);
        $nombre = (is_array($item) && isset($item['nombre'])) ? $item['nombre'] : $row['nombre'];

        $productosProcesados[] = [
            "id" => $id,
            "nombre" => $nombre,
            "precio" => $precio
        ];

        $total += $precio;
    }
}

echo json_encode([
    "items" => $productosProcesados,
    "total" => $total
]);
