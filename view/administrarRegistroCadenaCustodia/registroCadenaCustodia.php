<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: administrarLogin/login.php');
    exit;
}

include '../../model/conexion_db_Sarica.php';

// Cargar denunciantes para el select
$queryDenunciantes = mysqli_query($conexionbd, "SELECT idDenunciante, nombre, apellido, numeroDocumento FROM denunciante ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIGET – Registro de Cadena de Custodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../../assets/css/styleHeader/header.css">
  <link rel="stylesheet" href="../../assets/css/styleRegistroCadenaCustodia/registroCadenaCustodiaEstilo.css">
</head>

<body>
  <?php include ("../../includes/header.php") ?>

  <main class="container-fluid px-3 px-lg-4 py-4">

    <!-- Título -->
    <div class="d-flex align-items-center gap-3 mb-4">
      <div class="iconoTitulo d-flex align-items-center justify-content-center">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
          <path d="M12 2L3 7v5c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7L12 2z" />
        </svg>
      </div>
      <div>
        <h1 class="tituloPagina mb-0">Registro de Cadena de Custodia</h1>
        <p class="subtituloPagina mb-0">Diligencia todos los campos para registrar la incautación</p>
      </div>
    </div>

    <!-- Alerta de éxito -->
    <?php if (isset($_GET['exito'])): ?>
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        ✅ Registro guardado exitosamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Alerta de error -->
    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        ❌ Error al guardar el registro. Verifica los datos e intenta de nuevo.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form id="formularioRegistro" action="../../controller/registroCadenaCustodia/guardarRegistro.php" method="POST" enctype="multipart/form-data" novalidate>

      <!-- S1: Información de Origen -->
      <div class="tarjetaSeccion mb-4">
        <div class="encabezadoSeccion d-flex align-items-center gap-2 mb-3">
          <div class="numeroSeccion">1</div>
          <h2 class="tituloSeccion mb-0">Información de Origen</h2>
        </div>
        <div class="row g-3">

          <div class="col-12">
            <label for="selectDenunciante" class="etiquetaCampo">Seleccionar Ciudadano Denunciante</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
              </svg>
              <select id="selectDenunciante" name="idDenunciante" class="form-select campoPrincipal campoConIcono" required>
                <option value="">Seleccionar denunciante...</option>
                <?php while ($d = mysqli_fetch_assoc($queryDenunciantes)): ?>
                  <option value="<?= $d['idDenunciante'] ?>">
                    <?= htmlspecialchars($d['nombre'] . ' ' . $d['apellido']) ?> — Doc: <?= htmlspecialchars($d['numeroDocumento']) ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label for="campoCaso" class="etiquetaCampo">Número de Caso / Noticia Criminal</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
              </svg>
              <input type="text" id="campoCaso" name="numeroCaso" class="form-control campoPrincipal campoConIcono"
                placeholder="Ingrese el número de caso" required />
            </div>
          </div>

        </div>
      </div>

      <!-- S2: Detalles de la Incautación -->
      <div class="tarjetaSeccion mb-4">
        <div class="encabezadoSeccion d-flex align-items-center gap-2 mb-3">
          <div class="numeroSeccion">2</div>
          <h2 class="tituloSeccion mb-0">Detalles de la Incautación</h2>
        </div>
        <div class="row g-3">

          <div class="col-12 col-md-6">
            <label for="campoLugar" class="etiquetaCampo">Lugar de la incautación</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                <circle cx="12" cy="10" r="3" />
              </svg>
              <input type="text" id="campoLugar" name="lugarIncautacion" class="form-control campoPrincipal campoConIcono"
                placeholder="Ingrese el lugar de la incautación" required />
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label for="campoFecha" class="etiquetaCampo">Fecha de incautación</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
              </svg>
              <input type="date" id="campoFecha" name="fechaIncautacion" class="form-control campoPrincipal campoConIcono" required />
            </div>
          </div>

          <div class="col-12">
            <label for="campoDescripcion" class="etiquetaCampo">Descripción de la solicitud de incautación</label>
            <textarea id="campoDescripcion" name="descripcionSolicitud" class="form-control campoPrincipal" rows="4"
              placeholder="Detalle la solicitud de incautación" required></textarea>
          </div>

        </div>
      </div>

      <!-- S3: Datos del Dispositivo -->
      <div class="tarjetaSeccion mb-4">
        <div class="encabezadoSeccion d-flex align-items-center gap-2 mb-3">
          <div class="numeroSeccion">3</div>
          <h2 class="tituloSeccion mb-0">Datos del Dispositivo</h2>
        </div>
        <div class="row g-3">

          <div class="col-12 col-md-6">
            <label for="selectTipoDispositivo" class="etiquetaCampo">Tipo de Dispositivo</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="5" y="2" width="14" height="20" rx="2" ry="2" />
                <line x1="12" y1="18" x2="12.01" y2="18" />
              </svg>
              <select id="selectTipoDispositivo" name="tipoDispositivo" class="form-select campoPrincipal campoConIcono" required>
                <option value="">Seleccione un tipo...</option>
                <option value="Celular">Celular / Smartphone</option>
                <option value="Computador">Computador portátil</option>
                <option value="Disco">Disco duro / USB</option>
                <option value="Tablet">Tablet</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label for="campoMarca" class="etiquetaCampo">Marca / Modelo</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20.59 13.41 7.5 .5 1.5 6.5 14.41 19.41" />
                <line x1="1.5" y1="6.5" x2="7.5" y2="12.5" />
              </svg>
              <input type="text" id="campoMarca" name="marcaModelo" class="form-control campoPrincipal campoConIcono"
                placeholder="Ej: Samsung Galaxy S21" required />
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label for="campoSerial" class="etiquetaCampo">Número de Serie / IMEI</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="16" rx="2" />
                <line x1="3" y1="9" x2="21" y2="9" />
                <line x1="8" y1="14" x2="16" y2="14" />
              </svg>
              <input type="text" id="campoSerial" name="numeroSerieIMEI" class="form-control campoPrincipal campoConIcono"
                placeholder="Ingrese número de serie o IMEI" required />
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label for="selectEstado" class="etiquetaCampo">Estado Funcional</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
              </svg>
              <select id="selectEstado" name="estadoFuncional" class="form-select campoPrincipal campoConIcono" required>
                <option value="">Seleccione el estado...</option>
                <option value="Encendido">Encendido / Funcional</option>
                <option value="Apagado">Apagado</option>
                <option value="Dañado">Dañado</option>
                <option value="Bloqueado">Bloqueado / Cifrado</option>
              </select>
            </div>
          </div>

        </div>
      </div>

      <!-- S4: Seguridad y Etiquetado -->
      <div class="tarjetaSeccion mb-4">
        <div class="encabezadoSeccion d-flex align-items-center gap-2 mb-3">
          <div class="numeroSeccion">4</div>
          <h2 class="tituloSeccion mb-0">Seguridad y Etiquetado</h2>
        </div>
        <div class="row g-3">

          <div class="col-12 col-md-6">
            <label for="campoEtiqueta" class="etiquetaCampo">Código de la Etiqueta</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                <line x1="7" y1="7" x2="7.01" y2="7" />
              </svg>
              <input type="text" id="campoEtiqueta" name="codigoEtiqueta" class="form-control campoPrincipal campoConIcono"
                placeholder="Ingrese el código de la etiqueta" required />
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label for="campoHash" class="etiquetaCampo">
              Hash de verificación inicial
              <span class="etiquetaOpcional ms-1">(opcional)</span>
            </label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
              </svg>
              <input type="text" id="campoHash" name="hashVerificacion" class="form-control campoPrincipal campoConIcono"
                placeholder="Ej: MD5, SHA-256..." />
            </div>
          </div>

          <div class="col-12">
            <label class="etiquetaCampo">Fotografía del etiquetado</label>
            <div class="zonaArchivoAdjunto d-flex flex-column align-items-center justify-content-center gap-2 p-4">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="32" height="32" class="iconoAdjunto">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <polyline points="17 8 12 3 7 8" />
                <line x1="12" y1="3" x2="12" y2="15" />
              </svg>
              <p class="textoArchivoAdjunto mb-0">Arrastra una imagen o haz clic para seleccionar</p>
              <p class="small mb-0" style="color:var(--textoMedio)">JPG, PNG — máx. 5MB</p>
              <input type="file" id="campoFoto" name="fotografiaEtiqueta" accept="image/*" class="d-none"
                onchange="document.getElementById('nombreArchivo').textContent = this.files[0].name; document.getElementById('nombreArchivo').classList.remove('d-none');" />
              <button type="button" class="btn botonSecundario btn-sm mt-1"
                onclick="document.getElementById('campoFoto').click()">
                Seleccionar archivo
              </button>
              <span id="nombreArchivo" class="small d-none textoNombreArchivo"></span>
            </div>
          </div>

          <div class="col-12">
            <a href="../../view/administrarValidacion/validarAdmin.php" class="enlaceValidar d-flex align-items-center gap-2">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                <rect x="3" y="11" width="18" height="11" rx="2" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
              </svg>
              Validar privilegios
            </a>
          </div>

        </div>
      </div>

    </form>
  </main>

  <footer>
    <div class="container-fluid px-3 px-lg-4">
      <div class="d-flex align-items-center justify-content-between py-3 flex-wrap gap-3">
        <p class="mb-0 small textoPie">
          SIGET &copy; 2025 — Sarica General de la Misión, Seccional Tunja
        </p>
        <div class="d-flex align-items-center gap-3">
          <a href="../administrarHome/home.php" class="btn botonCancelar">Cancelar</a>
          <button type="submit" form="formularioRegistro" class="btn botonGuardar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
              <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
              <polyline points="17 21 17 13 7 13 7 21" />
              <polyline points="7 3 7 8 15 8" />
            </svg>
            Guardar y Generar Registro de Cadena de Custodia
          </button>
        </div>
      </div>
    </div>
  </footer>

</body>
<script>
  document.querySelector('a[href*="registroCadenaCustodia"]')?.classList.add('activo');
</script>
</html>