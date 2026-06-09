<?php
include '../../model/conexion_db_Sarica.php';

$idDepartamento = intval($_GET['idDepartamento']);
$query = mysqli_query($conexionbd, "SELECT idMunicipio, nombre FROM municipio WHERE idDepartamento = $idDepartamento ORDER BY nombre ASC");

$municipios = [];
while ($row = mysqli_fetch_assoc($query)) {
    $municipios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($municipios);
?>