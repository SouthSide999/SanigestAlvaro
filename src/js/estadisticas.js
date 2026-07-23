document.addEventListener('DOMContentLoaded', () => {

    async function obtenerEstadisticas() {
        const response = await fetch('/api/estadisticas');
        return await response.json();
    }

    function graficaMora(pagados, pendientes, mora) {
        const ctx = document.getElementById('grafica-mora');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pagados', 'En Mora'],
                datasets: [{
                    data: [pagados, pendientes],
                    backgroundColor: ['#10b981', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        const moraEl = document.getElementById('estadistica-mora');
        if (moraEl) {
            moraEl.textContent = Number(mora).toFixed(2);
        }
    }


    function graficaRecaudacion(data) {
        const ctx = document.getElementById('grafica-recaudacion');
        if (!ctx) return;

        const labels = data.map(i => `${i.mes}/${i.anio}`);
        const valores = data.map(i => parseFloat(i.total));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Recaudación (S/.)',
                    data: valores,
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'S/.' }
                    }
                }
            }
        });
    }

    /* ===============================
       4. GRÁFICA CONSUMO PROMEDIO
    =============================== */
    function graficaConsumoPromedio(data) {
        const ctx = document.getElementById('grafica-consumo-promedio');
        if (!ctx) return;

        const labels = data.map(i => `${i.mes}/${i.anio}`);
        const valores = data.map(i => parseFloat(i.promedio));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Consumo Promedio (m³)',
                    data: valores,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'm³' }
                    }
                }
            }
        });
    }

    /* ===============================
       5. GRÁFICA SOLICITUDES
    =============================== */
    function graficaSolicitudes(pendientes, atendidas) {
        const ctx = document.getElementById('grafica-solicitudes');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pendientes', 'Atendidas'],
                datasets: [{
                    data: [pendientes, atendidas],
                    backgroundColor: ['#f59e0b', '#10b981']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    /* ===============================
       6. GRÁFICA RECLAMOS
    =============================== */
    function graficaReclamos(pendientes, atendidos) {
        const ctx = document.getElementById('grafica-reclamos');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pendientes', 'Atendidos'],
                datasets: [{
                    data: [pendientes, atendidos],
                    backgroundColor: ['#ef4444', '#10b981']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    /* ===============================
       7. GRÁFICA ESTADO DE PREDIOS
    =============================== */
    function graficaPredios(activos, cortados) {
        const ctx = document.getElementById('grafica-predios');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Activos', 'Cortados'],
                datasets: [{
                    data: [activos, cortados],
                    backgroundColor: ['#3b82f6', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    /* ===============================
       8. EJECUCIÓN GENERAL
    =============================== */
    (async () => {
        const data = await obtenerEstadisticas();

        graficaMora(
            data.recibos.pagados,
            data.recibos.pendientes,
            Number(data.recibos.mora)
        );

        graficaRecaudacion(data.recaudacionMensual);

        graficaConsumoPromedio(data.consumoPromedioMensual);

        graficaSolicitudes(
            data.solicitudes.pendientes,
            data.solicitudes.atendidas
        );

        graficaReclamos(
            data.reclamos.pendientes,
            data.reclamos.atendidos
        );

        graficaPredios(
            data.predios.activos,
            data.predios.cortados
        );
    })();

});
