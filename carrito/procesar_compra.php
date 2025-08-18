<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "keto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

// Leer datos JSON crudo del body
$input = file_get_contents("php://input");
$data = json_decode($input, true);
$carrito = $data['carrito'] ?? [];

if (empty($carrito)) {
  http_response_code(400);
  echo "No se recibieron productos válidos.";
  exit;
}

foreach ($carrito as $id) {
  // Asegurar que el ID sea un número
  $id = intval($id);

  // Verificamos que haya stock
  $check = $conn->query("SELECT stock FROM productos WHERE ID = $id");
  $producto = $check->fetch_assoc();

  if ($producto && $producto['stock'] > 0) {
    // Reducimos stock en 1 unidad
    $conn->query("UPDATE productos SET stock = stock - 1 WHERE ID = $id");
  }
}

echo "Compra procesada correctamente";
