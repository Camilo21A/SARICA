<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIGET — Verificación de perfil</title>

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />

    <!-- Tabler Icons (íconos de línea) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/tabler-icons.min.css" />
    <link rel="stylesheet" href="../../assets/css/styleValidarAdministrador/validarAdmin.css" />
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <!--
    ┌─────────────────────────────────────────────────────────────┐
    │  MODAL DE VERIFICACIÓN DE PERFIL                            │
    │  Bootstrap 5 grid/utilities + custom CSS en archivo aparte  │
    └─────────────────────────────────────────────────────────────┘
  -->
    <div class="container-fluid px-3">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4" style="margin-top: 3rem;">

                <!-- Tarjeta principal -->
                <div class="sv-card" role="dialog" aria-modal="true" aria-labelledby="sv-nombre">

                    <!-- Avatar flotante -->
                    <div class="sv-avatar" aria-hidden="true">
                        <i class="ti ti-user"></i>
                    </div>

                    <!-- ── FORMULARIO ───────────────────────────────────────── -->
                    <div class="sv-body" id="sv-form-body">

                        <!-- Fila de marca -->
                        <!-- <div class="sv-brand-row">
                            <div class="sv-brand-dot"></div>
                            <span class="sv-brand-label">SIGET &middot; Verificación</span>
                            <div class="sv-brand-dot"></div>
                        </div> -->

                        <!-- Nombre y rol -->
                        <p class="sv-user-name" id="sv-nombre">Camilo Vela</p>
                        <span class="sv-role-badge">Fiscal</span>

                        <!-- Mensaje de verificación -->
                        <p class="sv-message mt-2">Camilo, verifica que eres tú.</p>
                        <!-- Separador -->
                        <div class="sv-sep"></div>

                        <!-- Campo de contraseña -->
                        <div class="sv-input-group">
                            <i class="ti ti-lock sv-input-icon" aria-hidden="true"></i>
                            <input type="password"id="sv-pwd"class="sv-input" placeholder="Contraseña" autocomplete="current-password" aria-label="Contraseña" aria-describedby="sv-error-pwd" />
                            <button class="sv-toggle-pwd" type="button" id="sv-toggle" aria-label="Mostrar contraseña" title="Mostrar contraseña">
                                <i class="ti ti-eye" id="sv-eye-ico"></i>
                            </button>
                        </div>

                        <!-- Error de validación -->
                        <p class="sv-error-msg" id="sv-error-pwd" role="alert">
                            Por favor ingresa tu contraseña.
                        </p>

                        <!-- Link cambio de usuario -->
                        <!--    <p class="sv-switch-link">
                            ¿No eres Camilo?
                            <a href="#" id="sv-switch-link">Cambiar usuario</a>
                        </p> -->

                    </div><!-- /sv-form-body -->


                    <!-- ── ESTADO DE ÉXITO (se muestra tras confirmar) ──────── -->
                    <div class="sv-success" id="sv-success" aria-live="polite">
                        <div class="sv-success-icon mx-auto">
                            <i class="ti ti-check" aria-hidden="true"></i>
                        </div>
                        <p class="sv-success-title">Identidad confirmada</p>
                        <p class="sv-success-msg">Bienvenido, Camilo. Redirigiendo al panel…</p>
                    </div>


                    <!-- ── PIE INSTITUCIONAL ────────────────────────────────── -->
                    <!--
            Nota: este footer se oculta cuando aparece el estado de éxito
            porque el botón Confirmar toma su lugar.
            Si prefieres mostrarlo siempre, elimina el id="sv-inst-footer".
          -->
                    <div class="sv-footer" id="sv-inst-footer">
                        <i class="ti ti-lock" aria-hidden="true"></i>
                        <span>
                            Acceso exclusivo para personal autorizado de la
                            Fiscalía Misión de la Nación. Toda actividad es
                            auditada y registrada.
                        </span>
                    </div>


                    <!-- ── BOTÓN CONFIRMAR (barra inferior flotante) ────────── -->
                    <button
                        type="button"
                        class="sv-confirm-btn"
                        id="sv-confirm-btn">
                        <i class="ti ti-shield-check" aria-hidden="true"></i>
                        Confirmar
                    </button>

                </div><!-- /sv-card -->

            </div><!-- /col -->
        </div><!-- /row -->
    </div><!-- /container -->


    <!-- Bootstrap 5 JS Bundle (Popper incluido) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmHgENSj5kSCQJaGXLzFkV3dHJzL"
        crossorigin="anonymous"></script>

    <!-- Lógica de la vista de verificación -->
    <script>
        const pwd = document.getElementById('sv-pwd');
        const toggleBtn = document.getElementById('sv-toggle');
        const eyeIco = document.getElementById('sv-eye-ico');
        const errMsg = document.getElementById('sv-error-pwd');
        const confirmBtn = document.getElementById('sv-confirm-btn');
        const switchLink = document.getElementById('sv-switch-link');
        const formBody = document.getElementById('sv-form-body');
        const successDiv = document.getElementById('sv-success');
        const instFooter = document.getElementById('sv-inst-footer');

        /* ── Alternar visibilidad de la contraseña ─────────────────── */
        toggleBtn.addEventListener('click', () => {
            const mostrar = pwd.type === 'password';
            pwd.type = mostrar ? 'text' : 'password';
            eyeIco.classList.toggle('ti-eye', !mostrar);
            eyeIco.classList.toggle('ti-eye-off', mostrar);
            toggleBtn.setAttribute('aria-label', mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña');
        });

        /* ── Limpiar error al escribir ─────────────────────────────── */
        pwd.addEventListener('input', () => {
            pwd.classList.remove('is-error');
            errMsg.style.display = 'none';
        });

        /* ── Enviar con Enter ──────────────────────────────────────── */
        pwd.addEventListener('keydown', e => {
            if (e.key === 'Enter') confirmar();
        });

        /* ── Confirmar identidad ───────────────────────────────────── */
        confirmBtn.addEventListener('click', confirmar);

        function confirmar() {
            if (!pwd.value.trim()) {
                pwd.classList.add('is-error');
                errMsg.style.display = 'block';
                pwd.focus();
                return;
            }

            /*
              ✅ AQUÍ VA TU LÓGICA DE AUTENTICACIÓN PHP/AJAX
              ─────────────────────────────────────────────
              Ejemplo con fetch:

              fetch('/verificar-identidad', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ password: pwd.value })
              })
              .then(res => res.json())
              .then(data => {
                if (data.ok) mostrarExito();
                else { pwd.classList.add('is-error'); errMsg.textContent = 'Contraseña incorrecta.'; errMsg.style.display = 'block'; }
              });

              Por ahora muestra el estado de éxito directamente:
            */
            mostrarExito();
        }

        function mostrarExito() {
            formBody.style.display = 'none';
            instFooter.style.display = 'none';
            successDiv.style.display = 'block';

            confirmBtn.innerHTML = '<i class="ti ti-arrow-left"></i> Volver al sistema';
            /* 🔄 Redirige a tu dashboard: window.location.href = '/dashboard'; */
        }

        /* ── Cambiar usuario ───────────────────────────────────────── */
        switchLink.addEventListener('click', e => {
            e.preventDefault();
            /*
              🔄 AQUÍ VA TU LÓGICA DE CIERRE DE SESIÓN
              window.location.href = '/logout';
            */
            alert('Redirigiendo a selección de usuario…');
        });
    </script>

</body>

</html>