<header class="dashboardUser__header">
    <div class="dashboardUser__header-grid">
        <a href="/">
            <h2 class="dashboardUser__logo">
                &#60;SaniGest /> <?php echo $titulo; ?>
            </h2>
        </a>

        <nav class="dashboardUser__nav">
            <form method="POST" action="/logoutUser" class="dashboardUser__form">
                <input type="submit" value="Cerrar Sesión" class="dashboardUser__submit--logout">
            </form>
        </nav>
    </div>
</header>