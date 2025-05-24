<?php

namespace Controllers;

use Model\Cliente;
use Model\Consumo;
use Model\Pago;
use MVC\Router;
use Model\Pagos;
use Model\Predio;
use Model\Estados;
use Model\Reclamo;
use Model\Trabajo;
use Model\Solicitud;
use Model\Contribuyente;
use Model\NuevaConexion;
use Model\TiposSolicitud;

class DashboardController
{
    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /');
        }
        if (!is_admin()) {
            header('Location: /');
        }

        // Últimas solicitudes
        $solicitudes_recientes = Solicitud::buscarultimos('fecha', 5);
        foreach ($solicitudes_recientes as $solicitud) {
            $solicitud->tipo = TiposSolicitud::find($solicitud->tipo_solicitud_id);
            $solicitud->estado = Estados::find($solicitud->estado_id);
        }

        // Ingresos del mes
        $mes_actual = date('m');
        $anio_actual = date('Y');

        $pagos = Pago::whereArray(['mes' => $mes_actual, 'anio' => $anio_actual]) ?? [];

        $ingresos_mes = array_sum(array_column($pagos, 'monto_pagado'));

        // Predios con deuda
        $predios_endeudados = Consumo::whereArrayLimit(['estado_id' => 1]) ?? [];

        foreach ($predios_endeudados as $predio) {
            $predio->datosPredio = Predio::find($predio->predio_id);
            $predio->contribuyente = Contribuyente::find($predio->datosPredio->contribuyente_id ?? null);
        }


        // Reclamos pendientes
        $reclamos_pendientes = Reclamo::whereArrayLimit(['estado_id' => 1]) ?? [];
        foreach ($reclamos_pendientes as $reclamo) {
            $reclamo->cliente = Cliente::find($reclamo->cliente_id);
            $reclamo->estado = Estados::find($reclamo->estado_id);

        }

        // Trabajos técnicos programados
        $trabajos_programados = NuevaConexion::whereArrayLimit(['estado_id' => 1]) ?? [];

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'solicitudes_recientes' => $solicitudes_recientes,
            'ingresos_mes' => $ingresos_mes,
            'predios_endeudados' => $predios_endeudados,
            'reclamos_pendientes' => $reclamos_pendientes,
            'trabajos_programados' => $trabajos_programados
        ]);
    }
}
