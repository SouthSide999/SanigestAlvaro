<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/agua">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/resumen" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="criterio" class="formulario__label">Buscar por:</label>
                <select id="criterio" name="criterio" class="formulario__input">
                    <option disabled selected>Selecciona una opción</option>
                    <option value="nombres">Nombre Contribuyente</option>
                    <option value="apellidos">Apellido Contribuyente</option>
                    <option value="direccion">Dirección Predio</option>
                    <option value="codigo_predio">Código Predio</option>
                    <option value="codigo_contribuyente">Código Contribuyente</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="dato" class="formulario__label">Valor de búsqueda:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="dato"
                    name="dato"
                    placeholder="Nombre, Apellido, Dirección o Código">
            </div>
        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input type="submit" value="Buscar" class="dashboard__boton__buscardor">
            <a href="/admin/resumen" class="dashboard__boton__buscardor">Lista Completa</a>
        </div>
    </form>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($registros)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Código-Dirección Predio</th>
                    <th scope="col" class="table__th">Código-Nombre Contribuyente</th>
                    <th scope="col" class="table__th">Acciones</th>

                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($registros as $registro) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $registro->codigo_predio . ' ' . $registro->direccion; ?></td>
                        <td class="table__td"><?php echo $registro->contribuyente->codigo_contribuyente . '-' . $registro->contribuyente->nombres . ' ' . $registro->contribuyente->apellidos; ?></td>
                        <td class="table__td--acciones">
                            <!-- Detalle -->
                            <a class="table__accion table__accion--editar" href="/admin/resumen/detalle?id=<?php echo $registro->id; ?>">
                                <i class="fa-solid fa-eye"></i>
                                Ver
                            </a>
                        </td>


                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay registros que coincidan con tu búsqueda o No hay registros todavia.</p>
    <?php } ?>
</div>

<?php echo $paginacion ?? ''; ?>