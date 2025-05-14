<h2><?php echo $titulo; ?></h2>
<div class="dashboard__contenedor-boton">

    <a class="dashboard__boton" href="/admin/contacto/buscar">
        <i class="fa-solid fa-magnifying-glass"></i>
        Buscar
    </a>
    <a class="dashboard__boton" href="/admin/contacto/atendido">
        <i class="fa-solid fa-check"></i>
        Atendidas
    </a>
    <a class="dashboard__boton" href="/admin/contacto">
        <i class="fa-solid fa-circle-arrow-left"></i>

        Volver
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($contactos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Numero de Telefono</th>
                    <th scope="col" class="table__th">Asunto</th>
                    <th scope="col" class="table__th">Mensaje</th>
                    <th scope="col" class="table__th">Estado (Cambia El Estado Haciendo Doble-Click)</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($contactos as $contacto) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $contacto->nombre ?>
                        </td>
                        <td class="table__td">
                            <?php echo $contacto->numero ?>
                        </td>
                        <td class="table__td">
                            <?php echo $contacto->asunto ?>
                        </td>
                        <td class="table__td">
                            <?php echo $contacto->mensaje ?>
                        </td>
                        <td class="table__td">
                            <?php if ($contacto->estado === '0') { ?>

                                <form method="POST" action="/admin/contacto/editar" class="table__formulario">
                                    <input type="hidden" name="id" value="<?php echo $contacto->id; ?>">
                                    <input type="hidden" name="estado" value="1">
                                    <button class="table__pendiente" type="submit">
                                        Pendiente
                                    </button>
                                </form>
                            <?php } elseif ($contacto->estado === '1') { ?>
                                <form method="POST" action="/admin/contacto/editar" class="table__formulario">
                                    <input type="hidden" name="id" value="<?php echo $contacto->id; ?>">
                                    <input type="hidden" name="estado" value="0">
                                    <button class="table__completa">
                                        Completa
                                    </button>
                                </form>
                            <?php   } ?>


                        <td class="table__td--acciones">
                            <!--eliminar-->
                            <form method="POST" action="/admin/contacto/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $contacto->id; ?>">
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
        <p class="text-center">No Hay Contactos Todavia</p>
    <?php } ?>
</div>

<?php
echo $paginacion;
?>


