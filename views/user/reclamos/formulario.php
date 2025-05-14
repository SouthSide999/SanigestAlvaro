<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Registrar Reclamo</legend>

    <!-- ID del Usuario (Oculto) -->
    <input type="hidden" name="cliente_id" value="<?php echo $usuario->id; ?>">

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre Completo</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre"
            placeholder="Tu Nombre Completo"
            value="<?php echo $usuario->nombre . " " . $usuario->apellido; ?>">
    </div>

    <div class="formulario__campo">
        <label for="correo" class="formulario__label">Correo Electrónico</label>
        <input
            type="email"
            class="formulario__input"
            id="correo"
            placeholder="Tu Correo Electrónico"
            value="<?php echo $usuario->email; ?>">
    </div>

    <div class="formulario__campo">
        <label for="telefono" class="formulario__label">Número de Contacto</label>
        <input
            type="tel"
            class="formulario__input"
            id="telefono"
            name="numero"
            placeholder="Tu Número de Teléfono"
            value="<?php echo $reclamo->numero; ?>">



    </div>

    <div class="formulario__campo">
        <label for="tipo_reclamo" class="formulario__label">Tipo de Reclamo</label>
        <select class="formulario__input" id="tipo_reclamo" name="tipo_reclamo_id">
            <option value="" selected disabled>Elije una opción</option>
            <?php foreach ($tiposreclamos as $tipo) : ?>
                <option value="<?php echo $tipo->id; ?>"
                    <?php echo ($reclamo->tipo_reclamo_id == $tipo->id) ? 'selected' : ''; ?>>
                    <?php echo $tipo->nombre; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción del Reclamo</label>
        <textarea
            class="formulario__input"
            id="descripcion"
            name="descripcion"
            placeholder="Describe tu problema"
            rows="5"><?php echo $reclamo->descripcion; ?></textarea>
    </div>



    <div class="formulario__campo">
        <label for="evidencia" class="formulario__label">Adjuntar Evidencias: </label>
        <span>Maximo Tres Imagenes de Evidencia</span>
        <input
            type="file"
            class="formulario__input formulario__input--file"
            id="evidencia"
            name="evidencias[]"
            multiple
            accept="image/png, image/webp, image/jpeg">
    </div>


    <input type="hidden" name="fecha" value="<?php echo date('Y-m-d H:i:s'); ?>">

</fieldset>

<?php
session_start();
if (isset($_SESSION['exito'])) :
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'El Reclamo se ha registrado correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '/user/reclamos'; // Redirigir después de cerrar la alerta
        });
    </script>
<?php
    unset($_SESSION['exito']); // Limpiar la variable de sesión para que no se muestre de nuevo
endif;
?>