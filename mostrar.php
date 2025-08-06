<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "keto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
$resultado = mysqli_query($conn, "SELECT * FROM productos ORDER BY ID");

while ($row = mysqli_fetch_assoc($resultado)) { ?>
<style>
    .imagen {
      width: 270px;
      height: auto;
    }
    .panel-heading{
        background-color: #f4851e;
        color: black;
    }
</style>
    <div class="col-sm-3">
        <div class="panel">
            <div class="panel-heading" style="text-align: center;"><?php echo $row['nombre'] ?> </div>
            <p class="panel-body"> <img class="imagen" src='https://cdn.pixabay.com/photo/2018/11/22/18/17/elephant-3832516_640.jpg' alt='test'></p>
            <div class="panel-footer" style="text-align: center;"> $<?php echo $row['precio'] ?> </div>
        </div>
    </div>
<?php
}

?>
