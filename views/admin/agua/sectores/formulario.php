<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Sector</legend>
    
    <div class="formulario__campo">
        <label for="nombre_sector" class="formulario__label">Nombre del Sector</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre_sector"
            name="nombre_sector"
            placeholder="Nombre del Sector"
            value="<?php echo $sector->nombre_sector ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="zona_id" class="formulario__label">Seleccionar Zona</label>
        <select class="formulario__input" id="zona_id" name="zona_id">
            <option value="">Seleccione una Zona</option>
            <?php foreach ($zonas as $zona) { ?>
                <option value="<?php echo $zona->id; ?>" <?php echo isset($sector) && $sector->zona_id == $zona->id ? 'selected' : ''; ?>>
                    <?php echo$zona->codigo_zona.'-'. $zona->nombre_zona; ?>
                </option>
            <?php } ?>
        </select>
    </div>

</fieldset>
