<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros</title>
    <link rel="stylesheet" href="../style.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
  #map1, #map2 {
      width: 100%;
      height: 400px; /* o lo que prefieras */
      border-radius: 10px;
      margin-bottom: 20px;
  }
</style>


</head>
<body>

<?php include 'navbar.php' ?>

<main>
    <h1>Sobre Nosotros</h1>
    <p>
        En <strong>Keto sur</strong> nos dedicamos a ofrecer productos saludables, nutritivos y deliciosos, 
        especialmente diseñados para acompañarte en tu estilo de vida keto.  
        Creemos que comer sano no significa renunciar al sabor, por eso seleccionamos cuidadosamente cada ingrediente 
        para que disfrutes de lo mejor de la alimentación cetogénica.
    </p>
    <br>
    <p>
        Nuestro local está ubicado en una zona céntrica y de fácil acceso. Te invitamos a visitarnos para conocer 
        nuestras viandas, snacks y panificados saludables. Nuestro equipo estará encantado de asesorarte y ayudarte 
        a elegir los productos ideales para vos.
    </p>
    <br>
        Actualmente contamos con dos locales donde podés visitarnos, realizar tus compras y conocer más sobre nuestra línea de productos keto y saludables.
    </p>

    <div class="map-container">
        <h2>📍 Local 1 - Av. 14 (Buenos Aires)</h2>
        <p>Dirección: Av. 14 126 y 127, B1884 Buenos Aires, Provincia de Buenos Aires</p>
        <div id="map1"></div>
    </div>

    <div class="map-container">
        <h2>📍 Local 2 - Diagonal 74 (La Plata)</h2>
        <p>Dirección: Diag. 74 1575, B1902 La Plata, Provincia de Buenos Aires</p>
        <div id="map2"></div>
    </div>
</main>

<?php include 'footer.html' ?>

<script>
// Inicializar ambos mapas
document.addEventListener("DOMContentLoaded", function() {
    // Local 1 - Av. 14
    const map1 = L.map('map1').setView([-34.791204, -58.278307], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map1);
    L.marker([-34.791204, -58.278307]).addTo(map1)
        .bindPopup("<b>Keto-surXamp - Local Av. 14</b><br>Av. 14 126 y 127, B1884 Buenos Aires.")
        .openPopup();

    // Local 2 - Diagonal 74
    const map2 = L.map('map2').setView([-34.922978, -57.954607], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map2);
    L.marker([-34.922978, -57.954607]).addTo(map2)
        .bindPopup("<b>Keto-surXamp - Local La Plata</b><br>Diag. 74 1575, B1902 La Plata.")
        .openPopup();
});
</script>

</body>
</html>