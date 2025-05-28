<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Datos de pago pendiente</legend>

    <div class="formulario__campo">
        <label for="anio" class="formulario__label">Mes</label>
        <input
            type="text"
            class="formulario__input"
            id="mes"
            name="mes"
            value="<?php echo nombreMes($pago->mes); ?>"
            readonly>


    </div>

    <div class="formulario__campo">
        <label for="anio" class="formulario__label">Año</label>
        <input
            type="number"
            class="formulario__input"
            id="anio"
            name="anio"
            value="<?php echo $pago->anio; ?>" readonly>
    </div>

    <div class="formulario__campo">
        <label for="fecha_inicio" class="formulario__label">Fecha de Inicio</label>
        <input
            type="date"
            class="formulario__input"
            id="fecha_inicio"
            name="fecha_inicio"
            value="<?php echo $pago->fecha_inicio; ?>" readonly>
    </div>

    <div class="formulario__campo">
        <label for="fecha_fin" class="formulario__label">Fecha de Fin</label>
        <input
            type="date"
            class="formulario__input"
            id="fecha_fin"
            name="fecha_fin"
            value="<?php echo $pago->fecha_fin; ?>" readonly>
    </div>

    <div class="formulario__campo">
        <label for="consumo_m3" class="formulario__label">Consumo (m³)</label>
        <input
            type="number"
            step="0.01"
            class="formulario__input"
            id="consumo_m3"
            name="consumo_m3"
            value="<?php echo $pago->consumo_m3; ?>" readonly>

    </div>

    <div class="formulario__campo">
        <label for="monto_total" class="formulario__label">Monto Total (S/)</label>
        <input
            type="text"
            class="formulario__input"
            id="monto_total"
            name="monto_total"
            placeholder="Calculado automáticamente"
            value="<?php echo $pago->monto_total; ?>"
            readonly readonly>
    </div>
</fieldset>