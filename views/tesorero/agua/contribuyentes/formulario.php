<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Contribuyente</legend>

    <div class="formulario__campo">
        <label for="codigo_contribuyente" class="formulario__label">Código del Contribuyente</label>
        <input
            type="text"
            class="formulario__input"
            id="codigo_contribuyente"
            name="codigo_contribuyente"
            placeholder="Se Ingresa Automaticamente"
            value="<?php echo $contribuyente->codigo_contribuyente ?? ''; ?>"
            disabled>
    </div>

    <div class="formulario__campo">
        <label for="nombres" class="formulario__label">Nombres</label>
        <input
            type="text"
            class="formulario__input"
            id="nombres"
            name="nombres"
            placeholder="Nombres del Contribuyente"
            value="<?php echo $contribuyente->nombres ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="apellidos" class="formulario__label">Apellidos</label>
        <input
            type="text"
            class="formulario__input"
            id="apellidos"
            name="apellidos"
            placeholder="Apellidos del Contribuyente"
            value="<?php echo $contribuyente->apellidos ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="documento_identidad" class="formulario__label">Documento de Identidad (DNI)</label>
        <input
            type="text"
            class="formulario__input"
            id="documento_identidad"
            name="documento_identidad"
            placeholder="DNI"
            value="<?php echo $contribuyente->documento_identidad ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="tipo_usuario" class="formulario__label">Tipo de Usuario</label>
        <select class="formulario__input" id="tipo_usuario" name="tipo_usuario">
            <option value="">-- Seleccionar --</option>
            <option value="natural" <?php echo ($contribuyente->tipo_usuario === 'natural') ? 'selected' : ''; ?>>Natural</option>
            <option value="juridico" <?php echo ($contribuyente->tipo_usuario === 'juridico') ? 'selected' : ''; ?>>Jurídico</option>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="estado_civil" class="formulario__label">Estado Civil</label>
        <select class="formulario__input" id="estado_civil" name="estado_civil">
            <option value="">-- Seleccionar --</option>
            <option value="soltero" <?php echo ($contribuyente->estado_civil === 'soltero') ? 'selected' : ''; ?>>Soltero</option>
            <option value="casado" <?php echo ($contribuyente->estado_civil === 'casado') ? 'selected' : ''; ?>>Casado</option>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="fecha_inscripcion" class="formulario__label">Fecha de Inscripción</label>
        <input
            type="date"
            class="formulario__input"
            id="fecha_inscripcion"
            name="fecha_inscripcion"
            value="<?php echo $contribuyente->fecha_inscripcion ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="observaciones" class="formulario__label">Observaciones</label>
        <textarea
            class="formulario__input"
            id="observaciones"
            name="observaciones"
            placeholder="Observaciones sobre el contribuyente"
            rows="5"><?php echo $contribuyente->observaciones ?? ''; ?></textarea>
    </div>
</fieldset>