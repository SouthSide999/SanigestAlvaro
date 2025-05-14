<h2 class="dashboardAgua__heading">Administración de Datos - Agua Potable</h2>
<div class="dashboardAgua__contenedor">
    <nav class="dashboardAgua__menu">
        <!-- 1. Resumen -->
        <a href="/admin/resumen" class="dashboardAgua__enlace">
            <i class="fa-solid fa-chart-pie"></i>
            <span class="dashboardAgua__menu-texto">Resumen</span>
        </a>

        <!-- 2. Contribuyentes -->
        <a href="/admin/contribuyentes" class="dashboardAgua__enlace">
            <i class="fa-solid fa-user"></i>
            <span class="dashboardAgua__menu-texto">Contribuyentes</span>
        </a>

        <!-- 3. Predios -->
        <a href="/admin/predios" class="dashboardAgua__enlace">
            <i class="fa-solid fa-house-chimney"></i>
            <span class="dashboardAgua__menu-texto">Predios</span>
        </a>

        <!-- 4. Conexiones -->
        <a href="/admin/conexiones" class="dashboardAgua__enlace">
            <i class="fa-solid fa-water"></i>
            <span class="dashboardAgua__menu-texto">Conexiones</span>
        </a>

        <!-- 5. Medidores -->
        <a href="/admin/medidores" class="dashboardAgua__enlace">
            <i class="fa-solid fa-tachometer-alt"></i>
            <span class="dashboardAgua__menu-texto">Medidores</span>
        </a>

        <!-- 6. Consumos -->
        <a href="/admin/consumos" class="dashboardAgua__enlace">
            <i class="fa-solid fa-droplet"></i>
            <span class="dashboardAgua__menu-texto">Consumos</span>
        </a>

        <!-- 7. Pagos -->
        <a href="/admin/pagos" class="dashboardAgua__enlace">
            <i class="fa-solid fa-credit-card"></i>
            <span class="dashboardAgua__menu-texto">Pagos</span>
        </a>

        <!-- 8. Recibos -->
        <a href="/admin/recibos" class="dashboardAgua__enlace">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span class="dashboardAgua__menu-texto">Recibos</span>
        </a>

        <!-- 9. Tarifas -->
        <a href="/admin/tarifas" class="dashboardAgua__enlace">
            <i class="fa-solid fa-tags"></i>
            <span class="dashboardAgua__menu-texto">Tarifas</span>
        </a>

        <!-- 10. Zonas -->
        <a href="/admin/zonas" class="dashboardAgua__enlace">
            <i class="fa-solid fa-map-pin"></i>
            <span class="dashboardAgua__menu-texto">Zonas</span>
        </a>

        <!-- 11. Sectores -->
        <a href="/admin/sectores" class="dashboardAgua__enlace">
            <i class="fa-solid fa-layer-group"></i>
            <span class="dashboardAgua__menu-texto">Sectores</span>
        </a>
    </nav>

    <!-- Recomendaciones de uso -->
    <section class="dashboardAgua__recomendaciones">
        <h3 class="dashboardAgua__recomendaciones-heading">📌 Recomendaciones para Registrar los Datos</h3>
        <ul class="dashboardAgua__recomendaciones-lista">

            <li>
                🧑‍💼 <strong>Primero crea al Contribuyente:</strong> Antes de registrar cualquier predio, conexión o medidor, asegúrate de registrar primero los datos del dueño (nombre, DNI o RUC, estado civil, etc.).
            </li>

            <li>
                🏠 <strong>Un contribuyente puede tener varias casas o terrenos:</strong> Por eso cada <strong>Predio</strong> debe estar vinculado a un contribuyente ya registrado. No se puede registrar un predio sin tener al contribuyente primero.
            </li>

            <li>
                📍 <strong>Ubicación del predio:</strong> Al crear un predio debes elegir correctamente la <strong>Zona</strong> y el <strong>Sector</strong> donde está ubicado. Asegúrate de que ya estén creados en el sistema.
            </li>

            <li>
                🔌 <strong>Conexión de Agua:</strong> Cada predio debe tener al menos una conexión. Aquí se indica si está operativa o no, y también cuántas personas viven en esa vivienda (dueños, hijos, inquilinos, etc.).
            </li>

            <li>
                ⚙️ <strong>Medidor de Agua:</strong> El número del medidor debe ser único y debe estar conectado a una vivienda específica. Si aún no hay medidor, se puede dejar pendiente pero no se podrá calcular consumo.
            </li>

            <li>
                💧 <strong>Consumo mensual:</strong> El consumo se mide por metros cúbicos (m³) y se registra por cada mes. Para calcularlo correctamente, el sistema usará la <strong>Tarifa</strong> según el tipo de usuario (doméstico, comercial, etc.).
            </li>

            <li>
                💵 <strong>Pagos:</strong> Cada vez que un contribuyente paga su recibo, se debe registrar el <strong>monto</strong> y la <strong>fecha del pago</strong>. Este pago se vincula automáticamente con su recibo y su consumo.
            </li>

            <li>
                🧾 <strong>Recibos:</strong> Se generan automáticamente al registrar el consumo y el pago. Puedes consultarlos o imprimirlos desde la sección “Recibos”.
            </li>

            <li>
                ⚠️ <strong>Importante:</strong> Siempre sigue este orden para evitar errores:
                <br><strong>Contribuyente → Predio → Zona/Sector → Conexión → Medidor → Tarifa.</strong>
            </li>

        </ul>
    </section>



</div>