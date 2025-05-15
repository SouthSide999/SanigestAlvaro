<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/contribuyentes">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="dashboard__formulario">
    <?php
    include_once __DIR__ . '../../../../templates/alertas.php';
    ?>
    <form class="formulario" enctype="multipart/form-data" action="/tesorero/contribuyentes/crear" method="POST">


        <?php
        include_once __DIR__ . '/formulario.php';
        ?>

        <input
            type="submit"
            value="Crear"
            class="formulario__submit formulario__submit--registrar">
    </form>
</div>


<?php if (isset($_GET['creado'])) : ?>
    <script>
        Swal.fire({
            title: "¡Creado!",
            text: "El contribuyente ha sido creado correctamente.",
            icon: "success",
            timer: 3000,
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "/tesorero/contribuyentes"; // Redirigir al listado de medidores
        });
    </script>
<?php endif; ?>