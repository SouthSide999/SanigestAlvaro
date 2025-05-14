<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información de la Zona</legend>
   <div class="formulario__campo">
        <label for="nombre_zona" class="formulario__label">Nombre de la Zona</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre_zona"
            name="nombre_zona"
            placeholder="Nombre de la Zona"
            value="<?php echo $zona->nombre_zona ?? ''; ?>">
    </div>
</fieldset>
