<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Medidor</legend>

    <div class="formulario__campo">
        <label for="contribuyente_id" class="formulario__label">Contribuyente</label>
        <select
            class="formulario__input"
            id="contribuyente_id"
            name="contribuyente_id">
            <option disabled <?php echo !$medidor->contribuyente_id ? 'selected' : ''; ?>>Selecciona un contribuyente</option>
            <?php foreach ($contribuyentes as $contribuyente) { ?>
                <option value="<?php echo $contribuyente->id; ?>"
                    <?php echo ($contribuyente->id === $medidor->contribuyente_id) ? 'selected' : ''; ?>>
                    <?php echo $contribuyente->nombres . '  ' . $contribuyente->apellidos; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="predio_id" class="formulario__label">Predio</label>
        <select
            class="formulario__input"
            id="predio_id"
            name="predio_id">
            <option disabled <?php echo !$medidor->predio_id ? 'selected' : ''; ?>>Selecciona un predio</option>
            <?php foreach ($predios as $predio) { ?>
                <option value="<?php echo $predio->id; ?>"
                    <?php echo ($predio->id === $medidor->predio_id) ? 'selected' : ''; ?>>
                    <?php echo $predio->codigo_predio . ' - ' . $predio->direccion . ' - ' . $predio->contribuyente->nombres . ' ' . $predio->contribuyente->apellidos; ?>
                </option>
            <?php } ?>
        </select>
    </div>



    <div class="formulario__campo">
        <label for="numero_medidor" class="formulario__label">Número de Medidor</label>
        <input
            type="text"
            class="formulario__input"
            id="numero_medidor"
            name="numero_medidor"
            placeholder="Ej: 123456"
            value="<?php echo $medidor->numero_medidor ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="numero_personas" class="formulario__label">Número de Personas</label>
        <input
            type="number"
            class="formulario__input"
            id="numero_personas"
            name="numero_personas"
            placeholder="Ej: 5"
            value="<?php echo $medidor->numero_personas ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="padres" class="formulario__label">Número de Padres</label>
        <input
            type="number"
            class="formulario__input"
            id="padres"
            name="padres"
            placeholder="Ej: 2"
            value="<?php echo $medidor->padres ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="hijos" class="formulario__label">Número de Hijos</label>
        <input
            type="number"
            class="formulario__input"
            id="hijos"
            name="hijos"
            placeholder="Ej: 3"
            value="<?php echo $medidor->hijos ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="familiares" class="formulario__label">Número de Familiares</label>
        <input
            type="number"
            class="formulario__input"
            id="familiares"
            name="familiares"
            placeholder="Ej: 2"
            value="<?php echo $medidor->familiares ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="inquilinos" class="formulario__label">Número de Inquilinos</label>
        <input
            type="number"
            class="formulario__input"
            id="inquilinos"
            name="inquilinos"
            placeholder="Ej: 1"
            value="<?php echo $medidor->inquilinos ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="observaciones" class="formulario__label">Observaciones</label>
        <textarea
            class="formulario__input"
            id="observaciones"
            name="observaciones"
            placeholder="Escribe alguna observación sobre el medidor"><?php echo $medidor->observaciones ?? ''; ?></textarea>
    </div>


</fieldset>