<h2><?php echo $titulo; ?></h2>
<div class="dashboardtecnico__contenedor-boton">
    <a class="dashboardtecnico__boton" href="/tecnico/nuevasconexiones/index">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboardtecnico__contenedor">
    <?php if (!empty($trabajos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Código</th>
                    <th scope="col" class="table__th">Fecha</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th">Tipo Servicio</th>
                    <th scope="col" class="table__th">Servicio</th>
                    <th scope="col" class="table__th">Localidad</th>
                    <th scope="col" class="table__th">Dirección</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($trabajos as $trabajo) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $trabajo->codigo_seguimiento; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $trabajo->fecha_solicitud; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $trabajo->estado_id->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo ucfirst($trabajo->tipo_servicio); ?>
                        </td>
                        <td class="table__td">
                            <?php echo ucfirst($trabajo->servicio); ?>
                        </td>
                        <td class="table__td">
                            <?php echo $trabajo->localidad; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $trabajo->direccion_principal; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/tecnico/nuevasconexiones/revisar?id=<?php echo $trabajo->id; ?>">
                                <i class="fa-solid fa-eye"></i>
                                Ver
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No Hay Trabajos Asignados Aún</p>
    <?php } ?>
</div>

<?php
session_start();
if (isset($_SESSION['exito'])) :
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Se Inicio la tarea correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '/tecnico/nuevasconexiones'; // Redirigir después de cerrar la alerta
        });
    </script>
<?php
    unset($_SESSION['exito']); // Limpiar la variable de sesión para que no se muestre de nuevo
endif;
?>