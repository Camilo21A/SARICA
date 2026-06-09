<?php
$db_servidor = "localhost";
$db_usuario = "Camilo";
$db_contrasena = "camilo09042006";
$db_nombre = "db_sarica";

$conexionbd = mysqli_connect($db_servidor, $db_usuario, $db_contrasena, $db_nombre);

if (mysqli_connect_errno()) {
  echo "Fallo al conectar con la base de datos.";
  exit();
/* } else {
  echo "Conexion exitosa."; */
}

mysqli_set_charset($conexionbd, "utf8");
?>