<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/ponentes">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/ponentes/buscar" enctype="multipart/form-data" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Buscar por Nombre: </label>
                <input
                    type="text"
                    class="formulario__input"
                    id="nombre"
                    name="nombre"
                    placeholder="Nombre Ponente">
            </div>
        </fieldset>
        <div class="dashboard__contenedor__boton">
            <input
                type="submit"
                value="Buscar Ponente"
                class="dashboard__boton__buscardor">
        </div>
    </form>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($ponentes)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Ubicación</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($ponentes as $ponente) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $ponente->nombre . " " . $ponente->apellido; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $ponente->ciudad . ", " . $ponente->pais; ?>
                        </td>
                        <td class="table__td--acciones">
                            <!--editar-->
                            <a class="table__accion table__accion--editar" href="/admin/ponentes/editar?id=<?php echo $ponente->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>

                            <!--eliminar-->
                            <form method="POST" action="/admin/ponentes/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $ponente->id; ?>">
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
        <p class="text-center">No Hay Ponentes Aún</p>
    <?php } ?>
</div>