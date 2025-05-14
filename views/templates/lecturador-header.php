<header class="dashboardlecturador__header">
    <div class="dashboardlecturador__header-grid">
        <a href="/">
            <h2 class="dashboardlecturador__logo">
                &#60;SaniGest /> <?php echo $titulo; ?>
            </h2>
        </a>

        <nav class="dashboardlecturador__nav">
            <form method="POST" action="/logout" class="dashboardlecturador__form">
                <input type="submit" value="Cerrar Sesión" class="dashboardlecturador__submit--logout">
            </form>
        </nav>
    </div>
</header>
