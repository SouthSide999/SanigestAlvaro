<h2 class="pagina__heading"><?php echo $titulo; ?></h2>

<!-- FORMULARIO DE BÚSQUEDA -->
<div class="estadoconexion__contenedor">
    <form class="dashboard__formulario__buscardor" action="/servicios/estado" method="POST" enctype="multipart/form-data">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="criterio" class="formulario__label">Buscar:</label>
                <select id="criterio" name="criterio" class="formulario__input" required>
                    <option disabled selected>Selecciona una opción</option>
                    <option value="solicitudes">Solicitud</option>
                    <option value="nueva_conexion">Nueva Conexión</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="dato" class="formulario__label">Ingrese el Código de Seguimiento:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="dato"
                    name="dato"
                    placeholder="Código de Seguimiento"
                    required>
            </div>
        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input type="submit" value="Buscar Solicitud" class="dashboard__boton__buscardor">
        </div>
    </form>
</div>
<!-- RESULTADO -->
<section class="estadoconexion__contenedor--ticket">
    <?php if (!empty($estado)) { ?>
        <h2 class="pagina__heading">El estado de tu búsqueda es:</h2>

        <div class="boleto-virtual">
            <div class="boleto boleto--<?php echo strtolower($estado->estado_id->nombre); ?> boleto--acceso">
                <div class="boleto__contenido">
                    <h4 class="boleto__logo">&#60;SaniGest /></h4>

                    <!-- Mostrar tipo de registro: Solicitud o Nueva Conexión -->
                    <p class="boleto__tipo">
                        Tipo:
                        <?php echo ($tipoBusqueda === 'solicitudes') ? 'Solicitud' : 'Nueva Conexión'; ?>
                    </p>

                    <!-- Mostrar tipo de solicitud si aplica (solo solicitudes normales) -->
                    <?php if (!empty($estado->tipo_solicitud_id->nombre)) { ?>
                        <p class="boleto__tipo-solicitud">
                            Tipo de Solicitud: <?php echo $estado->tipo_solicitud_id->nombre; ?>
                        </p>
                    <?php } ?>

                    <!-- Mostrar tipo de solicitante si existe -->
                    <?php if (!empty($estado->tipo_solicitante)) { ?>
                        <h4 class="boleto__logo"><?php echo $estado->tipo_solicitante; ?></h4>
                    <?php } ?>

                    <!-- Mostrar observación si existe -->
                    <?php if (!empty($estado->observacion_rechazo)) { ?>
                        <p class="boleto__observacion">Observación: <?php echo $estado->observacion_rechazo; ?></p>
                    <?php } ?>

                    <!-- Estado -->
                    <p class="boleto__plan">Estado: <?php echo $estado->estado_id->nombre; ?></p>

                    <!-- Nombre completo -->
                    <?php if (!empty($estado->nombre)) { ?>
                        <p class="boleto__nombre"><?php echo $estado->nombre . " " . $estado->apellido1 . " " . $estado->apellido2; ?></p>
                    <?php } elseif (!empty($estado->nombres)) { ?>
                        <p class="boleto__nombre"><?php echo $estado->nombres . " " . $estado->apellidos; ?></p>
                    <?php } ?>
                </div>

                <p class="boleto__codigo">#<?php echo $estado->codigo_seguimiento; ?></p>
            </div>
        </div>
    <?php } else { ?>
        <p class="text-center">No hay una búsqueda aún o no existe tu código. Revisa los datos ingresados.</p>
    <?php } ?>
</section>