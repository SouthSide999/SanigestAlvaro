<div class="dashboardtecnico__contenedor-boton">
    <a class="dashboardtecnico__boton" href="/tecnico/nuevasconexiones/pendientes">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="nuevaconexion">
    <form enctype="multipart/form-data" method="POST">
        <div class="nuevaconexion__formulario">
            <?php if ($nueva) { ?>
                <?php
                include_once __DIR__ . '/formulario.php';
                ?>

            <?php } else { ?>
                <p class="text-center">No Hay Informacion De Esta Nueva Conexion</p>
            <?php  } ?>

            <div class="nuevaconexion__contenedor-botones">

                <button id="btnConfirmarRechazo" class="nuevaconexion__formulario__boton nuevaconexion__formulario__boton--aceptar">Iniciar</button>


            </div>

        </div>
    </form>
</div>