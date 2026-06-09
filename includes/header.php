  <!--Header-->
  <header class="sticky-top">
    <div class="container-fluid px-3 px-lg-4">
      <div class="d-flex align-items-center justify-content-between py-2">

        <div class="d-flex align-items-center gap-3">
          <div class="contenedorLogo d-flex align-items-center justify-content-center">
            <img src="../../assets/image/logoSaricaVertical.jpg" alt="SARICA General de la Misión" class="logoFiscalia" />
          </div>
          <div>
            <p class="nombreSistema mb-0">SIGET</p>
            <p class="subtituloSistema mb-0">Gestión de Evidencia</p>
          </div>
        </div>

        <div class="d-flex align-items-center gap-3">
          <div class="d-flex align-items-center gap-2">
            <div class="avatarUsuario d-flex align-items-center justify-content-center">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
              </svg>
            </div>
            <div class="d-none d-sm-block">
              <p class="nombreUsuario mb-0"><?php echo $_SESSION['usuario_nombre'] . " " . $_SESSION['usuario_apellido']; ?></p>
              <p class="rolUsuario mb-0"><?php echo $_SESSION['usuario_rol']; ?></p>
            </div>
          </div>
          <a href="../../controller/cerrarSesion/cerrarSesion.php" class="botonCerrarSesion d-flex align-items-center gap-1">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
              <polyline points="16 17 21 12 16 7" />
              <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            <span class="d-none d-md-inline small">Cerrar sesión</span>
          </a>
        </div>
      </div>
    </div>
    <div class="barraDorada"></div>
  </header>