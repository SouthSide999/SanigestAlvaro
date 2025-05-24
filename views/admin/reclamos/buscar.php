<h2><?php echo $titulo; ?></h2>
<div class="dashboard__contenedor-boton">

    <a class="dashboard__boton" href="/admin/reclamos">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>

</div>

<div class="dashboardUser__gridCreate">

    <div>
        <div class="dashboardUser__contenedor">
            <h2>Reclamos del Usuario: <?php echo  $reclamoDetalle->usuario->nombre . " " . $reclamoDetalle->usuario->apellido ?></h2>
            <?php if (!empty($reclamos)) { ?>
                <table class="table">
                    <thead class="table__thead">
                        <tr>
                            <th scope="col" class="table__th">Fecha De Ingreso: </th>
                            <th scope="col" class="table__th">Usuario: </th>
                            <th scope="col" class="table__th">Tipo de Reclamo: </th>
                            <th scope="col" class="table__th">Estado: </th>
                            <th scope="col" class="table__th">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table__tbody">
                        <?php foreach ($reclamos as $reclamo) { ?>
                            <tr class="table__tr">
                                <td class="table__td">
                                    <?php echo $reclamo->fecha ?>
                                </td>
                                <td class="table__td">
                                    <?php echo $reclamo->usuario->nombre . " " . $reclamo->usuario->apellido ?>
                                </td>
                                <td class="table__td">
                                    <?php echo $reclamo->tipo->nombre ?>
                                </td>
                                <td class="table__td">
                                    <?php if ($reclamo->estado_id === '1') { ?>
                                        <form method="POST" action="/admin/reclamos/editarB" class="table__formulario">
                                            <input type="hidden" name="id" value="<?php echo $reclamo->id ?>">
                                            <input type="hidden" name="estado_id" value="5">
                                            <button class="table__pendiente" type="submit">Pendiente</button>
                                        </form>
                                    <?php } elseif ($reclamo->estado_id === '5') { ?>
                                        <form method="POST" action="/admin/reclamos/editarB" class="table__formulario">
                                            <input type="hidden" name="id" value="<?php echo $reclamo->id ?>">
                                            <input type="hidden" name="estado_id" value="1">
                                            <button class="table__completa">Completa</button>
                                        </form>
                                    <?php } ?>
                                </td>
                                <td class="table__td--acciones">
                                    <!-- Enlace corregido para incluir `id` y `page` -->
                                    <a class="table__accion table__accion--editar"
                                        href="/admin/reclamos/buscar?id=<?php echo $reclamo->id ?>">
                                        <i class="fa-solid fa-file"></i> Ver Detalle Completo
                                    </a>
                                    <!-- Eliminar -->
                                    <form method="POST" action="/admin/reclamos/eliminarB" class="table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $reclamo->id ?>">
                                        <button class="table__accion table__accion--eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="text-center">No Hay Reclamos Aún</p>
            <?php } ?>
        </div>
    </div>




    <div class="dashboardUser__formulario">
        <?php if ($reclamoDetalle) { ?>
            <fieldset class="formulario__fieldset">
                <legend class="formulario__legend">Estado Del Reclamo:</legend>
                <span>(Haz Click para cambiar el estado del reclamo)</span>
                <?php if ($reclamoDetalle->estado_id === '1') { ?>

                    <form method="POST" action="/admin/reclamos/editarB" class="table__formulario">
                        <input type="hidden" name="id" value="<?php echo $reclamoDetalle->id; ?>">
                        <input type="hidden" name="estado_id" value="5">
                        <button class="table__pendiente" type="submit">
                            Pendiente
                        </button>
                    </form>
                <?php } elseif ($reclamoDetalle->estado_id === '5') { ?>
                    <form method="POST" action="/admin/reclamos/editarB" class="table__formulario">
                        <input type="hidden" name="id" value="<?php echo $reclamoDetalle->id; ?>">
                        <input type="hidden" name="estado_id" value="1">
                        <button class="table__completa">
                            Completa
                        </button>
                    </form>
                <?php   } ?>
            </fieldset>
            <fieldset class="formulario__fieldset">

                <legend class="formulario__legend">Cliente Que Realizo El Reclamo:</legend>

                <div class="formulario__campo">
                    <label for="nombre" class="formulario__label">Nombre Completo</label>
                    <input
                        type="text"
                        class="formulario__input"
                        value="<?php echo  $reclamoDetalle->usuario->nombre . " " . $reclamoDetalle->usuario->apellido ?>">
                </div>

                <div class="formulario__campo">
                    <label for="nombre" class="formulario__label">Numero De Telefono</label>
                    <input
                        type="text"
                        class="formulario__input"
                        value="<?php echo  $reclamoDetalle->numero ?>">
                </div>


                <div class="formulario__campo">
                    <label for="nombre" class="formulario__label">Correo Electronico</label>
                    <input
                        type="text"
                        class="formulario__input"
                        value="<?php echo  $reclamoDetalle->usuario->email ?>">
                </div>
            </fieldset>
            <fieldset class="formulario__fieldset">
                <legend class="formulario__legend">Detalle Del Reclamo Realizado:</legend>

                <div class="formulario__campo">
                    <label for="Fecha" class="formulario__label">Fecha y Hora de Ingreso:</label>
                    <input
                        class="formulario__input"
                        value="<?php echo $reclamoDetalle->fecha; ?>">
                </div>
                <div class="formulario__campo">
                    <label for="nombre" class="formulario__label">Tipo Del Reclamo</label>
                    <input
                        type="text"
                        class="formulario__input"
                        value="<?php echo  $reclamoDetalle->tipo->nombre ?>">
                </div>

                <div class="formulario__campo">
                    <label for="descripcion" class="formulario__label">Descripción del Reclamo</label>
                    <textarea
                        class="formulario__input"
                        id="descripcion"
                        name="descripcion"
                        rows="5"><?php echo $reclamoDetalle->descripcion; ?></textarea>
                </div>


                <?php if (!empty($reclamoDetalle->evidencia)) {
                    $imagenes = json_decode($reclamoDetalle->evidencia);
                ?>
                    <p class="formulario__texto">Imágenes de Evidencia:</p>

                    <div class="formulario__imagenes">
                        <?php foreach ($imagenes as $index => $imagen) { ?>
                            <img class="imagen-evidencia"
                                src="<?php echo $_ENV['HOST'] . '/img/evidencias/' . $imagen; ?>.png"
                                alt="Evidencia <?php echo $index + 1; ?>"
                                data-index="<?php echo $index; ?>">
                        <?php } ?>
                    </div>

                    <!-- Modal para mostrar imágenes en grande -->
                    <div id="modalEvidencia" class="modal">
                        <span class="close">&times;</span>
                        <img id="modalImg" alt="Imagen de Evidencia">
                        <a id="descargarImg" class="descargar-btn" download>Descargar Imagen</a>
                    </div>

                <?php } else { ?>
                    <p class="text-center">No seleccionó ninguna evidencia aún.</p>
                <?php } ?>


            </fieldset>

        <?php } else { ?>
            <p class="text-center">No Selecciono Ningun Reclamos Aún</p>
        <?php  } ?>
    </div>
</div>