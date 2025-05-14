<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información de la Tarifa</legend>

    <div class="formulario__campo">
        <label for="codigo_tarifa" class="formulario__label">Código de Tarifa</label>
        <input
            type="text"
            class="formulario__input"
            id="codigo_tarifa"
            name="codigo_tarifa"
            placeholder="Se Crea El Codigo Automaticamente"
            value="<?php echo $tarifa->codigo_tarifa ?? ''; ?>"
            disabled>
    </div>

    <div class="formulario__campo">
        <label for="nombre_tarifa" class="formulario__label">Nombre de la Tarifa</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre_tarifa"
            name="nombre_tarifa"
            placeholder="Ej: Tarifa Plana"
            value="<?php echo $tarifa->nombre_tarifa ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="valor_tarifa" class="formulario__label">Valor de la Tarifa (S/.)</label>
        <input
            type="number"
            step="0.01"
            class="formulario__input"
            id="valor_tarifa"
            name="valor_tarifa"
            placeholder="Ej: 4.00"
            value="<?php echo !empty($tarifa->valor_tarifa) ? $tarifa->valor_tarifa : ''; ?>">
    </div>
</fieldset>