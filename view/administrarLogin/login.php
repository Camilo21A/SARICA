<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SIGET</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Source+Sans+3:wght@300;400;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="../../assets/css/styleLogin/login.css">
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100">

  <div class="tarjetaPrincipal d-flex mx-3 my-4">
    <div class="panelIzquierdo d-none d-md-flex flex-column p-0">
      <div class="barraSuperior"></div>
      <div class="panelIzquierdoContenido d-flex flex-column flex-grow-1 p-4 p-lg-5">
        <img src="../../assets/image/logoSaricaVertical.jpg" alt="Fiscalía" class="logoSarica mb-4"
          style="max-width: 180px;">
        <p class="preTitulo mb-2">Sistema institucional</p>
        <h1 class="marca mb-0">SI<span>GET</span></h1>
        <div class="separador mt-2 mb-3"></div>
        <p class="descripcion mb-0">Sistema de Gestión y Trazabilidad de Evidencia Digital — Sarica General de la
          Misión, Seccional Tunja.</p>
        <div class="d-flex flex-wrap gap-2 mt-4">
          <span class="etiquetaRol">Fiscal</span>
          <span class="etiquetaRol">Policía Judicial</span>
          <span class="etiquetaRol">Custodio</span>
          <span class="etiquetaRol">Administrador</span>
        </div>
        <div class="mt-auto pt-4 infoPie">
          <b>SARICA · General de la Misión</b>
        </div>
      </div>
    </div>

    <div class="panelDerecho d-flex flex-column flex-grow-1">
      <div class="barraSuperior"></div>
      <div class="d-flex flex-column justify-content-center p-4 p-lg-5">

        <div class="cabeceraMovil d-md-none">
          <img src="../../assets/image/logoSaricaVertical.jpg" alt="Logo" class="logoMovil">
          <div class="divisorVerticalMovil">
            <h1 class="marcaMovil">SI<span>GET</span></h1>
            <p class="descripcionMovil">Gestión y Trazabilidad<br>de Evidencia Digital</p>
          </div>
        </div>

        <div class="d-flex align-items-start gap-3 mb-4">
          <div class="acentoTitulo mt-1"></div>
          <div>
            <h2 class="tituloFormulario mb-1">Iniciar sesión</h2>
            <p class="subtituloFormulario mb-0">Acceso restringido a funcionarios autorizados</p>
          </div>
        </div>

        <div id="cajaAlerta" class="alert alert-danger d-none align-items-center gap-2 py-2 px-3 mb-3" role="alert">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"
            style="flex-shrink:0">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
          </svg>
          <span id="mensajeAlerta" class="small"></span>
        </div>

        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 mb-3" role="alert">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"
              style="flex-shrink:0">
              <circle cx="12" cy="12" r="10" />
              <line x1="12" y1="8" x2="12" y2="12" />
              <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            <span class="small">
              <?php
              if ($_GET['error'] === 'rol') {
                echo 'El rol seleccionado no coincide con este usuario.';
              } else {
                echo 'Email o contraseña incorrectos.';
              }
              ?>
            </span>
          </div>
        <?php endif; ?>

        <form action="../../controller/validarUsuario/validarUsuario.php" method="POST">
          <div class="row g-3 mb-3">
            <div class="col-12 col-sm-6">
              <label for="selectorRol" class="etiquetaCampo">Rol / Perfil</label>
              <select id="selectorRol" name="rol" class="form-select campoEntrada" required>
                <option value="">Seleccionar...</option>
                <option value="Fiscal">Fiscal</option>
                <option value="Policia">Policía Judicial</option>
                <option value="Custodio">Custodio</option>
                <option value="Administrador">Administrador</option>
              </select>
            </div>
            <div class="col-12 col-sm-6">
              <label for="campoDocumento" class="etiquetaCampo">No. Documento</label>
              <div class="position-relative">
                <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="4" width="18" height="16" rx="2" />
                  <line x1="3" y1="9" x2="21" y2="9" />
                </svg>
                <input type="text" id="campoDocumento" name="documento" class="form-control campoEntrada campoConIcono"
                  placeholder="Cédula / ID" />
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="campoCorreo" class="etiquetaCampo">Correo electrónico</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <polyline points="22,6 12,13 2,6" />
              </svg>
              <input type="email" id="campoCorreo" name="email" class="form-control campoEntrada campoConIcono"
                placeholder="correo@sarica.gov.co" required />
            </div>
          </div>

          <div class="mb-3">
            <label for="campoContrasena" class="etiquetaCampo">Contraseña</label>
            <div class="position-relative">
              <svg class="iconoCampo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
              </svg>
              <input type="password" id="campoContrasena" name="password"
                class="form-control campoEntrada campoConIcono" placeholder="••••••••" required />
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check mb-0">
              <input class="form-check-input casillaVerificacion" type="checkbox" id="recordarSeccion"
                name="recordar" />
              <label class="form-check-label etiquteCasilla" for="recordarSeccion">Recordar sesión</label>
            </div>
            <a href="#" class="enlaceOlvide small fw-semibold">¿Olvidaste tu contraseña?</a>
          </div>

          <button type="submit" class="btn w-100 botonIngresar">Ingresar al sistema</button>
        </form>

        <div class="d-flex align-items-start gap-2 mt-3 p-3 notaSeguridad">
          <svg viewBox="0 0 24 24" fill="none" stroke="#1565C0" stroke-width="2" width="14" height="14"
            style="flex-shrink:0;margin-top:2px">
            <path d="M12 2L3 7v5c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7L12 2z" />
          </svg>
          <p class="mb-0 small textoSeguridad">Acceso exclusivo para personal de la Fiscalía General de la Misión. Toda
            actividad es auditada y registrada.</p>
        </div>
      </div>
    </div>
  </div>

</body>

</html>