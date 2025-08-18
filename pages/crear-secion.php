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
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Marck+Script&family=Playwrite+NG+Modern:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="../style.css">
</head>
<body> 
  <?php include '../esencials/navbar.php' ?>
    <main>
        <section class="container">
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
        <button type="submit" value="enviar">ingresar</button>
    </div>
    </form>
</section>

<?php

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