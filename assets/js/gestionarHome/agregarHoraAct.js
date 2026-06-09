function actualizarFecha() {
    const ahora = new Date();

    // Configuración de idioma (Español)
    const opcionesDia = { weekday: 'long' };
    const opcionesMes = { month: 'long' };

    // 1. Obtener nombre del día (y capitalizar)
    let nombreDia = ahora.toLocaleDateString('es-ES', opcionesDia);
    nombreDia = nombreDia.charAt(0).toUpperCase() + nombreDia.slice(1);

    // 2. Obtener número del día (con cero inicial si es menor a 10)
    const numeroDia = ahora.getDate().toString().padStart(2, '0');

    // 3. Obtener mes y año
    const nombreMes = ahora.toLocaleDateString('es-ES', opcionesMes);
    const anio = ahora.getFullYear();
    const mesYAnio = `${nombreMes} de ${anio}`;

    // Inyectar los datos en el HTML
    document.getElementById('js-dia-nombre').textContent = nombreDia;
    document.getElementById('js-dia-numero').textContent = numeroDia;
    document.getElementById('js-mes-anio').textContent = mesYAnio;
}

// Ejecutar la función al cargar la página
actualizarFecha();