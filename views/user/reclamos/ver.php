<h2><?php echo $titulo; ?></h2>

<div class="dashboardUser__contenedor-boton">
    <a class="dashboardUser__boton" href="/user/reclamos">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboardUser__formulario">

    <form class="formulario" enctype="multipart/form-data" method="POST">
        <fieldset class="formulario__fieldset">


            <div class="formulario__campo">
                <label for="Fecha" class="formulario__label">Fecha y Hora de Ingreso:</label>
                <input
                    class="formulario__input"
                    value="<?php echo $reclamo->fecha; ?>">
            </div>

            <div class="formulario__campo">
                <label for="tipo_reclamo" class="formulario__label">Tipo de Reclamo:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="tipo_reclamo"
                    value="<?php echo $reclamo->tipo->nombre; ?>">
            </div>

            <div class="formulario__campo">
                <label for="descripcion" class="formulario__label">Descripción del Reclamo</label>
                <textarea
                    class="formulario__input"
                    id="descripcion"
                    name="descripcion"
                    rows="5"><?php echo $reclamo->descripcion; ?></textarea>
            </div>


            <div class="formulario__campo">
                <label for="correo" class="formulario__label">Correo Electrónico</label>
                <input
                    type="email"
                    class="formulario__input"
                    id="correo"

                    value="<?php echo $usuario->email; ?>">
            </div>

            <div class="formulario__campo">
                <label for="telefono" class="formulario__label">Número de Contacto</label>
                <input
                    type="tel"
                    class="formulario__input"
                    id="telefono"
                    name="numero"
                    value="<?php echo $reclamo->numero; ?>">
            </div>
            

            <?php if (!empty($reclamo->evidencia)) {
                $imagenes = json_decode($reclamo->evidencia);
            ?>
                <p class="formulario__texto">Imágenes de Evidencia:</p>

                <div class="formulario__imagenes">
                    <?php foreach ($imagenes as $index => $imagen) { ?>
                        <img class="imagen-evidencia"
                            src="<?php echo $_ENV['HOST'] . '/img/evidencias/' . $imagen; ?>.png"
                            alt="Evidencia <?php echo $index + 1; ?>"
                            data-index="<?php echo $index; ?>">
                    <?php } ?>
                </div>

                <!-- Modal para mostrar imágenes en grande -->
                <div id="modalEvidencia" class="modal">
                    <span class="close">&times;</span>
                    <img id="modalImg" alt="Imagen de Evidencia">
                    <a id="descargarImg" class="descargar-btn" download>Descargar Imagen</a>
                </div>

            <?php } else { ?>
                <p class="text-center">No se adjunto ninguna evidencia.</p>
            <?php } ?>




        </fieldset>


    </form>
</div>