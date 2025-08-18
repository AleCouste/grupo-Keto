<?php
session_start(); // Iniciar sesión (necesario para manipularla)

// Eliminar todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión (puedes cambiar la URL)
header("Location: ../index.php");
exit();
?>
