<header class="dashboardtecnico__header">
    <div class="dashboardtecnico__header-grid">
        <a href="/">
            <h2 class="dashboardtecnico__logo">
                &#60;SaniGest /> <?php echo $titulo; ?>
            </h2>
        </a>

        <nav class="dashboardtecnico__nav">
            <form method="POST" action="/logout" class="dashboardtecnico__form">
                <input type="submit" value="Cerrar Sesión" class="dashboardtecnico__submit--logout">
            </form>
        </nav>
    </div>
</header>