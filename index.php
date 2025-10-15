<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
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
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body>
    <div class=" top-line">
        <b>retiro en todas nuentras sucursales 📦</b>
    </div>
    <?php include 'esencials/navbar.php' ?>
  <main>
        <?php include 'carrusel.html' ?>
            <h1 style="text-align: center;">nuestras cosas ricas</h1>
        <?php include 'mostrar.php' ?>
  </main>
<footer>
  <div class="links">
    <ul>
      <b>compra online</b>
      <li><a href="compra.html">mis pedidos</a></li>
      <li><a href="compra.html">historial de compra</a></li>
    </ul>

    <ul>
      <b>atencion al cliente</b>
      <li><a href="https://www.instagram.com/keto_sur/" class="fa fa-instagram"> Instagram</a></li>
      <li><a href="https://api.whatsapp.com/send/?phone=5491157315312" class="fa fa-whatsapp"> WhatsApp Berazategui</a></li>
      <li><a href="https://api.whatsapp.com/send/?phone=5491171252770" class="fa fa-whatsapp"> WhatsApp La Plata</a></li>
    </ul>

    <ul>
      <b>sobre nosotros</b>
      <li><a href="compra.html">mis pedidos</a></li>
      <li><a href="compra.html">historial de compra</a></li>
      <li><a href="compra.html">mis pedidos</a></li>
    </ul>

    <ul>
      <b>contactanos</b>
      <li><a href="compra.html">mis pedidos</a></li>
      <li><a href="compra.html">historial de compra</a></li>
      <li><a href="compra.html">mis pedidos</a></li>
    </ul>
  </div>

  <p>© Keto Sur. Todos los derechos reservados.</p>
  <p>Av. 14 127 - Berazategui</p>
</footer>

<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="LD1tsm_OFfruROIkCZV7g";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>