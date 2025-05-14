<main class="contacto">
    <div class="contacto__heading">
        <h2 <?php aos_animacion(); ?> class="contacto__titulo">Contáctenos</h4>
            <h1 <?php aos_animacion(); ?> class="contacto__subtitulo">A la Unidad de Gestion Municipal</h3>
    </div>

    <div class="contacto__informacion">
        <div <?php aos_animacion(); ?> class="contacto__dato">
            <i class="contacto__icono fa-solid fa-location-dot"></i>
            <h4 class="contacto__etiqueta">Dirección</h4>
            <p class="contacto__texto">Plaza de Armas 642 Huaro-Quispicachi-Cusco</p>
        </div>
        <div  <?php aos_animacion(); ?> class="contacto__dato">
            <i class="contacto__icono fa-solid fa-phone"></i>
            <h4 class="contacto__etiqueta">Teléfono</h4>
            <p class="contacto__texto">+51 933 358 137</p>
        </div>
        <div <?php aos_animacion(); ?> class="contacto__dato">
            <i class="contacto__icono fa-solid fa-envelope"></i>
            <h4 class="contacto__etiqueta">Email</h4>
            <p class="contacto__texto">akidazapata@gmail.com</p>
        </div>
    </div>

    <div class="contacto__contenido">
        <div <?php aos_animacion(); ?> class="contacto__mapa">
            <div id="mapa" class="mapa__mapa"></div>
        </div>

        <div <?php aos_animacion(); ?> class="contacto__formulario">
            <?php
            include_once __DIR__ . '../../../templates/alertas.php';
            ?>
            <form class="formulario" action="/contacto/crear" enctype="multipart/form-data" method="POST">
                <fieldset class="formulario__fieldset">
                    <legend class="formulario__legend">Información:</legend>
                    <div class="formulario__campo">
                        <label for="asunto" class="formulario__label">Asunto: </label>
                        <input
                            type="text"
                            class="formulario__input"
                            id="asunto"
                            name="asunto"
                            placeholder="asunto"
                            value="<?php echo $contacto->asunto ?? ''; ?>">
                    </div>
                    <div class="formulario__campo">
                        <label for="nombre" class="formulario__label">Nombre: </label>
                        <input
                            type="text"
                            class="formulario__input"
                            id="nombre"
                            name="nombre"
                            placeholder="Nombre Completo"
                            value="<?php echo $contacto->nombre ?? ''; ?>">
                    </div>

                    <div class="formulario__campo">
                        <label for="numero" class="formulario__label">Numero: <span>(Para Contactarnos con Usted)</span></label>
                        <input
                            type="number"
                            class="formulario__input"
                            id="numero"
                            name="numero"
                            placeholder="Numero de Celular"
                            value="<?php echo $contacto->numero ?? ''; ?>">
                    </div>



                    <div class="formulario__campo">
                        <label for="mensaje" class="formulario__label">Mensaje</label>
                        <textarea
                            class="formulario__textarea"
                            id="mensaje"
                            name="mensaje"
                            placeholder="Contenido de la Noticia o Aviso"
                            rows="5"><?php echo $contacto->mensaje; ?></textarea>
                    </div>
                </fieldset>

                <input type="submit" value="Enviar" class="formulario__submit formulario__submit--registrar">
            </form>
        </div>
    </div>
</main>

<?php if (isset($_GET['exito'])) : ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Su mensaje fue enviado correctamente',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        }).then(() => {
            // Eliminar el parámetro de la URL después de mostrar la alerta
            const newUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        });
    </script>
<?php endif; ?>