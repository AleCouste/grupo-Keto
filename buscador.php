<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$busqueda = isset($_REQUEST['q']) ? $_REQUEST['q'] : "";

$stmt = $conn->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR categoria LIKE ?");
$like = "%" . $busqueda . "%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultados de búsqueda</title>

  <!-- Librerías -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="carrito.js" defer></script>
  <link rel="stylesheet" href="style.css">

  <style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f8f9fa;
    margin: 0;
    padding: 0;
  }

  /* === PRODUCTOS / CARDS Modernas Centradas === */
  .productos-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    padding: 20px;
  }

  .productos-row .card {
    flex: 1 1 calc(33.333% - 25px);
    min-width: 240px;
    max-width: 320px;
    background: #fff;
    border: none;
    border-radius: 14px;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.3s ease;
  }

  .productos-row .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(255, 145, 0, 0.25);
  }

  .productos-row .card .card-img-top {
    width: 100%;
    height: auto;
    max-height: 250px;
    object-fit: cover;
  }

  .productos-row .card-body {
    padding: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .productos-row .card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
  }

  .productos-row .card p {
    font-size: 1rem;
    color: #ff9100;
    font-weight: 600;
    margin: 5px 0 15px;
  }

  .productos-row .card button {
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    background: linear-gradient(90deg, #ffb347, #ff9100);
    color: white;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 3px 6px rgba(255, 145, 0, 0.3);
  }

  .productos-row .card button:hover {
    background: #e57c00;
    transform: translateY(-2px);
  }

  @media (max-width: 992px) {
    .productos-row .card {
      flex: 1 1 calc(50% - 25px);
    }
  }

  @media (max-width: 576px) {
    .productos-row .card {
      flex: 1 1 100%;
    }
  }
  </style>
</head>

<body>
  <div class="top-line">
    <b>Retiro en todas nuestras sucursales 📦</b>
  </div>

  <?php include 'esencials/navbar.php'; ?>

  <div class="container mt-4">
    <h2 style="text-align:center; margin-top:15px;">
      Resultados para "<span style="color:#ff9100;"><?= htmlspecialchars($busqueda) ?></span>"
    </h2>

    <div class="productos-row">
      <?php while ($producto = $resultado->fetch_assoc()) { ?>
        <div class="card">
          <a href="producto.php?id=<?= $producto['id'] ?>">
            <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
          </a>
          <div class="card-body">
            <h5 class="card-title"><?= $producto['nombre'] ?></h5>
            <p>$<?= $producto['precio'] ?></p>
            <button onclick='agregarAlCarrito({
              id: <?= (int)$producto["id"] ?>,
              nombre: "<?= htmlspecialchars($producto["nombre"], ENT_QUOTES) ?>",
              precio: <?= (int)$producto["precio"] ?>
            })'>
              Agregar al carrito
            </button>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>
