<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "keto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

if (!isset($_GET['id'])) {
    echo "ID de producto no especificado.";
    exit;
}

$id = intval($_GET['id']); // seguridad básica
$sql = "SELECT * FROM productos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "Producto no encontrado.";
    exit;
}

$producto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo $producto['nombre']; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Marck+Script&family=Playwrite+NG+Modern:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="style.css">
</head>
  <?php include 'esencials/navbar.php'; ?>
<body>
  <script> stockDisponible = <?= $producto['stock'] ?>; </script>
  <div class="row align-items-center container mt-5">
    <!-- Columna izquierda: texto -->
    <div class="col-md-6 mb-4">
      <h1 class="fw-bold"><?= $producto['nombre'] ?></h1>
      <p class="text-muted">Inicio · <?= $producto['nombre'] ?></p>
      <p><?= $producto['descripcion'] ?></p>

      <h3 class="text-success fw-bold">$<?= number_format($producto['precio'], 0, ',', '.') ?></h3>
<label for="cantidad-<?= $producto['id'] ?>">Cantidad:</label>
<input 
    type="number" 
    id="cantidad-<?= $producto['id'] ?>" 
    value="1" 
    min="1" 
    style="width:60px;"
>

<button onclick='
    const cantidad = document.getElementById("cantidad-<?= $producto["id"] ?>").value;
    agregarAlCarrito({
        id: <?= (int)$producto["id"] ?>,
        nombre: "<?= htmlspecialchars($producto["nombre"], ENT_QUOTES) ?>",
        precio: <?= (int)$producto["precio"] ?>,
        cantidad: cantidad
    });
'>
    Agregar al carrito
</button>
 
      </div>

    <div class="col-md-6 text-center">
      <img src="<?= $producto['imagen'] ?>" alt="Imagen del producto" class="img-fluid rounded" style="max-height: 450px;">
    </div>
  </div>

  <?php include 'esencials/footer.html' ?>

  <script src="carrito.js"></script>
</body>
</html>
