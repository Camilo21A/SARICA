<?php
session_start();
include '../../model/conexion_db_Sarica.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../view/administrarLogin/login.php');
    exit;
}

$idFuncionario = $_SESSION['usuario_id'];
$idDenunciante = $_POST['idDenunciante'];
$numeroCaso = $_POST['numeroCaso'];
$lugarIncautacion = $_POST['lugarIncautacion'];
$fechaIncautacion = $_POST['fechaIncautacion'];
$descripcionSolicitud = $_POST['descripcionSolicitud'];
$tipoDispositivo = $_POST['tipoDispositivo'];
$marcaModelo = $_POST['marcaModelo'];
$numeroSerieIMEI = $_POST['numeroSerieIMEI'];
$estadoFuncional = $_POST['estadoFuncional'];
$codigoEtiqueta = $_POST['codigoEtiqueta'];
$hashVerificacion = $_POST['hashVerificacion'] ?: 'N/A';
$horaActual = date('H:i:s');

// Obtener idMunicipio e idDepartamento del denunciante
$qDen = mysqli_query($conexionbd, "SELECT idMunicipio, idDepartamento FROM denunciante WHERE idDenunciante = $idDenunciante");
$denunciante = mysqli_fetch_assoc($qDen);
$idMunicipio = $denunciante['idMunicipio'];
$idDepartamento = $denunciante['idDepartamento'];

// 1. Insertar en denuncia
$sql1 = "INSERT INTO denuncia (fechaInicio, horaInicio, detalle, direccionDomicilio, numeroCaso, idFuncionarios, idDenunciante, idMunicipio, idDepartamento)
         VALUES ('$fechaIncautacion', '$horaActual', '$descripcionSolicitud', '$lugarIncautacion', '$numeroCaso', $idFuncionario, $idDenunciante, $idMunicipio, $idDepartamento)";
mysqli_query($conexionbd, $sql1);
$idDenuncia = mysqli_insert_id($conexionbd);

// Separar marca y modelo
$partes = explode(' ', $marcaModelo, 2);
$marca = $partes[0];
$modelo = isset($partes[1]) ? $partes[1] : $marca;

// 2. Insertar en dispositivoinvolucradao
$sql2 = "INSERT INTO dispositivoinvolucradao (tipoDispoistivo, marca, modelo, numeroSerial, estadoFuncional, idDenuncia)
         VALUES ('$tipoDispositivo', '$marca', '$modelo', '$numeroSerieIMEI', '$estadoFuncional', $idDenuncia)";
mysqli_query($conexionbd, $sql2);
$idDispositivo = mysqli_insert_id($conexionbd);

// 3. Insertar en evidenciadigital
$sql3 = "INSERT INTO evidenciadigital (codigoHast, fechaRegistro, lugar, tipoArchivo, metodoObtencion, nivelConfidencialidad, observaciones, idDispositivoInvolucradao)
         VALUES ('$hashVerificacion', '$fechaIncautacion', '$lugarIncautacion', 'N/A', 'Incautación directa', 'Confidencial', '$descripcionSolicitud', $idDispositivo)";
mysqli_query($conexionbd, $sql3);
$idEvidencia = mysqli_insert_id($conexionbd);

// 4. Subir fotografía si existe
$fotografiaRuta = null;
if (isset($_FILES['fotografiaEtiqueta']) && $_FILES['fotografiaEtiqueta']['error'] === UPLOAD_ERR_OK) {
    $carpeta = '../../assets/uploads/cadena_custodia/';
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0755, true);
    }
    $extension = pathinfo($_FILES['fotografiaEtiqueta']['name'], PATHINFO_EXTENSION);
    $nombreArchivo = 'cc_' . time() . '_' . $idDenuncia . '.' . $extension;
    move_uploaded_file($_FILES['fotografiaEtiqueta']['tmp_name'], $carpeta . $nombreArchivo);
    $fotografiaRuta = $carpeta . $nombreArchivo;
}

// 5. Insertar en cadenaCustodia
$fotoSQL = $fotografiaRuta ? "'$fotografiaRuta'" : "NULL";
$sql4 = "INSERT INTO cadenaCustodia (idDenuncia, idEvidenciaDigital, codigoEtiqueta, fotografiaRuta, idFuncionarioRegistra)
         VALUES ($idDenuncia, $idEvidencia, '$codigoEtiqueta', $fotoSQL, $idFuncionario)";

$resultado = mysqli_query($conexionbd, $sql4);

if ($resultado) {
    header('Location: ../../view/administrarRegistroCadenaCustodia/listarRegistros.php');
} else {
    header('Location: ../../view/administrarRegistroCadenaCustodia/registroCadenaCustodia.php?error=1');
}
exit;
?>
