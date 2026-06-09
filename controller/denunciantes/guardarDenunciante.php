<?php
session_start();
include '../../model/conexion_db_Sarica.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../view/administrarLogin/login.php');
    exit;
}

$accion        = $_POST['accion'];
$nombre        = $_POST['nombre'];
$apellido      = $_POST['apellido'];
$tipoDocumento = $_POST['tipoDocumento'];
$numeroDoc     = $_POST['numeroDocumento'];
$genero        = $_POST['genero'];
$estadoCivil   = $_POST['estadoCivil'];
$telefono      = $_POST['telefono'];
$correo        = $_POST['correoElectronico'];
$direccion     = $_POST['direccion'];

// idMunicipio e idDepartamento
$idMunicipio    = intval($_POST['idMunicipio']);
$idDepartamento = intval($_POST['idDepartamento']);

if ($accion === 'crear') {
    $sql = "INSERT INTO denunciante (nombre, apellido, tipoDocumento, numeroDocumento, genero, estadoCivil, telefono, correoElectronico, direccion, idMunicipio, idDepartamento)
            VALUES ('$nombre', '$apellido', '$tipoDocumento', '$numeroDoc', '$genero', '$estadoCivil', '$telefono', '$correo', '$direccion', $idMunicipio, $idDepartamento)";
    $resultado = mysqli_query($conexionbd, $sql);
    if ($resultado) {
        header('Location: ../../view/administrarDenunciantes/denunciantes.php?exito=crear');
    } else {
        header('Location: ../../view/administrarDenunciantes/denunciantes.php?error=1');
    }

} elseif ($accion === 'editar') {
    $id  = $_POST['idDenunciante'];
    $sql = "UPDATE denunciante SET
                nombre = '$nombre',
                apellido = '$apellido',
                tipoDocumento = '$tipoDocumento',
                numeroDocumento = '$numeroDoc',
                genero = '$genero',
                estadoCivil = '$estadoCivil',
                telefono = '$telefono',
                correoElectronico = '$correo',
                direccion = '$direccion'
            WHERE idDenunciante = $id";
    $resultado = mysqli_query($conexionbd, $sql);
    if ($resultado) {
        header('Location: ../../view/administrarDenunciantes/denunciantes.php?exito=editar');
    } else {
        header('Location: ../../view/administrarDenunciantes/denunciantes.php?error=1');
    }
}
exit;
?>