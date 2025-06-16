<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if (is_auth()) { ?>
                <a href="<?php
                            if (is_admin()) {
                                echo '/admin/dashboard';
                            } elseif (is_usuario()) {
                                echo '/user/dashboard';
                            } elseif (is_tesorero()) {
                                echo '/tesorero/dashboard';
                            } elseif (is_tecnico()) {
                                echo '/tecnico/dashboard';
                            } elseif (is_lecturador()) {
                                echo '/lecturador/dashboard';
                            } else {
                                echo '/sin-rol';
                            }
                            ?>" class="header__enlace">Administrar</a>

                <form method="POST" action="/logout" class="header__form">
                    <input type="submit" value="Cerrar Sesión" class="header__submit">
                </form>
            <?php } else { ?>

                <a href="/auth/registro" class="header__enlace">Registro</a>
                <a href="/auth/login" class="header__enlace">Intranet</a>

            <?php } ?>
        </nav>
        <div class="header__contenido">
            <a href="/">
                <h1 <?php aos_animacion(); ?> class="header__logo">
                    &#60;SaniGest />
                </h1>
            </a>

            <p <?php aos_animacion(); ?> class="header__texto">Eficiencia y transparencia en la gestión del agua y saneamiento urbano.</p>
            <p <?php aos_animacion(); ?> class="header__texto header__texto--modalidad">Municipalidad Distrital de Huaro</p>

            <a <?php aos_animacion(); ?> href="/loginUser" class="header__boton">Crea tu Cuenta</a>
        </div>
    </div>
</header>
<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">

                &#60;SaniGest />
            </h2>
        </a>
        <nav class="navegacion">
            <a href="/nosotros" class="navegacion__enlace <?php echo pagina_actual('/nosotros') ? 'navegacion__enlace--actual' : '' ?>">Sobre Nosotros</a>
            <a href="/quehacemos" class="navegacion__enlace <?php echo pagina_actual('/quehacemos') ? 'navegacion__enlace--actual' : '' ?>">Que Hacemos</a>
            <a href="/noticias" class="navegacion__enlace <?php echo pagina_actual('/noticias') ? 'navegacion__enlace--actual' : '' ?>">Noticias</a>
            <a href="/serviciosenlinea" class="navegacion__enlace <?php echo pagina_actual('/serviciosenlinea') ? 'navegacion__enlace--actual' : '' ?>">Servicios en Linea</a>
            <a href="/contacto/crear" class="navegacion__enlace <?php echo pagina_actual('/contacto') ? 'navegacion__enlace--actual' : '' ?>">Contacto</a>
            <a href="/necesitas-ayuda" class="navegacion__enlace <?php echo pagina_actual('/ayuda') ? 'navegacion__enlace--actual' : '' ?>">Ayuda</a>
            <a href="/loginUser" class="navegacion__enlace <?php echo pagina_actual('/loginUser') ? 'navegacion__enlace--actual' : '' ?>">Iniciar Sesión</a>





            <!-- <a href="/paquetes" class="navegacion__enlace <?php echo pagina_actual('/paquetes') ? 'navegacion__enlace--actual' : '' ?>">Paquetes</a>
            <a href="/workshops-conferencias" class="navegacion__enlace <?php echo pagina_actual('/workshops-conferencias') ? 'navegacion__enlace--actual' : '' ?>">Workshops / Conferencias</a>
            <a href="/registro" class="navegacion__enlace <?php echo pagina_actual('/registro') ? 'navegacion__enlace--actual' : '' ?>">Comprar Pase</a> -->
        </nav>
    </div>
</div>