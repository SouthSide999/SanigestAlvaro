<div class="noticia swiper-slide">
    <div class="noticia__informacion">
        <a class="noticia__enlace" href="/masinformacion?id=<?php echo $noticia->id; ?>">
            <h4 class="noticia__nombre"><?php echo $noticia->nombre ?> </h4>
            <div>
                <h4 class="noticia__resumen"><?php echo $noticia->contenido ?> </h4>
            </div>
        </a>
        <!-- <picture>
            <source class="noticia__imagen" srcset="img/noticias/<?php echo $noticia->imagen; ?>.webp" type="image/webp">
            <source class="noticia__imagen" srcset="img/noticias/<?php echo $noticia->imagen; ?>.png" type="image/png">
            <img class="noticia__imagen" loading="lazy" width="200" height="300" src="img/noticias/<?php echo $noticia->imagen; ?>.png" alt="Imagen Ponente">
        </picture> -->

        <?php if (isset($noticia->imagen)) { ?>
            <picture>
            <source class="noticia__imagen" srcset="img/noticias/<?php echo $noticia->imagen; ?>.webp" type="image/webp">
            <source class="noticia__imagen" srcset="img/noticias/<?php echo $noticia->imagen; ?>.png" type="image/png">
            <img class="noticia__imagen" loading="lazy" width="200" height="300" src="img/noticias/<?php echo $noticia->imagen; ?>.png" alt="Imagen Ponente">
        </picture>
        <?php } ?>
        
    </div>
</div>