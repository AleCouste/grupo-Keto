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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>navbar</title>
    <style>
/* Contenedor del navbar */
.navbar {
    display: flex;
    align-items: center;
    gap: 15px; /* espacio entre íconos */
}

/* Para que los elementos dentro de ul queden en linea */
.navbar ul {
    display: flex;
    align-items: center;
    gap: 15px;
    list-style: none;
}

/* Color naranja del carrito y el icono user */
.navbar .btn i,
.navbar ul .btn i {
    font-size: 22px;
    color: #ff9d00; /* naranja */
    transition: 0.2s ease-in-out;
}

/* Hover moderno */
.navbar .btn i:hover,
.navbar ul .btn i:hover {
    transform: scale(1.12);
}

/* Regla para quitar espacio extraño del <span> */
.navbar ul span.btn {
    display: flex;
    cursor: pointer;
}
/* Contenedor del header */
header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
}

/* Tamaño del logo */
header .sitio img {
    height: 70px; /* aumentalo a tu gusto */
    width: auto;
}

/* Ajustes del formulario de búsqueda */
header form.navbar-form {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Input buscador */
header form input[type="text"] {
    padding: 10px 14px;      
    font-size: 16px;         
    border-radius: 8px;     
    border: 1px solid #ddd;
    width: 250px;            
}

/* Botón buscar */
header form button {
    padding: 10px 14px;
    font-size: 16px;
    background-color: #ff9d00; 
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s ease-in-out;
}

header form button:hover {
    background-color: #e48700;
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
    <a href="carrito.php" class="btn">
        <i class="fa-solid fa-cart-shopping"></i>
        <span id="carrito-count">(0)</span>
    </a>

    <ul>
        <span class="btn" onclick="showPopup()">
            <i class="fa-solid fa-user"></i>
        </span>
        <div class="overlay" id="overlay" onclick="closePopup()"></div>

        <?php if (isset($_SESSION['U_nombre'])): ?>
        <li>
            <div class="popup" id="popup" style="display:none;">
                <h2>Usuario</h2>
                
                <span>
                    <i class="fa-solid fa-user"></i>
                    <?php echo htmlspecialchars($_SESSION['U_nombre']); ?>
                </span>
                <br>
                
                <span>
                    <i class="fa-solid fa-envelope"></i>
                    <?php echo htmlspecialchars($_SESSION['U_mail']); ?>
                </span>
                <br><br>

                <a href="pages/CerrarSesion.php">
                    <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
                </a>
            </div>
        </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<nav class="line">
    <ul>
		<li><a href="buscador.php?q=salado">salado</a></li>
        <li><a href="buscador.php?q=viandas">viandas</a></li>
        <li><a href="buscador.php?q=snacks">snacks</a></li>
        <li><a href="buscador.php?q=panificados">panificados</a></li>
		<li><a href="buscador.php?q=dulce">dulce</a></li>
		<li><a href="buscador.php?q=alfajores">alfajores</a></li>
    </ul>
</nav>

<!-- Scripts del popup -->
<script>
function showPopup() {
    document.getElementById('popup').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}
function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}
</script>

</body>
</html>
