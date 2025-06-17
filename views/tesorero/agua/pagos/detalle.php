<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/tesorero/pagos">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<!-- PAGOS PENDIENTES -->
<h3 class="dashboard__subtitulo">Pagos Pendientes</h3>
<div class="dashboard__contenedor">
    <?php if (!empty($consumos)) { ?>
        <form method="POST" action="/tesorero/pagos/pagar-multiple">
            <input type="hidden" name="predio_id" value="<?php echo $_GET['predio_id']; ?>">
            <div class="table--scroll">
                <table class="table">
                    <thead class="table__thead">
                        <tr>
                            <th class="table__th">Mes</th>
                            <th class="table__th">Año</th>
                            <th class="table__th">Periodo</th>
                            <th class="table__th">Consumo (m³)</th>
                            <th class="table__th">Monto Total (S/)</th>
                            <th class="table__th">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="table__tbody">
                        <?php foreach ($consumos as $consumo) { ?>
                            <tr class="table__tr">
                                <td class="table__td"><?php echo nombreMes($consumo->mes); ?></td>
                                <td class="table__td"><?php echo $consumo->anio; ?></td>
                                <td class="table__td"><?php echo $consumo->fecha_inicio . ' al ' . $consumo->fecha_fin; ?></td>
                                <td class="table__td"><?php echo $consumo->consumo_m3; ?></td>
                                <td class="table__td">S/ <?php echo number_format($consumo->monto_total, 2); ?></td>
                                <td class="table__td--acciones">
                                    <a class="table__accion table__accion--editar" href="/tesorero/pagos/realizar?id=<?php echo $consumo->id; ?>">
                                        <i class="fa-solid fa-money-bill-wave"></i> Pagar
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
    <?php } else { ?>
        <p class="text-center">No hay pagos pendientes para este predio.</p>
    <?php } ?>
</div>

<!-- PAGOS REALIZADOS -->
<h3 class="dashboard__subtitulo">Pagos Realizados</h3>
<div class="dashboard__contenedor">
    <?php if (!empty($pagos)) { ?>
        <div class="table--scroll">
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th class="table__th">Mes</th>
                        <th class="table__th">Año</th>
                        <th class="table__th">Fecha de Pago</th>
                        <th class="table__th">Monto Pagado (S/)</th>
                        <th class="table__th">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    <?php foreach ($pagos as $pago) { ?>
                        <tr class="table__tr">
                            <td class="table__td"><?php echo nombreMes($pago->mes); ?></td>
                            <td class="table__td"><?php echo $pago->anio; ?></td>
                            <td class="table__td"><?php echo $pago->fecha_pago; ?></td>
                            <td class="table__td">S/ <?php echo number_format($pago->monto_pagado, 2); ?></td>
                            <td class="table__td--acciones">
                                <a class="table__accion table__accion--editar" href="/comprobantePago/comprobante_<?php echo $pago->numero_comprobante; ?>.pdf" target="_blank">
                                    <i class="fa-solid fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p class="text-center">No se han realizado pagos aún.</p>
    <?php } ?>
</div>