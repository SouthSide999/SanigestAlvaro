<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/eventos">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="dashboard__formulario">
    <?php
    include_once __DIR__ . '../../../templates/alertas.php';
    ?>
    <form class="formulario" action="/admin/eventos/crear"  method="POST">


        <?php
        include_once __DIR__ . '/formulario.php';
        ?>

        <input
            type="submit"
            value="Registrar Evento"
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
            text: 'El evento se ha registrado correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '/admin/eventos'; // Redirigir después de cerrar la alerta
        });
    </script>
<?php
    unset($_SESSION['exito']); // Limpiar la variable de sesión para que no se muestre de nuevo
endif;
?>