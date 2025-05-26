<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<main class="bloques">
    <div class="bloques__grid">
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
    </div>
</main>