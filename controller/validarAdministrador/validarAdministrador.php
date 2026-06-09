<?php
session_start();

include '../../model/conexion_db_Sarica.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../view/administrarLogin/login.php');
    exit;
}

/* ── Restricción estricta por rol ───────────────────────────── */
if ($_SESSION['usuario_rol'] !== 'Administrador') {
    /* Devuelve a la misma vista con error de privilegios */
header('Location: ../../view/administrarHome/home.php?modal=confirmar&error=privilegios');
    exit;
}
/* ── Solo aceptar peticiones POST ───────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../view/administrarHome/home.php.php');
    exit;
}

/* ── Recoger la contraseña enviada desde el formulario ─────────── */
$contrasena = trim($_POST['contrasena'] ?? '');

if (empty($contrasena)) {
    header('Location: ../../view/administrarHome/home.php?modal=confirmar&error=vacia');
    exit;
}

/* ── Buscar al funcionario por su id de sesión                      */
/* y verificar simultáneamente que su rol sea 'Administrador'       */
$consulta = $conexionbd->prepare("
    SELECT contrasena 
    FROM funcionarios 
    WHERE idFuncionarios = ? 
    AND rol = 'Administrador'
");
$consulta->bind_param("i", $_SESSION['usuario_id']);
$consulta->execute();

/* ── Obtener el resultado ───────────────────────────────────────── */
$resultado   = $consulta->get_result();
$funcionario = $resultado->fetch_assoc();

if (!$funcionario) {
    /* El usuario no existe o no tiene rol de Administrador */
header('Location: ../../view/administrarHome/home.php?modal=confirmar&error=usuario');
    exit;
}

/* ── Comparar contraseña ingresada con el hash SHA2 de la BD ─────── */
/* SHA2('contrasena', 256) en MySQL  ===  hash('sha256', $contrasena) en PHP */
if (hash('sha256', $contrasena) === $funcionario['contrasena']) {
    /*  Rol y contraseña correctos: redirigir a página temporal */
    header('Location: ../../view/gestionarFuncionarios/listFuncionarios.php');
    exit;
} else {
    /*  Contraseña incorrecta */
    header('Location: ../../view/administrarHome/home.php?modal=confirmar&error=incorrecta');
    exit;
}
