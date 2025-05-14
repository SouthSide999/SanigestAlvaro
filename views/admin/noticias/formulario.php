<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información De la Noticia o Aviso</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre Noticia o Aviso</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre de la Noticia o Aviso"
            value="<?php echo $noticia->nombre; ?>">
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Contenido</label>
        <textarea
            class="formulario__input"
            id="contenido"
            name="contenido"
            placeholder="Contenido de la Noticia o Aviso"
            rows="30"><?php echo $noticia->contenido; ?></textarea>
    </div>
    <div class="formulario__campo">
        <label for="imagen" class="formulario__label">Imagen: </label>
        <input
            type="file"
            class="formulario__input formulario__input--file"
            id="imagen"
            name="imagen">
    </div>


    <?php if (isset($noticia->imagen_actual)) { ?>
        <p class="formulario__texto">
            Imagen Actual:

        </p>

        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/noticias/' . $noticia->imagen; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/noticias/' . $noticia->imagen; ?>.png" type="image/png">
                <img id="imagenEvidencia" src="<?php echo $_ENV['HOST'] . '/img/noticias/' . $noticia->imagen; ?>.png" alt="Imagen noticia"
                    alt="No Adjunto Ninguna Evidencia"
                    class="imagen-evidencia"
                    onclick="abrirModal('modalEvidencia', 'modalImgEvidencia', this)">
            </picture>
        </div>


        <!-- Modal para mostrar imágenes en grande -->
        <div id="modalEvidencia" class="modal">
            <span class="close">&times;</span>
            <img id="modalImg" alt="Imagen de Evidencia">
            <a id="descargarImg" class="descargar-btn" download>Descargar Imagen</a>
        </div>

    <?php } ?>
</fieldset>