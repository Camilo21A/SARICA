<?php
session_start();
include '../../model/conexion_db_Sarica.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../view/administrarLogin/login.php');
    exit;
}

$id  = intval($_GET['id']);
$sql = "DELETE FROM denunciante WHERE idDenunciante = $id";
$resultado = mysqli_query($conexionbd, $sql);

if ($resultado) {
    header('Location: ../../view/administrarDenunciantes/denunciantes.php?exito=eliminar');
} else {
    header('Location: ../../view/administrarDenunciantes/denunciantes.php?error=1');
}
exit;
?>