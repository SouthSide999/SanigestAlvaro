<div class="dashboardtecnico__contenedor-boton">
    <a class="dashboardtecnico__boton" href="/tecnico/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<h1 class="dashboardtecnico__mensaje">Bienvenido Señor Técnico: <?php echo $nombre; ?></h1>
<div class="dashboardtecnico__grid">
    <div>
        <div class="dashboardtecnico__navegacion">
            <a class="dashboardtecnico__navegacion-enlace" href="/tecnico/nuevasconexiones">
                <i class="dashboardtecnico__navegacion-icono fa-solid fa-network-wired"></i>
                <h4 class="dashboardtecnico__navegacion-etiqueta">Nuevas Conexiones</h4>
            </a>
            <a class="dashboardtecnico__navegacion-enlace" href="/tecnico/nuevasconexiones/pendientes">
                <i class="dashboardtecnico__navegacion-icono fa-solid fa-xmark"></i>
                <h4 class="dashboardtecnico__navegacion-etiqueta">Pendientes</h4>
                <p class="dashboardtecnico__navegacion-texto">Conexiones Pendientes</p>
            </a>

            <a class="dashboardtecnico__navegacion-enlace" href="/tecnico/nuevasconexiones/encurso">
                <i class="dashboardtecnico__navegacion-icono fa-solid fa-spinner"></i>
                <h4 class="dashboardtecnico__navegacion-etiqueta">En Curso</h4>
                <p class="dashboardtecnico__navegacion-texto">Conexiones en Curso</p>
            </a>
        </div>
    </div>

    <div class="dashboardtecnico__recomendaciones">
        <h3 class="dashboardtecnico__recomendaciones-titulo">Recomendaciones de Seguridad</h3>
        <ul class="dashboardtecnico__recomendaciones-lista">
            <li>Utiliza siempre el equipo de protección personal (EPP) adecuado.</li>
            <li>Antes de iniciar un trabajo, verifica que las herramientas estén en buen estado.</li>
            <li>Sigue los protocolos de seguridad para trabajos en altura y espacios confinados.</li>
            <li>Si detectas una fuga o desperfecto mayor, informa inmediatamente a tu supervisor.</li>
            <li>Mantén siempre una comunicación efectiva con el equipo de trabajo.</li>
        </ul>
    </div>
</div>