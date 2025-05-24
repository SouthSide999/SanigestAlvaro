<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<main class="bloques">
    <div class="bloques__grid">

        <!-- Últimas Solicitudes Recibidas -->
        <div class="bloque">
            <h3 class="bloque__heading">Últimas Solicitudes</h3>
            <?php foreach ($solicitudes_recientes as $solicitud) { ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto">
                        <?php
                        $tipoNombre = $solicitud->tipo->nombre ?? 'Tipo desconocido';
                        $nombreContribuyente = $solicitud->nombres.''.$solicitud->apellidos ?? 'Contribuyente';
                        echo $tipoNombre . " por " . $nombreContribuyente . " - " . $solicitud->fecha;
                        ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <!-- Ingresos Totales del Mes -->
        <div class="bloque">
            <h3 class="bloque__heading">Ingresos del Mes</h3>
            <p class="bloque__texto--cantidad">S/ <?php echo number_format($ingresos_mes, 2); ?></p>
        </div>

        <!-- Predios con Deuda -->
        <div class="bloque">
            <h3 class="bloque__heading">Predios con Deuda</h3>
            <?php foreach ($predios_endeudados as $predio) { ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto">
                        <?php echo $predio->datosPredio->codigo_predio . " " . $predio->contribuyente->nombres . " " . $predio->contribuyente->apellidos . " monto - S/ " . number_format($predio->monto_total, 2); ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <!-- Reclamos Pendientes -->
        <div class="bloque">
            <h3 class="bloque__heading">Reclamos Pendientes</h3>
            <?php foreach ($reclamos_pendientes as $reclamo) { ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto">
                        <?php echo $reclamo->cliente->nombre . " - " . $reclamo->descripcion . " Estado: " . $reclamo->estado->nombre; ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <!-- Trabajos Técnicos Programados -->
        <div class="bloque">
            <h3 class="bloque__heading">Nuevas Conexiones</h3>
            <?php foreach ($trabajos_programados as $trabajo) { ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto">
                        <?php
                        // Obtener nombre del solicitante
                        if ($trabajo->tipo_persona === 'juridico') {
                            $solicitante = $trabajo->razon_social;
                        } else {
                            $solicitante = trim("{$trabajo->nombre} {$trabajo->apellido1} {$trabajo->apellido2}");
                        }

                        $tipoServicio = ucfirst($trabajo->tipo_servicio) ?: 'Servicio';
                        $direccion = $trabajo->direccion_principal ?: 'Sin dirección';
                        $fecha = date('d/m/Y', strtotime($trabajo->fecha_solicitud));

                        echo "$solicitante solicitó $tipoServicio el $fecha en $direccion";
                        ?>
                    </p>
                </div>
            <?php } ?>
        </div>


    </div>
</main>