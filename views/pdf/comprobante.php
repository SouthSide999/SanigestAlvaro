<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
        }

        .header h1 {
            margin-bottom: 0;
        }

        .datos {
            margin-top: 20px;
        }

        .datos table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .datos th,
        .datos td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 30px;
        }
    </style>
</head>
<?php
if (!isset($pago)) {
    echo "Variable \$pago no definida";
    exit;
}
if (!isset($contribuyente)) {
    echo "Variable \$contribuyente no definida";
    exit;
}
if (!isset($predio)) {
    echo "Variable \$predio no definida";
    exit;
}
if (!isset($usuario)) {
    echo "Variable \$usuario no definida";
    exit;
}
?>

<body>
    <div class="header">
        <h1>Municipalidad Distrital de Huaro</h1>
        <h2>Comprobante de Pago</h2>
        <p><strong>N°:</strong> <?= $pago->numero_comprobante ?></p>
    </div>

    <div class="datos">
        <h3>Datos del Contribuyente</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <td><?= $contribuyente->nombres.' '.$contribuyente->apellidos ?></td>
            </tr>
            <tr>
                <th>Documento</th>
                <td><?= $contribuyente->documento_identidad  ?></td>
            </tr>
        </table>

        <h3>Datos del Predio</h3>
        <table>
            <tr>
                <th>Código</th>
                <td><?= $predio->codigo_predio ?></td>
            </tr>
            <tr>
                <th>Dirección</th>
                <td><?= $predio->direccion ?></td>
            </tr>
        </table>

        <h3>Datos del Pago</h3>
        <table>
            <tr>
                <th>Mes</th>
                <td><?= nombreMes($pago->mes)  ?></td>
            </tr>
            <tr>
                <th>Año</th>
                <td><?= $pago->anio ?></td>
            </tr>
            <tr>
                <th>Monto Pagado</th>
                <td>S/ <?= number_format($pago->monto_pagado, 2) ?></td>
            </tr>
            <tr>
                <th>Fecha de Pago</th>
                <td><?= $pago->fecha_pago ?></td>
            </tr>
            <tr>
                <th>Atendido por</th>
                <td><?=   $usuario->nombre.' '.$usuario->apellido?? '---' ?></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Gracias por su pago. Este comprobante ha sido generado por el sistema Sanigest.</p>
    </div>
</body>

</html>