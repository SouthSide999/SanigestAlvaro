<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/lecturador/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__boton" href="/lecturador/lectura/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Nuevo Consumo
    </a>
    <a class="dashboard__boton" href="/lecturador/lectura/generar">
        <i class="fa-solid fa-circle-plus"></i>
        Generar Multiples Consumos
    </a>
</div>
<?php
$mesActual = date('n');
$anioActual = date('Y');
?>
<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/lecturador/lectura" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="mes" class="formulario__label">Mes:</label>
                <select class="formulario__input" id="mes" name="mes">
                    <option value="">-- Todos --</option>
                    <?php
                    $meses = [
                        1 => 'Enero',
                        2 => 'Febrero',
                        3 => 'Marzo',
                        4 => 'Abril',
                        5 => 'Mayo',
                        6 => 'Junio',
                        7 => 'Julio',
                        8 => 'Agosto',
                        9 => 'Septiembre',
                        10 => 'Octubre',
                        11 => 'Noviembre',
                        12 => 'Diciembre'
                    ];
                    foreach ($meses as $num => $nombre) {
                        $selected = ($num == $mesActual) ? 'selected' : '';
                        echo "<option value=\"$num\" $selected>$nombre</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="anio" class="formulario__label">Año:</label>
                <input type="number" class="formulario__input" id="anio" name="anio" min="2000" max="2099" value="<?php echo $anioActual; ?>" placeholder="Ej: 2025">
            </div>
        </fieldset>


        <div class="dashboard__contenedor__boton">
            <input
                type="submit"
                value="Buscar"
                class="dashboard__boton__buscardor">
            <a href="/lecturador/lectura" class="dashboard__boton__buscardor">
                Lista Completa
            </a>
        </div>
    </form>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($consumos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th class="table__th">Código Predio</th>
                    <th class="table__th">Mes</th>
                    <th class="table__th">Año</th>
                    <th class="table__th">Inicio</th>
                    <th class="table__th">Fin</th>
                    <th class="table__th">Tarifa</th>
                    <th class="table__th">Consumo (m³)</th>
                    <th class="table__th">Monto Total (S/)</th>
                    <th class="table__th">Estado</th>
                    <th class="table__th">Acciones</th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($consumos as $consumo) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $consumo->predio->codigo_predio ?? 'N/D'; ?></td>
                        <td class="table__td"><?php echo $meses[(int)$consumo->mes]; ?></td>
                        <td class="table__td"><?php echo $consumo->anio; ?></td>
                        <td class="table__td"><?php echo $consumo->fecha_inicio; ?></td>
                        <td class="table__td"><?php echo $consumo->fecha_fin; ?></td>
                        <td class="table__td"><?php echo $consumo->tarifa->nombre_tarifa; ?></td>
                        <td class="table__td"><?php echo $consumo->consumo_m3; ?></td>
                        <td class="table__td"><?php echo number_format($consumo->monto_total, 2); ?></td>
                        <td class="table__td"><?php echo $consumo->estado->nombre ?? 'Pendiente'; ?></td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/lecturador/lectura/editar?id=<?php echo $consumo->id; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Editar
                            </a>
                            <form method="POST" action="/lecturador/lectura/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $consumo->id; ?>">
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
        <p class="text-center">No se encontraron lecturas registradas.</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>

<?php
session_start();
if (isset($_SESSION['eliminado'])) :
?>
    <script>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'La Lectura fue eliminado correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php unset($_SESSION['eliminado']);
endif; ?>

<?php
if (isset($_SESSION['error'])) :
?>
    <script>
        Swal.fire({
            title: '¡Error!',
            text: '<?php echo $_SESSION['error']; ?>',
            icon: 'error',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php unset($_SESSION['error']);
endif; ?>