<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información de la Conexión</legend>

    <div class="formulario__campo">
        <label for="predio_id" class="formulario__label">Predio</label>
        <select
            class="formulario__input"
            id="predio_id"
            name="predio_id">
            <option disabled <?php echo !$conexion->predio_id ? 'selected' : ''; ?>>Selecciona un predio</option>
            <?php foreach ($predios as $predio) { ?>
                <option value="<?php echo $predio->id; ?>"
                    <?php echo ($predio->id === $conexion->predio_id) ? 'selected' : ''; ?>>
                    <?php echo $predio->codigo_predio . ' - ' . $predio->direccion . ' - ' . $predio->contribuyente->nombres . ' ' . $predio->contribuyente->apellidos; ?>
                </option>
            <?php } ?>
        </select>
    </div>


    <div class="formulario__campo">
        <label for="numero_conexiones" class="formulario__label">Número de Conexiones</label>
        <input
            type="text"
            class="formulario__input"
            id="numero_conexiones"
            name="numero_conexiones"
            placeholder="Ej: 2"
            value="<?php echo $conexion->numero_conexiones ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="operativos" class="formulario__label">Conexiones Operativas</label>
        <input
            type="number"
            class="formulario__input"
            id="operativos"
            name="operativos"
            placeholder="Ej: 1"
            value="<?php echo $conexion->operativos ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="no_operativos" class="formulario__label">Conexiones No Operativas</label>
        <input
            type="number"
            class="formulario__input"
            id="no_operativos"
            name="no_operativos"
            placeholder="Ej: 1"
            value="<?php echo $conexion->no_operativos ?? ''; ?>">
    </div>
</fieldset>