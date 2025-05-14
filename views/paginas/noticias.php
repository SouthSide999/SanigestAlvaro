<main class="agenda">
    <div <?php aos_animacion(); ?> class="noticias noticias">
        <h3 <?php aos_animacion(); ?> class="noticias__heading">&lt;Noticias y Avisos /></h3>
        <p <?php aos_animacion(); ?> class="agenda__descripcion">Noticias Y Avisos de la UGM de la Municipalidad Distrital de Huaro</p>

        <p class="noticias__fecha">Actualizado al <span class="footer__copyright--regular">
                <?php
                $meses = [
                    1 => 'Enero',
                    2 => 'Febrero',
                    3 => 'Marzo',
                    4 => 'Abril',
                    5 => 'Mayo',
                    6 => 'Junio',
                    7 => 'Julio',
                    8 => 'Agosto',
                    9 => 'Septiembre',
                    10 => 'Octubre',
                    11 => 'Noviembre',
                    12 => 'Diciembre'
                ];
                $fecha = new DateTime();
                echo $fecha->format('j') . ' de ' . $meses[(int)$fecha->format('n')] . ' de ' . $fecha->format('Y');
                ?>
            </span></p>

        <!-- Inicio listado-->
        <div class="noticias__listado slider swiper">
            <div class="swiper-wrapper">

                <?php foreach ($noticias as $noticia) { ?>
                    <?php include __DIR__ . '../../templates/noticia.php'; ?>
                <?php }  ?>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination swiper-pagination swiper-pagination--workshops"></div>
        </div>
        <!-- Fin listado-->
    </div>
</main>