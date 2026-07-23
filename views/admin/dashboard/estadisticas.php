<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<main class="bloques">
    <div class="bloques__grid">

        <!-- Nivel de Mora -->
        <div class="historial-grafica">
            <h3 class="historial-grafica__titulo">Nivel de Mora</h3>
            <p class="historial-grafica__descripcion">
                Porcentaje de predios con recibos pendientes de pago.
            </p>
            <div class="historial-grafica__icono">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <canvas id="grafica-mora" width="400" height="300"></canvas>
            <div class="historial-grafica__resumen">
                <p>
                    <strong>Mora:</strong>
                    <span id="estadistica-mora">--</span> %
                    <strong>Mora:</strong>
                    <span id="estadistica-mora">--</span> %
                    <strong>Mora:</strong>
                    <span id="estadistica-mora">--</span> %
                </p>

            </div>
        </div>


        <!-- Recaudación Mensual -->
        <div class="historial-grafica">
            <h3 class="historial-grafica__titulo">Recaudación Mensual</h3>
            <p class="historial-grafica__descripcion">
                Evolución de los ingresos recaudados por mes.
            </p>
            <div class="historial-grafica__icono">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
            <canvas id="grafica-recaudacion" width="400" height="300"></canvas>
            <div class="historial-grafica__resumen">
                <p><strong>Total del mes:</strong> S/ <?php echo number_format($recaudacion_mes, 2); ?></p>
                <p><strong>Recibos pagados:</strong> <?php echo $recibos_pagados; ?></p>
            </div>
        </div>

        <!-- Consumo Promedio -->
        <div class="historial-grafica">
            <h3 class="historial-grafica__titulo">Consumo Promedio</h3>
            <p class="historial-grafica__descripcion">
                Consumo promedio mensual de agua potable por predio.
            </p>
            <div class="historial-grafica__icono">
                <i class="fa-solid fa-droplet"></i>
            </div>
            <canvas id="grafica-consumo-promedio" width="400" height="300"></canvas>
            <div class="historial-grafica__resumen">
                <p><strong>Promedio:</strong> <?php echo number_format($consumo_promedio, 2); ?> m³</p>
                <p><strong>Periodo:</strong> <?php echo $mes_actual . ' ' . $anio_actual; ?></p>
            </div>
        </div>

        <!-- Solicitudes -->
        <div class="historial-grafica">
            <h3 class="historial-grafica__titulo">Solicitudes Registradas</h3>
            <p class="historial-grafica__descripcion">
                Distribución de solicitudes por tipo.
            </p>
            <div class="historial-grafica__icono">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>
            <canvas id="grafica-solicitudes" width="400" height="300"></canvas>
            <div class="historial-grafica__resumen">
                <p><strong>Pendientes:</strong> <?php echo $solicitudes_pendientes; ?></p>
                <p><strong>Total:</strong> <?php echo $total_solicitudes; ?></p>
            </div>
        </div>

        <!-- Reclamos -->
        <div class="historial-grafica">
            <h3 class="historial-grafica__titulo">Reclamos</h3>
            <p class="historial-grafica__descripcion">
                Estado actual de los reclamos registrados.
            </p>
            <div class="historial-grafica__icono">
                <i class="fa-solid fa-headset"></i>
            </div>
            <canvas id="grafica-reclamos" width="400" height="300"></canvas>
            <div class="historial-grafica__resumen">
                <p><strong>Pendientes:</strong> <?php echo $reclamos_pendientes; ?></p>
                <p><strong>Atendidos:</strong> <?php echo $reclamos_atendidos; ?></p>
            </div>
        </div>

        <!-- Estado de Predios -->
        <div class="historial-grafica">
            <h3 class="historial-grafica__titulo">Estado de Predios</h3>
            <p class="historial-grafica__descripcion">
                Predios activos frente a predios cortados o suspendidos.
            </p>
            <div class="historial-grafica__icono">
                <i class="fa-solid fa-house-circle-check"></i>
            </div>
            <canvas id="grafica-predios" width="400" height="300"></canvas>
            <div class="historial-grafica__resumen">
                <p><strong>Activos:</strong> <?php echo $predios_activos; ?></p>
                <p><strong>Cortados:</strong> <?php echo $predios_cortados; ?></p>
            </div>
        </div>

    </div>
</main>