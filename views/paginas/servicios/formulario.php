<fieldset class="formulario__fieldset">
    <h2>Solicitud de Nuevo Suministro</h2>

    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Datos</legend>
        <div class="formulario__campo">
            <label for="tipo_solicitante" class="formulario__label">Tipo Solicitante</label>
            <select id="tipo_solicitante" name="tipo_solicitante" class="formulario__input" required>
                <option value="" disabled selected>Elige una opción</option>
                <option value="propietario" <?php echo ($nuevaconexion->tipo_solicitante ?? '') === 'propietario' ? 'selected' : ''; ?>>Propietario del Inmueble</option>
                <option value="representante" <?php echo ($nuevaconexion->tipo_solicitante ?? '') === 'representante' ? 'selected' : ''; ?>>Representante del Inmueble</option>
            </select>
        </div>

        <div class="formulario__campo">
            <label for="tipo_persona" class="formulario__label">Tipo Persona</label>
            <select id="tipo_persona" name="tipo_persona" class="formulario__input" required>
                <option value="" disabled selected>Elige una opción</option>
                <option value="natural" <?php echo ($nuevaconexion->tipo_persona ?? '') === 'natural' ? 'selected' : ''; ?>>Natural</option>
                <option value="juridico" <?php echo ($nuevaconexion->tipo_persona ?? '') === 'juridico' ? 'selected' : ''; ?>>Jurídico</option>
            </select>
        </div>

        <div id="naturalCampos">
            <div class="formulario__campo">
                <label for="tipo_documento_natural" class="formulario__label">Tipo de Documento</label>
                <select id="tipo_documento_natural" name="tipo_documento_natural" class="formulario__input">
                    <option value="" disabled selected>Elige una opción</option>
                    <option value="dni" <?php echo ($nuevaconexion->tipo_documento_natural ?? '') === 'dni' ? 'selected' : ''; ?>>DNI</option>
                    <option value="carnet extranjeria" <?php echo ($nuevaconexion->tipo_documento_natural ?? '') === 'carnet extranjeria' ? 'selected' : ''; ?>>Carnet de Extranjería</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="numero_documento_natural" class="formulario__label">Número de Documento</label>
                <input type="text" id="numero_documento_natural" name="numero_documento_natural" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->numero_documento_natural ?? ''); ?>">
            </div>
        </div>

        <div id="juridicoCampos" style="display: none;">
            <div class="formulario__campo">
                <label for="tipo_documento_juridico" class="formulario__label">Tipo de Documento</label>
                <select id="tipo_documento_juridico" name="tipo_documento_juridico" class="formulario__input">
                    <option value="" disabled selected>Elige una opción</option>
                    <option value="ruc" <?php echo ($nuevaconexion->tipo_documento_juridico ?? '') === 'ruc' ? 'selected' : ''; ?>>RUC</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="numero_documento_juridico" class="formulario__label">Número de Documento</label>
                <input type="text" id="numero_documento_juridico" name="numero_documento_juridico" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->numero_documento_juridico ?? ''); ?>">
            </div>

            <div class="formulario__campo">
                <label for="razon_social" class="formulario__label">Razón Social</label>
                <input type="text" id="razon_social" name="razon_social" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->razon_social ?? ''); ?>">
            </div>
        </div>

        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombres del Titular</label>
            <input type="text" id="nombre" name="nombre" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->nombre ?? ''); ?>">
        </div>

        <div class="formulario__campo">
            <label for="apellido1" class="formulario__label">Primer Apellido del Titular</label>
            <input type="text" id="apellido1" name="apellido1" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->apellido1 ?? ''); ?>">
        </div>

        <div class="formulario__campo">
            <label for="apellido2" class="formulario__label">Segundo Apellido del Titular</label>
            <input type="text" id="apellido2" name="apellido2" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->apellido2 ?? ''); ?>">
        </div>

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->email ?? ''); ?>">
        </div>

        <div class="formulario__campo">
            <label for="celular" class="formulario__label">Celular</label>
            <input type="text" id="celular" name="celular" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->celular ?? ''); ?>">
        </div>
    </fieldset>


    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Datos Servicio</legend>
        <div class="formulario__campo">
            <label for="tipo_servicio" class="formulario__label">Tipo Servicio</label>
            <select id="tipo_servicio" name="tipo_servicio" class="formulario__input" required>
                <option value="" disabled selected>Elige una opción</option>
                <option value="agua" <?php echo ($nuevaconexion->tipo_servicio ?? '') === 'agua' ? 'selected' : ''; ?>>Agua</option>
                <option value="desague" <?php echo ($nuevaconexion->tipo_servicio ?? '') === 'desague' ? 'selected' : ''; ?>>Desagüe</option>
                <option value="agua_desague" <?php echo ($nuevaconexion->tipo_servicio ?? '') === 'agua_desague' ? 'selected' : ''; ?>>Agua y Desagüe</option>
            </select>
        </div>

        <div class="formulario__campo">
            <label for="servicio" class="formulario__label">Servicio</label>
            <select id="servicio" name="servicio" class="formulario__input">
                <option value="" disabled selected>Elige una opción</option>
                <option value="nueva" <?php echo ($nuevaconexion->servicio ?? '') === 'nueva' ? 'selected' : ''; ?>>Nueva</option>
                <option value="independizacion" <?php echo ($nuevaconexion->servicio ?? '') === 'independizacion' ? 'selected' : ''; ?>>Independización</option>
                <option value="subramal" <?php echo ($nuevaconexion->servicio ?? '') === 'subramal' ? 'selected' : ''; ?>>Subramal</option>
            </select>
        </div>
    </fieldset>

    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Dirección</legend>
        <div class="formulario__campo">
            <label for="localidad" class="formulario__label">Localidad</label>
            <select id="localidad" name="localidad" class="formulario__input" required>
                <option value="" disabled selected>Elige una opción</option>
                <option value="Huaro" <?php echo ($nuevaconexion->localidad ?? '') === 'Huaro' ? 'selected' : ''; ?>>Huaro</option>
            </select>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label">Dirección Principal</label>
            <input type="text" name="direccion_principal" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->direccion_principal ?? ''); ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Referencia</label>
            <input type="text" name="referencia_direccion" class="formulario__input" value="<?php echo htmlspecialchars($nuevaconexion->referencia_direccion ?? ''); ?>">
        </div>
    </fieldset>


    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Adjuntar Documentos</legend>

        <div class="formulario__campo">
            <label for="documento_propiedad" class="formulario__label">Documento de Propiedad</label>
            <input type="file" id="documento_propiedad" name="documento_propiedad" class="formulario__input">
        </div>

        <div class="formulario__campo">
            <label for="dni_documento" class="formulario__label">Documento de Identidad (DNI)</label>
            <input type="file" id="dni_documento" name="dni_documento" class="formulario__input">
        </div>

        <div class="formulario__campo">
            <label for="croquis" class="formulario__label">Croquis del Predio</label>
            <input type="file" id="croquis" name="croquis" class="formulario__input">
        </div>

        <div class="formulario__campo">
            <label for="foto_instalacion" class="formulario__label">Foto donde se Realizará la Instalación</label>
            <input type="file" id="foto_instalacion" name="foto_instalacion" class="formulario__input">
        </div>

        <div class="formulario__campo">
            <label for="foto_recibo" class="formulario__label">Ultimo Recibo </label>
            <input type="file" id="foto_recibo" name="foto_recibo" class="formulario__input">
        </div>

        <div id="representanteCampos" style="display: none;">
            <div class="formulario__campo">
                <label for="foto_autorizacion_notarial" class="formulario__label">Autorización Notarial</label>
                <input type="file" id="foto_autorizacion_notarial" name="foto_autorizacion_notarial" class="formulario__input">
            </div>

            <div class="formulario__campo">
                <label for="foto_vigencia_poder" class="formulario__label">Vigencia Poder</label>
                <input type="file" id="foto_vigencia_poder" name="foto_vigencia_poder" class="formulario__input">
            </div>
        </div>


    </fieldset>
</fieldset>