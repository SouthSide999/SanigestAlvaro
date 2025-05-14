<header class="dashboardTesorero__header">
    <div class="dashboardTesorero__header-grid">
        <a href="/">
            <h2 class="dashboardTesorero__logo">
                &#60;SaniGest /> <?php echo $titulo; ?>
            </h2>
        </a>

        <nav class="dashboardTesorero__nav">
            <form method="POST" action="/logout" class="dashboardTesorero__form">
                <input type="submit" value="Cerrar Sesión" class="dashboardTesorero__submit--logout">
            </form>
        </nav>
    </div>
</header>