<h2><?php echo $titulo; ?></h2>
<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/eventos/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Evento
    </a>
    <a class="dashboard__boton" href="/admin/eventos/buscar">
        <i class="fa-solid fa-magnifying-glass"></i>
        Buscar Evento
    </a>
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
            text: 'El evento ha sido eliminado correctamente.',
            icon: 'success',
            timer: 3000, // La alerta se cierra en 3 segundos
            confirmButtonText: 'OK'
        });
    </script>
<?php
    unset($_SESSION['eliminado']); // Limpiar la sesión para que no se repita
endif;
?>