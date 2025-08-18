<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "keto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
$resultado = mysqli_query($conn, "SELECT * FROM productos ORDER BY ID");

while ($row = mysqli_fetch_assoc($resultado)) { ?>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="carrito.js" defer></script>
</head>
<body>
<div class="container mt-4">
  <div class="row">
    <?php
    $resultado = $conn->query("SELECT * FROM productos");
    while ($producto = $resultado->fetch_assoc()) {
    ?>
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="Imagen">
          <div class="card-body">
            <h5 class="card-title"><?= $producto['nombre'] ?></h5>
            <p><strong>$<?= $producto['precio'] ?></strong></p>
            <p>Stock disponible: <?= $producto['stock'] ?></p>
            <script>
              function Toast() {
                  Toastify({
                    text: "¡Compra realizada con éxito!",
                    duration: 3000,
                    gravity: "top", // top o bottom
                    position: "right", // left, center o right
                    backgroundColor: "#4CAF50",
                    close: true
                  }).showToast();
              }
            </script>
            <button class="btn btn-success" onclick="Toast(); agregarAlCarrito(<?= $producto['id'] ?>)" <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>Agregar al carrito</button>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<?php } ?>
</body>