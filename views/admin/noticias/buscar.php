<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/noticias">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/noticias/buscar" enctype="multipart/form-data" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Buscar por Nombre: </label>
                <input
                    type="text"
                    class="formulario__input"
                    id="nombre"
                    name="nombre"
                    placeholder="Nombre de la Noticia">
            </div>
        </fieldset>
        <div class="dashboard__contenedor__boton">
            <input
                type="submit"
                value="Buscar Noticias"
                class="dashboard__boton__buscardor">
        </div>
    </form>
</div>
<div class="dashboard__contenedor">
    <?php if (!empty($noticias)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Contenido</th>
                    <th scope="col" class="table__th">Acciones</th>

                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($noticias as $noticia) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $noticia->nombre ?>
                        </td>
                        <td class="table__td">
                            <h4 class="noticia__introduccion"><?php echo $noticia->contenido ?></h4>
                        </td>

                        <td class="table__td--acciones">
                            <!--editar-->
                            <a class="table__accion table__accion--editar" href="/admin/noticias/editar?id=<?php echo $noticia->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>

                            <!--eliminar-->
                            <form method="POST" action="/admin/noticias/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $noticia->id; ?>">
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
        <p class="text-center">No Hay Noticias Aún</p>
    <?php } ?>
</div>
