<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keto Sur</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class=" top-line">
        <b>retiro en todas nuentras sucursales 📦</b>
    </div>
<?php include 'C:\xampp\htdocs\keto-sur\esencials\navbar.php' ?>
<style>
    p img{
        width: 250px;
    }
</style>
<?php
if (isset($_POST['submit'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "keto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Limpieza del dato ingresado
    $searchString = mysqli_real_escape_string($conn, trim(htmlentities($_POST['search'])));

    // Validaciones básicas
    if ($searchString === "" || !ctype_alnum($searchString) || strlen($searchString) < 3) {
        echo "Búsqueda inválida";
        exit();
    }

    $searchString = "%$searchString%";

    $sql = "SELECT * FROM productos WHERE categoria LIKE ?";

    // Preparar y ejecutar la consulta
    $prepared_stmt = $conn->prepare($sql);

    if (!$prepared_stmt) {
        echo "Error en la preparación de la consulta: " . $conn->error;
        exit();
    }

    $prepared_stmt->bind_param('s', $searchString);
    $prepared_stmt->execute();

    $result = $prepared_stmt->get_result();

    if ($result->num_rows === 0) {
        echo "No se encontraron productos.";
    } else {
    while ($row = $result->fetch_assoc()) { 
        ?>
        <div class="col-sm-3">
            <div class="panel">
                <div class="panel-heading" style="text-align: center;"><?php echo $row['nombre'] ?> </div>
                    <p class="panel-body"><img class="imagen" src='https://cdn.pixabay.com/photo/2018/11/22/18/17/elephant-3832516_640.jpg' alt='test'></p>
                <div class="panel-footer" style="text-align: center;"> $<?php echo $row['precio'] ?> </div>
            </div>
        </div>
    <?php
        }
    }

    // Cerrar conexión
    $prepared_stmt->close();
    $conn->close();

} else {
    echo "¡Acceso no permitido!";
    exit();
}
?>
</body>
</html>