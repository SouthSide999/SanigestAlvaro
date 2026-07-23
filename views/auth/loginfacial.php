<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Inicia sesión mediante reconocimiento facial</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <div class="formulario">

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input
                type="email"
                class="formulario__input"
                placeholder="Tu Email"
                id="email"
                name="email">
        </div>

        <div style="margin-top:20px;">
            <video id="video" width="400" autoplay></video>
        </div>

        <button type="button"
                class="formulario__submit"
                id="btnFacial">
            Validar Rostro
        </button>

    </div>

    <div class="acciones">
        <a href="/auth/login" class="acciones__enlace">
            Iniciar Sesión Mediante Usuario y Contraseña
        </a>
    </div>
</main>

