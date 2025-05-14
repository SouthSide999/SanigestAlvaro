<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/ponentes">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/eventos/buscar" enctype="multipart/form-data" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Buscar por Nombre del evento: </label>
                <input
                    type="text"
                    class="formulario__input"
                    id="nombre"
                    name="nombre"
                    placeholder="Nombre del Evento"
                    value="<?php echo $busqueda ?>"
                    
                    >
            </div>
        </fieldset>
        <div class="dashboard__contenedor__boton">
            <input
                type="submit"
                value="Buscar Evento"
                class="dashboard__boton__buscardor">
        </div>
    </form>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($eventos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Evento</th>
                    <th scope="col" class="table__th">Tipo</th>
                    <th scope="col" class="table__th">Dia y Hora</th>
                    <th scope="col" class="table__th">Ponente</th>
                    <th scope="col" class="table__th"></th>

                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($eventos as $evento) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $evento->nombre?>
                        </td>
                        <td class="table__td">
                            <?php echo $evento->categoria->nombre?>
                        </td>
                        <td class="table__td">
                            <?php echo "Dia: ".$evento->dia->nombre." Hora: ".$evento->hora->hora?>
                        </td>
                        <td class="table__td">
                            <?php echo $evento->ponente->nombre." ".$evento->ponente->apellido?>
                        </td>

                        <td class="table__td--acciones">
                            <!--editar-->
                            <a class="table__accion table__accion--editar" href="/admin/eventos/editar?id=<?php echo $evento->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>

                            <!--eliminar-->
                            <form method="POST" action="/admin/eventos/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $evento->id; ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>


                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No Hay Eventos Aún</p>
    <?php } ?>
</div>
