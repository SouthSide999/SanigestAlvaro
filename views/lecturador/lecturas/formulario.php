<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Datos de Lectura</legend>

    <!-- Predio -->
    <div class="formulario__campo">
        <label for="predio_id" class="formulario__label">Predio</label>
        <select class="formulario__input" id="predio_id" name="predio_id">
            <option value="" disabled <?php echo empty($lectura->predio_id) ? 'selected' : ''; ?>>-- Seleccionar --</option>
            <?php foreach ($predios as $predio) : ?>
                <option
                    value="<?php echo $predio->id; ?>"
                    data-tarifa="<?php echo $predio->tarifa->tarifa_agua ?? 0; ?>"
                    data-desague="<?php echo $predio->tarifa->tarifa_desague ?? 0; ?>"
                    data-cargo="<?php echo $predio->tarifa->cargo_fijo ?? 0; ?>"

                    <?php echo ($predio->id == $lectura->predio_id) ? 'selected' : ''; ?>>
                    <?php echo $predio->codigo_predio . ' - ' . $predio->direccion; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Mes -->
    <div class="formulario__campo">
        <label for="mes" class="formulario__label">Mes</label>
        <select class="formulario__input" id="mes" name="mes">
            <option value="" disabled>-- Seleccionar --</option>
            <?php
            $meses = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];
            $mesSeleccionado = $lectura->mes ?? date('n');
            foreach ($meses as $num => $nombre) : ?>
                <option value="<?php echo $num; ?>" <?php echo ($num == $mesSeleccionado) ? 'selected' : ''; ?>>
                    <?php echo $nombre; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Año -->
    <div class="formulario__campo">
        <label for="anio" class="formulario__label">Año</label>
        <input type="number" class="formulario__input" id="anio" name="anio" min="2000" max="2100" value="<?php echo $lectura->anio ?? date('Y'); ?>">
    </div>

    <!-- Fechas -->
    <?php $primerDiaMes = date('Y-m-01');
    $ultimoDiaMes = date('Y-m-t'); ?>

    <div class="formulario__campo">
        <label for="fecha_inicio" class="formulario__label">Fecha de Inicio</label>
        <input type="date" class="formulario__input" id="fecha_inicio" name="fecha_inicio" value="<?php echo $lectura->fecha_inicio ?? $primerDiaMes; ?>">
    </div>

    <div class="formulario__campo">
        <label for="fecha_fin" class="formulario__label">Fecha de Fin</label>
        <input type="date" class="formulario__input" id="fecha_fin" name="fecha_fin" value="<?php echo $lectura->fecha_fin ?? $ultimoDiaMes; ?>">
    </div>

    <!-- Consumo -->
    <div class="formulario__campo">
        <label for="consumo_m3" class="formulario__label">Consumo (m³)</label>
        <input type="number" step="0.01" class="formulario__input" id="consumo_m3" name="consumo_m3" value="<?php echo $lectura->consumo_m3; ?>">
    </div>

    <!-- Monto por Agua -->
    <div class="formulario__campo">
        <label for="monto_agua" class="formulario__label">Monto Agua (S/)</label>
        <input
            type="text"
            class="formulario__input"
            id="monto_agua"
            name="monto_agua"
            value="<?php echo $lectura->monto_agua ?? ''; ?>"
            readonly>
    </div>

    <!-- Monto por Desagüe -->
    <div class="formulario__campo">
        <label for="monto_desague" class="formulario__label">Monto Desagüe (S/)</label>
        <input
            type="text"
            class="formulario__input"
            id="monto_desague"
            name="monto_desague"
            value="<?php echo $lectura->monto_desague ?? ''; ?>"
            readonly>
    </div>

    <!-- Monto Total -->
    <div class="formulario__campo">
        <label for="monto_total" class="formulario__label">Monto Total (S/)</label>
        <input
            type="text"
            class="formulario__input"
            id="monto_total"
            name="monto_total"
            placeholder="Calculado automáticamente"
            value="<?php echo $lectura->monto_total ?? ''; ?>"
            readonly>
    </div>
</fieldset>