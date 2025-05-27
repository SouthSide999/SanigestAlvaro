<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/tesorero/agua">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/tesorero/pagos" enctype="multipart/form-data" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="buscar_por" class="formulario__label">Buscar por:</label>
                <select class="formulario__input" id="criterio" name="criterio">
                    <option disabled selected>Selecciona un opcion</option>
                    <option value="codigo_predio">Código</option>
                    <option value="direccion">Dirección</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="dato" class="formulario__label">Valor a buscar:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="dato"
                    name="dato"
                    placeholder="Ingrese el valor a buscar">
            </div>
        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input
                type="submit"
                value="Buscar"
                class="dashboard__boton__buscardor">
            <a href="/tesorero/pagos" class="dashboard__boton__buscardor">
                Lista Completa
            </a>
        </div>
    </form>
</div>
<div class="dashboard__contenedor">
    <?php if (!empty($predios)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th class="table__th">Código Predio</th>
                    <th class="table__th">Contribuyente</th>
                    <th class="table__th">Dirección</th>
                    <th class="table__th">Zona / Sector</th>
                    <th class="table__th">Acciones</th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($predios as $predio) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $predio->codigo_predio; ?></td>
                        <td class="table__td">
                            <?php echo $predio->contribuyente->apellidos . ', ' . $predio->contribuyente->nombres; ?>
                            <br><small>(<?php echo $predio->contribuyente->codigo_contribuyente; ?>)</small>
                        </td>
                        <td class="table__td"><?php echo $predio->direccion; ?></td>
                        <td class="table__td">
                            Zona ID: <?php echo $predio->zona_id; ?> /
                            Sector ID: <?php echo $predio->sector_id; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/tesorero/pagos/detalle?predio_id=<?php echo $predio->id; ?>">
                                <i class="fa-solid fa-eye"></i> Ver Pagos/Deudas
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay predios registrados con deudas o pagos realizados.</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>