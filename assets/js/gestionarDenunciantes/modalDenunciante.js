// ── Abrir modal editar ────────────────────────────────
    function abrirEditar(id, nombre, apellido, tipoDoc, numDoc, genero, estadoCivil, telefono, correo, direccion, idDep, idMun) {
    document.getElementById('modalTitulo').textContent  = 'Editar Denunciante';
    document.getElementById('inputId').value            = id;
    document.getElementById('inputAccion').value        = 'editar';
    document.getElementById('inputNombre').value        = nombre;
    document.getElementById('inputApellido').value      = apellido;
    document.getElementById('inputTipoDoc').value       = tipoDoc;
    document.getElementById('inputNumDoc').value        = numDoc;
    document.getElementById('inputGenero').value        = genero;
    document.getElementById('inputEstadoCivil').value   = estadoCivil;
    document.getElementById('inputTelefono').value      = telefono;
    document.getElementById('inputCorreo').value        = correo;
    document.getElementById('inputDireccion').value     = direccion;

    const selDep = document.getElementById('inputDepartamento');
    selDep.value = idDep;
    selDep.dispatchEvent(new Event('change'));

    setTimeout(() => {
        document.getElementById('inputMunicipio').value = idMun;
    }, 600);

    new bootstrap.Modal(document.getElementById('modalDenunciante')).show();
}

document.getElementById('modalDenunciante').addEventListener('show.bs.modal', function (e) {
    if (e.relatedTarget && e.relatedTarget.hasAttribute('data-bs-target')) {
        document.getElementById('modalTitulo').textContent  = 'Nuevo Denunciante';
        document.getElementById('inputAccion').value        = 'crear';
        document.getElementById('inputId').value            = '';
        document.getElementById('formDenunciante').reset();
        document.getElementById('inputMunicipio').innerHTML = '<option value="">Primero seleccione departamento...</option>';
    }
});