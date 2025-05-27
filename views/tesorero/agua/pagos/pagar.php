<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/tesorero/consumos">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php
    include_once __DIR__ . '/../../../templates/alertas.php';
    ?>
    <form class="formulario" action="/tesorero/consumos/crear" method="POST">

        <?php
        include_once __DIR__ . '/formulario.php'; // Este incluirá los campos como ID del predio, lectura actual, etc.
        ?>

        <input
            type="submit"
            value="Registrar Lectura"
            class="formulario__submit formulario__submit--registrar">
    </form>
</div>

<?php if (isset($_GET['creado'])) : ?>
    <script>
        Swal.fire({
            title: "¡Lectura registrada!",
            text: "La lectura se ha guardado correctamente.",
            icon: "success",
            timer: 3000,
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "/tesorero/consumos"; // Redirigir a la lista de lecturas
        });
    </script>
<?php endif; ?>

<?php if (isset($alertas['error']) && !empty($alertas['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error de registro',
            html: `
            <ul style="text-align: left;">
                <?php foreach ($alertas['error'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        `,
            confirmButtonText: 'Intentar de nuevo'
        });
    </script>
<?php endif; ?>