
document.addEventListener('DOMContentLoaded', function () {
    const mesSelect = document.getElementById('mes');
    const anioInput = document.getElementById('anio');
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const fechaFinInput = document.getElementById('fecha_fin');

    mesSelect.addEventListener('change', function () {
        const mes = parseInt(this.value);
        const anio = parseInt(anioInput.value);

        if (!mes || !anio) return;

        // Asegura dos dígitos en el mes (01, 02, etc.)
        const mesFormateado = mes.toString().padStart(2, '0');

        // Fecha inicio = primer día del mes
        fechaInicioInput.value = `${anio}-${mesFormateado}-01`;

        // Obtener último día del mes
        const ultimoDia = new Date(anio, mes, 0).getDate(); // el "0" obtiene el último día del mes anterior al mes+1
        fechaFinInput.value = `${anio}-${mesFormateado}-${ultimoDia}`;
    });
});

