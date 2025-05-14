<aside class="dashboardTesorero__sidebar">
    <nav class="dashboardTesorero__menu">

        <a href="/tesorero/dashboard" class="dashboardTesorero__enlace <?php echo pagina_actual('/dashboard') ? 'dashboardTesorero__enlace--actual' : ''; ?> ">
            <i class="fa-solid fa-house"></i>
            <span class="dashboardTesorero__menu-texto">
                Inicio
            </span>
        </a>
        <a href="/tesorero/agua" class="dashboardTesorero__enlace <?php echo pagina_actual('/agua') ? 'dashboardTesorero__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-faucet-drip"></i>
            <span class="dashboardTesorero__menu-texto">
                Agua Potable
            </span>
        </a>
        <a href="/tesorero/solicitudes" class="dashboardTesorero__enlace <?php echo pagina_actual('/solicitudes') ? 'dashboardTesorero__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-file-lines"></i>
            <span class="dashboardTesorero__menu-texto">
                Solicitudes
            </span>
        </a>

    </nav>
</aside>