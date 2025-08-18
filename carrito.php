<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Carrito</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Marck+Script&family=Playwrite+NG+Modern:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class=" top-line">
    <b>retiro en todas nuentras sucursales 📦</b>
</div>
<?php include 'esencials/navbar.php' ?>
<div class="container mt-4">
  <h2>Mi carrito</h2>
  <ul id="lista-carrito" class="list-group mb-3"></ul>
  <div id="total" class="fw-bold fs-5 mt-2"></div>
  <button class="btn btn-primary mt-3" onclick="procesarCompra()">Finalizar compra</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

  if (carrito.length === 0) {
    document.getElementById('lista-carrito').innerHTML = "<li class='list-group-item'>El carrito está vacío</li>";
    return;
  }

  // Agrupar por ID (como strings para compatibilidad)
  const cantidades = {};
  carrito.forEach(ID => {
    const strID = ID.toString();
    cantidades[strID] = (cantidades[strID] || 0) + 1;
  });

  const idsUnicos = Object.keys(cantidades);

  fetch('carrito/get_productos.php?ids=' + idsUnicos.join(','))
    .then(res => res.json())
    .then(data => {
      const lista = document.getElementById('lista-carrito');
      let total = 0;

      data.forEach(p => {
        const cantidad = cantidades[p.id.toString()];
        const precio = parseFloat(p.precio);
        const subtotal = precio * cantidad;
        total += subtotal;

        let li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `
          <div>
            <strong>${p.nombre}</strong><br>
            Cantidad: ${cantidad}<br>
            Precio unitario: $${precio}<br>
            Subtotal: <strong>$${subtotal}</strong>
          </div>
          <button class="btn btn-sm btn-danger" onclick="quitarDelCarrito(${p.id})">Quitar uno</button>
        `;
        lista.appendChild(li);
      });

      document.getElementById('total').textContent = `Total: $${total}`;
    })
    .catch(error => {
      console.error("Error al cargar los productos del carrito:", error);
      document.getElementById('lista-carrito').innerHTML = "<li class='list-group-item'>Error al cargar el carrito.</li>";
    });
});

function quitarDelCarrito(id) {
  let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

  // Quitar solo una unidad
  const index = carrito.indexOf(id);
  if (index !== -1) carrito.splice(index, 1);

  localStorage.setItem("carrito", JSON.stringify(carrito));
  location.reload();
}

function procesarCompra() {
  let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

  if (carrito.length === 0) {
    alert("El carrito está vacío.");
    return;
  }

  fetch('carrito/procesar_compra.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ carrito: carrito })
  })
  .then(res => res.text())
  .then(msg => {
    alert(msg);
    localStorage.removeItem('carrito');
    location.reload();
  });
}
</script>
</body>
</html>
