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

		// se fija si existen en la base de datos  y si concuerdan la contraseña y el mail con alguno la trae a la secion
		
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
    <link rel="stylesheet" href="../style.css">
</head>
<body id="iniciar">
    <main class="login-wrapper">
        <section class="login-container">
            <h2>Iniciar sesión</h2>


            <?php if (!empty($error)): ?>
                <div class="error"><p><?php echo htmlspecialchars($error); ?></p></div>
            <?php endif; ?>


            <form action="" method="post" class="login-form">
                <div class="input-group" style="text-align: center">
                    <label for="email">Correo</label>
                    <input type="email" name="U_mail" id="email" required>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="U_contraseña" id="password" required>
                </div>

                <a href="pages/crear-sesion.php" class="link-crear">¿No tenés cuenta? Crear cuenta</a>

                <button type="submit" class="btn-login">Ingresar</button>
            </form>
        </section>
    </main>
</body>
</html>
