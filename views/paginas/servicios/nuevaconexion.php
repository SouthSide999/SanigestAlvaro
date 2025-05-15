<div class="nuevaconexion">
    <div class="nuevaconexion__formulario">
        <?php
        include_once __DIR__ . '../../../templates/alertas.php';
        ?>



        <form class="formulario" action="/servicios/nuevaconexion/crear" enctype="multipart/form-data" method="POST">
            <?php
            include_once __DIR__ . '/formulario.php';
            ?>
            <input type="submit" value="Enviar" class="nuevaconexion__formulario__boton">
        </form>
    </div>
</div>