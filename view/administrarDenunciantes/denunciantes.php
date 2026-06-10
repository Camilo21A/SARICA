<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header('Location: ../administrarLogin/login.php');
  exit;
}

include '../../model/conexion_db_Sarica.php';

// Filtro búsqueda
$filtro = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$where = $filtro ? "WHERE nombre LIKE '%$filtro%' OR apellido LIKE '%$filtro%' OR numeroDocumento LIKE '%$filtro%'" : '';

$query = mysqli_query($conexionbd, "SELECT * FROM denunciante $where ORDER BY nombre ASC");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIGET – Gestión de Denunciantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Source+Sans+3:wght@300;400;600&display=swap"
    rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../../assets/css/styleHeader/header.css">
  <link rel="stylesheet" href="../../assets/css/styleListaRegistros/listaRegistros.css">
  <link rel="stylesheet" href="../../assets/css/styleDenunciantes/denunciantes.css">
</head>

<body>
  <?php include '../../includes/header.php'; ?>

  <main class="container-fluid px-3 px-lg-4 py-4">

    <!-- Título -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
      <div class="d-flex align-items-center gap-3">
        <div class="iconoTitulo d-flex align-items-center justify-content-center">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
            <circle cx="12" cy="7" r="4" />
          </svg>
        </div>
        <div>
          <a href="../administrarHome/home.php" class="btnVolverInicio mt-1">  VOLVER AL INICIO</a>
          <h1 class="tituloPagina mb-0">Gestión de Denunciantes</h1>
          <p class="subtituloPagina mb-0">Registra, consulta y administra los ciudadanos denunciantes</p>
        </div>
      </div>
      <button class="btnNuevo" data-bs-toggle="modal" data-bs-target="#modalDenunciante">
        + Nuevo Denunciante
      </button>
    </div>

    <!-- Alertas -->
    <?php if (isset($_GET['exito'])): ?>
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
       
        <?= $_GET['exito'] === 'crear' ? 'Denunciante registrado exitosamente.' : ($_GET['exito'] === 'editar' ? 'Denunciante actualizado exitosamente.' : 'Denunciante eliminado exitosamente.') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Filtro búsqueda -->
    <div class="tarjetaSeccion mb-4">
      <form method="GET" class="row g-3 align-items-end">
        <div class="col-12 col-md-6">
          <label class="etiquetaCampo">Buscar denunciante</label>
          <input type="text" name="buscar" value="<?= htmlspecialchars($filtro) ?>" class="form-control campoFiltro"
            placeholder="Nombre, apellido o documento..." />
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btnNuevo w-100">Buscar</button>
          <a href="denunciantes.php" class="btn btn-outline-secondary w-100"
            style="border-radius:7px;font-size:13px;">Limpiar</a>
        </div>
      </form>
    </div>

    <!-- Tabla -->
    <div class="tablaPrincipal">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th class="px-3 py-3">#</th>
            <th>Nombre completo</th>
            <th>Documento</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Género</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($query) === 0): ?>
            <tr>
              <td colspan="7" class="text-center py-4" style="color:#4a6fa5;">
                No hay denunciantes registrados.
              </td>
            </tr>
          <?php else: ?>
            <?php while ($d = mysqli_fetch_assoc($query)): ?>
              <tr>
                <td class="px-3"><?= $d['idDenunciante'] ?></td>
                <td><strong><?= htmlspecialchars($d['nombre'] . ' ' . $d['apellido']) ?></strong></td>
                <td><?= htmlspecialchars($d['tipoDocumento'] . ': ' . $d['numeroDocumento']) ?></td>
                <td><?= htmlspecialchars($d['telefono']) ?></td>
                <td><?= htmlspecialchars($d['correoElectronico']) ?></td>
                <td><?= htmlspecialchars($d['genero']) ?></td>
                <td class="d-flex gap-2">
                  <!-- Botón editar -->
                  <button class="btnEditar" onclick="abrirEditar(
                    <?= $d['idDenunciante'] ?>,
                    '<?= addslashes($d['nombre']) ?>',
                    '<?= addslashes($d['apellido']) ?>',
                    '<?= $d['tipoDocumento'] ?>',
                    '<?= $d['numeroDocumento'] ?>',
                    '<?= $d['genero'] ?>',
                    '<?= $d['estadoCivil'] ?>',
                    '<?= $d['telefono'] ?>',
                    '<?= addslashes($d['correoElectronico']) ?>',
                    '<?= addslashes($d['direccion']) ?>',
                    <?= $d['idDepartamento'] ?>,
                    <?= $d['idMunicipio'] ?>
                    )">
                    Editar
                  </button>
                  <!-- Botón eliminar -->
                  <a href="../../controller/denunciantes/eliminarDenunciante.php?id=<?= $d['idDenunciante'] ?>"
                    class="btnEliminar" onclick="return confirm('¿Seguro que deseas eliminar este denunciante?')">
                    Eliminar
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </main>

  <!-- ── MODAL CREAR / EDITAR ──────────────────────────── -->
  <div class="modal fade" id="modalDenunciante" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border-radius:12px;border:1.5px solid #dce8f5;">

        <div class="modal-header"
          style="background:linear-gradient(90deg,#0d4fa0,#1565C0);border-radius:10px 10px 0 0;">
          <h5 class="modal-title" style="color:#fff;font-family:'Playfair Display',serif;" id="modalTitulo">
            Nuevo Denunciante
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <form id="formDenunciante" method="POST" action="../../controller/denunciantes/guardarDenunciante.php">
          <input type="hidden" name="idDenunciante" id="inputId" />
          <input type="hidden" name="accion" id="inputAccion" value="crear" />

          <div class="modal-body p-4">
            <div class="row g-3">

              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Nombre</label>
                <input type="text" name="nombre" id="inputNombre" class="form-control campoFiltro" required />
              </div>
              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Apellido</label>
                <input type="text" name="apellido" id="inputApellido" class="form-control campoFiltro" required />
              </div>

              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Tipo de Documento</label>
                <select name="tipoDocumento" id="inputTipoDoc" class="form-select campoFiltro" required>
                  <option value="CC">Cédula de Ciudadanía</option>
                  <option value="TI">Tarjeta de Identidad</option>
                  <option value="CE">Cédula de Extranjería</option>
                  <option value="Pasaporte">Pasaporte</option>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Número de Documento</label>
                <input type="text" name="numeroDocumento" id="inputNumDoc" class="form-control campoFiltro" required />
              </div>

              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Género</label>
                <select name="genero" id="inputGenero" class="form-select campoFiltro" required>
                  <option value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Estado Civil</label>
                <select name="estadoCivil" id="inputEstadoCivil" class="form-select campoFiltro" required>
                  <option value="Soltero">Soltero/a</option>
                  <option value="Casado">Casado/a</option>
                  <option value="Union libre">Unión libre</option>
                  <option value="Divorciado">Divorciado/a</option>
                  <option value="Viudo">Viudo/a</option>
                </select>
              </div>

              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Teléfono</label>
                <input type="text" name="telefono" id="inputTelefono" class="form-control campoFiltro" required />
              </div>
              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Correo electrónico</label>
                <input type="email" name="correoElectronico" id="inputCorreo" class="form-control campoFiltro"
                  required />
              </div>

              <div class="col-12">
                <label class="etiquetaCampo">Dirección</label>
                <input type="text" name="direccion" id="inputDireccion" class="form-control campoFiltro" />
              </div>

              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Departamento</label>
                <select name="idDepartamento" id="inputDepartamento" class="form-select campoFiltro" required>
                  <option value="">Seleccionar...</option>
                  <?php
                  $deptos = mysqli_query($conexionbd, "SELECT idDepartamento, nombre FROM departamento ORDER BY nombre ASC");
                  while ($dep = mysqli_fetch_assoc($deptos)):
                    ?>
                    <option value="<?= $dep['idDepartamento'] ?>"><?= htmlspecialchars($dep['nombre']) ?></option>
                  <?php endwhile; ?>
                </select>
              </div>

              <div class="col-12 col-md-6">
                <label class="etiquetaCampo">Municipio</label>
                <select name="idMunicipio" id="inputMunicipio" class="form-select campoFiltro" required>
                  <option value="">Primero seleccione departamento...</option>
                </select>
              </div>

            </div>
          </div>

          <div class="modal-footer" style="border-top:1.5px solid #dce8f5;">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
              style="border-radius:7px;font-size:13px;">Cancelar</button>
            <button type="submit" class="btnNuevo">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

<script src="../../assets/js/gestionarDenunciantes/cargarMunicipios.js"></script>
<script src="../../assets/js/gestionarDenunciantes/modalDenunciante.js"></script>
</body>

<script>
  document.querySelector('a[href*="denunciantes"]')?.classList.add('activo');
</script>

</html>