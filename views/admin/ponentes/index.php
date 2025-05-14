<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/ponentes/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir ponente
    </a>
    <a class="dashboard__boton" href="/admin/ponentes/buscar">
        <i class="fa-solid fa-magnifying-glass"></i>
        Buscar ponente
    </a>
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
            text: 'El ponente ha sido eliminado correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php
    unset($_SESSION['eliminado']); // Limpiar la sesión para que no se repita
endif;
?>