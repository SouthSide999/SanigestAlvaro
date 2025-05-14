<main class="authUser__body">
    <div <?php aos_animacion(); ?> class="authUser">

        <div class="authUser__form authUser__form--registrar">
            <form method="POST" action="/user/registro">
                <h1 class="authUser__titulo">Registro</h1>

                <div class="authUser__input">
                    <input
                        type="text"
                        placeholder="Código Predio"
                        id="codigo_predio"
                        name="codigo_predio"
                        value="<?= s($cliente->codigo_predio) ?>">
                    <i class="authUser__icono bx bxs-id-card"></i>
                </div>

                <div class="authUser__input">
                    <input
                        type="text"
                        placeholder="Nombres"
                        id="nombre"
                        name="nombre"
                        value="<?= s($cliente->nombre) ?>">
                    <i class="authUser__icono bx bxs-user"></i>
                </div>

                <div class="authUser__input">
                    <input
                        type="text"
                        placeholder="Apellido"
                        id="apellido"
                        name="apellido"
                        value="<?= s($cliente->apellido) ?>">
                    <i class="authUser__icono bx bxs-user"></i>
                </div>

                <div class="authUser__input">
                    <input
                        type="email"
                        placeholder="Correo Electrónico"
                        id="email"
                        name="email"
                        value="<?= s($cliente->email) ?>">
                    <i class="authUser__icono bx bxs-envelope"></i>
                </div>

                <div class="authUser__input">
                    <input
                        type="password"
                        placeholder="Tu Password"
                        id="password"
                        name="password">
                    <i class="authUser__icono bx bxs-lock-alt"></i>
                </div>

                <div class="authUser__input">
                    <input
                        type="password"
                        placeholder="Repetir Password"
                        id="password2"
                        name="password2">
                    <i class="authUser__icono bx bxs-lock-alt"></i>
                </div>

                <div class="authUser__input">
                    <input
                        type="text"
                        placeholder="DNI"
                        id="dni"
                        name="dni"
                        value="<?= s($cliente->dni ?? '') ?>">
                    <i class="authUser__icono bx bxs-id-card"></i>
                </div>

                <div class="authUser__input">
                    <input
                        type="tel"
                        placeholder="Celular"
                        id="celular"
                        name="celular"
                        value="<?= s($cliente->celular ?? '') ?>">
                    <i class="authUser__icono bx bxs-phone"></i>
                </div>

                <button type="submit" class="authUser__boton">Registrarse</button>
            </form>
        </div>

    </div>
</main>