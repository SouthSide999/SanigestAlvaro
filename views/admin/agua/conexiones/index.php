<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/agua">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__boton" href="/admin/conexiones/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Nueva Conexión
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/conexiones" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="criterio" class="formulario__label">Buscar por:</label>
                <select id="criterio" name="criterio" class="formulario__input">
                    <option disabled selected>Selecciona una opción</option>
                    <option value="predio_id">ID Predio</option>
                    <option value="contribuyente_id">ID Contribuyente</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="dato" class="formulario__label">Valor de búsqueda:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="dato"
                    name="dato"
                    placeholder="ID de Predio o ID de Contribuyente">
            </div>
        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input type="submit" value="Buscar Conexión" class="dashboard__boton__buscardor">
            <a href="/admin/conexiones" class="dashboard__boton__buscardor">Lista Completa</a>
        </div>
    </form>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($conexiones)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Código Predio y Contribuyente</th>
                    <th scope="col" class="table__th">Número de Conexiones</th>
                    <th scope="col" class="table__th">Operativas</th>
                    <th scope="col" class="table__th">No Operativas</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($conexiones as $conexion) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $conexion->predio->codigo_predio . '-' . $conexion->contribuyente->nombres . ' ' .
                                                    $conexion->contribuyente->apellidos; ?></td>
                        <td class="table__td"><?php echo $conexion->numero_conexiones; ?></td>
                        <td class="table__td"><?php echo $conexion->operativos; ?></td>
                        <td class="table__td"><?php echo $conexion->no_operativos; ?></td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/conexiones/editar?id=<?php echo $conexion->id; ?>">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>
                            <form method="POST" action="/admin/conexiones/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $conexion->id; ?>">
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
        <p class="text-center">No hay conexiones registradas aún.</p>
    <?php } ?>
</div>

<?php echo $paginacion ?? ''; ?>

<?php
if (isset($_SESSION['eliminado'])) :
?>
    <script>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'La conexión ha sido eliminada correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php unset($_SESSION['eliminado']);
endif; ?>