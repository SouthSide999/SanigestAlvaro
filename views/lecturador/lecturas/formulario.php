<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Datos de Lectura</legend>

    <div class="formulario__campo">
        <label for="predio_id" class="formulario__label">Predio</label>
        <select class="formulario__input" id="predio_id" name="predio_id">
            <option value="" disabled <?php echo empty($lectura->predio_id) ? 'selected' : ''; ?>>-- Seleccionar --</option>
            <?php foreach ($predios as $predio) : ?>
                <option
                    value="<?php echo $predio->id; ?>"
                    data-tarifa="<?php echo $predio->tarifa->valor_tarifa ?? 0; ?>"
                    <?php echo ($predio->id == $lectura->predio_id) ? 'selected' : ''; ?>>
                    <?php echo $predio->codigo_predio . ' - ' . $predio->direccion; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>



    <div class="formulario__campo">
        <label for="mes" class="formulario__label">Mes</label>
        <select class="formulario__input" id="mes" name="mes">
            <option value="" disabled>-- Seleccionar --</option>
            <?php
            $meses = [
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre'
            ];

            // Determinar el mes seleccionado (de la lectura o del sistema)
            $mesSeleccionado = $lectura->mes ?? date('n');

            foreach ($meses as $num => $nombre) : ?>
                <option value="<?php echo $num; ?>" <?php echo ($num == $mesSeleccionado) ? 'selected' : ''; ?>>
                    <?php echo $nombre; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="anio" class="formulario__label">Año</label>
        <input
            type="number"
            class="formulario__input"
            id="anio"
            name="anio"
            min="2000"
            max="2100"
            value="<?php echo $lectura->anio ?? date('Y'); ?>">
    </div>



    <?php
    $primerDiaMes = date('Y-m-01'); // primer día del mes actual
    $ultimoDiaMes = date('Y-m-t');  // último día del mes actual
    ?>

    <div class="formulario__campo">
        <label for="fecha_inicio" class="formulario__label">Fecha de Inicio</label>
        <input
            type="date"
            class="formulario__input"
            id="fecha_inicio"
            name="fecha_inicio"
            value="<?php echo $lectura->fecha_inicio ?? $primerDiaMes; ?>">
    </div>

    <div class="formulario__campo">
        <label for="fecha_fin" class="formulario__label">Fecha de Fin</label>
        <input
            type="date"
            class="formulario__input"
            id="fecha_fin"
            name="fecha_fin"
            value="<?php echo $lectura->fecha_fin ?? $ultimoDiaMes; ?>">
    </div>



    <div class="formulario__campo">
        <label for="consumo_m3" class="formulario__label">Consumo (m³)</label>
        <input
            type="number"
            step="0.01"
            class="formulario__input"
            id="consumo_m3"
            name="consumo_m3"
            value="<?php echo $lectura->consumo_m3; ?>">

    </div>

    <div class="formulario__campo">
        <label for="monto_total" class="formulario__label">Monto Total (S/)</label>
        <input
            type="text"
            class="formulario__input"
            id="monto_total"
            name="monto_total"
            placeholder="Calculado automáticamente"
            value="<?php echo $lectura->monto_total; ?>"
            readonly>
    </div>
</fieldset>