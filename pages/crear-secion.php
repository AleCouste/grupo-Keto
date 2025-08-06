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
    <form action="crear-secion.php" method="post" class="registro">
        <div>
        <h1>Ingrese sus datos</h1>
        <p>
            <label>Nombre</label>
            <input type="text" name="Unombre" placeholder="Ingrese su nombre" required>
        </p>
        <p>
            <label>Correo</label>
            <input type="email" name="Umail" placeholder="Ingrese su email" required>
        </p>
        <p>
            <label>Telefono</label>
            <input type="tel" name="Utelefono" placeholder="Ingrese su telefono" required>
        </p>
        <p>
            <label>Contraseña</label>
            <input type="password" name="Ucontraseña" placeholder="Ingrese su contraseña" required>
        </p>
        <a href="iniciar-secion.php">¿ya tenes cuenta? inicia secion</a> <br>
        <button type="submit" value="enviar">ingresar</button>
    </div>
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

  $nombre = $_POST['Unombre'];
  $contraseña = $_POST['Ucontraseña'];
  $mail = $_POST['Umail'];
  $telefono = $_POST['Utelefono'];
    
  $sql = "INSERT INTO usuarios (Unombre, Umail, Utelefono, Ucontraseña) VALUES ('$nombre', '$mail', '$telefono', '$contraseña')";

  if ($conn->query($sql) === TRUE) {
    ?> <h2>cuenta creada prueba </h2> <?php
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

?>
</main>
     <footer>

   <div class="text">
    <b><p>&copy; keto sur Todos los derechos reservados.</p></b>
   </div> 
      
    </footer>
</body>

</html>