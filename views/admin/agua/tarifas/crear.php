<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/tarifas">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php
    include_once __DIR__ . '../../../../templates/alertas.php';
    ?>
    <form class="formulario" action="/admin/tarifas/crear" enctype="multipart/form-data" method="POST">

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
            text: "La tarifa ha sido creada correctamente.",
            icon: "success",
            timer: 3000,
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "/admin/tarifas"; // Redirigir al listado de tarifas
        });
    </script>
<?php endif; ?>
