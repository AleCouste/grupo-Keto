<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$error = "";

// Procesar el formulario solo si se envió
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['Umail']) && isset($_POST['Ucontraseña'])) {
        $correo = $_POST['Umail'];
        $contraseña = $_POST['Ucontraseña'];

        // Usar consulta preparada para mayor seguridad
        $sql = "SELECT * FROM usuarios WHERE Umail = ? AND Ucontraseña = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $correo, $contraseña);
        $stmt->execute();
        $result = $stmt->get_result();

        // Validar si se encontró al usuario
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            // Guardar datos en sesión
            $_SESSION['Unombre'] = $usuario['Unombre'];
            $_SESSION['Umail'] = $usuario['Umail'];

            // Redirigir al home
            header(header: " ../index.php");
            exit();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Marck+Script&family=Playwrite+NG+Modern:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body id="iniciar">
    <main>
        <section class="container">
            <h2>Iniciar secion</h2>
            <?php if (!empty($error)): ?>
                <div class="error">
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <form action="index.php" method="post" class="registro">
                <p>
                    <label>Correo</label>
                    <input type="email" name="Umail" placeholder="Ingrese su email" required>
                </p>
                <p>
                    <label>Contraseña</label>
                    <input type="password" name="Ucontraseña" placeholder="Ingrese su contraseña" required>
                </p>
                <a href="pages/crear-secion.php">¿No tenés cuenta? Crear cuenta</a> <br>
                <button type="submit">Ingresar</button>
            </form>
        </section>
    </main>
</body>
</html>
