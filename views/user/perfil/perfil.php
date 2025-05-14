<div class="userPerfil__contenedor">
    <div class="dashboardUser__contenedor-boton">
        <a class="dashboardUser__boton" href="/user/dashboard">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
    </div>
    <div class="dashboardUser__formulario">
        <?php
        include_once __DIR__ . '../../../templates/alertas.php';
        ?>
        <form class="formulario" enctype="multipart/form-data" method="POST">
            <?php
            include_once __DIR__ . '/formulario.php';
            ?>
            <input
                type="submit"
                value="Actualizar Perfil"
                class="formulario__submit formulario__submit--registrarU">
        </form>
    </div>
</div>