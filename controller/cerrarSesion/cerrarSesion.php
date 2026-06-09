<?php
session_start();

// 1. Vaciar todas las variables de la sesión
$_SESSION = array();

// 2. Destruir la sesión en el servidor
session_destroy();

// 3. Mandar al usuario al login de patitas en la calle
header('Location: ../../view/administrarLogin/login.php');
exit;
?>