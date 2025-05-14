<h2><?php echo $titulo; ?></h2>

<div class="dashboardUser__gridCreate">
    <div>
        <form class="dashboard__formulario__buscardor" action="/admin/reclamos/buscar" enctype="multipart/form-data" method="POST">
            <fieldset class="formulario__fieldset">
                <div class="formulario__campo">
                    <label for="nombre" class="formulario__label">Buscar El Reclamo Por El Nombre de la Persona: </label>
                    <input
                        type="text"
                        class="formulario__input"
                        id="nombre"
                        name="nombre"
                        placeholder="Nombre">
                </div>
            </fieldset>
            <div class="dashboard__contenedor__boton">
                <input
                    type="submit"
                    value="Buscar"
                    class="dashboard__boton__buscardor">
            </div>
        </form>
        <h2>Todos Los Reclamos: </h2>
        <div class="dashboardUser__contenedor">
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
                                    <?= htmlspecialchars($reclamo->fecha) ?>
                                </td>
                                <td class="table__td">
                                    <?= htmlspecialchars($reclamo->usuario->nombre . " " . $reclamo->usuario->apellido) ?>
                                </td>
                                <td class="table__td">
                                    <?= htmlspecialchars($reclamo->tipo->nombre) ?>
                                </td>
                                <td class="table__td">
                                    <?php if ($reclamo->estado === '0') { ?>
                                        <form method="POST" action="/admin/reclamos/editar" class="table__formulario">
                                            <input type="hidden" name="id" value="<?= $reclamo->id ?>">
                                            <input type="hidden" name="estado" value="1">
                                            <button class="table__pendiente" type="submit">Pendiente</button>
                                        </form>
                                    <?php } elseif ($reclamo->estado === '1') { ?>
                                        <form method="POST" action="/admin/reclamos/editar" class="table__formulario">
                                            <input type="hidden" name="id" value="<?= $reclamo->id ?>">
                                            <input type="hidden" name="estado" value="0">
                                            <button class="table__completa">Completa</button>
                                        </form>
                                    <?php } ?>
                                </td>
                                <td class="table__td--acciones">
                                    <!-- Enlace corregido para incluir `id` y `page` -->
                                    <a class="table__accion table__accion--editar"
                                        href="/admin/reclamos?<?= http_build_query(array_merge($_GET, ['id' => $reclamo->id])) ?>">
                                        <i class="fa-solid fa-file"></i> Ver Detalle Completo
                                    </a>
                                    <!-- Eliminar -->
                                    <form method="POST" action="/user/reclamos/eliminar" class="table__formulario">
                                        <input type="hidden" name="id" value="<?= $reclamo->id ?>">
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
            <?= $paginacion ?>
        </div>
    </div>




    <div class="dashboardUser__formulario">
        <?php if ($reclamoDetalle) { ?>
            <fieldset class="formulario__fieldset">
                <legend class="formulario__legend">Estado Del Reclamo:</legend>
                <span>(Haz Click para cambiar el estado del reclamo)</span>
                <?php if ($reclamoDetalle->estado === '0') { ?>
                    <form method="POST" action="/admin/reclamos/editar" class="table__formulario">
                        <input type="hidden" name="id" value="<?php echo $reclamoDetalle->id ?>">
                        <input type="hidden" name="estado" value="1">
                        <button class="table__pendiente" type="submit">Pendiente</button>
                    </form>
                <?php } elseif ($reclamoDetalle->estado === '1') { ?>
                    <form method="POST" action="/admin/reclamos/editar" class="table__formulario">
                        <input type="hidden" name="id" value="<?php echo $reclamoDetalle->id ?>">
                        <input type="hidden" name="estado" value="0">
                        <button class="table__completa">Completa</button>
                    </form>
                <?php } ?>
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