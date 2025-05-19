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
                <a id="btnRechazar" class="nuevaconexion__formulario__boton nuevaconexion__formulario__boton--rechazar" href="#">
                    <i class="fa-solid fa-x"></i>
                    Rechazar
                </a>
                <button id="btnConfirmarRechazo" class="nuevaconexion__formulario__boton nuevaconexion__formulario__boton--aceptar">Finalizar</button>
            </div>

            <!-- Modal de Observaciones -->
            <div id="modalnuevaconexionObservaciones" class="modalnuevaconexion">
                <div class="modalnuevaconexion-contenido">
                    <h3>Observaciones</h3>
                    <textarea id="observaciones" name="observacion_rechazo" placeholder="Escribe las observaciones..." class="formulario__input"><?php echo $nueva->observacion_rechazo; ?></textarea>
                    <button id="btnConfirmarRechazo" class="nuevaconexion__formulario__boton">Confirmar</button>
                    <a id="btnCerrarObservaciones" class="nuevaconexion__formulario__boton">Cancelar</a>
                </div>
            </div>
        </div>
    </form>
</div>