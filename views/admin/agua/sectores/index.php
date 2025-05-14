<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/agua">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__boton" href="/admin/sectores/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Nuevo Sector
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/sectores" enctype="multipart/form-data" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="nombre_sector" class="formulario__label">Buscar Sector:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="nombre_sector"
                    name="nombre_sector"
                    placeholder="Ingrese el nombre del sector">
            </div>
        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input
                type="submit"
                value="Buscar Sector"
                class="dashboard__boton__buscardor">
            <a href="/admin/sectores" class="dashboard__boton__buscardor">
                Lista Completa
            </a>
        </div>
    </form>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($sectores)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Código</th>
                    <th scope="col" class="table__th">Nombre de Sector</th>
                    <th scope="col" class="table__th">Zona</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($sectores as $sector) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $sector->codigo_sector; ?></td>
                        <td class="table__td"><?php echo $sector->nombre_sector; ?></td>
                        <td class="table__td"><?php echo $sector->zona->codigo_zona .'-'.$sector->zona->nombre_zona; ?></td>


                        <td class="table__td--acciones">
                            <!-- Editar -->
                            <a class="table__accion table__accion--editar" href="/admin/sectores/editar?id=<?php echo $sector->id; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Editar
                            </a>

                            <!-- Eliminar -->
                            <form method="POST" action="/admin/sectores/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $sector->id; ?>">
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
        <p class="text-center">No hay sectores registrados aún.</p>
    <?php } ?>
</div>

<?php echo $paginacion ?? ''; ?>

<?php
if (isset($_SESSION['eliminado'])) :
?>
    <script>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'El Sector ha sido eliminada correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php unset($_SESSION['eliminado']); endif; ?>


