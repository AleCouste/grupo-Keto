<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['U_mail']) && !empty($_POST['U_contraseña'])) {
        $correo = $_POST['U_mail'];
        $contraseña = $_POST['U_contraseña'];

        $sql = "SELECT * FROM usuarios WHERE U_mail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            if ($usuario['confirmado'] == 0) {
                $error = "⚠️ Debes confirmar tu cuenta. Revisa tu correo.";
            } elseif (password_verify($contraseña, $usuario['U_contraseña'])) {
                $_SESSION['U_nombre'] = $usuario['U_nombre'];
                $_SESSION['U_mail'] = $usuario['U_mail'];
                header("Location: http://localhost/keto-surXamp/index.php");
                exit();
            } else {
                $error = "Correo o contraseña incorrectos.";
            }
        } else {
            $error = "Correo o contraseña incorrectos.";
        }

        $stmt->close();
    } else {
        $error = "Por favor complete todos los campos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body id="iniciar">
    <main>
        <section class="container">
            <h2>Iniciar sesión</h2>
            <?php if (!empty($error)): ?>
                <div class="error"><p><?php echo htmlspecialchars($error); ?></p></div>
            <?php endif; ?>
            <form action="" method="post" class="registro">
                <p><label>Correo</label><input type="email" name="U_mail" required></p>
                <p><label>Contraseña</label><input type="password" name="U_contraseña" required></p>
                <a href="pages/crear-sesion.php">¿No tenés cuenta? Crear cuenta</a><br>
                <button type="submit">Ingresar</button>
            </form>
        </section>
    </main>
</body>
</html>
