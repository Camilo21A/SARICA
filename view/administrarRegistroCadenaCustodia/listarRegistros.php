<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../administrarLogin/login.php');
    exit;
}

include '../../model/conexion_db_Sarica.php';

// Filtros
$filtroFecha      = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$filtroEstado     = isset($_GET['estado']) ? $_GET['estado'] : '';
$filtroDenunciante = isset($_GET['denunciante']) ? $_GET['denunciante'] : '';

$where = "WHERE 1=1";
if ($filtroFecha)        $where .= " AND d.fechaInicio = '$filtroFecha'";
if ($filtroEstado)       $where .= " AND di.estadoFuncional = '$filtroEstado'";
if ($filtroDenunciante)  $where .= " AND (den.nombre LIKE '%$filtroDenunciante%' 
                                     OR den.apellido LIKE '%$filtroDenunciante%'
                                     OR CONCAT(den.nombre, ' ', den.apellido) LIKE '%$filtroDenunciante%')";

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
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIGET – Lista de Registros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../../assets/css/styleHeader/header.css">
  <link rel="stylesheet" href="../../assets/css/styleRegistroCadenaCustodia/listaRegistros.css">
</head>
<body>
  <?php include '../../includes/header.php'; ?>

  <main class="container-fluid px-3 px-lg-4 py-4">

    <!-- Título -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
      <div class="d-flex align-items-center gap-3">
        <div class="iconoTitulo d-flex align-items-center justify-content-center">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
            <path d="M12 2L3 7v5c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7L12 2z"/>
          </svg>
        </div>
        <div>
          <h1 class="tituloPagina mb-0">Registros de Cadena de Custodia</h1>
          <p class="subtituloPagina mb-0">Consulta y exporta los registros existentes</p>
        </div>
      </div>
      <div class="d-flex gap-2">
        <a href="registroCadenaCustodia.php" class="btnNuevo">+ Nuevo Registro</a>
        <a href="../../controller/exportarPDF/exportarRegistros.php?fecha=<?= urlencode($filtroFecha) ?>&estado=<?= urlencode($filtroEstado) ?>&denunciante=<?= urlencode($filtroDenunciante) ?>" class="btnExportar">
          ⬇ Exportar PDF
        </a>
      </div>
    </div>

    <!-- Filtros -->
    <div class="tarjetaSeccion mb-4">
      <form method="GET" class="row g-3 align-items-end">
        <div class="col-12 col-md-3">
          <label class="etiquetaCampo">Fecha de incautación</label>
          <input type="date" name="fecha" value="<?= htmlspecialchars($filtroFecha) ?>" class="form-control campoFiltro"/>
        </div>
        <div class="col-12 col-md-3">
          <label class="etiquetaCampo">Estado del dispositivo</label>
          <select name="estado" class="form-select campoFiltro">
            <option value="">Todos</option>
            <option value="Encendido"  <?= $filtroEstado === 'Encendido'  ? 'selected' : '' ?>>Encendido</option>
            <option value="Apagado"    <?= $filtroEstado === 'Apagado'    ? 'selected' : '' ?>>Apagado</option>
            <option value="Dañado"     <?= $filtroEstado === 'Dañado'     ? 'selected' : '' ?>>Dañado</option>
            <option value="Bloqueado"  <?= $filtroEstado === 'Bloqueado'  ? 'selected' : '' ?>>Bloqueado</option>
          </select>
        </div>
        <div class="col-12 col-md-3">
          <label class="etiquetaCampo">Denunciante</label>
          <input type="text" name="denunciante" value="<?= htmlspecialchars($filtroDenunciante) ?>" class="form-control campoFiltro" placeholder="Nombre o apellido"/>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btnNuevo w-100">Filtrar</button>
          <a href="listarRegistros.php" class="btn btn-outline-secondary w-100" style="border-radius:7px;font-size:13px;">Limpiar</a>
        </div>
      </form>
    </div>

    <!-- Tabla -->
    <div class="tablaPrincipal">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th class="px-3 py-3">#</th>
            <th>Caso</th>
            <th>Denunciante</th>
            <th>Fecha</th>
            <th>Dispositivo</th>
            <th>Serial / IMEI</th>
            <th>Estado</th>
            <th>Etiqueta</th>
            <th>Funcionario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($query) === 0): ?>
            <tr>
              <td colspan="10" class="text-center py-4" style="color:#4a6fa5;">No hay registros que coincidan con los filtros.</td>
            </tr>
          <?php else: ?>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
              <?php
                $estadoClass = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $row['estadoFuncional']));
              ?>
              <tr>
                <td class="px-3"><?= $row['idCadenaCustodia'] ?></td>
                <td><strong><?= htmlspecialchars($row['numeroCaso']) ?></strong></td>
                <td><?= htmlspecialchars($row['nombreDenunciante'] . ' ' . $row['apellidoDenunciante']) ?></td>
                <td><?= date('d/m/Y', strtotime($row['fechaInicio'])) ?></td>
                <td><?= htmlspecialchars($row['tipoDispoistivo'] . ' — ' . $row['marca'] . ' ' . $row['modelo']) ?></td>
                <td><?= htmlspecialchars($row['numeroSerial']) ?></td>
                <td><span class="badgeEstado <?= $estadoClass ?>"><?= htmlspecialchars($row['estadoFuncional']) ?></span></td>
                <td><?= htmlspecialchars($row['codigoEtiqueta']) ?></td>
                <td><?= htmlspecialchars($row['funcionario']) ?></td>
                <td>
                  <a href="../../controller/exportarPDF/exportarRegistros.php?id=<?= $row['idCadenaCustodia'] ?>"
                     class="btn btn-sm"
                     style="background:#fee2e2;color:#C62828;border-radius:6px;font-size:11px;font-weight:600;">
                    PDF
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </main>
</body>
<script>
  document.querySelector('a[href*="listarRegistros"]')?.classList.add('activo');
</script>
</html>