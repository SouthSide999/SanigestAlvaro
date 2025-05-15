<?php

namespace Controllers;

use MVC\Router;
use Model\Consumo;
use Classes\Paginacion;
use Model\Predio;
use Model\Tarifa;

class FacturacionLecturadorController
{
    public static function indexLectura(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_lecturador()) {
            header('Location: /auth/login');
            exit;
        }

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /lecturador/consumos?page=1');
            exit;
        }

        $consumos = [];
        $por_pagina = 10;
        $paginacion = null; // Inicializamos por defecto

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $anio = $_POST['anio'] ?? '';
            $mes = $_POST['mes'] ?? '';
            if ($anio && $mes) {
                $consumos = Consumo::whereArray(['mes' => $mes, 'anio' => $anio]) ?? [];

                foreach ($consumos as $consumo) {
                    $consumo->predio = Predio::find($consumo->predio_id);
                    $consumo->tarifa = $consumo->predio
                        ? Tarifa::find($consumo->predio->tarifa_id)
                        : null;
                }
            }
        } else {
            $total = Consumo::total();
            $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
            $consumos = Consumo::paginar($por_pagina, $paginacion->offset());

            foreach ($consumos as $consumo) {
                $consumo->predio = Predio::find($consumo->predio_id);
                $consumo->tarifa = $consumo->predio
                    ? Tarifa::find($consumo->predio->tarifa_id)
                    : null;
            }
        }

        $router->render('lecturador/lecturas/index', [
            'titulo' => 'Lista de Consumos',
            'consumos' => $consumos,
            'paginacion' => $paginacion ? $paginacion->paginacion() : ''
        ]);
    }
}
