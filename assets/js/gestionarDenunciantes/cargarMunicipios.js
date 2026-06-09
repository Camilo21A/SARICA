 // ── Cargar municipios según departamento ──────────────
    document.getElementById('inputDepartamento').addEventListener('change', function () {
    const idDep = this.value;
    const selectMun = document.getElementById('inputMunicipio');
    selectMun.innerHTML = '<option value="">Cargando...</option>';

    if (!idDep) {
        selectMun.innerHTML = '<option value="">Primero seleccione departamento...</option>';
        return;
    }

    fetch('../../controller/denunciantes/getMunicipios.php?idDepartamento=' + idDep)
        .then(res => res.json())
        .then(data => {
            selectMun.innerHTML = '<option value="">Seleccionar municipio...</option>';
            data.forEach(m => {
                selectMun.innerHTML += `<option value="${m.idMunicipio}">${m.nombre}</option>`;
            });
        });
});