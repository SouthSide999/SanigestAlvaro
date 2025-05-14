<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Perfil del Usuario</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Tu Nombre"
            value="<?php echo $cliente->nombre; ?>"
            >
    </div>

    <div class="formulario__campo">
        <label for="apellido" class="formulario__label">Apellido</label>
        <input
            type="text"
            class="formulario__input"
            id="apellido"
            name="apellido"
            placeholder="Tu Apellido"
            value="<?php echo $cliente->apellido; ?>"
            >
    </div>

    <div class="formulario__campo">
        <label for="email" class="formulario__label">Correo Electrónico</label>
        <input
            type="email"
            class="formulario__input"
            id="email"
            name="email"
            placeholder="Tu Correo Electrónico"
            value="<?php echo $cliente->email; ?>"
            >
    </div>

    <div class="formulario__campo">
        <label for="password" class="formulario__label">Contraseña</label>
        <input
            type="password"
            class="formulario__input"
            id="password"
            name="password"
            placeholder="Tu Contraseña"
            >
        <small>* Ingresa solo si deseas cambiar tu contraseña.</small>
    </div>

</fieldset>

<?php if (isset($predio) && $predio): ?>
    <fieldset class="formulario__fieldset">
        <legend class="formulario__legend">Información del Predio Asociado a la Cuenta</legend>
        <small>* (Esta informacion no puede ser modificada).</small>

        <div class="formulario__campo">
            <label class="formulario__label">Código</label>
            <p class="formulario__input"><?php echo $predio->codigo_predio; ?></p>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Contribuyente</label>
            <p class="formulario__input"><?php echo $predio->contribuyente->nombres.' '.$predio->contribuyente->apellidos; ?></p>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Dirección</label>
            <p class="formulario__input"><?php echo $predio->direccion.' '.$predio->manzana .' Lt: '.$predio->lote_numero ?? 'No especificada'; ?></p>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Zona-Sector</label>
            <p class="formulario__input"><?php echo $predio->zona->nombre_zona.' / '.$predio->sector->nombre_sector ?? 'No especificada'; ?></p>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Tarifa</label>
            <p class="formulario__input"><?php echo $predio->tarifa->nombre_tarifa.' S/:'. $predio->tarifa->valor_tarifa ?? 'No especificada'; ?></p>
        </div>




        <!-- Agrega más campos según lo que tengas en la tabla `predios` -->
    </fieldset>
<?php endif; ?>


<?php
session_start();
if (isset($_SESSION['exito'])) :
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Tu perfil se ha actualizado correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '/user/perfil'; // Redirigir después de cerrar la alerta
        });
    </script>
<?php
    unset($_SESSION['exito']);
endif;
?>
