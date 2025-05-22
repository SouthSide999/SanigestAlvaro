<div class="dashboardUser__contenedor-boton">
    <a class="dashboardUser__boton" href="/user/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
<canvas hidden> </canvas>

<div class="historial-grafica">
    <h3 class="historial-grafica__titulo">Historial de Consumo (m³)</h3>
    <p class="historial-grafica__descripcion">Visualiza el consumo mensual de agua potable registrado por tu medidor.</p>
    <div class="historial-grafica__icono">
        <i class="fa-solid fa-droplet"></i>
    </div>
    <canvas id="grafica-consumo" width="400" height="300"></canvas>
    <div class="historial-grafica__resumen">
        <p><strong>Consumo Máximo:</strong> <span id="max-consumo">--</span> m³</p>
        <p><strong>Consumo Promedio:</strong> <span id="prom-consumo">--</span> m³</p>
    </div>
</div>

<div class="historial-grafica">
    <h3 class="historial-grafica__titulo">Historial de Monto Total (S/)</h3>
    <p class="historial-grafica__descripcion">Revisa el monto facturado cada mes en base a tu consumo.</p>
    <div class="historial-grafica__icono">
        <i class="fa-solid fa-sack-dollar"></i>
    </div>
    <canvas id="grafica-monto" width="400" height="300"></canvas>
    <div class="historial-grafica__resumen">
        <p><strong>Monto Máximo:</strong> S/ <span id="max-monto">--</span></p>
        <p><strong>Promedio Mensual:</strong> S/ <span id="prom-monto">--</span></p>
    </div>
</div>