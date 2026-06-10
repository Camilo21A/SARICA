<?php
session_start();
include '../../model/conexion_db_Sarica.php';

/* ── Verificar sesión activa ────────────────────────────────────── */
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../view/administrarLogin/login.php');
    exit;
}

/* ── Eliminar el funcionario por su id ──────────────────────────── */
$id  = intval($_GET['id']);
$sql = "DELETE FROM funcionarios WHERE idFuncionarios = $id";
$resultado = mysqli_query($conexionbd, $sql);

if ($resultado) {
    header('Location: ../../view/gestionarFuncionarios/funcionarios.php?exito=eliminar');
} else {
    header('Location: ../../view/gestionarFuncionarios/funcionarios.php?error=1');
}
exit;
?>