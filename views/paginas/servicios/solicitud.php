<div class="nuevaconexion">
    <div class="nuevaconexion__formulario">
        <?php
        include_once __DIR__ . '../../../templates/alertas.php';
        ?>
        <form class="formulario" action="/servicios/solicitud/crear" enctype="multipart/form-data" method="POST">

            <fieldset class="formulario__fieldset">
                <h2>Solicitud</h2>
                    <fieldset class="formulario_nueva_solicitud__fieldset">
                        <legend class="formulario__legend">Datos del Solicitante</legend>

                        <div class="formulario__campo">
                            <label for="nombres" class="formulario__label">Nombres del Solicitante</label>
                            <input type="text" id="nombres" name="nombres" class="formulario__input" value="<?php echo htmlspecialchars($solicitud->nombres ?? ''); ?>" >
                        </div>

                        <div class="formulario__campo">
                            <label for="apellidos" class="formulario__label">Apellidos del Solicitante</label>
                            <input type="text" id="apellidos" name="apellidos" class="formulario__input" value="<?php echo htmlspecialchars($solicitud->apellidos ?? ''); ?>" >
                        </div>

                        <div class="formulario__campo">
                            <label for="dni" class="formulario__label">DNI del Solicitante</label>
                            <input type="text" id="dni" name="dni" class="formulario__input" value="<?php echo htmlspecialchars($solicitud->dni ?? ''); ?>" >
                        </div>

                        <div class="formulario__campo">
                            <label for="email" class="formulario__label">Correo Electrónico</label>
                            <input type="email" id="email" name="email" class="formulario__input" value="<?php echo htmlspecialchars($solicitud->correo_electronico ?? ''); ?>" >
                        </div>
                    </fieldset>

                    <fieldset class="formulario_nueva_solicitud__fieldset">
                        <legend class="formulario__legend">Detalles de la Solicitud</legend>

                        <div class="formulario__campo">
                            <label for="tipo_solicitud" class="formulario__label">Tipo de Solicitud</label>
                            <select id="tipo_solicitud" name="tipo_solicitud_id" class="formulario__input" >
                                <option value="" disabled selected>Elige una opción</option>
                                <?php foreach ($tipoSolicitud as $tipo): ?>
                                    <option value="<?php echo $tipo->id; ?>" <?php echo ($solicitud->tipo_solicitud_id ?? '') == $tipo->id ? 'selected' : ''; ?>>
                                        <?php echo $tipo->nombre; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="formulario__campo">
                            <label for="descripcion" class="formulario__label">Descripción de la Solicitud</label>
                            <textarea id="descripcion" name="descripcion" class="formulario__input" ><?php echo $solicitud->descripcion ?? ''; ?></textarea>
                        </div>

                        <div class="formulario__campo">
                            <label for="evidencia" class="formulario__label">Evidencia (opcional)</label>
                            <input type="file" id="evidencia" name="evidencia" class="formulario__input">
                        </div>
                    </fieldset>
            </fieldset>
            <input type="submit" value="Enviar" class="nuevaconexion__formulario__boton">
        </form>
    </div>
</div>