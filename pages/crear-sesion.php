<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // ajusta la ruta según tu estructura

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['U_nombre'] ?? '');
    $contraseña = trim($_POST['U_contraseña'] ?? '');
    $mail = trim($_POST['U_mail'] ?? '');
    $telefono = trim($_POST['U_telefono'] ?? '');

    if ($nombre && $contraseña && $mail && $telefono) {
        // Verificar si el correo ya existe
        $check = $conn->prepare("SELECT U_id FROM usuarios WHERE U_mail=?");
        $check->bind_param("s", $mail);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $mensaje = "❌ Ese correo ya está registrado.";
        } else {
            $hash = password_hash($contraseña, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(16));

            $sql = "INSERT INTO usuarios (U_nombre, U_mail, U_telefono, U_contraseña, token, confirmado) 
                    VALUES (?, ?, ?, ?, ?, 0)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nombre, $mail, $telefono, $hash, $token);

            if ($stmt->execute()) {
                // Enviar correo de confirmación
                $mailSender = new PHPMailer(true);
                try {
                    $mailSender->isSMTP();
                    $mailSender->Host = 'smtp.gmail.com';
                    $mailSender->SMTPAuth = true;
                    $mailSender->Username = 'labuburosquita@gmail.com';
                    $mailSender->Password = 'lmex vjud hcmx trev'; 
                    $mailSender->SMTPSecure = 'tls';
                    $mailSender->Port = 587;

                    $mailSender->setFrom('labuburosquita@gmail.com', 'Keto App');
                    $mailSender->addAddress($mail, $nombre);

                    $url = "http://localhost/keto-surXamp/pages/confirmar.php?token=$token";

                    $mailSender->isHTML(true);
                    $mailSender->Subject = 'Confirma tu cuenta';
                    $mailSender->Body    = "Hola $nombre, confirma tu cuenta haciendo clic aquí: <a href='$url'>$url</a>";
                    $mailSender->AltBody = "Copia y pega este enlace en tu navegador: $url";

                    $mailSender->send();
                    $mensaje = "✅ Cuenta creada. Revisa tu correo para confirmarla.";
                } catch (Exception $e) {
                    $mensaje = "❌ Error al enviar correo: {$mailSender->ErrorInfo}";
                }
            } else {
                $mensaje = "❌ Error al crear cuenta: " . $stmt->error;
            }
            $stmt->close();
        }
        $check->close();
    } else {
        $mensaje = "Por favor complete todos los campos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include '../esencials/navbar.php'; ?>
    <main>
        <section class="container">
            <h1>Crear cuenta</h1>
            <form action="crear-sesion.php" method="post" class="registro">
                <p><label>Nombre</label><input type="text" name="U_nombre" required></p>
                <p><label>Correo</label><input type="email" name="U_mail" required></p>
                <p><label>Teléfono</label><input type="tel" name="U_telefono" required></p>
                <p><label>Contraseña</label><input type="password" name="U_contraseña" required></p>
                <button type="submit">Registrar</button>
            </form>
            <?php if (!empty($mensaje)): ?>
                <p><?php echo htmlspecialchars($mensaje); ?></p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
