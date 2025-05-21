<fieldset class="formulario__fieldset">
    <h2>Solicitud ID: <?php echo $solicitud->id; ?></h2>


    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Datos del Solicitante</legend>

        <div class="formulario__campo">
            <label for="nombres" class="formulario__label">Nombres</label>
            <input type="text" id="nombres" class="formulario__input" value="<?php echo $solicitud->nombres; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="apellidos" class="formulario__label">Apellidos</label>
            <input type="text" id="apellidos" class="formulario__input" value="<?php echo $solicitud->apellidos; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="dni" class="formulario__label">DNI</label>
            <input type="text" id="dni" class="formulario__input" value="<?php echo $solicitud->dni; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Correo Electrónico</label>
            <input type="email" id="email" class="formulario__input" value="<?php echo $solicitud->email; ?>" readonly>
        </div>
    </fieldset>


    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Detalles de la Solicitud</legend>

        <div class="formulario__campo">
            <label for="tipo_solicitud_id" class="formulario__label">Tipo de Solicitud</label>
            <input type="text" id="tipo_solicitud_id" class="formulario__input" value="<?php echo $solicitud->tipo_solicitud->nombre; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="descripcion" class="formulario__label">Descripción</label>
            <textarea id="descripcion" class="formulario__input" readonly><?php echo $solicitud->descripcion; ?></textarea>
        </div>

        <div class="formulario__campo">
            <label for="documento_propiedad" class="formulario__label">Evidencia</label>
            <?php if (isset($solicitud->evidencia)) { ?>
                <div class="formulario__imagen">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/evidenciasSolicitudes/' . $solicitud->evidencia; ?>.webp" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/evidenciasSolicitudes/' . $solicitud->evidencia; ?>.png" type="image/png">
                        <img id="imagenEvidencia" src="<?php echo $_ENV['HOST'] . '/img/evidenciasSolicitudes/' . $solicitud->evidencia; ?>.png" alt="Imagen "
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
        </div>

        <div class="formulario__campo">
            <label for="fecha" class="formulario__label">Fecha de Solicitud</label>
            <input type="text" id="fecha" class="formulario__input" value="<?php echo $solicitud->fecha; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="estado_id" class="formulario__label">Estado de Solicitud</label>
            <input type="text" id="estado_id" class="formulario__input" value="<?php echo $solicitud->estado_id->nombre; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="personal_asignado" class="formulario__label">Personal Asignado</label>
            <input type="text" id="personal_asignado" class="formulario__input" value="<?php echo $solicitud->personal_asignado->nombre.' '.$solicitud->personal_asignado->apellido; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="codigo_seguimiento" class="formulario__label">Código de Seguimiento</label>
            <input type="text" id="codigo_seguimiento" class="formulario__input" value="<?php echo $solicitud->codigo_seguimiento; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="observaciones" class="formulario__label">Observaciones</label>
            <textarea id="observaciones" class="formulario__input" readonly><?php echo $solicitud->observaciones; ?></textarea>
        </div>
    </fieldset>

</fieldset>