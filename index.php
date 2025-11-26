<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keto sur</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Marck+Script&family=Playwrite+NG+Modern:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body>
    <?php include 'esencials/navbar.php' ?>
  <main>
<br>
<!-- carrusel con hero -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="hero-slide" style="background-image:url('imagenes/hero.jpg');">
            </div>
        </div>

        <div class="carousel-item">
            <div class="hero-slide" style="background-image:url('imagenes/hero2.jpg');">
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>

<!-- los botones de las categorias-->
</div>
    <nav class="line">
        <ul class="nav-categorias">
            <li><a href="buscador.php?q=salado">salado</a></li>
            <li><a href="buscador.php?q=viandas">viandas</a></li>
            <li><a href="buscador.php?q=snacks">snacks</a></li>
            <li><a href="buscador.php?q=panificados">panificados</a></li>
            <li><a href="buscador.php?q=dulce">dulce</a></li>
            <li><a href="buscador.php?q=alfajores">alfajores</a></li>
        </ul>
    </nav>
        <h1 style="text-align: center; font-size: 60px;"> Nuestras cosas ricas</h1>
    <?php include 'mostrar.php' ?>
  </main>
    <div class="line-bottom">
        <h1>¡Recibi tu Pedido sin moverte de tu casa!</h1>
        <p>Hace tus compras más fácil y rápido. Todo lo que necesitás en un solo lugar  </p>
    </div> 
  <?php include 'esencials/footer.html' ?>
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="LD1tsm_OFfruROIkCZV7g";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>