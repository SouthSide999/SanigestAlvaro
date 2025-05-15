<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/solicitudes">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="nuevaconexion">
    <form enctype="multipart/form-data" method="POST">
        <div class="nuevaconexion__formulario">
            <?php if ($solicitud) { ?>
                <?php
                include_once __DIR__ . '/formulario.php';
                ?>

            <?php } else { ?>
                <p class="text-center">No Hay Información De Esta Solicitud</p>
            <?php  } ?>

            <div class="nuevaconexion__contenedor-botones">
                <a id="btnRechazar" class="nuevaconexion__formulario__boton nuevaconexion__formulario__boton--rechazar" href="#">
                    <i class="fa-solid fa-x"></i>
                    Rechazar
                </a>
                <a id="btnAsignar" class="nuevaconexion__formulario__boton nuevaconexion__formulario__boton--asignar" href="#">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Asignar Al Personal
                </a>
            </div>

            <!-- Modal de Observaciones -->
            <div id="modalnuevaconexionObservaciones" class="modalnuevaconexion">
                <div class="modalnuevaconexion-contenido">
                    <h3>Observaciones</h3>
                    <textarea id="observaciones" name="observaciones" placeholder="Escribe las observaciones..." class="formulario__input"><?php echo $solicitud->observaciones; ?></textarea>
                    <button id="btnConfirmarRechazo" class="nuevaconexion__formulario__boton">Rechazar</button>
                    <a id="btnCerrarObservaciones" class="nuevaconexion__formulario__boton">Cancelar</a>
                </div>
            </div>

            <!-- Modal de Asignación -->
            <div id="modalnuevaconexionAsignacion" class="modalnuevaconexion">
                <div class="modalnuevaconexion-contenido">
                    <h3>Asignar Personal</h3>
                    <select id="personal_asignado" name="personal_asignado">
                        <option value="" disabled selected>Seleccionar Personal</option>
                        <?php foreach ($personal as $personal) { ?>
                            <option value="<?php echo $personal->id; ?>"><?php echo $personal->nombre . " " . $personal->apellido.'/'.$personal->rol_id->nombre;  ?></option>
                        <?php } ?>
                    </select>
                    <button id="btnConfirmarAsignacion" class="nuevaconexion__formulario__boton">Asignar</button>
                    <a id="btnCerrarAsignacion" class="nuevaconexion__formulario__boton">Cancelar</a>
                </div>
            </div>
        </div>
    </form>
</div>