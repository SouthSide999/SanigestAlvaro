<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/ponentes">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="dashboard__formulario">
    <?php
    include_once __DIR__ . '../../../templates/alertas.php';
    ?>
    <form class="formulario" action="/admin/ponentes/crear" enctype="multipart/form-data" method="POST">


        <?php
        include_once __DIR__ . '/formulario.php';
        ?>

        <input
            type="submit"
            value="Registrar Ponente"
            class="formulario__submit formulario__submit--registrar">
    </form>
</div>

<?php
session_start();
if (isset($_SESSION['exito'])) :
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'El ponente se ha registrado correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '/admin/ponentes'; // Redirigir después de cerrar la alerta
        });
    </script>
<?php
    unset($_SESSION['exito']); // Limpiar la variable de sesión para que no se muestre de nuevo
endif;
?>