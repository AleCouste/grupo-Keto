<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <div class="sitio">
        <a href="http://localhost/Keto-surXamp/index.php" class="navbar-form navbar-left" >
            <img src="imagenes/keto_logo.png" alt="Logo">
        </a>
    </div>

    <form class="navbar-form" role="search" action="buscador.php" method="post">
        <input type="text" placeholder="buscar..." name="q" required>
        <button type="submit" name="submit">Buscar</button>
    </form>

    <nav class="navbar">
        <a href="carrito.php" class="btn">
            🛒
            <span id="carrito-count">(0)</span>
        </a>
    <ul>
    <span class="btn" onclick="showPopup()">👤</span>
    <div class="overlay" id="overlay" onclick="closePopup()"></div>
<?php if (isset($_SESSION['U_nombre'])): ?>
    <li>
        <div class="popup" id="popup">
            <h2>Usuario</h2>
            <span> 👤 <?php echo htmlspecialchars($_SESSION['U_nombre']); ?></span>
            <br>
            <span> 📧 <?php echo htmlspecialchars($_SESSION['U_mail']); ?></span>
            <br>
            <a href="pages/CerrarSesion.php">Cerrar sesión</a>
        </div>
    </li>
<?php else: ?>
    <div class="popup" id="popup">
        <li>
            <?php include 'pages/iniciar-sesion.php' ?>
        </li>
<?php endif; ?>

        </div>
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
        </ul>
    </nav>
</header>
      <nav class="line">
        <ul>
            <li><a href="buscador.php?q=viandas">viandas</a></li>
            <li><a href=""> snacks</a></li>
            <li><a href=""> panificados</a></li>
        </ul>
      </nav>