<fieldset class="formulario__fieldset">
    <h2>Solicitud de Nuevo Conexion: <?php echo $nueva->codigo_solicitud; ?></h2>

    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Datos</legend>
        <div class="formulario__campo">
            <label for="tipo_solicitante" class="formulario__label">Tipo Solicitante</label>
            <input type="text" id="tipo_solicitante" class="formulario__input" value="<?php echo $nueva->tipo_solicitante; ?>" readonly>

        </div>

        <div class="formulario__campo">
            <label for="tipo_persona" class="formulario__label">Tipo Persona</label>
            <input id="tipo_persona" type="text" class="formulario__input" value="<?php echo $nueva->tipo_persona; ?>" readonly>
        </div>

        <div id="naturalCampos">
            <div class="formulario__campo">
                <label for="tipo_documento_natural" class="formulario__label">Tipo de Documento</label>
                <input type="text" class="formulario__input" value="<?php echo $nueva->tipo_documento_natural; ?>" readonly>
            </div>

            <div class="formulario__campo">
                <label for="numero_documento_natural" class="formulario__label">Número de Documento</label>
                <input type="text" class="formulario__input" value="<?php echo $nueva->numero_documento_natural; ?>" readonly>
            </div>
        </div>

        <div id="juridicoCampos" style="display: none;">
            <div class="formulario__campo">
                <label for="tipo_documento_juridico" class="formulario__label">Tipo de Documento</label>
                <input type="text" class="formulario__input" value="<?php echo $nueva->tipo_documento_juridico; ?>" readonly>
            </div>

            <div class="formulario__campo">
                <label for="numero_documento_juridico" class="formulario__label">Número de Documento</label>
                <input type="text" class="formulario__input" value="<?php echo $nueva->numero_documento_juridico; ?>" readonly>
            </div>

            <div class="formulario__campo">
                <label for="razon_social" class="formulario__label">Razón Social</label>
                <input type="text" class="formulario__input" value="<?php echo $nueva->razon_social; ?>" readonly>
            </div>
        </div>

        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombres del Titular</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->nombre; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="apellido1" class="formulario__label">Primer Apellido del Titular</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->apellido1; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="apellido2" class="formulario__label">Segundo Apellido del Titular</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->apellido2; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="correo" class="formulario__label">Correo Electrónico</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->correo; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="celular" class="formulario__label">Celular</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->celular; ?>" readonly>
        </div>
    </fieldset>


    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Datos Servicio</legend>
        <div class="formulario__campo">
            <label for="tipo_servicio" class="formulario__label">Tipo Servicio</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->tipo_servicio; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="servicio" class="formulario__label">Servicio</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->servicio; ?>" readonly>
        </div>
    </fieldset>

    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Dirección</legend>
        <div class="formulario__campo">
            <label for="localidad" class="formulario__label">Localidad</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->localidad; ?>" readonly>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label">Dirección Principal</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->direccion_principal; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Referencia</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->referencia_direccion; ?>" readonly>
        </div>
    </fieldset>


    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Documentos</legend>



        <div class="formulario__campo">
            <label for="documento_propiedad" class="formulario__label">Documento de Propiedad</label>
            <?php if (isset($nueva->documento_propiedad)) { ?>
                <div class="formulario__imagen">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->documento_propiedad; ?>.webp" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->documento_propiedad; ?>.png" type="image/png">
                        <img id="imagenEvidencia" src="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->documento_propiedad; ?>.png" alt="Imagen "
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
            <label for="dni_documento" class="formulario__label">Documento de Identidad (DNI)</label>
            <?php if (isset($nueva->dni_documento)) { ?>
                <div class="formulario__imagen">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->dni_documento; ?>.webp" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->dni_documento; ?>.png" type="image/png">
                        <img id="imagenEvidencia" src="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->dni_documento; ?>.png" alt="Imagen "
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
            <label for="croquis" class="formulario__label">Croquis del Predio</label>

            <?php if (isset($nueva->croquis)) { ?>
                <div class="formulario__imagen">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->croquis; ?>.webp" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->croquis; ?>.png" type="image/png">
                        <img id="imagenEvidencia" src="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->croquis; ?>.png" alt="Imagen "
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
            <label for="foto_instalacion" class="formulario__label">Foto donde se Realizará la Instalación</label>

            <?php if (isset($nueva->croquis)) { ?>
                <div class="formulario__imagen">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_instalacion; ?>.webp" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_instalacion; ?>.png" type="image/png">
                        <img id="imagenEvidencia" src="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_instalacion; ?>.png" alt="Imagen "
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
            <label for="foto_recibo" class="formulario__label">Ultimo Recibo </label>

            <?php if (isset($nueva->foto_recibo)) { ?>
                <div class="formulario__imagen">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_recibo; ?>.webp" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_recibo; ?>.png" type="image/png">
                        <img id="imagenEvidencia" src="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_recibo; ?>.png" alt="Imagen "
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

        <div id="representanteCampos" style="display: none;">
            <div class="formulario__campo">
                <label for="foto_autorizacion_notarial" class="formulario__label">Autorización Notarial</label>

                <?php if (isset($nueva->foto_autorizacion_notarial)) { ?>
                    <div class="formulario__imagen">
                        <picture>
                            <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_autorizacion_notarial; ?>.webp" type="image/webp">
                            <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_autorizacion_notarial; ?>.png" type="image/png">
                            <img id="imagenEvidencia" src="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_autorizacion_notarial; ?>.png" alt="Imagen "
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
                <label for="foto_vigencia_poder" class="formulario__label">Vigencia Poder</label>

                <?php if (isset($nueva->foto_vigencia_poder)) { ?>
                    <div class="formulario__imagen">
                        <picture>
                            <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_vigencia_poder; ?>.webp" type="image/webp">
                            <source srcset="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_vigencia_poder; ?>.png" type="image/png">
                            <img id="imagenEvidencia" src="<?php echo $_ENV['HOST'] . '/img/nuevaconexion/' . $nueva->foto_vigencia_poder; ?>.png" alt="Imagen "
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
        </div>
    </fieldset>

    <fieldset class="formulario_nueva_conexion__fieldset">
        <legend class="formulario__legend">Datos Tecnicos</legend>

        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Feche de Tramite</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->fecha_solicitud; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Estado</label>
            <input type="text" class="formulario__input"  value="<?php echo $nueva->estado_id->nombre; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Tecnico Asignado</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->tecnico_id -> nombre ." ".$nueva->tecnico_id -> apellido; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Codigo de la Solicitudr</label>
            <input type="text" class="formulario__input" value="<?php echo $nueva->codigo_solicitud; ?>" readonly>
        </div>

        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Observaciones</label>
            <textarea class="formulario__input" readonly><?php echo $nueva->observacion_rechazo; ?></textarea>
        </div>

    </fieldset>
</fieldset>