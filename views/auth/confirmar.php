<main class="auth">
    <div class="auth__1">
        <h2 class="auth__heading"><?php echo $titulo; ?></h2>
        <p class="auth__texto">Tu Cuenta SaniGest</p>

        <?php
        require_once __DIR__ . '/../templates/alertas.php';
        ?>

        <?php if (isset($alertas['exito'])) { ?>
            <div class="acciones--centrar">
                <a href="/auth/login" class="acciones__enlace">Iniciar Sesión</a>
            </div>
        <?php } ?>
    </div>

    <div>
        <?php
        require_once __DIR__ . '/../templates/slider.php';
        ?>

    </div>

</main>