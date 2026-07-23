<header class="header" role="banner">
    <!-- Partículas de agua animadas (fondo) -->
    <div class="header__particulas" aria-hidden="true">
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span>
    </div>
    
    <!-- Onda decorativa inferior -->
    <div class="header__onda" aria-hidden="true">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path class="header__onda-path" d="M0,60 C360,120 720,0 1080,60 C1260,90 1380,30 1440,60 L1440,120 L0,120 Z"/>
        </svg>
    </div>

    <div class="header__contenedor">
        <!-- Barra superior de utilidad -->
        <div class="header__utilidad" role="complementary" aria-label="Acciones de usuario">
            <?php if (is_auth()): ?>
                <?php
                $dashboardUrls = [
                    'admin'      => '/admin/dashboard',
                    'usuario'    => '/user/dashboard',
                    'tesorero'   => '/tesorero/dashboard',
                    'tecnico'    => '/tecnico/dashboard',
                    'lecturador' => '/lecturador/dashboard',
                ];
                $rol = obtener_rol_usuario();
                $urlDashboard = $dashboardUrls[$rol] ?? '/sin-rol';
                ?>
                <a href="<?= htmlspecialchars($urlDashboard, ENT_QUOTES, 'UTF-8') ?>" class="header__enlace header__enlace--admin">
                    <svg class="header__icono" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Administrar</span>
                </a>

                <form method="POST" action="/logout" class="header__form">
                    <?= csrf_field() ?>
                    <button type="submit" class="header__submit">
                        <svg class="header__icono" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            <?php else: ?>
                <a href="/auth/registro" class="header__enlace">
                    <svg class="header__icono" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    <span>Registro</span>
                </a>
                <a href="/auth/login" class="header__enlace header__enlace--primario">
                    <svg class="header__icono" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    <span>Intranet</span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Contenido principal del hero -->
        <div class="header__hero">
            <div class="header__badge" data-aos="fade-down" data-aos-duration="800">
                <span class="header__badge-punto"></span>
                Municipalidad Distrital de Huaro
            </div>

            <a href="/" class="header__marca" data-aos="zoom-in" data-aos-duration="1000">
                <h1 class="header__logo">
                    <span class="header__logo-bracket">&lt;</span>
                    <span class="header__logo-texto">SaniGest</span>
                    <span class="header__logo-bracket">/&gt;</span>
                </h1>
            </a>

            <p class="header__eslogan" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                Eficiencia y transparencia en la gestión del <span class="header__eslogan--acento">agua</span> y <span class="header__eslogan--acento">saneamiento</span> urbano.
            </p>

            <div class="header__acciones" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                <a href="/auth/registro" class="header__boton header__boton--primario">
                    <span>Crear Cuenta</span>
                    <svg class="header__boton-flecha" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
                <a href="/serviciosenlinea" class="header__boton header__boton--secundario">
                    <span>Ver Servicios</span>
                </a>
            </div>

            <!-- Stats animados -->
            <div class="header__stats" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
                <div class="header__stat">
                    <span class="header__stat-numero" data-contador="15000">0</span>
                    <span class="header__stat-etiqueta">Usuarios Activos</span>
                </div>
                <div class="header__stat-divisor"></div>
                <div class="header__stat">
                    <span class="header__stat-numero" data-contador="98">0</span>
                    <span class="header__stat-etiqueta">% Cobertura</span>
                </div>
                <div class="header__stat-divisor"></div>
                <div class="header__stat">
                    <span class="header__stat-numero" data-contador="24">0</span>
                    <span class="header__stat-etiqueta">/7 Atención</span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Barra de navegación principal (sticky con glassmorphism) -->
<div class="barra" role="navigation" aria-label="Navegación principal">
    <div class="barra__contenido">
        <a href="/" class="barra__marca" aria-label="SaniGest - Inicio">
            <span class="barra__logo" aria-hidden="true">
                <span class="barra__logo-bracket">&lt;</span>SaniGest<span class="barra__logo-bracket">/&gt;</span>
            </span>
        </a>

        <nav class="navegacion" id="menu-principal">
            <?php
            $enlaces = [
                '/nosotros'         => 'Sobre Nosotros',
                '/quehacemos'       => 'Qué Hacemos',
                '/noticias'         => 'Noticias',
                '/serviciosenlinea' => 'Servicios en Línea',
                '/contacto/crear'   => 'Contacto',
                '/necesitas-ayuda'  => 'Ayuda',
                '/loginUser'        => 'Iniciar Sesión',
            ];
            foreach ($enlaces as $url => $texto):
                $esActiva = pagina_actual($url);
                $clase = 'navegacion__enlace' . ($esActiva ? ' navegacion__enlace--actual' : '');
                $ariaCurrent = $esActiva ? ' aria-current="page"' : '';
            ?>
                <a href="<?= $url ?>" class="<?= $clase ?>"<?= $ariaCurrent ?>>
                    <span class="navegacion__texto"><?= $texto ?></span>
                    <span class="navegacion__indicador"></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <button class="navegacion__toggle" aria-expanded="false" aria-controls="menu-principal" aria-label="Abrir menú de navegación">
            <span class="navegacion__icono" aria-hidden="true"></span>
        </button>
    </div>
</div>

<main id="contenido-principal">