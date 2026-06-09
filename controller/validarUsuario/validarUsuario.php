<?php
session_start();
// Asegúrate de que la ruta sea correcta según donde ubiques este archivo
include '../../model/conexion_db_Sarica.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos de los inputs del HTML basándonos en su atributo 'name'
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rol = trim($_POST['rol']);

    // 1. Buscamos al usuario ÚNICAMENTE por su correo electrónico
    $consulta = $conexionbd->prepare("SELECT * FROM funcionarios WHERE correo = ?");

   // 2. Ejecutar pasando solo el correo

    // Esta linea era la que estaba ANTESSS
    // ////////////////////// : 
    /* $consulta->execute([$email]); */

    // ESTAS DOS SON LAS QUE SE AGREGARON: 
    $consulta->bind_param("s", $email);
    $consulta->execute();

    // 3. Obtenemos el objeto de resultado del statement
    $resultado = $consulta->get_result();

    // Luego extraemos la fila como un arreglo asociativo
    $usuario = $resultado->fetch_assoc();

    // ========================================================
    // CONTROL DE ERRORES PASO A PASO
    // ========================================================

    // PASO A: ¿El correo existe en la base de datos?
    if (!$usuario) {
        // Si no existe el correo, mandamos error genérico
        header('Location: ../../view/administrarLogin/login.php?error=1');
        exit;
    }

    // PASO B: El correo existe, pero ¿el rol elegido coincide con el de la DB?
    if ($usuario['rol'] !== $rol) {
        // Si el rol es diferente, mandamos explícitamente el error de rol
        header('Location: ../../view/administrarLogin/login.php?error=rol');
        exit;
    }

    // PASO C: El correo y el rol coinciden perfectamente. ¿La contraseña es correcta?
    if (hash('sha256', $password) === $usuario['contrasena']) {
        // Credenciales correctas: Iniciar sesión

        $_SESSION['usuario_id'] = $usuario['idFuncionarios'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_apellido'] = $usuario['apellido'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        // Redirigir al panel principal
        header('Location: ../../view/administrarHome/home.php');
        exit;
    } else {
        // Si la contraseña no coincide, mandamos error de credenciales
        header('Location: ../../view/administrarLogin/login.php?error=1');
        exit;
    }
} else {
    // Si alguien intenta acceder a este archivo directamente sin mandar datos, lo devolvemos al login.
    header('Location: ../../view/administrarLogin/login.php');
    exit;
}
?>