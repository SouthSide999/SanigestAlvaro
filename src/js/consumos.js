document.addEventListener('DOMContentLoaded', function () {
    alert('prueba')
    const predioSelect = document.getElementById('predio_id');
    const consumoInput = document.getElementById('consumo_m3');
    const montoTotalInput = document.getElementById('monto_total');

    function calcularMonto() {
        const selectedOption = predioSelect.options[predioSelect.selectedIndex];
        const tarifa = parseFloat(selectedOption.dataset.tarifa || 0);
        const consumo = parseFloat(consumoInput.value || 0);
        console.log(selectedOption);

        if (!isNaN(tarifa) && !isNaN(consumo)) {
            const monto = tarifa * consumo;
            montoTotalInput.value = monto.toFixed(2);
        } else {
            montoTotalInput.value = '';
        }
    }

    predioSelect.addEventListener('change', calcularMonto);
    consumoInput.addEventListener('input', calcularMonto);
});
