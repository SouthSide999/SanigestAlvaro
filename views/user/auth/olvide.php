<div class="login">
    <div class="login__inner">
        <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>

        <label for="login__tab-signin" class="login__label login__label--tab"><?php echo $titulo; ?></label>
        <label for="login__tab-signin" class="login__label login__label--tab">Recupera tu acceso a SaniGest</label>

        <div class="login__form">
                <form method="POST" action="/olvideUser" class="login__form-content">
                    <div class="login__group">
                        <label for="email" class="login__label">Correo Electrónico</label>
                        <input
                            type="email"
                            class="login__input"
                            placeholder="Tu Email"
                            id="email"
                            name="email"
                            >
                    </div>

                    <div class="login__group">
                        <input type="submit" class="login__button" value="Enviar Instrucciones">
                    </div>
                </form>

                <div class="login__hr"></div>

                <div class="login__foot-link">
                    <a href="/loginUser" class="login__link">¿Ya tienes cuenta? Iniciar Sesión</a><br>
                    <a href="/loginUser" class="login__link">¿Aún no tienes una cuenta? Obtener una</a>
                </div>

        </div>
    </div>
</div>

<?php if (isset($_SESSION['mensaje_exito'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Hecho!',
            text: '<?= $_SESSION['mensaje_exito'] ?>',
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php unset($_SESSION['mensaje_exito']); ?>
<?php endif; ?>

<?php if (isset($alertas['error']) && !empty($alertas['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Hubo un problema',
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