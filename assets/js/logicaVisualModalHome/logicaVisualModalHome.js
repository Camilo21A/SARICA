/* ── Referencias al DOM ─────────────────────────────────────────── */
const backdrop   = document.getElementById('sv-backdrop');
const closeBtn   = document.getElementById('sv-close-btn');
const btnAbrir   = document.getElementById('btn-gestionar-funcionarios');
const pwd        = document.getElementById('sv-pwd');
const toggleBtn  = document.getElementById('sv-toggle');
const eyeIco     = document.getElementById('sv-eye-ico');
const errMsg     = document.getElementById('sv-error-pwd');
const confirmBtn = document.getElementById('sv-confirm-btn');

/* ── Abrir modal al clic en "Gestionar Funcionarios" ────────────── */
btnAbrir.addEventListener('click', e => {
    e.preventDefault();
    backdrop.classList.add('activo');
    pwd.focus();
});

/* ── Cerrar con el botón X ──────────────────────────────────────── */
closeBtn.addEventListener('click', cerrarModal);

/* ── Cerrar al hacer clic fuera de la tarjeta ───────────────────── */
backdrop.addEventListener('click', e => {
    if (e.target === backdrop) cerrarModal();
});

/* ── Cerrar con la tecla Escape ─────────────────────────────────── */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && backdrop.classList.contains('activo')) cerrarModal();
});

/* ── Función de cierre reutilizable ─────────────────────────────── */
function cerrarModal() {
    backdrop.classList.remove('activo');
    pwd.value = '';
    pwd.classList.remove('is-error');
    errMsg.style.display = 'none';
}

/* ── Alternar visibilidad de la contraseña ─────────────────────── */
toggleBtn.addEventListener('click', () => {
    const mostrar = pwd.type === 'password';
    pwd.type = mostrar ? 'text' : 'password';

    if (mostrar) {
        /* Ojo tachado — contraseña visible */
        eyeIco.innerHTML = `
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
            <line x1="1" y1="1" x2="23" y2="23"/>`;
    } else {
        /* Ojo normal — contraseña oculta */
        eyeIco.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>`;
    }

    toggleBtn.setAttribute('aria-label', mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña');
});

/* ── Limpiar error al escribir ─────────────────────────────────── */
pwd.addEventListener('input', () => {
    pwd.classList.remove('is-error');
    errMsg.style.display = 'none';
    const errServidor = document.querySelector('.sv-error-msg[style*="display:block"]');
    if (errServidor) errServidor.style.display = 'none';
});

/* ── Enviar con Enter ──────────────────────────────────────────── */
pwd.addEventListener('keydown', e => {
    if (e.key === 'Enter') confirmar();
});

/* ── Validar antes de enviar ───────────────────────────────────── */
confirmBtn.addEventListener('click', confirmar);

function confirmar() {
    if (!pwd.value.trim()) {
        pwd.classList.add('is-error');
        errMsg.style.display = 'block';
        pwd.focus();
    }
}

/* ── Abrir automáticamente si el controller devolvió un error ───── */
// solo abre el modal si viene del controller de confirmar
if (window.location.search.includes('modal=confirmar')) {
    backdrop.classList.add('activo');
}