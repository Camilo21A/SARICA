<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/* ¿No existe la sesión del usuario? ¡Para afuera! */
if (!isset($_SESSION['usuario_id'])) {
    header('Location: administrarLogin/login.php');
    exit;
}
?>
<!-- ══════════════ MODAL CONFIRMAR ADMINISTRADOR ══════════════ -->
<div class="sv-backdrop" id="sv-backdrop" role="dialog" aria-modal="true" aria-labelledby="sv-nombre">

    <div class="sv-card">

        <!-- Avatar flotante -->
        <div class="sv-avatar" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
            </svg>
        </div>

        <!-- Botón cerrar (X) -->
        <button class="sv-close-btn" id="sv-close-btn" aria-label="Cerrar">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>

        <!--
        ── FORMULARIO ──────────────────────────────────────────-->
        <form class="sv-body" id="sv-form"
            action="../../controller/validarAdministrador/validarAdministrador.php"
            method="POST">

            <!-- Nombre y rol (viene de la sesión PHP) -->
            <p class="sv-user-name" id="sv-nombre">
                <?php echo $_SESSION['usuario_nombre'] . ' ' . $_SESSION['usuario_apellido']; ?>
            </p>
            <span class="sv-role-badge"><?php echo $_SESSION['usuario_rol']; ?></span>

            <!-- Mensaje de verificación -->
            <p class="sv-message mt-2">
                <?php echo $_SESSION['usuario_nombre']; ?>, verifica que eres tú.
            </p>

            <!-- Separador -->
            <div class="sv-sep"></div>

            <!-- Campo de contraseña -->
            <div class="sv-input-group">

                <!-- Ícono candado (izquierda) -->
                <span class="sv-input-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </span>

                <!--
                name="contrasena" es lo que recibe $_POST['contrasena']
                en el controller
                -->
                <input type="password" id="sv-pwd" name="contrasena" class="sv-input"
                    placeholder="Contraseña" autocomplete="current-password"
                    aria-label="Contraseña" aria-describedby="sv-error-pwd" />

                <!-- Botón ojo (derecha) — toggle manejado por JS -->
                <button class="sv-toggle-pwd" type="button" id="sv-toggle"
                    aria-label="Mostrar contraseña" title="Mostrar contraseña">
                    <svg id="sv-eye-ico" xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>

            <!-- Error de validación del JS (campo vacío) -->
            <p class="sv-error-msg" id="sv-error-pwd" role="alert">
                Por favor ingresa tu contraseña.
            </p>

            <?php if (isset($_GET['error'])): ?>
                <!-- Error devuelto por el controller via URL -->
                <p class="sv-error-msg" style="display:block;">
                    <?php
                    $mensajes = [
                        'incorrecta'  => 'Contraseña incorrecta. Intenta de nuevo.',
                        'vacia'       => 'Por favor ingresa tu contraseña.',
                        'usuario'     => 'Usuario no encontrado.',
                        'servidor'    => 'Error de servidor. Contacta al administrador.',
                        'privilegios' => 'No cuentas con los privilegios necesarios. Solo los Administradores pueden acceder.',
                    ];
                    echo $mensajes[$_GET['error']] ?? 'Error desconocido.';
                    ?>
                </p>
            <?php endif; ?>

        </form><!-- /sv-body -->

        <!-- ── PIE INSTITUCIONAL ──────────────────────────────── -->
        <div class="sv-footer">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"
                style="flex-shrink:0; margin-top:1px;">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
            <span>
                Acceso exclusivo para personal autorizado de la
                Fiscalía Misión de la Nación. Toda actividad es
                auditada y registrada.
            </span>
        </div>

        <!-- ── BOTÓN CONFIRMAR ─────── -->
        <button type="submit" form="sv-form" class="sv-confirm-btn" id="sv-confirm-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                <polyline points="9 12 11 14 15 10" />
            </svg>
            Confirmar
        </button>

    </div><!-- /sv-card -->
</div><!-- /sv-backdrop -->