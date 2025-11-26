<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Carrito</title>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Marck+Script&family=Playwrite+NG+Modern:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <style>  
    .lista {
        font-size: 20px;
    }
    .compra {
        font-size: 2rem !important;
    }
  </style>
</head>
<body>

<?php include 'esencials/navbar.php' ?>

<div class="container mt-4">
  <h2 style="font-size: 60px;">Mi carrito</h2>
  <ul id="lista-carrito" class="list-group mb-3 lista"></ul>
  <div id="total" class="fw-bold fs-2 mt-2"></div>
  <button class="btn btn-primary mt-3 compra" onclick="FinalizarCompra()">Finalizar compra</button>
  <button class="btn btn-warning mt-2 compra" onclick="limpiarCarrito()">Vaciar carrito</button>
</div>

<script>

function actualizarContadorCarrito() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    let contador = document.getElementById('carrito-count');
    if (contador) {
        const totalProductos = carrito.reduce((sum, item) => sum + (item.cantidad || 1), 0);
        contador.textContent = `(${totalProductos})`;
    }
}


function limpiarCarrito() {
    localStorage.removeItem("carrito");
    actualizarContadorCarrito();
    document.getElementById('lista-carrito').innerHTML = "<li class='list-group-item'>El carrito está vacío</li>";
    document.getElementById('total').textContent = "";
}


function mostrarCarrito() {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const lista = document.getElementById('lista-carrito');

    if (carrito.length === 0) {
        lista.innerHTML = "<li class='list-group-item'>El carrito está vacío</li>";
        document.getElementById('total').textContent = "";
        return;
    }

    const idsUnicos = carrito.map(item => item.id);

    fetch('carrito/get_productos.php?ids=' + idsUnicos.join(','))
        .then(res => res.json())
        .then(data => {
            lista.innerHTML = "";
            let total = 0;

            if (!data || data.length === 0) {
                limpiarCarrito();
                return;
            }

            data.forEach(p => {
                let item = carrito.find(i => i.id == p.id);
                const cantidad = item.cantidad || 1;
                const precio = item.precio || parseFloat(p.precio);
                const nombre = item.nombre || p.nombre;
                const imagen = item.imagen || p.imagen;
                const subtotal = precio * cantidad;
                total += subtotal;

                let li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
                    <div class="d-flex align-items-center">
                        <img src="${imagen}" alt="${nombre}" style="width:60px; height:60px; object-fit:cover; margin-right:15px; border-radius:5px;">
                        <div>
                            <strong>${nombre}</strong><br>
                            Precio unitario: $${precio}<br>
                            Cantidad: ${cantidad}<br>
                            Subtotal: <strong>$${subtotal}</strong>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-danger compra" onclick="quitarDelCarrito(${p.id})">Quitar uno</button>
                        <button class="btn btn-sm btn-success compra" onclick="agregarAlCarrito(${p.id}, '${nombre}', ${precio}, '${imagen}')">Agregar uno</button>
                    </div>
                `;
                lista.appendChild(li);
            });

            document.getElementById('total').textContent = `Total: $${total}`;
        })
        .catch(error => {
            console.error("Error al cargar los productos del carrito:", error);
            lista.innerHTML = "<li class='list-group-item text-danger'>Error al cargar el carrito.</li>";
        });
}

function agregarAlCarrito(id, nombre, precio, imagen) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    let item = carrito.find(i => i.id == id);
    if (item) {
        item.cantidad++;
    } else {
        carrito.push({ id, nombre, precio, imagen, cantidad: 1 });
    }
    localStorage.setItem("carrito", JSON.stringify(carrito));
    mostrarCarrito();
    actualizarContadorCarrito();
}

function quitarDelCarrito(id) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    const index = carrito.findIndex(i => i.id == id);
    if (index !== -1) {
        if (carrito[index].cantidad > 1) {
            carrito[index].cantidad--;
        } else {
            carrito.splice(index, 1);
        }
    }
    localStorage.setItem("carrito", JSON.stringify(carrito));
    mostrarCarrito();
    actualizarContadorCarrito();
}


function procesarCompra() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (carrito.length === 0) {
        alert("El carrito está vacío.");
        return;
    }

    fetch('carrito/procesar_compra.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ carrito: carrito })
    })
    .then(res => res.json())
    .then(data => {
        console.log("Respuesta de PHP:", data);
        if (data.items && data.items.length > 0) {
            alert("Compra procesada. Total: $" + data.total);
            limpiarCarrito();
        } else {
            alert("Error: carrito vacío o inválido");
        }
    })
    .catch(err => console.error("Error en procesarCompra:", err));
}


document.addEventListener('DOMContentLoaded', () => {
    mostrarCarrito();
    actualizarContadorCarrito();
});   

function enviarPedidoWhatsApp(numero = "5491157315312") {

    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (carrito.length === 0) {
        alert("El carrito está vacío");
        return;
    }

    let mensaje = "🛒 Pedido:\n";
    let total = 0;

    carrito.forEach(item => {
        mensaje += `${item.cantidad} x ${item.nombre} - $${item.precio * item.cantidad}\n`;
        total += item.precio * item.cantidad;
    });

    mensaje += `\nTotal: $${total}`;

    let mensajeCodificado = encodeURIComponent(mensaje);

    let url = `https://wa.me/${numero}?text=${mensajeCodificado}`;

    window.open(url, "_blank");
}

function FinalizarCompra() {
    enviarPedidoWhatsApp();
    procesarCompra();
}


</script>

</body>
</html>
