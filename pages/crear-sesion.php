<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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
    <style>
main {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 150px);
  padding: 40px 20px;
  animation: fadeBackground 1s ease forwards;
}

@keyframes fadeBackground {
  from { background-color: #fffaf2; opacity: 0.7; }
  to { background-color: #fffaf2; opacity: 1; }
}

.container {
  background: #ffffff;
  padding: 40px 50px;
  border-radius: 16px;
  box-shadow: 0 6px 18px rgba(255, 162, 0, 0.15);
  text-align: center;
  max-width: 420px;
  width: 100%;
  color: #333;
  opacity: 0;
  transform: translateY(30px);
  animation: fadeUp 0.8s ease-out forwards;
}

@keyframes fadeUp {
  0% {
    opacity: 0;
    transform: translateY(40px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.container h1 {
  color: #ff9100;
  font-size: 1.9rem;
  margin-bottom: 25px;
  font-weight: 700;
  letter-spacing: 0.5px;
}

.registro {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.registro label {
  text-align: left;
  font-weight: 600;
  color: #a66b2c;
  margin-bottom: 5px;
  font-size: 0.95rem;
}

.registro input {
  width: 100%;
  padding: 12px 14px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  background-color: #fffaf2;
}

.registro input:focus {
  border-color: #ff9d00;
  box-shadow: 0 0 0 3px rgba(255, 157, 0, 0.2);
  outline: none;
}

.registro button {
  width: 100%;
  padding: 12px;
  font-size: 1rem;
  border-radius: 8px;
  background: linear-gradient(90deg, #ffb347, #ff9100);
  color: white;
  font-weight: 600;
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
}

.registro button:hover {
  background: #e57c00;
  transform: translateY(-2px);
}

.container p {
  margin-top: 15px;
  color: #333;
  font-size: 0.9rem;
}
    </style>
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
