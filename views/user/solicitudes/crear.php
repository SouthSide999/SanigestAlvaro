<h2><?php echo $titulo; ?></h2>

<div class="dashboardUser__contenedor-boton">
    <a class="dashboardUser__boton" href="/user/solicitud">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboardUser__formulario">
    <?php
    include_once __DIR__ . '../../../templates/alertas.php';
    ?>
    <form class="formulario" action="/user/reclamos" enctype="multipart/form-data" method="POST">
        <?php
        include_once __DIR__ . '/formulario.php';
        ?>
        <input
            type="submit"
            value="Registrar La Solicitud"
            class="formulario__submit formulario__submit--registrarU">
    </form>
</div>



