<div class="login">
    <div class="login__inner">
        <?php
        require_once __DIR__ . '/../../templates/alertas.php';
        ?>

        <input id="login__tab-signin" type="radio" name="login__tab" class="login__tab login__tab--signin" checked>
        <label for="login__tab-signin" class="login__label login__label--tab">Iniciar Sección</label>

        <input id="login__tab-signup" type="radio" name="login__tab" class="login__tab login__tab--signup">
        <label for="login__tab-signup" class="login__label login__label--tab">Crear Nueva Cuenta</label>

        <div class="login__form">

            <div class="login__section login__section--signin">
                <form method="POST" action="/loginUser" class="login__form-content">
                    <div class="login__group">
                        <label for="login__email" class="login__label">Correo Electrónico</label>
                        <input id="login__email" name="email" type="email" class="login__input" value="<?= $cliente->email ?? '' ?>">
                    </div>
                    <div class="login__group">
                        <label for="login__password" class="login__label">Password</label>
                        <input id="login__password" name="password" type="password" class="login__input" data-type="password">
                    </div>
                    <div class="login__group">
                        <input id="login__keep-signed" type="checkbox" class="login__check" checked>
                        <label for="login__keep-signed" class="login__label login__label--checkbox">
                            <span class="login__icon"></span> Mantener sesión iniciada
                        </label>
                    </div>
                    <div class="login__group">
                        <input type="submit" class="login__button" value="Sign In">
                    </div>
                </form>
                <div class="login__hr"></div>
                <div class="login__foot-link">
                    <a href="/olvide" class="login__link">¿Olvidaste tu contraseña?</a>
                </div>
            </div>

            <div class="login__section login__section--signup">
                <form method="POST" action="/registroUser" class="login__form-content">
                    <div class="login__group">
                        <label for="signup__codigo_predio" class="login__label">Código de Predio</label>
                        <input id="signup__codigo_predio" name="codigo_predio" type="text" class="login__input" value="<?= $cliente->codigo_predio ?? '' ?>">
                    </div>
                    <div class="login__group">
                        <label for="signup__nombre" class="login__label">Nombres</label>
                        <input id="signup__nombre" name="nombre" type="text" class="login__input" value="<?= $cliente->nombre ?? '' ?>">
                    </div>
                    <div class="login__group">
                        <label for="signup__apellido" class="login__label">Apellidos</label>
                        <input id="signup__apellido" name="apellido" type="text" class="login__input" value="<?= $cliente->apellido ?? '' ?>">
                    </div>
                    <div class="login__group">
                        <label for="signup__email" class="login__label">Correo Electrónico</label>
                        <input id="signup__email" name="email" type="email" class="login__input" value="<?= $cliente->email ?? '' ?>">
                    </div>
                    <div class="login__group">
                        <label for="signup__password" class="login__label">Password</label>
                        <input id="signup__password" name="password" type="password" class="login__input" data-type="password">
                    </div>
                    <div class="login__group">
                        <label for="signup__password2" class="login__label">Repetir Password</label>
                        <input id="signup__password2" name="password2" type="password" class="login__input" data-type="password">
                    </div>
                    <div class="login__group">
                        <label for="signup__dni" class="login__label">DNI</label>
                        <input id="signup__dni" name="dni" type="text" class="login__input" value="<?= $cliente->dni ?? '' ?>">
                    </div>
                    <div class="login__group">
                        <label for="signup__celular" class="login__label">Celular</label>
                        <input id="signup__celular" name="celular" type="tel" class="login__input" value="<?= $cliente->celular ?? '' ?>">
                    </div>
                    <div class="login__group">
                        <input type="submit" class="login__button" value="Sign Up">
                    </div>
                </form>
                <div class="login__hr"></div>
                <div class="login__foot-link">
                    <label for="login__tab-signin" class="login__label login__label--switch">¿Ya tienes una cuenta?</label>
                </div>
            </div>

        </div>
    </div>
</div>

<?php if (isset($_SESSION['registro_exitoso'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Registro exitoso',
            text: 'Tu cuenta ha sido creada correctamente',
            confirmButtonText: 'Iniciar sesión'
        });
    </script>
<?php unset($_SESSION['registro_exitoso']);
endif; ?>


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