<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/nuevaconexion">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="nuevaconexion">
    <form enctype="multipart/form-data" method="POST">
        <div class="nuevaconexion__formulario">
            <?php if ($nueva) { ?>
                <?php
                include_once __DIR__ . '../formulario.php';
                ?>

            <?php } else { ?>
                <p class="text-center">No Hay Informacion De Esta Nueva Conexion</p>
            <?php  } ?>

            <div class="nuevaconexion__contenedor-botones">
                <a id="btnRechazar" class="nuevaconexion__formulario__boton nuevaconexion__formulario__boton--rechazar" href="#">
                    <i class="fa-solid fa-x"></i>
                    Rechazar
                </a>
                <a id="btnAsignar" class="nuevaconexion__formulario__boton nuevaconexion__formulario__boton--asignar" href="#">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Asignar Técnico
                </a>
            </div>

            <!-- Modal de Observaciones -->
            <div id="modalnuevaconexionObservaciones" class="modalnuevaconexion">
                <div class="modalnuevaconexion-contenido">
                    <h3>Observaciones</h3>
                    <textarea id="observaciones" name="observacion_rechazo" placeholder="Escribe las observaciones..." class="formulario__input"><?php echo $nueva->observacion_rechazo; ?></textarea>
                    <input type="hidden" id="estadoRechazo" name="estado_id" value="3">
                    <input type="hidden" name="tecnico_id" value="100">

                    <button id="btnConfirmarRechazo" class="nuevaconexion__formulario__boton">Rechazar</button>
                    <a id="btnCerrarObservaciones" class="nuevaconexion__formulario__boton">Cancelar</a>
                </div>
            </div>

            <!-- Modal de Asignación -->
            <div id="modalnuevaconexionAsignacion" class="modalnuevaconexion">
                <div class="modalnuevaconexion-contenido">
                    <h3>Asignar Técnico</h3>
                    <select id="tecnico" name="tecnico_id">
                        <option value="" disabled selected>Seleccionar Técnico</option>
                        <?php foreach ($tecnico as $t) { ?>
                            <option value="<?php echo $t->id; ?>"><?php echo $t->nombre . " " . $t->apellido;  ?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" id="estadoAsignacion" name="estado_id" value="2">
                    <button id="btnConfirmarAsignacion" class="nuevaconexion__formulario__boton">Asignar</button>
                    <a id="btnCerrarAsignacion" class="nuevaconexion__formulario__boton">Cancelar</a>
                </div>
            </div>
        </div>
    </form>
</div>

