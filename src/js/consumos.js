document.addEventListener('DOMContentLoaded', function () {
    const predioSelect = document.getElementById('predio_id');
    const consumoInput = document.getElementById('consumo_m3');
    const montoAguaInput = document.getElementById('monto_agua');
    const montoDesagueInput = document.getElementById('monto_desague');
    const montoTotalInput = document.getElementById('monto_total');

    function calcularMontos() {
        const selectedOption = predioSelect.options[predioSelect.selectedIndex];

        const tarifaAgua = parseFloat(selectedOption.dataset.tarifa || 0);
        const tarifaDesague = parseFloat(selectedOption.dataset.desague || 0);
        const cargoFijo = parseFloat(selectedOption.dataset.cargo || 0);
        const consumo = parseFloat(consumoInput.value || 0);

        if (!isNaN(tarifaAgua) && !isNaN(tarifaDesague) && !isNaN(cargoFijo) && !isNaN(consumo)) {
            const montoAgua = tarifaAgua * consumo;
            const montoDesague = tarifaDesague * consumo;
            const montoTotal = montoAgua + montoDesague + cargoFijo;

            montoAguaInput.value = montoAgua.toFixed(2);
            montoDesagueInput.value = montoDesague.toFixed(2);
            montoTotalInput.value = montoTotal.toFixed(2);
        } else {
            montoAguaInput.value = '';
            montoDesagueInput.value = '';
            montoTotalInput.value = '';
        }
    }

    predioSelect.addEventListener('change', calcularMontos);
    consumoInput.addEventListener('input', calcularMontos);
});
