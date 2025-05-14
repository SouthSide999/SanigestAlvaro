<main class="agenda">
    <h2 class="agenda__heading">Workshops & Conferencias</h2>
    <p class="agenda__descripcion">Talleres y Conferencias dictados por expertos en desarrollo web</p>

    <div class="eventos">
        <h3 <?php aos_animacion(); ?> class="eventos__heading">&lt;Conferencias /></h3>

        <p class="eventos__fecha">Viernes 5 de Octubre</p>

        <!-- Inicio listado-->
        <div <?php aos_animacion(); ?> class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos['conferencias_v'] as $evento) { ?>
                    <?php include __DIR__ . '../../templates/evento.php'; ?>
                <?php }  ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination swiper-pagination--conferencias"></div>



        </div>
        <!-- Fin listado-->


        <p <?php aos_animacion(); ?> class="eventos__fecha">Sábado 6 de Octubre</p>
        <!-- Inicio listado-->
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">

                <?php foreach ($eventos['conferencias_s'] as $evento) { ?>
                    <?php include __DIR__ . '../../templates/evento.php'; ?>
                <?php }  ?>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination swiper-pagination swiper-pagination--conferencias"></div>



        </div>
        <!-- Fin listado-->
    </div>

    <div <?php aos_animacion(); ?> class="eventos eventos--workshops">
        <h3 <?php aos_animacion(); ?> class="eventos__heading">&lt;Workshops /></h3>

        <p class="eventos__fecha">Viernes 5 de Octubre</p>
        <!-- Inicio listado-->
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">

                <?php foreach ($eventos['workshops_v'] as $evento) { ?>
                    <?php include __DIR__ . '../../templates/evento.php'; ?>
                <?php }  ?>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination swiper-pagination swiper-pagination--workshops"></div>



        </div>
        <!-- Fin listado-->



        <p class="eventos__fecha">Sábado 6 de Octubre</p>
        <!-- Inicio listado-->
        <div <?php aos_animacion(); ?> class="eventos__listado slider swiper">
            <div class="swiper-wrapper">

                <?php foreach ($eventos['workshops_s'] as $evento) { ?>
                    <?php include __DIR__ . '../../templates/evento.php'; ?>
                <?php }  ?>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination swiper-pagination--workshops"></div>


        </div>
        <!-- Fin listado-->
    </div>
</main>