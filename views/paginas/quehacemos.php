<main class="quehacemos">
    <h2 class="quehacemos__heading"><?php echo $titulo ?></h2>
    <p class="quehacemos__descripcion">En Sanigest Huaro, trabajamos para garantizar la gestión eficiente del agua y
        saneamiento en nuestro distrito. Nos enfocamos en optimizar el uso de los recursos hídricos, modernizar la
        administración y promover la sostenibilidad.</p>

    <div class="quehacemos__grid">
        <div <?php aos_animacion(); ?>  class="hacemos">
            <i class="fa-solid fa-bars-progress"></i>
            <h3 class="hacemos__nombre">Gestión y Administración del Agua</h3>
            <ul class="hacemos__lista">
                <li class="hacemos__elemento">Monitoreamos y optimizamos el abastecimiento de agua potable,
                    asegurando una distribución equitativa y sostenible para la comunidad.</li>
            </ul>
            <div class="hacemos__imagen">
                <picture>
                    <source srcset="build/img/Sanigest_Huaro.avif" type="image/avif">
                    <source srcset="build/img/Sanigest_Huaro.webp" type="image/webp">
                    <img loading="lazy" width="200" height="300" src="build/img/Sanigest_Huaro.jpg" alt="Imagen SaniGest">
                </picture>
            </div>

        </div>

        <div  <?php aos_animacion(); ?>  class="hacemos">
            <i class="fa-solid fa-helmet-safety"></i>
            <h3 class="hacemos__nombre"> Infraestructura y Mantenimiento</h3>
            <ul class="hacemos__lista">
                <li class="hacemos__elemento">Supervisamos y mejoramos las redes de distribución, alcantarillado
                    y plantas de tratamiento, garantizando un sistema seguro y eficiente.</li>
            </ul>
            <div class="hacemos__imagen">
                <picture>
                    <source srcset="build/img/Infraestructura_Mantenimiento.avif" type="image/avif">
                    <source srcset="build/img/Infraestructura_Mantenimiento.webp" type="image/webp">
                    <img loading="lazy" width="200" height="300" src="build/img/Infraestructura_Mantenimiento.jpg" alt="Imagen sanigest">
                </picture>
            </div>

        </div>

        <div <?php aos_animacion(); ?>  class="hacemos">
            <i class="fa-solid fa-tree"></i>
            <h3 class="hacemos__nombre">Concientización y Sostenibilidad</h3>
            <ul class="hacemos__lista">
                <li class="hacemos__elemento">Fomentamos el uso responsable del agua a través de programas educativos,
                    campañas de sensibilización y estrategias de conservación ambiental.</li>
            </ul>
            <div class="hacemos__imagen">
                <picture>
                    <source srcset="build/img/Concientizacion_Sostenibilidad.avif" type="image/avif">
                    <source srcset="build/img/Concientizacion_Sostenibilidad.webp" type="image/webp">
                    <img loading="lazy" width="200" height="300" src="build/img/Concientizacion_Sostenibilidad.jpg" alt="Imagen sanigest">
                </picture>
            </div>

        </div>
    </div>
</main>