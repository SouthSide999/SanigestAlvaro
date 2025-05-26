<?php

namespace Controllers;

use Model\Pago;
use MVC\Router;
use Model\Predio;
use Model\Cliente;
use Model\Consumo;
use Model\Estados;
use Model\Reclamo;
use Model\Solicitud;
use Model\Contribuyente;
use Model\NuevaConexion;
use Model\TiposSolicitud;


class DashboardTesoreroController
{
        public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /');
        }
        if (!is_tesorero()) {
            header('Location: /');
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

        $router->render('tesorero/dashboard/index', [
            'titulo' => 'Panel de Tesoreria',
            'ingresos_mes' => $ingresos_mes,
            'predios_endeudados' => $predios_endeudados
        ]);
    }
}
