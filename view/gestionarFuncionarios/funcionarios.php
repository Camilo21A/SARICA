<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../administrarLogin/login.php');
    exit;
}

include '../../model/conexion_db_Sarica.php';

/* ── Filtro de búsqueda ─────────────────────────────────────────── */
$filtro = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$where = $filtro
    ? "WHERE f.nombre LIKE '%$filtro%'
          OR f.apellido LIKE '%$filtro%'
          OR f.numeroDocumento LIKE '%$filtro%'"
    : '';

/* ── Traemos funcionarios junto con el nombre del cargo ─────────── */
/* JOIN con la tabla cargo para mostrar el nombre en la tabla       */
$query = mysqli_query($conexionbd, "
    SELECT f.idFuncionarios,
           f.idCargo,
           f.nombre,
           f.apellido,
           f.tipoDocumento,
           f.numeroDocumento,
           f.telefono,
           f.correo,
           f.rol,
           c.nombre AS nombreCargo
    FROM funcionarios f
    LEFT JOIN cargo c ON f.idCargo = c.idCargo
    $where
    ORDER BY f.nombre ASC
");

/* ── Traemos los cargos para el select del modal ───────────────── */
$cargos = mysqli_query($conexionbd, "SELECT idCargo, nombre FROM cargo ORDER BY nombre ASC");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIGET – Gestión de Funcionarios</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Source+Sans+3:wght@300;400;600&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Estilos propios -->
    <link rel="stylesheet" href="../../assets/css/styleHeader/header.css" />
    <link rel="stylesheet" href="../../assets/css/styleFuncionarios/funcionarios.css" />
</head>

<body>
    <?php include '../../includes/header.php'; ?>

    <main class="container-fluid px-3 px-lg-4 py-4">

        <!-- ── Título de la página ──────────────────────────────── -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="iconoTitulo d-flex align-items-center justify-content-center">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <polyline points="17 11 19 13 23 9" />
                    </svg>
                </div>
                <div>
                    <a href="../administrarHome/home.php" class="btnVolverInicio mt-1">
                        VOLVER AL INICIO
                    </a>
                    <h1 class="tituloPagina mb-0">Gestión de Funcionarios</h1>
                    <p class="subtituloPagina mb-0">Registra, consulta, administra y exporta dcumentos de los
                        funcionarios.</p><br>

                </div>
            </div>
            <!-- Abre el modal de crear -->
            <div class="d-flex gap-2">
                <button class="btnNuevo" data-bs-toggle="modal" data-bs-target="#modalFuncionario">
                    + Nuevo Funcionario
                </button>
                <a href="../../controller/funcionarios/exportarFuncionariosPDF.php" class="btnExportar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                        viewBox="0 0 16 16" style="margin-bottom:1px;">
                        <path
                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.1h14v-2.1a.5.5 0 0 1 1 0v2.6a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5V10.4a.5.5 0 0 1 .5-.5z" />
                        <path
                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                    </svg>
                    Exportar PDF
                </a>
            </div>
        </div>

        <!-- ── Alertas de éxito / error ─────────────────────────── -->
        <?php if (isset($_GET['exito'])): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <?php
                $mensajesExito = [
                    'crear' => 'Funcionario registrado exitosamente.',
                    'editar' => 'Funcionario actualizado exitosamente.',
                    'eliminar' => 'Funcionario eliminado exitosamente.',
                ];
                echo $mensajesExito[$_GET['exito']] ?? 'Operación exitosa.';
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <?php
                $mensajesError = [
                    'duplicado' => 'Ya existe un funcionario con ese número de documento o correo.',
                    '1' => 'Ocurrió un error al procesar la solicitud.',
                ];
                echo $mensajesError[$_GET['error']] ?? 'Error desconocido.';
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- ── Filtro de búsqueda ────────────────────────────────── -->
        <div class="tarjetaSeccion mb-4">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-12 col-md-6">
                    <label class="etiquetaCampo">Buscar funcionario</label>
                    <input type="text" name="buscar" value="<?= htmlspecialchars($filtro) ?>"
                        class="form-control campoFiltro" placeholder="Nombre, apellido o documento..." />
                </div>
                <div class="col-12 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btnNuevo w-100">Buscar</button>
                    <a href="funcionarios.php" class="btn btn-outline-secondary w-100"
                        style="border-radius:7px; font-size:13px;">Limpiar</a>
                </div>
            </form>
        </div>

        <!-- ── Tabla de funcionarios ─────────────────────────────── -->
        <div class="tablaPrincipal">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-3 py-3">#</th>
                        <th>Nombre completo</th>
                        <th>Documento</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Cargo</th>
                        <th>Acciones</th>
                        <th>PDF</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query) === 0): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4" style="color:#4a6fa5;">
                                No hay funcionarios registrados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php while ($f = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td class="px-3"><?= $f['idFuncionarios'] ?></td>
                                <td><strong><?= htmlspecialchars($f['nombre'] . ' ' . $f['apellido']) ?></strong></td>
                                <td><?= htmlspecialchars($f['tipoDocumento'] . ': ' . $f['numeroDocumento']) ?></td>
                                <td><?= htmlspecialchars($f['telefono']) ?></td>
                                <td><?= htmlspecialchars($f['correo']) ?></td>
                                <td>
                                    <!-- Badge visual para el rol -->
                                    <span class="badgeRol badgeRol--<?= strtolower(str_replace(' ', '-', $f['rol'])) ?>">
                                        <?= htmlspecialchars($f['rol']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($f['nombreCargo']) ?></td>
                                <td class="d-flex gap-2">

                                    <!-- Botón editar — pasa todos los datos al modal -->
                                    <button class="btnEditar" onclick="abrirEditar(
                                        <?= $f['idFuncionarios'] ?>,
                                        '<?= addslashes($f['nombre']) ?>',
                                        '<?= addslashes($f['apellido']) ?>',
                                        '<?= $f['tipoDocumento'] ?>',
                                        '<?= $f['numeroDocumento'] ?>',
                                        '<?= $f['telefono'] ?>',
                                        '<?= addslashes($f['correo']) ?>',
                                        '<?= addslashes($f['rol']) ?>',
                                        <?= $f['idCargo'] ?>
                                        )">
                                        Editar
                                    </button>

                                    <!-- Botón eliminar -->
                                    <a href="../../controller/funcionarios/eliminarFuncionario.php?id=<?= $f['idFuncionarios'] ?>"
                                        class="btnEliminar"
                                        onclick="return confirm('¿Seguro que deseas eliminar este funcionario?')">
                                        Eliminar
                                    </a>

                                </td>

                                <td>
                                    <a href="../../controller/funcionarios/exportarFuncionariosPDF.php?id=<?= $f['idFuncionarios'] ?>"
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

    <!-- ══════════════ MODAL CREAR / EDITAR FUNCIONARIO ══════════════ -->
    <div class="modal fade" id="modalFuncionario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius:12px; border:1.5px solid #dce8f5;">

                <!-- Cabecera del modal -->
                <div class="modal-header"
                    style="background:linear-gradient(90deg,#0d4fa0,#1565C0); border-radius:10px 10px 0 0;">
                    <h5 class="modal-title" id="modalTitulo" style="color:#fff; font-family:'Playfair Display',serif;">
                        Nuevo Funcionario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Formulario — apunta al controller guardar -->
                <form id="formFuncionario" method="POST" action="../../controller/funcionarios/guardarFuncionario.php">

                    <!-- Campos ocultos de control -->
                    <input type="hidden" name="idFuncionario" id="inputId" />
                    <input type="hidden" name="accion" id="inputAccion" value="crear" />

                    <div class="modal-body p-4">
                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-12 col-md-6">
                                <label class="etiquetaCampo">Nombre</label>
                                <input type="text" name="nombre" id="inputNombre" class="form-control campoFiltro"
                                    required />
                            </div>

                            <!-- Apellido -->
                            <div class="col-12 col-md-6">
                                <label class="etiquetaCampo">Apellido</label>
                                <input type="text" name="apellido" id="inputApellido" class="form-control campoFiltro"
                                    required />
                            </div>

                            <!-- Tipo de documento -->
                            <div class="col-12 col-md-6">
                                <label class="etiquetaCampo">Tipo de Documento</label>
                                <select name="tipoDocumento" id="inputTipoDoc" class="form-select campoFiltro" required>
                                    <option value="CC">Cédula de Ciudadanía</option>
                                    <option value="TI">Tarjeta de Identidad</option>
                                    <option value="CE">Cédula de Extranjería</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                </select>
                            </div>

                            <!-- Número de documento -->
                            <div class="col-12 col-md-6">
                                <label class="etiquetaCampo">Número de Documento</label>
                                <input type="text" name="numeroDocumento" id="inputNumDoc"
                                    class="form-control campoFiltro" required />
                            </div>

                            <!-- Teléfono -->
                            <div class="col-12 col-md-6">
                                <label class="etiquetaCampo">Teléfono</label>
                                <input type="text" name="telefono" id="inputTelefono" class="form-control campoFiltro"
                                    required />
                            </div>

                            <!-- Correo -->
                            <div class="col-12 col-md-6">
                                <label class="etiquetaCampo">Correo electrónico</label>
                                <input type="email" name="correo" id="inputCorreo" class="form-control campoFiltro"
                                    required />
                            </div>

                            <!-- Rol -->
                            <div class="col-12 col-md-6">
                                <label class="etiquetaCampo">Rol</label>
                                <select name="rol" id="inputRol" class="form-select campoFiltro" required>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Fiscal">Fiscal</option>
                                    <option value="Policia Judicial">Policía Judicial</option>
                                    <option value="Custodio">Custodio</option>
                                </select>
                            </div>

                            <!-- Cargo (viene de la tabla cargo) -->
                            <div class="col-12 col-md-6">
                                <label class="etiquetaCampo">Cargo</label>
                                <select name="idCargo" id="inputCargo" class="form-select campoFiltro" required>
                                    <option value="">Seleccionar...</option>
                                    <?php
                                    /* Recorremos los cargos traídos al inicio */
                                    while ($c = mysqli_fetch_assoc($cargos)):
                                        ?>
                                        <option value="<?= $c['idCargo'] ?>">
                                            <?= htmlspecialchars($c['nombre']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- Contraseña — solo visible al crear -->
                            <div class="col-12" id="campoClave">
                                <label class="etiquetaCampo">Contraseña</label>
                                <input type="password" name="contrasena" id="inputClave"
                                    class="form-control campoFiltro" placeholder="Mínimo 8 caracteres" />
                                <small class="text-muted" style="font-size:11px;">
                                    Al editar, dejar en blanco para mantener la contraseña actual.
                                </small>
                            </div>

                        </div>
                    </div>

                    <!-- Pie del modal -->
                    <div class="modal-footer" style="border-top:1.5px solid #dce8f5;">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            style="border-radius:7px; font-size:13px;">Cancelar</button>
                        <button type="submit" class="btnNuevo">Guardar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- JS del modal de funcionarios -->
    <script src="../../assets/js/gestionarFuncionarios/modalFuncionario.js"></script>

    <!-- Marcar activo el link del sidebar si existe -->
    <script>
        document.querySelector('a[href*="listFuncionarios"]')?.classList.add('activo');
    </script>

</body>

</html>