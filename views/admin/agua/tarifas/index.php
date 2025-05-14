<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/agua">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__boton" href="/admin/tarifas/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Nueva Tarifa
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/tarifas" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="criterio" class="formulario__label">Buscar por:</label>
                <select id="criterio" name="criterio" class="formulario__input">
                    <option disabled selected>Selecciona una opción</option>
                    <option value="codigo_tarifa">Código</option>
                    <option value="nombre_tarifa">Nombre</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="dato" class="formulario__label">Valor de búsqueda:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="dato"
                    name="dato"
                    placeholder="Código o nombre de la tarifa">
            </div>
        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input type="submit" value="Buscar Tarifa" class="dashboard__boton__buscardor">
            <a href="/admin/tarifas" class="dashboard__boton__buscardor">Lista Completa</a>
        </div>
    </form>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($tarifas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Código</th>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Valor (S/.)</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($tarifas as $tarifa) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $tarifa->codigo_tarifa; ?></td>
                        <td class="table__td"><?php echo $tarifa->nombre_tarifa; ?></td>
                        <td class="table__td">S/ <?php echo number_format($tarifa->valor_tarifa, 2); ?></td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/tarifas/editar?id=<?php echo $tarifa->id; ?>">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>
                            <form method="POST" action="/admin/tarifas/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $tarifa->id; ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay tarifas registradas aún.</p>
    <?php } ?>
</div>

<?php echo $paginacion ?? ''; ?>

<?php
if (isset($_SESSION['eliminado'])) :
?>
    <script>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'La tarifa ha sido eliminada correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php unset($_SESSION['eliminado']); endif; ?>

