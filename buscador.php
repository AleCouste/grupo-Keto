<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keto Sur</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class=" top-line">
        <b>retiro en todas nuentras sucursales 📦</b>
    </div>
<?php include 'esencials/navbar.php' ?>
<style>
    p img{
        width: 250px;
    }
</style>
<?php
if (isset($_POST['submit'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "keto";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Recoger el término de búsqueda desde POST
    $busqueda = $_POST['q'];

    // Preparar y ejecutar la consulta segura
    $stmt = $conn->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR categoria LIKE ?");
    $like = "%" . $busqueda . "%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $resultado = $stmt->get_result();
?>

<div class="container mt-4">
  <h2>Resultados para "<?= htmlspecialchars($busqueda) ?>"</h2>
  <div class="row">
    <?php while ($producto = $resultado->fetch_assoc()) { ?>
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="<?= $producto['imagen'] ?>" class="card-img-top">
          <div class="card-body">
            <h5><?= $producto['nombre'] ?></h5>
            <p><strong>$<?= $producto['precio'] ?></strong></p>
            <p>stock = x<?= $producto['stock'] ?></p>
              <?php if ($producto['stock'] > 0): ?>
                <button class="btn btn-success" onclick="agregarAlCarrito(<?php echo $producto['id']; ?>) ">Agregar al carrito</button>
              <?php else: ?>
                <button class="btn btn-secondary" disabled>Sin stock</button>
              <?php endif; ?>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
</body>
<?php } ?>
</html>