<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/sectores">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php
    include_once __DIR__ . '../../../../templates/alertas.php';
    ?>
    <form class="formulario"  enctype="multipart/form-data" method="POST">

        <?php
        include_once __DIR__ . '/formulario.php';
        ?>

        <input
            type="submit"
            value="Actualizar"
            class="formulario__submit formulario__submit--registrar">
    </form>
</div>

<?php if (isset($_GET['actualizado']) && $_GET['actualizado'] == 1) : ?>
    <script>
        Swal.fire({
            title: "¡Actualizado!",
            text: "El Sector ha sido actualizado correctamente.",
            icon: "success",
            timer: 3000,
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "/admin/sectores"; // Redirigir al listado de sectores
        });
    </script>
<?php endif; ?>
