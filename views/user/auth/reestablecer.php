<div class="login">
    <div class="login__inner">
        <h2 class="login__label login__label--heading"><?= $titulo; ?></h2>
        <p class="login__label login__label--texto">Coloca tu nuevo password</p>

        <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>

        <?php if ($token_valido) { ?>
            <form method="POST" action="" class="login__form-content">
                <div class="login__group">
                    <label for="password" class="login__label">Nuevo Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="login__input"
                        placeholder="Tu Nuevo Password">
                </div>

                <div class="login__group">
                    <input type="submit" class="login__button" value="Guardar Password">
                </div>
            </form>
        <?php } ?>

        <div class="login__hr"></div>
        <div class="login__foot-link">
            <a href="/loginUser" class="login__link">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/loginUser" class="login__link">¿Aún no tienes una cuenta? Obtener una</a>
        </div>
    </div>
</div>
