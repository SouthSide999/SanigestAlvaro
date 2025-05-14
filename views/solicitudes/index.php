<h2><?php echo $titulo; ?></h2>


<?php echo $paginacion; ?>

<div class="dashboard__contenedor">
    <?php if (!empty($solicitudes)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th class="table__th">Código</th>
                    <th class="table__th">Fecha</th>
                    <th class="table__th">Estado</th>
                    <th class="table__th">Tipo de Solicitud</th>
                    <th class="table__th">Solicitante</th>
                    <th class="table__th">DNI</th>
                    <th class="table__th">Acciones</th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($solicitudes as $solicitud) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $solicitud->codigo_seguimiento; ?></td>
                        <td class="table__td"><?php echo $solicitud->fecha; ?></td>
                        <td class="table__td"><?php echo $solicitud->estado->nombre; ?></td>
                        <td class="table__td"><?php echo $solicitud->tipo_solicitud->nombre; ?></td>
                        <td class="table__td"><?php echo $solicitud->nombres . ' ' . $solicitud->apellidos; ?></td>
                        <td class="table__td"><?php echo $solicitud->dni; ?></td>
                        <td class="table__td--acciones">
                            <?php if ($usuariorol === '2') { ?>
                                <a class="table__accion table__accion--editar" href="/admin/solicitudes/finalizar?id=<?php echo $solicitud->id; ?>">
                                    <i class="fa-solid fa-eye"></i>
                                    Revisar
                                </a>
                            <?php } elseif ($usuariorol === '3') { ?>
                                <a class="table__accion table__accion--editar" href="/tesorero/solicitudes/finalizar?id=<?php echo $solicitud->id; ?>">
                                    <i class="fa-solid fa-eye"></i>
                                    Revisar
                                </a>
                            <?php } elseif ($usuariorol === '4') { ?>
                                <a class="table__accion table__accion--editar" href="/tecnico/solicitudes/finalizar?id=<?php echo $solicitud->id; ?>">
                                    <i class="fa-solid fa-eye"></i>
                                    Revisar
                                </a>
                            <?php } elseif ($usuariorol === '5') { ?>
                                <a class="table__accion table__accion--editar" href="/lecturador/solicitudes/finalizar?id=<?php echo $solicitud->id; ?>">
                                    <i class="fa-solid fa-eye"></i>
                                    Revisar
                                </a>
                            <?php } ?>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay solicitudes registradas aún</p>
    <?php } ?>
</div>
<?php
session_start();
if (isset($_SESSION['exito'])) :
?>
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Se Finalizo correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '/tesorero/solicitudes'; // Redirigir después de cerrar la alerta
        });
    </script>
<?php
    unset($_SESSION['exito']); // Limpiar la variable de sesión para que no se muestre de nuevo
endif;
?>