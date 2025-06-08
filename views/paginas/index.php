<section class="bienvenida">
    <?php
    include_once __DIR__ . '../../templates/texto-bienvenida.php';
    ?>

    <div <?php aos_animacion(); ?> class="nosotros__grid">
        <div class="nosotros__imagen">
            <picture>
                <source srcset="/build/img/header-huaro.webp" type="image/webp">
                <source srcset="/build/img/header-huaro.avif" type="image/png">
                <img class="masinformacion__informacion__imagen" loading="lazy" width="200" height="300" src="/build/img/header-huaro.jpg" alt="Imagen Ponente">
            </picture>
        </div>

        <div class="nosotros__contenido">
            <p class="nosotros__texto">Sanigest, un sistema innovador diseñado para la administración y optimización
                de los servicios de agua y saneamiento en el distrito de Huaro. Nuestro objetivo es mejorar la calidad de vida de
                los residentes mediante una gestión eficiente y sostenible de estos recursos esenciales. Explora nuestro proyecto y
                descubre cómo buscamos transformar la gestión de agua y saneamiento en nuestra comunidad.</p>

            <p class="nosotros__texto">
                Sanigest es un proyecto liderado por un equipo de profesionales dedicados a mejorar los servicios de agua y saneamiento
                en Huaro. Formamos parte de una iniciativa más amplia que busca impulsar el desarrollo sostenible en la región. Nuestro
                equipo está compuesto por [mencionar los roles clave: ingenieros, gestores de recursos hídricos, colaboradores locales],
                y estamos comprometidos con la mejora continua de la calidad del servicio.
            </p>
        </div>
    </div>
</section>

<?php
include __DIR__ . '/noticias.php';
?>

<section class="mapa">
    <h2 <?php aos_animacion(); ?> class="mapa__heading">Donde Estamos? </h2>

    <div class="mapa__descripcion">
        <p <?php aos_animacion(); ?> class="mapa__texto">
            El sistema Sanigest se encuentra ubicado en la Municipalidad Distrital de Huaro, específicamente en el área de UGM (Unidad de Gestión Municipal).
            Este sistema, que tiene como objetivo la administración y optimización de los servicios de agua y saneamiento en el distrito de Huaro, es manejado
            directamente por el personal de la UGM.
        </p>

        <p <?php aos_animacion(); ?> class="mapa__texto">
            El equipo de la UGM se encarga de la operación y gestión del software Sanigest, garantizando la eficiencia y efectividad en el control y la optimización
            de los recursos hídricos y de saneamiento en la comunidad. La Municipalidad Distrital de Huaro es el centro neurálgico de este sistema, permitiendo un mejor
            servicio para los habitantes del distrito.
        </p>
    </div>
    <div id="mapa" class="mapa__mapa"></div>
</section>

<section class="resumen" <?php aos_animacion(); ?>>
    <div class="resumen__grid">
        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $ponentes_total; ?></p>
            <p class="resumen__texto">Cantidad de usuarios registrados</p>
        </div>

        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $conferencia_total; ?></p>
            <p class="resumen__texto">Usuarios activos</p>
        </div>

        <div <?php aos_animacion(); ?> class=" resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $workshops_total; ?></p>
            <p class="resumen__texto">Personal de la UGM capacitado</p>
        </div>

        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero">18</p>
            <p class="resumen__texto">Número de incidentes solucionados</p>
        </div>
    </div>
</section>


<!-- <section class="carrusel">

    <div class="carrusel_contenedor">
        <div class="slide">

            <div class="item" style="background: url('/build/img/Sanigest_Huaro.jpg'); background-size: cover;">
                <div class="content">
                    <div class="name">Gestión Integral</div>
                    <div class="description">Monitorea y administra los servicios de agua y saneamiento desde un solo lugar.</div>
                    <button onclick="window.location.href='/user/dashboard'">Ver Plataforma</button>
                </div>
            </div>

            <div class="item" style="background: url('/build/img/Concientizacion_Sostenibilidad.jpg'); background-size: cover;">
                <div class="content">
                    <div class="name">Sostenibilidad</div>
                    <div class="description">Promovemos el uso responsable del agua y el cuidado del medio ambiente en Huaro.</div>
                    <button onclick="window.location.href='/educacion/conciencia'">Aprende Más</button>
                </div>
            </div>

            <div class="item" style="background: url('/build/img/Infraestructura_Mantenimiento.jpg'); background-size: cover;">
                <div class="content">
                    <div class="name">Mantenimiento Eficiente</div>
                    <div class="description">Gestiona reportes técnicos y realiza seguimiento a conexiones y reparaciones.</div>
                    <button onclick="window.location.href='/tecnico/gestion'">Ver Procesos</button>
                </div>
            </div>

            <div class="item" style="background: url('/build/img/header-huaro.jpg'); background-size: cover;">
                <div class="content">
                    <div class="name">Atención al Usuario</div>
                    <div class="description">Facilitamos el registro de reclamos y consultas con total transparencia.</div>
                    <button onclick="window.location.href='/user/soporte'">Contactar Soporte</button>
                </div>
            </div>

            <div class="item" style="background: url('/build/img/resumen_index.jpg'); background-size: cover;">
                <div class="content">
                    <div class="name">Resumen de Actividades</div>
                    <div class="description">Visualiza tus consumos, pagos, facturación y más desde tu panel de usuario.</div>
                    <button onclick="window.location.href='/user/perfil'">Ir al Perfil</button>
                </div>
            </div>

        </div>

        <div class="button">
            <button class="prevCarrusel"><i class="fa-solid fa-arrow-left"></i></button>
            <button class="nextCarrusel"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>

</section> -->