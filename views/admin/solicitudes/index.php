<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor">
    <?php if (!empty($solicitudes)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Código</th>
                    <th scope="col" class="table__th">Fecha</th>
                    <th scope="col" class="table__th">Tipo Solicitud</th>
                    <th scope="col" class="table__th">Nombre y Apellidos</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($solicitudes as $solicitud) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $solicitud->codigo_seguimiento; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $solicitud->fecha; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $solicitud->tipo_solicitud->nombre; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $solicitud->nombres . " " . $solicitud->apellidos; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $solicitud->estado->nombre; ?>
                        </td>

                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/solicitudes/revisar?id=<?php echo $solicitud->id; ?>">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                Revisar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay solicitudes registradas.</p>
    <?php } ?>
</div>

<?php echo $paginacion ?? ''; ?>

<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'asignado') : ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Solicitud asignada',
            text: 'La solicitud fue asignada correctamente.',
            confirmButtonText: 'Aceptar'
        });
    </script>
<?php endif; ?>
