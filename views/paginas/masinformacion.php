<main <?php aos_animacion(); ?> class="masinformacion">
    <h2 class="masinformacion__heading"><?php echo  $noticia->nombre; ?></h2>
    <p class="masinformacion__descripcion">Conoce más sobre esta Notica</p>

    <div class="masinformacion__grid">
        <div class="masinformacion__informacion">
            <div class="masinformacion__informacion__imagen">
                <?php if (isset($noticia->imagen)) { ?>
                    <picture>
                        <source srcset="img/noticias/<?php echo $noticia->imagen; ?>.webp" type="image/webp">
                        <source srcset="img/noticias/<?php echo $noticia->imagen; ?>.png" type="image/png">
                        <img class="masinformacion__informacion__imagen" loading="lazy" width="200" height="300" src="img/noticias/<?php echo $noticia->imagen; ?>.png" alt="Imagen">
                    </picture>
                <?php } else { ?>
                    <picture>
                        <source srcset="/build/img/header-huaro.webp" type="image/webp">
                        <source srcset="/build/img/header-huaro.png" type="image/png">
                        <img class="masinformacion__informacion__imagen" loading="lazy" width="200" height="300" src="/build/img/header-huaro.jpg" alt="Imagen Ponente">
                    </picture>
                <?php  } ?>
            </div>
        </div>

        <div class="masinformacion__informacion__contenido">
            <p class="masinformacion__informacion__texto"><?php echo  $noticia->contenido; ?></p>
        </div>
    </div>
</main>