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
        <label for="estado_servicio_id" class="formulario__label">Estado del Servicio</label>
        <select class="formulario__input" id="estado_servicio_id" name="estado_servicio_id">
            <option value="" disabled selected>-- Seleccionar --</option>
            <?php foreach ($estado as $est) : ?>
                <option value="<?php echo $est->id; ?>"
                    <?php echo (isset($predio->estado_servicio_id) && $predio->estado_servicio_id == $est->id) ? 'selected' : ''; ?>>
                    <?php echo s($est->nombre); ?>
                </option>
            <?php endforeach; ?>
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

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Medidor</legend>

    <div class="formulario__campo">
        <label for="numero_medidor" class="formulario__label">Número de Medidor</label>
        <input
            type="text"
            class="formulario__input"
            id="numero_medidor"
            name="numero_medidor"
            placeholder="Ej: 123456"
            value="<?php echo $medidor->numero_medidor ?? 'No Cuenta con un medidor'; ?>">
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

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información de la Conexión</legend>

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