<?php

namespace Controllers;

use Model\Pago;
use Model\Zona;
use MVC\Router;
use Model\Predio;
use Model\Sector;
use Model\Tarifa;
use Model\Consumo;
use Classes\Paginacion;
use Model\Contribuyente;
use Model\EstadoConsumo;
use Random\Engine\Secure;

class PagoController
{
    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /tesorero/pagos?page=1');
            exit;
        }

        $por_pagina = 30;
        $predios_con_consumo = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = $_POST['criterio'] ?? '';
            $dato = $_POST['dato'] ?? '';

            if ($criterio && $dato) {
                // Filtrar todos los predios según criterio y dato
                $predios = Predio::buscar($criterio, $dato);

                // De esos, filtrar solo los que tienen consumo
                foreach ($predios as $predio) {
                    $hayConsumo = Consumo::where('predio_id', $predio->id);
                    if (!empty($hayConsumo)) {
                        $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
                        $predio->zona = Zona::find($predio->zona_id);
                        $predio->sector = Sector::find($predio->sector_id);
                        $predios_con_consumo[] = $predio;
                    }
                }
            }
        } else {
            // Sin búsqueda, cargamos todos los predios con consumo
            $predios = Predio::all();
            foreach ($predios as $predio) {
                $hayConsumo = Consumo::where('predio_id', $predio->id);
                if (!empty($hayConsumo)) {
                    $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
                    $predio->zona = Zona::find($predio->zona_id);
                    $predio->sector = Sector::find($predio->sector_id);
                    $predios_con_consumo[] = $predio;
                }
            }
        }

        $total_predios = count($predios_con_consumo);
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total_predios);

        // Paginamos el array filtrado
        $offset = $paginacion->offset();
        $predios_paginados = array_slice($predios_con_consumo, $offset, $por_pagina);

        $router->render('tesorero/agua/pagos/index', [
            'titulo' => 'Lista de Predio por Contribuyente',
            'predios' => $predios_paginados,
            'paginacion' => $paginacion->paginacion(),
        ]);
    }

    public static function detallePagos(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $predio_id = $_GET['predio_id'] ?? null;

        if (!$predio_id) {
            header('Location: /tesorero/pagos');
            exit;
        }

        // Pagos pendientes: consumos con estado_id = 1 (registrado)
        $consumos = Consumo::buscarestricto('predio_id', $predio_id);
        $consumos_pendientes = array_filter($consumos, function ($c) {
            return $c->estado_id == 1;
        });

        // Pagos realizados (JOIN con consumo para obtener predio_id)
        $pagos = Pago::all(); // o usar un método específico
        $pagos_realizados = [];

        foreach ($pagos as $pago) {
            $consumo = Consumo::find($pago->consumo_id);
            if ($consumo && $consumo->predio_id == $predio_id) {
                $pago->mes = $consumo->mes;
                $pago->anio = $consumo->anio;
                $pagos_realizados[] = $pago;
            }
        }

        $router->render('tesorero/agua/pagos/detalle', [
            'titulo' => 'Lista de Consumos',
            'consumos' => $consumos_pendientes,
            'pagos' => $pagos_realizados,
        ]);
    }

    public static function realizarPago(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $router->render('tesorero/agua/consumos/index', [
            'titulo' => 'Lista de Consumos',
        ]);
    }
    public static function verRecibo(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $router->render('tesorero/agua/consumos/index', [
            'titulo' => 'Lista de Consumos',
        ]);
    }
}
