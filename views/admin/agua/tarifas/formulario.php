<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información de la Tarifa</legend>

    <div class="formulario__campo">
        <label for="codigo_tarifa" class="formulario__label">Código de Tarifa</label>
        <input
            type="text"
            class="formulario__input"
            id="codigo_tarifa"
            name="codigo_tarifa"
            placeholder="Se genera automáticamente"
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
            placeholder="Ej: Doméstico 0-8 m³"
            value="<?php echo $tarifa->nombre_tarifa ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="clase" class="formulario__label">Clase</label>
        <select class="formulario__input" id="clase" name="clase">
            <option value="" disabled selected>-- Seleccionar --</option>
            <?php
            $clases = ['Residencial', 'Doméstico', 'No Residencial', 'Comercial I', 'Comercial II', 'Industrial', 'Estatal'];
            foreach ($clases as $opcion) :
            ?>
                <option value="<?php echo $opcion; ?>" <?php echo ($tarifa->clase === $opcion) ? 'selected' : ''; ?>>
                    <?php echo $opcion; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Categoría</label>
        <input
            type="text"
            class="formulario__input"
            id="categoria"
            name="categoria"
            placeholder="Ej: Social, Comercial I, General"
            value="<?php echo $tarifa->categoria ?? 'General'; ?>">
    </div>

    <div class="formulario__campo">
        <label for="rango_min" class="formulario__label">Rango Mínimo (m³)</label>
        <input
            type="number"
            class="formulario__input"
            id="rango_min"
            name="rango_min"
            min="0"
            value="<?php echo $tarifa->rango_min ?? 0; ?>">
    </div>

    <div class="formulario__campo">
        <label for="rango_max" class="formulario__label">Rango Máximo (m³)</label>
        <input
            type="number"
            class="formulario__input"
            id="rango_max"
            name="rango_max"
            min="0"
            value="<?php echo $tarifa->rango_max ?? 9999; ?>">
    </div>

    <div class="formulario__campo">
        <label for="tarifa_agua" class="formulario__label">Tarifa Agua (S/ por m³)</label>
        <input
            type="number"
            step="0.0001"
            class="formulario__input"
            id="tarifa_agua"
            name="tarifa_agua"
            placeholder="Ej: 1.0674"
            value="<?php echo $tarifa->tarifa_agua ?? 0.0000; ?>">
    </div>

    <div class="formulario__campo">
        <label for="tarifa_desague" class="formulario__label">Tarifa Desagüe (S/ por m³)</label>
        <input
            type="number"
            step="0.0001"
            class="formulario__input"
            id="tarifa_desague"
            name="tarifa_desague"
            placeholder="Ej: 0.9103"
            value="<?php echo $tarifa->tarifa_desague ?? 0.0000; ?>">
    </div>

    <div class="formulario__campo">
        <label for="cargo_fijo" class="formulario__label">Cargo Fijo (S/ por mes)</label>
        <input
            type="number"
            step="0.01"
            class="formulario__input"
            id="cargo_fijo"
            name="cargo_fijo"
            placeholder="Ej: 5.11"
            value="<?php echo $tarifa->cargo_fijo ?? 0.00; ?>">
    </div>
</fieldset>
