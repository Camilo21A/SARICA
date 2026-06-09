<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../view/administrarLogin/login.php');
    exit;
}

include '../../model/conexion_db_Sarica.php';
require_once '../../library/fpdf/fpdf.php';

// ── Filtros ───────────────────────────────────────────────
$id          = isset($_GET['id'])          ? intval($_GET['id'])   : 0;
$filtroFecha = isset($_GET['fecha'])       ? $_GET['fecha']        : '';
$filtroEstado = isset($_GET['estado'])     ? $_GET['estado']       : '';
$filtroDenunc = isset($_GET['denunciante']) ? $_GET['denunciante'] : '';

// ── Where ─────────────────────────────────────────────────
$where = "WHERE 1=1";
if ($id)
    $where .= " AND cc.idCadenaCustodia = $id";
if ($filtroFecha)
    $where .= " AND d.fechaInicio = '$filtroFecha'";
if ($filtroEstado)
    $where .= " AND di.estadoFuncional = '$filtroEstado'";
if ($filtroDenunc)
    $where .= " AND (den.nombre LIKE '%$filtroDenunc%'
                OR den.apellido LIKE '%$filtroDenunc%'
                OR CONCAT(den.nombre, ' ', den.apellido) LIKE '%$filtroDenunc%')";

// ── Query ─────────────────────────────────────────────────
$query = mysqli_query($conexionbd, "
    SELECT
        cc.idCadenaCustodia,
        cc.codigoEtiqueta,
        cc.fechaRegistro,
        d.numeroCaso,
        d.fechaInicio,
        d.direccionDomicilio,
        d.detalle,
        den.nombre AS nombreDenunciante,
        den.apellido AS apellidoDenunciante,
        den.numeroDocumento,
        di.tipoDispoistivo,
        di.marca,
        di.modelo,
        di.numeroSerial,
        di.estadoFuncional,
        ev.codigoHast,
        CONCAT(f.nombre, ' ', f.apellido) AS funcionario
    FROM cadenaCustodia cc
    INNER JOIN denuncia d                 ON cc.idDenuncia = d.idDenuncia
    INNER JOIN denunciante den            ON d.idDenunciante = den.idDenunciante
    INNER JOIN dispositivoinvolucradao di ON di.idDenuncia = d.idDenuncia
    INNER JOIN evidenciadigital ev        ON cc.idEvidenciaDigital = ev.idEvidenciaDigital
    INNER JOIN funcionarios f             ON cc.idFuncionarioRegistra = f.idFuncionarios
    $where
    ORDER BY cc.fechaRegistro DESC
");

// ── Clase PDF ─────────────────────────────────────────────
class PDF extends FPDF
{
    function txt($str)
    {
        return iconv('UTF-8', 'windows-1252//TRANSLIT', $str);
    }

    function Header()
    {
        $this->SetFillColor(13, 79, 160);
        $this->Rect(0, 0, 210, 22, 'F');

        $this->SetFillColor(198, 40, 40);
        $this->Rect(0, 22, 210, 3, 'F');

        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(255, 255, 255);
        $this->SetXY(10, 5);
        $this->Cell(0, 10, 'SIGET - Sistema de Gestion y Trazabilidad', 0, 0, 'L');

        $this->SetFont('Arial', '', 9);
        $this->SetXY(10, 14);
        $this->Cell(0, 6, 'Registro de Cadena de Custodia  |  Fiscalia General de la Mision, Seccional Tunja', 0, 0, 'L');

        $this->SetFont('Arial', '', 8);
        $this->SetXY(140, 14);
        $this->Cell(60, 6, 'Generado: ' . date('d/m/Y H:i'), 0, 0, 'R');

        $this->Ln(18);
    }

    function Footer()
    {
        $this->SetY(-12);
        $this->SetFillColor(13, 79, 160);
        $this->Rect(0, $this->GetY(), 210, 15, 'F');
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 8, 'SIGET (c) 2025  -  Pagina ' . $this->PageNo() . '  -  Documento de uso institucional', 0, 0, 'C');
    }

    function TituloSeccion($titulo)
    {
        $this->SetFillColor(21, 101, 192);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(10);
        $this->Cell(190, 7, '  ' . $this->txt($titulo), 0, 1, 'L', true);
        $this->SetTextColor(0, 0, 0);
        $this->Ln(2);
    }

    function FilaDato($etiqueta, $valor)
    {
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(240, 245, 252);
        $this->SetX(10);
        $this->Cell(55, 6, $this->txt($etiqueta . ':'), 0, 0, 'L', true);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(135, 6, $this->txt($valor), 0, 1, 'L', true);
    }

    function LineaDivisora()
    {
        $this->SetDrawColor(184, 205, 232);
        $this->SetX(10);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(3);
    }
}

// ── Generar PDF ───────────────────────────────────────────
$pdf = new PDF();
$pdf->SetMargins(10, 30, 10);
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();

if (mysqli_num_rows($query) === 0) {
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 10, 'No se encontraron registros con los filtros aplicados.', 0, 1, 'C');
} else {
    while ($row = mysqli_fetch_assoc($query)) {

        if ($pdf->GetY() > 230) {
            $pdf->AddPage();
        }

        // Encabezado del registro
        $pdf->SetFillColor(212, 160, 23);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetX(10);
        $pdf->Cell(95, 7, $pdf->txt('  Registro N. ' . $row['idCadenaCustodia']), 0, 0, 'L', true);
        $pdf->SetFillColor(13, 79, 160);
        $pdf->Cell(95, 7, $pdf->txt('Caso: ' . $row['numeroCaso']), 0, 1, 'R', true);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);

        // Sección 1
        $pdf->TituloSeccion('1. Informacion del Denunciante');
        $pdf->FilaDato('Nombre',    $row['nombreDenunciante'] . ' ' . $row['apellidoDenunciante']);
        $pdf->FilaDato('Documento', $row['numeroDocumento']);
        $pdf->Ln(2);

        // Sección 2
        $pdf->TituloSeccion('2. Detalles de la Incautacion');
        $pdf->FilaDato('Fecha',       date('d/m/Y', strtotime($row['fechaInicio'])));
        $pdf->FilaDato('Lugar',       $row['direccionDomicilio']);
        $pdf->FilaDato('Descripcion', $row['detalle']);
        $pdf->Ln(2);

        // Sección 3
        $pdf->TituloSeccion('3. Datos del Dispositivo');
        $pdf->FilaDato('Tipo',         $row['tipoDispoistivo']);
        $pdf->FilaDato('Marca/Modelo', $row['marca'] . ' ' . $row['modelo']);
        $pdf->FilaDato('Serial/IMEI',  $row['numeroSerial']);
        $pdf->FilaDato('Estado',       $row['estadoFuncional']);
        $pdf->Ln(2);

        // Sección 4
        $pdf->TituloSeccion('4. Seguridad y Etiquetado');
        $pdf->FilaDato('Codigo Etiqueta', $row['codigoEtiqueta']);
        $pdf->FilaDato('Hash',            $row['codigoHast']);
        $pdf->FilaDato('Funcionario',     $row['funcionario']);
        $pdf->FilaDato('Fecha Registro',  date('d/m/Y H:i', strtotime($row['fechaRegistro'])));
        $pdf->Ln(4);

        $pdf->LineaDivisora();
        $pdf->Ln(3);
    }
}

$pdf->Output('I', 'cadena_custodia_' . date('Ymd_His') . '.pdf');
exit;
?>