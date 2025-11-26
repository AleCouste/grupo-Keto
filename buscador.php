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
  .product-page-image-container {
      display: flex;
      justify-content: center;
      align-items: center;
  }

  .product-page-image {
      display: block;
      max-width: 500px;
      width: 90%;
      margin: 2rem auto;
      border-radius: var(--border-radius);
      box-shadow: 0 4px 12px var(--shadow-light);
  }

  .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
      padding: 2rem;
      max-width: 1400px;
      margin: 0 auto;
  }

  .card {
    display: flex;
    flex-direction: column;
    background: var(--background-white);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: 0 2px 10px var(--shadow-light);
    transition: all 0.3s ease;
  }

  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 16px var(--shadow-strong);
  }

  .card .card-image-link {
    display: block;
    height: 220px;
    overflow: hidden;
  }

  .card .card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .card:hover .card-image {
    transform: scale(1.05);
  }

  .card-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex-grow: 1;
  }

  .card-title {
    font-size: 2.2rem;
    text-align: center
    font-weight: 600;
    color: var(--text-dark);
  }

  .card-price {
    font-size: 1.8rem;
    font-weight: 500;
    color: var(--primary-color);
  }

  .btn {
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    background: linear-gradient(90deg, #ffb347, var(--primary-color));
    color: var(--text-light);
    cursor: pointer;
    font-size: 1.8rem;
    font-weight: 500;
    transition: all 0.3s ease;
    text-align: center;
    text-decoration: none;
    margin-top: auto;
  }

  .btn:hover {
    background: var(--primary-hover);
    transform: translateY(-2px);
  }

  @media (max-width: 992px) {
      body {
          padding-top: 120px; 
      }
      .new-main-header {
          height: 70px;
      }
      .new-search-form {
          padding: 0 20px;
      }
      .new-main-nav ul {
          gap: 15px;
      }
      .new-main-nav a {
          font-size: 1rem;
      }
  }

  @media (max-width: 768px) {
      body {
          padding-top: 180px; 
      }
      .new-header-container {
          padding: 0 15px;
      }
      .new-main-header {
          flex-wrap: wrap;
          height: auto;
          padding: 15px 0;
      }
      .logo-wrapper {
          width: 100%;
          text-align: center;
          margin-bottom: 15px;
          order: 1;
      }
      .new-search-form {
          order: 3;
          width: 100%;
          padding: 0;
          margin-top: 15px;
      }
      .new-header-icons {
          order: 2;
          width: auto;
      }
      .new-main-nav ul {
          flex-wrap: wrap;
          justify-content: center;
          gap: 10px;
      }
      .new-main-nav a {
          font-size: 0.9rem;
      }
  }
  </style>
</head>

<body>
  <?php include 'esencials/navbar.php'; ?>

  <div class="container mt-4">
    <h2 style="text-align:center; margin-top:15px;">
      Resultados para "<span style="color:#ff9100;"><?= htmlspecialchars($busqueda) ?></span>"
    </h2>

<!-- mismo bloque para mostrar productos -->
  <div class="product-grid">
    <?php while ($producto = $resultado->fetch_assoc()) { ?>
      <div class="card">
        <a href="producto.php?id=<?= $producto['id'] ?>" class="card-image-link">
          <img src="<?= $producto['imagen'] ?>" class="card-image" alt="<?= htmlspecialchars($producto['nombre']) ?>">
        </a>
        <div class="card-content">
          <h3 class="card-title"><?= $producto['nombre'] ?></h3>
          <p class="card-price">$<?= $producto['precio'] ?></p>
          <button class="btn" onclick='agregarAlCarrito({
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
</body>
</html>
