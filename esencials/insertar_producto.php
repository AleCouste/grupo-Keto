<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "keto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

$nombre = $_POST['nombre'];
$imagen = $_POST['imagen'];
$precio = $_POST['precio'];
$categoria = $_POST['categoria'];
$stock = $_POST['stock'];

$sql = "INSERT INTO productos (nombre, imagen, precio, categoria, stock) VALUES ('$nombre', '$imagen', '$precio', '$categoria', '$stock')";
$conn->query($sql);

header("Location: productos.php");
?>
