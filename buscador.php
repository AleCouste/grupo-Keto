<!DOCTYPE html>
<html lang="en">
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
    <link rel="stylesheet" href="style.css">
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
.productos-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

.productos-row .card {
  flex: 1 1 calc(33.333% - 20px); /* 🔥 3 por fila en PC */
  min-width: 220px;
  max-width: 320px;
  display: flex;
  flex-direction: column;
  border: none;
  box-shadow: 0 6px 10px rgba(0,0,0,0.05);
  transition: transform 0.2s ease-in-out;
}

.productos-row .card:hover {
  transform: scale(1.04);
}

/* Imágenes responsivas */
.productos-row .card .card-img-top {
  width: 100%;
  height: auto;
  max-height: 250px;     /* límite en PC */
  object-fit: cover;
  object-position: center;
  border-radius: 6px 6px 0 0;
  transition: transform 0.3s ease;
}

.productos-row .card .card-img-top:hover {
  transform: scale(1.05);
}

/* Tablet: 2 por fila */
@media (max-width: 992px) {
  .productos-row .card {
    flex: 1 1 calc(50% - 20px);
  }
  .productos-row .card .card-img-top {
    max-height: 200px;
  }
}

/* Celular: 1 por fila */
@media (max-width: 576px) {
  .productos-row .card {
    flex: 1 1 100%;
  }
  .productos-row .card .card-img-top {
    max-height: 160px;
  }
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
    $busqueda = isset($_REQUEST['q']) ? $_REQUEST['q'] : "";

    // Preparar y ejecutar la consulta segura
    $stmt = $conn->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR categoria LIKE ?");
    $like = "%" . $busqueda . "%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $resultado = $stmt->get_result();
?>

<div class="container mt-4">
  <h2>Resultados para "<?= htmlspecialchars($busqueda) ?>"</h2>
<div class="container mt-4">
  <div class="productos-row">
    <?php while ($producto = $resultado->fetch_assoc()) { ?>
      <div class="card">
        <a href="producto.php?id=<?= $producto['id'] ?>">
          <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="Imagen del producto">
        </a>
        <div class="card-body">
          <h5 class="card-title"><?= $producto['nombre'] ?></h5>
          <p><strong>$<?= $producto['precio'] ?></strong></p>
          <p>Stock disponible: <?= $producto['stock'] ?></p>
          <script>
            function Toast() {
              Toastify({
                text: "¡Producto agregado al carrito!",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50",
                close: true
              }).showToast();
            }
          </script>
          <button class="btn btn-success"
                  onclick="Toast(); agregarAlCarrito(<?= $producto['id'] ?>)"
                  <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>
            Agregar al carrito
          </button>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
</body>
<?php } ?>
</html>