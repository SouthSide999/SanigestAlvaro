<h2><?php echo $titulo; ?></h2>
<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/noticias/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Noticia o Avisos
    </a>
    <a class="dashboard__boton" href="/admin/noticias/buscar">
        <i class="fa-solid fa-magnifying-glass"></i>
        Buscar Noticia o Avisos
    </a>

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
        <p class="text-center">No Hay Eventos Aún</p>
    <?php } ?>
</div>

<?php
echo $paginacion;
?>

<?php
session_start();
if (isset($_SESSION['eliminado'])) :
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'La Noticia ha sido eliminado correctamente.',
            icon: 'success',
            timer: 3000, // La alerta se cierra en 3 segundos
            confirmButtonText: 'OK'
        });
    </script>
<?php
    unset($_SESSION['eliminado']); // Limpiar la sesión para que no se repita
endif;
?>