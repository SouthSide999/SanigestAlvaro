<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/agua">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__boton" href="/admin/medidores/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Nuevo Medidor
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/medidores" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="criterio" class="formulario__label">Buscar por:</label>
                <select id="criterio" name="criterio" class="formulario__input">
                    <option disabled selected>Selecciona una opción</option>
                    <option value="numero_medidor">Número de Medidor</option>
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
                    placeholder="Número de medidor o ID de contribuyente">
            </div>
        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input type="submit" value="Buscar Medidor" class="dashboard__boton__buscardor">
            <a href="/admin/medidores" class="dashboard__boton__buscardor">Lista Completa</a>
        </div>
    </form>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($medidores)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Codigo Predio y Contribuyente</th>
                    <th scope="col" class="table__th">N° Medidor</th>
                    <th scope="col" class="table__th">Personas</th>
                    <th scope="col" class="table__th">Inquilinos</th>
                    <th scope="col" class="table__th">Observaciones</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($medidores as $medidor) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $medidor->predio->codigo_predio.'-'.$medidor->contribuyente->nombres.' '.
                          $medidor->contribuyente->apellidos
                        ; ?></td>
                        <td class="table__td"><?php echo $medidor->numero_medidor; ?></td>
                        <td class="table__td"><?php echo $medidor->numero_personas; ?></td>
                        <td class="table__td"><?php echo $medidor->inquilinos; ?></td>
                        <td class="table__td"><?php echo $medidor->observaciones; ?></td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/medidores/editar?id=<?php echo $medidor->id; ?>">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>
                            <form method="POST" action="/admin/medidores/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $medidor->id; ?>">
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
        <p class="text-center">No hay medidores registrados aún.</p>
    <?php } ?>
</div>

<?php echo $paginacion ?? ''; ?>

<?php
if (isset($_SESSION['eliminado'])) :
?>
    <script>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'El medidor ha sido eliminado correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php unset($_SESSION['eliminado']);
endif; ?>