<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "UPDATE usuarios SET confirmado=1 WHERE token=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "✅ Cuenta confirmada. Ya puedes iniciar sesión.";
    } else {
        echo "❌ Token inválido o cuenta ya confirmada.";
    }

    $stmt->close();
}
$conn->close();
?>
