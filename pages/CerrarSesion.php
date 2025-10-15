<?php

session_start();

$_SESSION = array();

session_destroy();

header("Location: http://localhost/keto-surXamp/index.php");
exit();
?>
