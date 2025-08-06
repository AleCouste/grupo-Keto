<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Marck+Script&family=Playwrite+NG+Modern:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body> 
    <?php 
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>
    <header>
        <div class="sitio">
            <a href="/keto-sur/index.php">
                <img src="/" >
            </a>
        </div>
        <form class="navbar-form navbar-left" role="search" action="buscador.php" method="post">
            <input type="text" placeholder="buscar..." name="search">
            <button type="submit" name="submit">buscar</button>
        </form>
        <nav class="navbar">
            <ul>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 15">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                <?php if (isset($_SESSION['Unombre'])): ?>
            <a href="perfil.php" class="btn">
              <span class="glyphicon glyphicon-user"></span> <?php echo htmlspecialchars($_SESSION['Unombre']); ?>
            </a>
        <?php else: ?>
            <a href="pages\iniciar-secion.php" class="btn">
              <span class="glyphicon glyphicon-user"></span> Iniciar Sesión
            </a>
        <?php endif; ?>
        <?php if (isset($_SESSION['Unombre'])): ?>
            <li>
                <a href="CerrarSecion.php" class="btn">
                    <span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión
                </a>
            </li>
        <?php endif; ?>  
            </ul>
        </nav>
    </header>
</body>