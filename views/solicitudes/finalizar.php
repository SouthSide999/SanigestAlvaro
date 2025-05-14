<div class="dashboard__contenedor-boton">
    <?php if ($usuariorol === '2') { ?>
        <a class="dashboard__boton" href="/admin/solicitudes">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
    <?php } elseif ($usuariorol === '3') { ?>
        <a class="dashboard__boton" href="/tesorero/solicitudes">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
    <?php } elseif ($usuariorol === '4') { ?>
        <a class="dashboard__boton" href="/tecnico/solicitudes">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
    <?php } elseif ($usuariorol === '5') { ?>
        <a class="dashboard__boton" href="/lecturador/solicitudes">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
    <?php } ?>
</div>
<div class="nuevaconexion">
    <form enctype="multipart/form-data" method="POST">
        <div class="nuevaconexion__formulario">
            <?php if ($solicitud) { ?>
                <?php
                include_once __DIR__ . '../formulario.php';
                ?>

            <?php } else { ?>
                <p class="text-center">No Hay Información De Esta Solicitud</p>
            <?php  } ?>
            <div class="nuevaconexion__contenedor-botones">
                <a id="btnRechazar" class="nuevaconexion__formulario__boton nuevaconexion__formulario__boton--rechazar" href="#">
                    <i class="fa-solid fa-x"></i>
                    Rechazar
                </a>
                <input type="hidden" id="estadoSolicitud" name="estado_id" value="">
                <input type="submit" class="nuevaconexion__formulario__boton nuevaconexion__formulario__boton--aceptar" value="Finalizar">
            </div>

            <!-- Modal de Observaciones -->
            <div id="modalnuevaconexionObservaciones" class="modalnuevaconexion">
                <div class="modalnuevaconexion-contenido">
                    <h3>Observaciones</h3>
                    <textarea id="observaciones" name="observaciones" placeholder="Escribe las observaciones..." class="formulario__input"><?php echo $solicitud->observaciones; ?></textarea>
                    <button id="btnConfirmarRechazo" class="nuevaconexion__formulario__boton">Confirmar</button>
                    <a id="btnCerrarObservaciones" class="nuevaconexion__formulario__boton">Cancelar</a>
                </div>
            </div>
        </div>
    </form>
</div>