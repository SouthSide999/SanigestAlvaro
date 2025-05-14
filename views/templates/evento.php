<div class="evento swiper-slide">
    <p class="evento__hora"><?php echo $evento->hora->hora ?></p>
    <div class="evento__informacion">
        <a class="evento__enlace" href="/masinformacion?id=<?php echo $evento->id; ?>">
            <h4 class="evento__nombre"><?php echo $evento->nombre ?> </h4>
            <div>
                <h4 class="evento__introduccion"><?php echo $evento->descripcion ?> </h4>
            </div>
            <div class="evento__autor-info">
                <!--primera forma -->
                <!-- <picture>
                                        <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen; ?>.webp" type="image/webp">
                                        <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen; ?>.png" type="image/png">
                                        <img src="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen; ?>.png" alt="Imagen Ponente">
                                    </picture> -->
    
                <!--segunda forma -->
                <picture>
                    <source class="evento__imagen-autor" srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.webp" type="image/webp">
                    <source class="evento__imagen-autor" srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" type="image/png">
                    <img class="evento__imagen-autor" loading="lazy" width="200" height="300" src="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" alt="Imagen Ponente">
                </picture>
                <p class="evento__autor-nombre">
                    <?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido ?>
                </p>
    
            </div>
        </a>
    </div>
</div>
