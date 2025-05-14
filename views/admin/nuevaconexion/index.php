<h2><?php echo $titulo; ?></h2>


<div class="dashboard__contenedor">
    <?php if (!empty($nuevaconexion)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Codigo</th>
                    <th scope="col" class="table__th">Fecha</th>
                    <th scope="col" class="table__th">Tipos Solicitante</th>
                    <th scope="col" class="table__th">Nombre y Apellidos</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th">Acciones</th>

                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($nuevaconexion as $nueva) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $nueva->codigo_seguimiento ?>
                        </td>

                        <td class="table__td">
                            <?php echo $nueva->fecha_solicitud ?>
                        </td>

                        <td class="table__td">
                            <?php echo $nueva->tipo_solicitante ?>
                        </td>

                        <td class="table__td">
                            <?php echo $nueva->nombre . " " . $nueva->apellido1 . " " . $nueva->apellido2 ?>
                        </td>

                        <td class="table__td">
                            <?php echo $nueva->estado_id->nombre ?>
                        </td>


                        <td class="table__td--acciones">

                            <a class="table__accion table__accion--editar" href="/admin/nuevaconexion/revisar?id=<?php echo $nueva->id; ?>">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                Revisar
                            </a>

                            <!-- <a class="table__accion table__accion--eliminar" href="/admin/nuevaconexion/rechazar?id=<?php echo $nueva->id; ?>">
                                <i class="fa-solid fa-x"></i>
                                Rechazar
                            </a>

                            <a class="table__accion table__accion--asignar" href="/admin/nuevaconexion/asignar?id=<?php echo $nueva->id; ?>">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                Asignar Tecnico
                            </a> -->

                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No Hay Ninguna Solicitud Para Una Nueva Conexion</p>
    <?php } ?>

</div>

<?php
echo $paginacion;
?>