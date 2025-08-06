<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Marck+Script&family=Playwrite+NG+Modern:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body id="iniciar"> 
    <div class=" top-line">
        <b>retiro en todas nuentras sucursales 📦</b>
    </div>
<?php include 'C:\xampp\htdocs\keto-sur\esencials\navbar.php' ?>
    <main>
        <section class="container">
               <h2>ingrese sus datos</h2>
    <form action="iniciar-secion.php" method="post" class="registro">
        <p>
            <label>correo</label>
            <input type="email" name="Umail" placeholder="Ingrese su email" required> 
        </p>
        <p>
            <label>contraseña</label>
            <input type="password" name="Ucontraseña" placeholder="Ingrese su contraseña" required>
        </p>
       <a href="crear-secion.php">¿no tenes cuenta? crear cuenta</a> <br>
       <button type="submit" value="enviar">ingresar</button>
    </form>
</section>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar que las variables POST estén definidas
if (isset($_POST['Unombre']) && isset($_POST['Ucontraseña'])) {
    $nombre = $_POST['Unombre'];
    $contraseña = $_POST['Ucontraseña'];

    // Usamos consulta preparada correctamente
    $sql = "SELECT * FROM usuarios WHERE Unombre = ? AND Ucontraseña = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $nombre, $contraseña);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc(); // Obtener los datos del usuario
            $_SESSION['Unombre'] = $usuario['Unombre'];
            $_SESSION['Umail'] = $usuario['Umail']; // Guardar el correo en sesión

            echo "Inicio de sesión exitoso.<br>";
            echo "Bienvenido, " . $usuario['Unombre'] . "<br>";
            echo "Tu correo es: " . $usuario['Umail'];
        } else {
            echo "Usuario o contraseña incorrectos.";
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "Por favor complete todos los campos.";
}

$conn->close();
?>
</main>

<footer>
   <div class="text">
            <b>
                <p>&copy; keto sur Todos los derechos reservados.</p>
            </b>
    </div> 
</footer>

</body>
</html>