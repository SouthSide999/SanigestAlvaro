<main class="auth__4">


    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Recupera tu acceso a SaniGest</p> 

    <?php
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <form method="POST" action="/auth/olvide" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input
                type="email"
                class="formulario__input"
                placeholder="Tu Email"
                id="email"
                name="email"
            >
        </div>

        <input type="submit" class="formulario__submit" value="Enviar Instrucciones">
    </form>

    <div class="acciones">
        <a href="/auth/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar Sesión</a>
        <a href="/auth/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Obtener una</a>
    </div>

</main>