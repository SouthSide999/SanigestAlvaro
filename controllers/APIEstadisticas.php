<?php

namespace Controllers;

use Model\Consumo;
use Model\Recibo;
use Model\Pago;
use Model\Predio;

class APIEstadisticas
{
    public static function index()
    {
        if (!is_auth() || !is_admin()) {
            echo json_encode(['error' => 'No autorizado']);
            return;
        }

        $totalConsumos = Consumo::total();
        $consumosPagados = Consumo::totalArray(['estado_id'=>2]);
        // $consumosPagados = Recibo::total('estado_pago_id', 2);

        $consumosPendientes = $totalConsumos - $consumosPagados;

        $nivelMora = $totalConsumos > 0
            ? round(($consumosPendientes / $totalConsumos) * 100, 2)
            : 0;

        // $pagosPorMes = Pago::total();

        // $consumoPorMes = Consumo::total();

        // $prediosActivos = Predio::countWhere('estado_servicio_id', 1);
        // $prediosCortados = Predio::countWhere('estado_servicio_id', 2);

        echo json_encode([
            'recibos' => [
                'total' => $totalConsumos,
                'pagados' => $consumosPagados,
                'pendientes' => $consumosPendientes,
                'mora' => $nivelMora
            ],
            // 'pagosPorMes' => $pagosPorMes,
            // 'consumoPorMes' => $consumoPorMes,
            // 'predios' => [
            //     'activos' => $prediosActivos,
            //     'cortados' => $prediosCortados
            // ]
        ]);
    }
}
