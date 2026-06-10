/* ── Abrir modal en modo editar ─────────────────────────────────── */
/* Recibe todos los datos del funcionario desde los atributos      */
/* onclick en la tabla y los inyecta en los campos del formulario  */
function abrirEditar(id, nombre, apellido, tipoDoc, numDoc, telefono, correo, rol, idCargo) {

    document.getElementById('modalTitulo').textContent  = 'Editar Funcionario';
    document.getElementById('inputId').value            = id;
    document.getElementById('inputAccion').value        = 'editar';
    document.getElementById('inputNombre').value        = nombre;
    document.getElementById('inputApellido').value      = apellido;
    document.getElementById('inputTipoDoc').value       = tipoDoc;
    document.getElementById('inputNumDoc').value        = numDoc;
    document.getElementById('inputTelefono').value      = telefono;
    document.getElementById('inputCorreo').value        = correo;
    document.getElementById('inputRol').value           = rol;
    document.getElementById('inputCargo').value         = idCargo;

    /* Al editar, la contraseña es opcional — se limpia el campo   */
    document.getElementById('inputClave').value         = '';
    document.getElementById('inputClave').removeAttribute('required');

    new bootstrap.Modal(document.getElementById('modalFuncionario')).show();
}

/* ── Resetear modal al abrir en modo crear ──────────────────────── */
document.getElementById('modalFuncionario').addEventListener('show.bs.modal', function (e) {

    /* Solo resetea si se abrió con el botón "+ Nuevo Funcionario"  */
    if (e.relatedTarget && e.relatedTarget.hasAttribute('data-bs-target')) {

        document.getElementById('modalTitulo').textContent  = 'Nuevo Funcionario';
        document.getElementById('inputAccion').value        = 'crear';
        document.getElementById('inputId').value            = '';
        document.getElementById('formFuncionario').reset();

        /* Al crear, la contraseña es obligatoria                   */
        document.getElementById('inputClave').setAttribute('required', 'required');
    }
});