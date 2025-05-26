<?php
$mesActual = date('n');
$anioActual = date('Y');

?>

<h2>Generar Consumos Múltiples</h2>

<form class="dashboard__formulario" action="/tesorero/consumos/generar" method="POST">
    <?php
    include_once __DIR__ . '/../../../templates/alertas.php';
    ?>
    <div class="formulario__campo">
        <label for="mes" class="formulario__label">Mes</label>
        <select class="formulario__input" id="mes" name="mes" required>
            <option value="" disabled>-- Seleccionar --</option>
            <?php foreach ($meses as $num => $nombre): ?>
                <option value="<?php echo $num; ?>" <?php echo ($num == $mesActual) ? 'selected' : ''; ?>>
                    <?php echo $nombre; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="anio" class="formulario__label">Año</label>
        <input type="number" class="formulario__input" id="anio" name="anio" min="2000" max="2100"
            value="<?php echo $anioActual; ?>" required>
    </div>

    <div class="formulario__campo">
        <label for="fecha_inicio" class="formulario__label">Fecha de Inicio</label>
        <input type="date" class="formulario__input" id="fecha_inicio" name="fecha_inicio"
            required>
    </div>

    <div class="formulario__campo">
        <label for="fecha_fin" class="formulario__label">Fecha de Fin</label>
        <input type="date" class="formulario__input" id="fecha_fin" name="fecha_fin"
            required>
    </div>

    <input type="submit" class="formulario__submit formulario__submit--registrar" value="Generar Consumos">

</form>


<?php if (isset($_GET['exito']) && $_GET['exito'] == 1): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Consumos generados correctamente para los predios operativos.',
            timer: 3000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '/tesorero/consumos';
        });
    </script>
<?php elseif (isset($_GET['error']) && $_GET['error'] == 1): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Campos incompletos',
            text: 'Todos los campos son obligatorios.',
            confirmButtonText: 'OK'
        });
    </script>
<?php elseif (isset($_GET['sinPredios']) && $_GET['sinPredios'] == 1): ?>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Sin predios operativos',
            text: 'No se encontraron predios en estado operativo.',
            confirmButtonText: 'Entendido'
        });
    </script>
<?php endif; ?>
<?php if (isset($alertas['error']) && !empty($alertas['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error de registro',
            html: `
            <ul style="text-align: left;">
                <?php foreach ($alertas['error'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        `,
            confirmButtonText: 'Intentar de nuevo'
        });
    </script>
<?php endif; ?>