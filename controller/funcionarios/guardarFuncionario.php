<?php
session_start();
include '../../model/conexion_db_Sarica.php';

/* ── Verificar sesión activa ────────────────────────────────────── */
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../view/administrarLogin/login.php');
    exit;
}

/* ── Recoger datos del formulario ───────────────────────────────── */
$accion         = $_POST['accion'];
$nombre         = $_POST['nombre'];
$apellido       = $_POST['apellido'];
$tipoDocumento  = $_POST['tipoDocumento'];
$numeroDoc      = $_POST['numeroDocumento'];
$telefono       = $_POST['telefono'];
$correo         = $_POST['correo'];
$rol            = $_POST['rol'];
$idCargo        = intval($_POST['idCargo']);
$contrasena     = $_POST['contrasena'];

if ($accion === 'crear') {

    /* ── Hashear la contraseña con SHA2-256 igual que el sistema ── */
    $hash = hash('sha256', $contrasena);

    $sql = "INSERT INTO funcionarios
                (idCargo, nombre, apellido, tipoDocumento, numeroDocumento, telefono, correo, contrasena, rol)
            VALUES
                ($idCargo, '$nombre', '$apellido', '$tipoDocumento', '$numeroDoc', '$telefono', '$correo', '$hash', '$rol')";

    $resultado = mysqli_query($conexionbd, $sql);

    if ($resultado) {
        header('Location: ../../view/gestionarFuncionarios/funcionarios.php?exito=crear');
    } else {
        header('Location: ../../view/gestionarFuncionarios/funcionarios.php?error=1');
    }

} elseif ($accion === 'editar') {

    $id = intval($_POST['idFuncionario']);

    /* ── Si mandó contraseña nueva la hasheamos, si no la dejamos── */
    if (!empty($contrasena)) {
        $hash    = hash('sha256', $contrasena);
        $sqlClave = ", contrasena = '$hash'";
    } else {
        $sqlClave = '';
    }

    $sql = "UPDATE funcionarios SET
                idCargo         = $idCargo,
                nombre          = '$nombre',
                apellido        = '$apellido',
                tipoDocumento   = '$tipoDocumento',
                numeroDocumento = '$numeroDoc',
                telefono        = '$telefono',
                correo          = '$correo',
                rol             = '$rol'
                $sqlClave
            WHERE idFuncionarios = $id";

    $resultado = mysqli_query($conexionbd, $sql);

    if ($resultado) {
        header('Location: ../../view/gestionarFuncionarios/funcionarios.php?exito=editar');
    } else {
        header('Location: ../../view/gestionarFuncionarios/funcionarios.php?error=1');
    }
}
exit;
?>