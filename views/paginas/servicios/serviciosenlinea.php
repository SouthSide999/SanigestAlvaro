<div class="servicios-linea">
    <h2 <?php aos_animacion(); ?> class="servicios-linea__title">Servicios en Línea</h2>

    <div <?php aos_animacion(); ?> class="servicios-linea__grid">
        <a href="/servicios/nuevaconexion" class="servicios-linea__item">
            <h3 class="servicios-linea__item-title">Solicitar una Nueva Conexión de Agua</h3>
            <i class="fa-solid fa-plug servicios-linea__item-icono"></i>
            <p class="servicios-linea__item-description">Inicia tu solicitud de conexión de manera rápida y sencilla.</p>
        </a>

        <a href="/servicios/estado" class="servicios-linea__item">
            <h3 class="servicios-linea__item-title">Consultar Estado de Solicitud</h3>
            <i class="fa-solid fa-magnifying-glass servicios-linea__item-icono"></i>
            <p class="servicios-linea__item-description">Revisa el estado de tu trámite en tiempo real.</p>
        </a>

        <a href="/servicios/solicitud/crear" class="servicios-linea__item">
            <h3 class="servicios-linea__item-title">Solicitudes Generales</h3>
            <i class="fa-solid fa-clipboard-list servicios-linea__item-icono"></i>
            <p class="servicios-linea__item-description">Solicita inspecciones técnicas u otros servicios administrativos no relacionados a conexiones ni reclamos.</p>
        </a>



        <a href="" class="servicios-linea__item">
            <h3 class="servicios-linea__item-title">Consultar Recibos y Facturación</h3>
            <i class="fa-solid fa-file-invoice-dollar servicios-linea__item-icono"></i>
            <p class="servicios-linea__item-description">Accede a tus recibos actuales fácilmente.</p>
        </a>
    </div>


</div>

<?php
if (isset($_GET['codigo'])) :
?>
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Tu solicitud se ha registrado correctamente. Código de Seguimiento es: <?php echo htmlspecialchars($_GET['codigo']); ?>',
            icon: 'success',
            timer: 10000,
            confirmButtonText: 'OK'
        });
    </script>
<?php
endif;
?>