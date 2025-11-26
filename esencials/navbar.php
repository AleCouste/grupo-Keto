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
    <title>navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<style>
    .navbar {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .navbar ul {
        display: flex;
        align-items: center;
        gap: 15px;
        list-style: none;
    }

    /* iconos */
    .navbar .btn i,
    .navbar ul .btn i {
        font-size: 30px;
        color: #ff9d00;
        transition: 0.2s ease-in-out;
    }
    .navbar .btn i:hover,
    .navbar ul .btn i:hover {
        transform: scale(1.12);
    }

    /* header */
    header {
        background-color: #f0eceaff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
    }

    /* logo */
    header .sitio img {
        height: 110px;
        width: auto;
        border-radius: 50%;
        object-fit: cover;  
    }

    /* buscador */
    header form.navbar-form {
        display: flex;
        align-items: center;
        gap: 0; 
    }

    header form input[type="text"] {
        padding: 14px 18px;       
        font-size: 18px;           
        border-radius: 10px 0 0 10px; 
        border: 2px solid #ffcb80;
        border-right: none;        
        width: 300px;              
        background: #fff;
        transition: 0.25s;
    }

    header form input[type="text"]:focus {
        border-color: #ff9d00;
        outline: none;
        box-shadow: 0 0 6px rgba(255,157,0,0.4);
    }

    header form button {
        padding: 14px 20px;        
        font-size: 18px;           
        background: #ff9d00;
        color: white;
        border: 2px solid #ff9d00;
        border-radius: 0 10px 10px 0; 
        cursor: pointer;
        font-weight: 600;
        transition: 0.25s;
    }

    header form button:hover {
        background: #e48700;
    }

    /*  Offcanvas osea el panel lateral del carrito */
    .offcanvas {
        background-color: #fffaf2;
        width: 340px;
    }
    .offcanvas-header {
        background-color: #ff9d00;
        color: white;
    }
    .offcanvas-body {
        overflow-y: auto;
    }


    #offcanvasCarrito .text-muted {
        font-size: 2rem !important;   
        font-weight: 600;             
        color: #555 !important;       
    }


    #offcanvasCarrito .btn-warning {
        font-size: 1.6rem !important; 
        padding: 14px 24px !important;  
        border-radius: 12px;            
    }

    #offcanvasCarrito .carrito-item {
        font-size: 1.6rem; 
    }

    #offcanvasCarrito .carrito-item strong,
    #offcanvasCarrito .carrito-item b {
        font-size: 1.8rem;
    }

    #offcanvasCarrito .carrito-item p {
        font-size: 1.5rem;
        margin: 2px 0;
    }

    .carrito-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }
    .carrito-item img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 10px;
    }
    .carrito-item button {
        border: none;
        background: none;
        color: #ff4d4d;
        font-size: 18px;
        cursor: pointer;
    }
    .carrito-total {
        font-weight: bold;
        font-size: 18px;
        text-align: center;
        margin-top: 10px;
    }
    </style>
</head>
<body>

<header>
    <div class="sitio">
        <a href="http://localhost/Keto-surXamp/index.php" class="navbar-form navbar-left">
            <img src="imagenes/keto_logo.png" alt="Logo">
        </a>
    </div>

    <form class="navbar-form" role="search" action="buscador.php" method="post">
        <input type="text" placeholder="Buscar..." name="q" required>
        <button type="submit" name="submit">Buscar</button>
    </form>

    <nav class="navbar">
        <!-- todo esto es para el carrito -->
        <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCarrito" aria-controls="offcanvasCarrito" style="background:none; border:none;">
            <i class="fa-solid fa-cart-shopping"></i>
            <span id="carrito-count">(0)</span>
        </button>

        
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarrito" aria-labelledby="offcanvasCarritoLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasCarritoLabel">🛒 Tu Carrito</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body">
                <div id="carrito-items">
                    <p class="text-center text-muted">El carrito está vacío</p>
                </div>
                <div class="carrito-total" id="carrito-total"></div>
            <div class="text-center mt-3">
                <a href="carrito.php" class="btn btn-warning">
                    Finalizar compra
                </a>
            </div>
        </div>
        </div>
<!-- esto es para los usuarios -->
        <ul>
            <li>
                <span class="btn" onclick="showPopup()" style="background:none; border:none;">
                    <i class="fa-solid fa-user"></i>
                </span>
            </li>

            <div class="overlay" id="overlay" onclick="closePopup()" style="display:none;"></div>

            <?php if (isset($_SESSION['U_nombre'])): ?>
            <li>
                <div class="popup" id="popup" style="display:none;">
                    <h2>Usuario</h2>
                    <span><i class="fa-solid fa-user"></i> <?= htmlspecialchars($_SESSION['U_nombre']); ?></span><br>
                    <span><i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($_SESSION['U_mail']); ?></span><br><br>
                    <a href="pages/CerrarSesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
                </div>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<!-- todos los scripts para las utilidades -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// script popup usuario
function showPopup() {
    const popup = document.getElementById('popup');
    const overlay = document.getElementById('overlay');
    if (!popup) return; // Evita error si no hay sesión
    popup.style.display = 'block';
    overlay.style.display = 'block';
}

function closePopup() {
    const popup = document.getElementById('popup');
    const overlay = document.getElementById('overlay');
    if (popup) popup.style.display = 'none';
    overlay.style.display = 'none';
}


// scripts que muestran los productos en el costado
function mostrarCarritoLateral() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    let contenedor = document.getElementById("carrito-items");
    let totalDiv = document.getElementById("carrito-total");
    contenedor.innerHTML = "";
    let total = 0;

    if (carrito.length === 0) {
        contenedor.innerHTML = `<p class="text-center text-muted">El carrito está vacío</p>`;
        totalDiv.textContent = "";
        return;
    }

    carrito.forEach((item, index) => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        contenedor.innerHTML += `
            <div class="carrito-item">
                <img src="${item.imagen || 'imagenes/default.png'}" alt="${item.nombre}">
                <div class="flex-grow-1">
                    <strong>${item.nombre}</strong><br>
                    Cant: ${item.cantidad} | $${subtotal}
                </div>
                <button onclick="quitarDelCarrito(${index})"><i class="fa-solid fa-trash"></i></button>
            </div>
        `;
    });

    totalDiv.textContent = `Total: $${total}`;
}

// script que quita los productos del carrito
function quitarDelCarrito(index) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    carrito.splice(index, 1);
    localStorage.setItem("carrito", JSON.stringify(carrito));
    mostrarCarritoLateral();
    actualizarContadorCarrito();
}

// script que actualiza el contador
function actualizarContadorCarrito() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    let total = carrito.reduce((sum, item) => sum + (item.cantidad || 1), 0);
    document.getElementById("carrito-count").textContent = `(${total})`;
}

// script que actualiza el panel cuando se abre
document.addEventListener("DOMContentLoaded", () => {
    actualizarContadorCarrito();
    mostrarCarritoLateral();

    const offcanvasCarrito = document.getElementById("offcanvasCarrito");
    offcanvasCarrito.addEventListener("show.bs.offcanvas", mostrarCarritoLateral);
});
</script>

</body>
</html>
