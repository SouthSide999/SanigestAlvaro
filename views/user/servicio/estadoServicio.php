<div class="dashboardUser__contenedor-boton">
    <a class="dashboardUser__boton" href="/user/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<section class="estadoServicio">
    <h2 class="estadoServicio__titulo">Resumen del Predio y Estado de Servicio</h2>

    <div class="estadoServicio__card estadoServicio__card--estado">
        <h3 class="estadoServicio__subtitulo">Estado del Servicio</h3>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Estado:</span> <?php echo $estadoServicio->nombre ?? 'No definido'?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Descripción:</span> <?php echo $estadoServicio->descripcion ?? '-' ?></p>
    </div>

    <div class="estadoServicio__card estadoServicio__card--predio">
        <h3 class="estadoServicio__subtitulo">Datos del Predio</h3>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Código:</span> <?php echo $predio->codigo_predio ?? '-' ?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Dirección:</span> <?php echo $predio->direccion ?? '-' ?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Fecha de Registro:</span> <?php echo date('d/m/Y', strtotime($predio->fecha_registro ?? $predio->created_at ?? '')) ?></p>
    </div>

    <div class="estadoServicio__card estadoServicio__card--ubicacion">
        <h3 class="estadoServicio__subtitulo">Ubicación</h3>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Zona:</span> <?php echo $zona->nombre_zona ?? '-' ?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Sector:</span> <?php echo $sector->nombre_sector ?? '-' ?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Manzana:</span> <?php echo $predio->manzana ?? '-' ?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Lote:</span> <?php echo $predio->lote_numero ?? '-' ?></p>
    </div>

    <div class="estadoServicio__card estadoServicio__card--conexion">
        <h3 class="estadoServicio__subtitulo">Conexiones</h3>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Total:</span> <?php echo $conexion->numero_conexiones ?? 0 ?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Operativos:</span> <?php echo $conexion->operativos ?? 0 ?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">No Operativos:</span> <?php echo $conexion->no_operativos ?? 0 ?></p>
    </div>

    <div class="estadoServicio__card estadoServicio__card--medidor">
        <h3 class="estadoServicio__subtitulo">Medidor</h3>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">N° Medidor:</span> <?php echo $medidor->numero_medidor ?? '-' ?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Personas:</span> <?php echo $medidor->numero_personas ?? 0 ?></p>
        <p class="estadoServicio__dato"><span class="estadoServicio__etiqueta">Inquilinos:</span> <?php echo $medidor->inquilinos ?? 0 ?></p>
    </div>
</section>