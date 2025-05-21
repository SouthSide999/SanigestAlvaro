<h2 class="pagina__heading"><?php echo $titulo; ?></h2>

<!-- FORMULARIO DE BÚSQUEDA -->
<div class="estadoconexion__contenedor">
    <form class="dashboard__formulario__buscardor" action="/servicios/consultar-recibo" method="POST" enctype="multipart/form-data">
        <fieldset class="formulario__fieldset">

            <div class="formulario__campo">
                <label for="dato" class="formulario__label">Ingrese el Código de Predio:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="codigo_predio"
                    name="codigo_predio"
                    placeholder="Código de Predio"
                    required>
            </div>
        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input type="submit" value="Buscar Recibo" class="dashboard__boton__buscardor">
        </div>
    </form>
</div>
<!-- RESULTADO -->
<?php if ($mensaje): ?>
    <section class="recibo__contenedor">
        <h3 class="recibo__mensaje"><?php echo $mensaje; ?></h3>
    </section>
<?php endif; ?>

<?php if ($resultado): ?>
    <section class="recibo__contenedor">
        <h2 class="recibo__heading">El estado de tu búsqueda es:</h2>

        <div class="recibo__contenido">
            <h3 class="recibo__subtitulo">Datos del Predio</h3>
            <div class="recibo__datos">
                <p class="recibo__dato"><strong class="recibo__label">Código:</strong> <?php echo $resultado['predio']->codigo_predio; ?></p>
                <p class="recibo__dato"><strong class="recibo__label">Dirección:</strong> <?php echo $resultado['predio']->direccion; ?></p>
                <p class="recibo__dato"><strong class="recibo__label">Estado del Servicio:</strong> <?php echo $resultado['estado_servicio']->nombre; ?></p>
            </div>

            <h3 class="recibo__subtitulo">Contribuyente</h3>
            <div class="recibo__contribuyente">
                <p class="recibo__dato"><strong class="recibo__label">Nombre:</strong> <?php echo $resultado['contribuyente']->nombres . ' ' . $resultado['contribuyente']->apellidos; ?></p>
                <p class="recibo__dato"><strong class="recibo__label">DNI:</strong> <?php echo $resultado['contribuyente']->documento_identidad; ?></p>
            </div>

            <?php if ($resultado['consumo']): ?>
                <h3 class="recibo__subtitulo">Detalle del Consumo</h3>
                <div class="recibo__consumo">
                    <p class="recibo__dato"><strong class="recibo__label">Periodo:</strong> <?php echo date('F Y', mktime(0, 0, 0, $resultado['consumo']->mes, 1)); ?></p>
                    <p class="recibo__dato"><strong class="recibo__label">Inicio:</strong> <?php echo $resultado['consumo']->fecha_inicio; ?></p>
                    <p class="recibo__dato"><strong class="recibo__label">Fin:</strong> <?php echo $resultado['consumo']->fecha_fin; ?></p>
                    <p class="recibo__dato"><strong class="recibo__label">Consumo:</strong> <?php echo $resultado['consumo']->consumo_m3; ?> m³</p>
                    <p class="recibo__dato"><strong class="recibo__label">Monto total:</strong> S/. <?php echo number_format($resultado['consumo']->monto_total, 2); ?></p>
                    <p class="recibo__dato"><strong class="recibo__label">Estado del recibo:</strong> <?php echo $resultado['estado_recibo']->nombre ?? 'No disponible'; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>