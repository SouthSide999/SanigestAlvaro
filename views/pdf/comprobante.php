<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 20px 30px;
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            padding-bottom: 5px;
            border-bottom: 2px solid #00897b;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 20px;
            color: #004d40;
            margin: 0;
        }

        .header h2 {
            font-size: 14px;
            color: #00695c;
            margin: 3px 0;
        }

        .header p {
            font-size: 12px;
            margin: 3px 0;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 10px;
        }

        .section {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }

        .section h3 {
            margin: 0 0 5px 0;
            font-size: 12px;
            color: #00796b;
            border-left: 4px solid #00796b;
            padding-left: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            text-align: left;
        }

        th {
            background-color: #e0f2f1;
            color: #004d40;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            color: #666;
            margin-top: 10px;
        }

        .solo {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Municipalidad Distrital de Huaro</h1>
        <h2>Sistema Sanigest</h2>
        <h2>Comprobante de Pago</h2>
        <p><strong>N° de Comprobante:</strong> <?= $pago->numero_comprobante ?></p>
    </div>

    <div class="grid-container">
        <div class="section">
            <h3>Contribuyente</h3>
            <table>
                <tr>
                    <th>Nombre</th>
                    <td><?= $contribuyente->nombres . ' ' . $contribuyente->apellidos ?></td>
                </tr>
                <tr>
                    <th>Documento</th>
                    <td><?= $contribuyente->documento_identidad ?></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>Predio</h3>
            <table>
                <tr>
                    <th>Código</th>
                    <td><?= $predio->codigo_predio ?></td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td><?= $predio->direccion ?></td>
                </tr>
                <tr>
                    <th>Tarifa</th>
                    <td><?= $tarifa->nombre_tarifa ?? '---' ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section solo">
        <h3>Pago</h3>
        <table>
            <tr>
                <th>Mes</th>
                <td><?= nombreMes($pago->mes) ?></td>
                <th>Año</th>
                <td><?= $pago->anio ?></td>
            </tr>
            <tr>
                <th>Monto Agua</th>
                <td>S/ <?= number_format($consumo->monto_agua ?? 0, 2) ?></td>
                <th>Monto Desagüe</th>
                <td>S/ <?= number_format($consumo->monto_desague ?? 0, 2) ?></td>
            </tr>
            <tr>
                <th>Cargo Fijo</th>
                <td>S/ <?= number_format($tarifa->cargo_fijo ?? 0, 2) ?></td>
                <th>Total Pagado</th>
                <td><strong>S/ <?= number_format($pago->monto_pagado ?? 0, 2) ?></strong></td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td><?= $pago->fecha_pago ?></td>
                <th>Atendido por</th>
                <td><?= $usuario->nombre . ' ' . $usuario->apellido ?? '---' ?></td>
            </tr>
        </table>
    </div>

    <div class="section solo">
        <h3>Últimos Consumos</h3>
        <table>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>m³</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($consumos_anteriores)): ?>
                    <?php foreach ($consumos_anteriores as $c): ?>
                        <tr>
                            <td><?= nombreMes($c->mes) ?></td>
                            <td><?= $c->anio ?></td>
                            <td><?= number_format($c->consumo_m3 ?? 0, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No hay registros anteriores</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Gracias por su pago. Este comprobante ha sido generado automáticamente por el sistema Sanigest.</p>
    </div>

</body>

</html>