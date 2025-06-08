<div class="nuevaconexion">
    <div class="nuevaconexion__formulario">
        <?php
        include_once __DIR__ . '../../../templates/alertas.php';
        ?>
        <form class="formulario" action="/servicios/solicitud/crear" enctype="multipart/form-data" method="POST">

            <fieldset class="formularioservicios__fieldset">
                <h2 class="formularioservicios__heading">Solicitud</h2>
                <fieldset class="formularioservicios__fieldset">
                    <legend class="formularioservicios__legend">Datos del Solicitante</legend>

                    <div class="formularioservicios__campo">
                        <label for="nombres" class="formularioservicios__label">Nombres del Solicitante</label>
                        <input type="text" id="nombres" name="nombres" class="formularioservicios__input" value="<?php echo htmlspecialchars($solicitud->nombres ?? ''); ?>">
                    </div>

                    <div class="formularioservicios__campo">
                        <label for="apellidos" class="formularioservicios__label">Apellidos del Solicitante</label>
                        <input type="text" id="apellidos" name="apellidos" class="formularioservicios__input" value="<?php echo htmlspecialchars($solicitud->apellidos ?? ''); ?>">
                    </div>

                    <div class="formularioservicios__campo">
                        <label for="dni" class="formularioservicios__label">DNI del Solicitante</label>
                        <input type="text" id="dni" name="dni" class="formularioservicios__input" value="<?php echo htmlspecialchars($solicitud->dni ?? ''); ?>">
                    </div>

                    <div class="formularioservicios__campo">
                        <label for="email" class="formularioservicios__label">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="formularioservicios__input" value="<?php echo htmlspecialchars($solicitud->correo_electronico ?? ''); ?>">
                    </div>
                </fieldset>

                <fieldset class="formularioservicios__fieldset">
                    <legend class="formularioservicios__legend">Detalles de la Solicitud</legend>

                    <div class="formularioservicios__campo">
                        <label for="tipo_solicitud" class="formularioservicios__label">Tipo de Solicitud</label>
                        <select id="tipo_solicitud" name="tipo_solicitud_id" class="formularioservicios__input">
                            <option value="" disabled selected>Elige una opción</option>
                            <?php foreach ($tipoSolicitud as $tipo): ?>
                                <option value="<?php echo $tipo->id; ?>" <?php echo ($solicitud->tipo_solicitud_id ?? '') == $tipo->id ? 'selected' : ''; ?>>
                                    <?php echo $tipo->nombre; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="formularioservicios__campo">
                        <label for="descripcion" class="formularioservicios__label">Descripción de la Solicitud</label>
                        <textarea id="descripcion" name="descripcion" class="formularioservicios__input"><?php echo $solicitud->descripcion ?? ''; ?></textarea>
                    </div>

                    <div class="formularioservicios__campo">
                        <label for="evidencia" class="formularioservicios__label">Evidencia (opcional)</label>
                        <input type="file" id="evidencia" name="evidencia" class="formularioservicios__input">
                    </div>
                </fieldset>
            </fieldset>

            <input type="submit" value="Enviar" class="nuevaconexion__formulario__boton">
        </form>
    </div>
</div>