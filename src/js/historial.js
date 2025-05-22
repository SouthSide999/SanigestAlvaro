document.addEventListener('DOMContentLoaded', () => {
    async function cargarDatos() {
        const url = '/api/historial';
        const respuesta = await fetch(url);
        let resultado = await respuesta.json();

        // Tomar solo los últimos 5 elementos
        resultado = resultado.slice(-5);

        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        const etiquetas = resultado.map(item => `${meses[item.mes - 1]} ${item.anio}`);
        const consumos = resultado.map(item => parseFloat(item.consumo_m3));
        const montos = resultado.map(item => parseFloat(item.monto_total));

        return { etiquetas, consumos, montos };
    }


    function calcularStepMaximo(datos) {
        const max = Math.max(...datos);
        const maxRedondeado = Math.ceil(max / 5) * 5; // redondear hacia arriba al múltiplo de 5
        const step = Math.ceil(maxRedondeado / 5);
        return { max: maxRedondeado, step };
    }

    function graficarConsumo(etiquetas, consumos) {
        const ctxConsumo = document.getElementById('grafica-consumo');
        if (!ctxConsumo) return;

        const { max, step } = calcularStepMaximo(consumos);

        new Chart(ctxConsumo.getContext('2d'), {
            type: 'bar',
            data: {
                labels: etiquetas,
                datasets: [{
                    label: 'Consumo de Agua (m³)',
                    data: consumos,
                    backgroundColor: '#3b82f6',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: max,
                        ticks: {
                            stepSize: step
                        },
                        title: { display: true, text: 'm³' }
                    }
                }
            }
        });

        document.getElementById('max-consumo').textContent = Math.max(...consumos).toFixed(2);
        const promedioConsumo = consumos.reduce((a, b) => a + b, 0) / consumos.length;
        document.getElementById('prom-consumo').textContent = promedioConsumo.toFixed(2);
    }

    function graficarMonto(etiquetas, montos) {
        const ctxMonto = document.getElementById('grafica-monto');
        if (!ctxMonto) return;

        const { max, step } = calcularStepMaximo(montos);

        new Chart(ctxMonto.getContext('2d'), {
            type: 'bar',
            data: {
                labels: etiquetas,
                datasets: [{
                    label: 'Monto Total (S/.)',
                    data: montos,
                    backgroundColor: '#10b981',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: max,
                        ticks: {
                            stepSize: step
                        },
                        title: { display: true, text: 'S/.' }
                    }
                }
            }
        });

        document.getElementById('max-monto').textContent = Math.max(...montos).toFixed(2);
        const promedioMonto = montos.reduce((a, b) => a + b, 0) / montos.length;
        document.getElementById('prom-monto').textContent = promedioMonto.toFixed(2);
    }

    (async () => {
        const { etiquetas, consumos, montos } = await cargarDatos();
        graficarConsumo(etiquetas, consumos);
        graficarMonto(etiquetas, montos);
    })();
});
