<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Predio</legend>

    <div class="formulario__campo">
        <label for="codigo_predio" class="formulario__label">Código del Predio</label>
        <input
            type="text"
            class="formulario__input"
            id="codigo_predio"
            name="codigo_predio"
            placeholder="Ingresado Automaticamente"
            value="<?php echo s($predio->codigo_predio ?? ''); ?>"
            disabled>
    </div>

    <div class="formulario__campo">
        <label for="contribuyente_id" class="formulario__label">Contribuyente</label>
        <select class="formulario__input" id="contribuyente_id" name="contribuyente_id">
            <option value="" disabled selected>-- Seleccionar --</option>
            <?php foreach ($contribuyentes as $contribuyente) : ?>
                <option value="<?php echo $contribuyente->id; ?>"
                    <?php echo ($predio->contribuyente_id == $contribuyente->id) ? 'selected' : ''; ?>>
                    <?php echo $contribuyente->nombres . ' ' . $contribuyente->apellidos; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="formulario__campo">
        <label for="tarifa_id" class="formulario__label">Tarifa</label>
        <select class="formulario__input" id="tarifa_id" name="tarifa_id">
            <option value="" disabled selected>-- Seleccionar --</option>
            <?php foreach ($tarifas as $tarifa) : ?>
                <option value="<?php echo $tarifa->id; ?>"
                    <?php echo ($predio->tarifa_id == $tarifa->id) ? 'selected' : ''; ?>>
                    <?php echo $tarifa->codigo_tarifa . ' - ' . $tarifa->nombre_tarifa . ' (S/' . number_format($tarifa->valor_tarifa, 2) . ')'; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="formulario__campo">
        <label for="zona_id" class="formulario__label">Zona</label>
        <select class="formulario__input" id="zona_id" name="zona_id">
            <option value="" disabled selected>-- Seleccionar --</option>
            <?php foreach ($zonas as $zona) : ?>
                <option value="<?php echo $zona->id; ?>"
                    <?php echo ($predio->zona_id == $zona->id) ? 'selected' : ''; ?>>
                    <?php echo $zona->nombre_zona; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="sector_id" class="formulario__label">Sector</label>
        <select class="formulario__input" id="sector_id" name="sector_id">
            <option value="" disabled selected>-- Seleccionar --</option>
            <?php foreach ($sectores as $sector) : ?>
                <option value="<?php echo $sector->id; ?>"
                    <?php echo ($predio->sector_id == $sector->id) ? 'selected' : ''; ?>>
                    <?php echo $sector->nombre_sector; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="manzana" class="formulario__label">Manzana</label>
        <input
            type="text"
            class="formulario__input"
            id="manzana"
            name="manzana"
            placeholder="Ej: MZ-A"
            value="<?php echo s($predio->manzana ?? ''); ?>">
    </div>

    <div class="formulario__campo">
        <label for="lote_numero" class="formulario__label">Lote</label>
        <input
            type="text"
            class="formulario__input"
            id="lote_numero"
            name="lote_numero"
            placeholder="Ej: LT-10"
            value="<?php echo s($predio->lote_numero ?? ''); ?>">
    </div>

    <div class="formulario__campo">
        <label for="direccion" class="formulario__label">Dirección</label>
        <input
            type="text"
            class="formulario__input"
            id="direccion"
            name="direccion"
            placeholder="Dirección del predio"
            value="<?php echo s($predio->direccion ?? ''); ?>">
    </div>

    <div class="formulario__campo">
        <label for="secuencia" class="formulario__label">Secuencia</label>
        <input
            type="text"
            class="formulario__input"
            id="secuencia"
            name="secuencia"
            placeholder="Ingresado Automaticamente"
            value="<?php echo s($predio->secuencia ?? ''); ?>" disabled>
    </div>

    <div class="formulario__campo">
        <label for="situacion" class="formulario__label">Situación</label>
        <select class="formulario__input" id="situacion" name="situacion">
            <option value="" disabled selected>-- Seleccionar --</option>
            <option value="activo" <?php echo ($predio->situacion === 'activo') ? 'selected' : ''; ?>>Activo</option>
            <option value="inactivo" <?php echo ($predio->situacion === 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
        </select>
    </div>


    <div class="formulario__campo">
        <label for="fecha_registro" class="formulario__label">Fecha de Registro</label>
        <input
            type="date"
            class="formulario__input"
            id="fecha_registro"
            name="fecha_registro"
            value="<?php echo s($predio->fecha_registro ?? ''); ?>">
    </div>
</fieldset>