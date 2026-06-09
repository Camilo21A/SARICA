<?php
session_start();

// ¿No existe la sesión del usuario? ¡Para afuera!
if (!isset($_SESSION['usuario_id'])) {
    // Como estamos dentro de la carpeta 'view', entramos directo a 'administrarLogin'
    header('Location: administrarLogin/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bienvenido - SIGET</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/styleHome/home.css">
    <link rel="stylesheet" href="../../assets/css/styleHeader/header.css">
    <link rel="stylesheet" href="../../assets/css/styleModalHome/modalHome.css">
    <script src="../../assets/js/gestionarHome/agregarHoraAct.js"></script>

</head>

<body>
    <!-- ══════════════ HEADER ══════════════ -->
    <header class="sticky-top">
        <?php include("../../includes/header.php") ?>
        <!-- Barra móvil con hamburguesa (solo visible < 624px) -->
        <div class="barraMobil">
            <span class="barraMobilTitulo">Menú</span>
            <button class="botonHamburguesa" id="btnHamburguesa" aria-label="Abrir menú">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>
    <!-- ══════════════ BREADCRUMB ══════════════ -->
    <div class="container-fluid px-3 px-lg-4 py-2 rutaNavegacion">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="inicio.html" class="enlaceInicio">Fiscalía</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="inicio.html" class="enlaceInicio">SIGET</a>
                </li>
                <li class="breadcrumb-item active enlaceActiva" aria-current="page">Inicio</li>
            </ol>
        </nav>
    </div>

    <!-- Overlay oscuro detrás del sidebar en móvil -->
    <div class="sidebarOverlay" id="sidebarOverlay"></div>

    <!-- ══════════════ LAYOUT: SIDEBAR + CONTENIDO ══════════════ -->
    <div class="contenedorPagina">

        <!-- ── SIDEBAR ── -->
        <aside class="sidebar">

            <p class="sidebarSeccionTitulo">Menú principal</p>
            <a href="home.php" class="sidebarItem activo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                Inicio
            </a>

            <hr class="sidebarDivider" />
            <p class="sidebarSeccionTitulo">Gestión</p>
            <a href="" class="sidebarItem" id="btn-gestionar-funcionarios">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="120" height="120" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="8.5" cy="7" r="4" />
                    <polyline points="18 8 20 10 24 6" />
                    <circle cx="19" cy="16" r="3" />
                    <line x1="4" y1="3.5" x2="13" y2="3.5" stroke-linecap="round" />
                    <rect x="5.5" y="1" width="6" height="2.5" rx="0.5" fill="currentColor" stroke="none" />
                </svg>
                Gestionar Funcionarios
            </a>

            <a href="../administrarDenunciantes/denunciantes.php" class="sidebarItem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Gestionar Denunciantes
            </a>

            <a href="../administrarRegistroCadenaCustodia/registroCadenaCustodia.php" class="sidebarItem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L3 7v5c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7L12 2z" />
                </svg>
                Nueva Cadena de Custodia
            </a>

            <a href="../administrarRegistroCadenaCustodia/listarRegistros.php" class="sidebarItem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                </svg>
                Ver Registros
            </a>

            <a href="" class="sidebarItem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                </svg>
                Registro de casos
            </a>

            <a href="" class="sidebarItem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2" />
                    <line x1="8" y1="21" x2="16" y2="21" />
                    <line x1="12" y1="17" x2="12" y2="21" />
                </svg>
                Evidencia digital
            </a>

            <hr class="sidebarDivider" />
            <p class="sidebarSeccionTitulo">Reportes</p>

            <a href="" class="sidebarItem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="20" x2="18" y2="10" />
                    <line x1="12" y1="20" x2="12" y2="4" />
                    <line x1="6" y1="20" x2="6" y2="14" />
                </svg>
                Reportes
            </a>

            <a href="" class="sidebarItem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                </svg>
                Actas y documentos
            </a>

            <hr class="sidebarDivider" />
            <p class="sidebarSeccionTitulo">Sistema</p>

            <a href="" class="sidebarItem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3" />
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33
            1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06
            a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09
            A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9
            4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06
            a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09
            a1.65 1.65 0 0 0-1.51 1z" />
                </svg>
                Configuración
            </a>

            <div class="sidebarPie">
                SIGET © 2025<br />Sarica General de la Misión
            </div>

        </aside>

        <!-- ══════════════ CONTENIDO PRINCIPAL ══════════════ -->
        <main class="contenidoPrincipal">

            <!-- Banner de bienvenida -->
            <div class="bannerBienvenida d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <h1 class="tituloBienvenida mb-1">Bienvenido,
                        <?php echo $_SESSION['usuario_nombre'] . ' ' . $_SESSION['usuario_apellido']; ?></h1>
                    <p class="subtituloBienvenida mb-0"><?php echo $_SESSION['usuario_rol']; ?> — Seccional Tunja</p>
                </div>
                <div class="fechaBanner">
                    <!-- Se agrega la fevha actual Usando js. -->
                    <p id="js-dia-nombre" class="diaFecha mb-0">Cargando...</p>
                    <p id="js-dia-numero" class="numeroDia mb-0">--</p>
                    <p id="js-mes-anio" class="mesFecha mb-0">...</p>
                    <script src="../../assets/js/gestionarHome/agregarHoraAct.js"></script>

                </div>
            </div>

            <!-- Alerta institucional -->
            <div class="alertaInstitucional d-flex align-items-start gap-2 mb-4">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"
                    style="margin-top:1px; flex-shrink:0;">
                    <path
                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                <p class="mb-0">
                    <strong>Recordatorio institucional:</strong> Todo acceso y actividad en este sistema es auditado y
                    registrado.
                    Acceso exclusivo para personal autorizado de la Fiscalía General de la Nación.
                </p>
            </div>

            <!-- Métricas -->
            <p class="tituloSeccionInterna">Resumen</p>
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="tarjetaMetrica">
                        <div class="iconoMetrica azul">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20"
                                height="20">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="numeroMetrica mb-0">142</p>
                            <p class="etiquetaMetrica mb-0">Casos activos</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="tarjetaMetrica">
                        <div class="iconoMetrica verde">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20"
                                height="20">
                                <path d="M12 2L3 7v5c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7L12 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="numeroMetrica mb-0">87</p>
                            <p class="etiquetaMetrica mb-0">Cadenas registradas</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="tarjetaMetrica">
                        <div class="iconoMetrica dorado">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20"
                                height="20">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div>
                            <p class="numeroMetrica mb-0">34</p>
                            <p class="etiquetaMetrica mb-0">Denunciantes</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="tarjetaMetrica">
                        <div class="iconoMetrica rojo">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20"
                                height="20">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                        <div>
                            <p class="numeroMetrica mb-0">5</p>
                            <p class="etiquetaMetrica mb-0">Pendientes hoy</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acceso rápido -->
            <p class="tituloSeccionInterna">Acceso rápido</p>
            <div class="row g-3 mb-4">

                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="../administrarRegistroCadenaCustodia/registroCadenaCustodia.php" class="tarjetaAcceso">
                        <div class="iconoAcceso azul">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22"
                                height="22">
                                <path d="M12 2L3 7v5c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7L12 2z" />
                            </svg>
                        </div>
                        <p class="tituloAcceso mb-1">Nueva cadena de custodia</p>
                        <p class="descripcionAcceso mb-0">Registra la incautación y genera el acta de cadena de
                            custodia.</p>
                        <span class="etiquetaAcceso">Registro</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="../administrarDenunciantes/denunciantes.php" class="tarjetaAcceso">
                        <div class="iconoAcceso verde">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22"
                                height="22">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <line x1="19" y1="8" x2="19" y2="14" />
                                <line x1="22" y1="11" x2="16" y2="11" />
                            </svg>
                        </div>
                        <p class="tituloAcceso mb-1">Registrar denunciante</p>
                        <p class="descripcionAcceso mb-0">Ingresa los datos del ciudadano denunciante al sistema.</p>
                        <span class="etiquetaAcceso verde">Gestión</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="" class="tarjetaAcceso">
                        <div class="iconoAcceso dorado">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22"
                                height="22">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </div>
                        <p class="tituloAcceso mb-1">Consultar evidencia</p>
                        <p class="descripcionAcceso mb-0">Busca y consulta el estado de evidencias por número de caso.
                        </p>
                        <span class="etiquetaAcceso dorado">Consulta</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="" class="tarjetaAcceso">
                        <div class="iconoAcceso morado">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22"
                                height="22">
                                <line x1="18" y1="20" x2="18" y2="10" />
                                <line x1="12" y1="20" x2="12" y2="4" />
                                <line x1="6" y1="20" x2="6" y2="14" />
                            </svg>
                        </div>
                        <p class="tituloAcceso mb-1">Generar reporte</p>
                        <p class="descripcionAcceso mb-0">Exporta reportes de casos, cadenas y estadísticas del período.
                        </p>
                        <span class="etiquetaAcceso morado">Reportes</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="" class="tarjetaAcceso">
                        <div class="iconoAcceso rojo">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22"
                                height="22">
                                <rect x="2" y="3" width="20" height="14" rx="2" />
                                <line x1="8" y1="21" x2="16" y2="21" />
                                <line x1="12" y1="17" x2="12" y2="21" />
                            </svg>
                        </div>
                        <p class="tituloAcceso mb-1">Evidencia digital</p>
                        <p class="descripcionAcceso mb-0">Gestiona archivos digitales asociados a casos en curso.</p>
                        <span class="etiquetaAcceso rojo">Archivos</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="" class="tarjetaAcceso">
                        <div class="iconoAcceso gris">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22"
                                height="22">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                            </svg>
                        </div>
                        <p class="tituloAcceso mb-1">Actas y documentos</p>
                        <p class="descripcionAcceso mb-0">Visualiza y descarga actas generadas por el sistema.</p>
                        <span class="etiquetaAcceso gris">Documentos</span>
                    </a>
                </div>

            </div>

            <!-- Actividad reciente + Pendientes -->
            <div class="row g-3">

                <!-- Actividad reciente -->
                <div class="col-12 col-lg-6">
                    <p class="tituloSeccionInterna">Actividad reciente</p>
                    <div class="tarjetaLista">
                        <div class="encabezadoLista">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14"
                                height="14">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            Últimos movimientos
                        </div>
                        <div class="filaActividad">
                            <div class="puntito verde"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Cadena de custodia registrada</p>
                                <p class="casoActividad mb-0">Caso #2025-00341</p>
                            </div>
                            <span class="tiempoActividad">hace 12 min</span>
                        </div>
                        <div class="filaActividad">
                            <div class="puntito azul"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Denunciante vinculado</p>
                                <p class="casoActividad mb-0">Caso #2025-00339</p>
                            </div>
                            <span class="tiempoActividad">hace 1 h</span>
                        </div>
                        <div class="filaActividad">
                            <div class="puntito dorado"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Evidencia cargada</p>
                                <p class="casoActividad mb-0">Caso #2025-00335</p>
                            </div>
                            <span class="tiempoActividad">hace 3 h</span>
                        </div>
                        <div class="filaActividad">
                            <div class="puntito rojo"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Reporte generado</p>
                                <p class="casoActividad mb-0">Período jun 2025</p>
                            </div>
                            <span class="tiempoActividad">ayer</span>
                        </div>
                        <div class="filaActividad">
                            <div class="puntito azul"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Caso actualizado</p>
                                <p class="casoActividad mb-0">Caso #2025-00330</p>
                            </div>
                            <span class="tiempoActividad">ayer</span>
                        </div>
                    </div>
                </div>

                <!-- Pendientes -->
                <div class="col-12 col-lg-6">
                    <p class="tituloSeccionInterna">Pendientes</p>
                    <div class="tarjetaLista">
                        <div class="encabezadoLista rojo">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14"
                                height="14">
                                <path
                                    d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <line x1="12" y1="9" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                            Requieren atención
                        </div>
                        <div class="filaActividad">
                            <div class="puntito rojo"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Cadena sin firma digital</p>
                                <p class="casoActividad mb-0">Caso #2025-00340</p>
                            </div>
                            <span class="tiempoActividad urgente">Urgente</span>
                        </div>
                        <div class="filaActividad">
                            <div class="puntito dorado"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Denunciante sin documentar</p>
                                <p class="casoActividad mb-0">Caso #2025-00338</p>
                            </div>
                            <span class="tiempoActividad">Hoy</span>
                        </div>
                        <div class="filaActividad">
                            <div class="puntito dorado"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Evidencia pendiente de carga</p>
                                <p class="casoActividad mb-0">Caso #2025-00336</p>
                            </div>
                            <span class="tiempoActividad">Hoy</span>
                        </div>
                        <div class="filaActividad">
                            <div class="puntito azul"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Acta por generar</p>
                                <p class="casoActividad mb-0">Caso #2025-00329</p>
                            </div>
                            <span class="tiempoActividad">Esta semana</span>
                        </div>
                        <div class="filaActividad">
                            <div class="puntito azul"></div>
                            <div class="textoActividad">
                                <p class="mb-0">Reporte mensual pendiente</p>
                                <p class="casoActividad mb-0">Julio 2025</p>
                            </div>
                            <span class="tiempoActividad">Esta semana</span>
                        </div>
                    </div>
                </div>

            </div>
            <!-- fin row actividad -->

        </main>
        <!-- fin contenidoPrincipal -->

    </div>
    <!-- fin contenedorPagina -->
    <?php include("../administrarModalHome/modalHome.php") ?>
    <script>
        const btn = document.getElementById('btnHamburguesa');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const items = document.querySelectorAll('.sidebarItem');

        function abrirSidebar() {
            sidebar.classList.add('abierto');
            overlay.classList.add('visible');
            btn.classList.add('activo');
        }

        function cerrarSidebar() {
            sidebar.classList.remove('abierto');
            overlay.classList.remove('visible');
            btn.classList.remove('activo');
        }

        btn.addEventListener('click', () => {
            sidebar.classList.contains('abierto') ? cerrarSidebar() : abrirSidebar();
        });

        overlay.addEventListener('click', cerrarSidebar);

        // Cerrar al seleccionar una opción (solo en móvil)
        items.forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 624) cerrarSidebar();
            });
        });
    </script>
    <script src="../../assets/js/logicaVisualModalHome/logicaVisualModalHome.js"></script>
</body>

</html>