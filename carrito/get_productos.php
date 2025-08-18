<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "keto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }


$ids = explode(',', $_GET['ids'] ?? '');
$ids = array_filter($ids, 'is_numeric'); 

if (count($ids) > 0) {
  $id_list = implode(',', $ids);

  $resultado = $conn->query("SELECT * FROM productos WHERE id IN ($id_list)");

  if ($resultado) {
    $productos = [];
    while ($row = $resultado->fetch_assoc()) {
      $productos[] = $row;
    }
    echo json_encode($productos);
  } else {
    // Error en la consulta SQL
    http_response_code(500);
    echo json_encode(["error" => "Error al consultar la base de datos"]);
  }
} else {
  // No se pasaron IDs válidos
  echo json_encode([]);
}

