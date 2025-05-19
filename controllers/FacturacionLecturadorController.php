<?php

namespace Controllers;

use MVC\Router;
use Model\Predio;
use Model\Tarifa;
use Model\Consumo;
use Classes\Paginacion;
use Model\EstadoConsumo;

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

    public static function crearLectura(Router $router)
    {
        if (!is_auth() || !is_lecturador()) {
            header('Location: /auth/login');
            exit;
        }

        $alertas = [];
        $lectura = new Consumo();

        // Obtener datos necesarios para el formulario
        $predios = Predio::all();
        $estados = EstadoConsumo::all();

        // Cargar tarifa para cada predio (si la necesitas para el formulario)
        foreach ($predios as $predio) {
            $predio->tarifa = Tarifa::find($predio->tarifa_id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lectura->sincronizar($_POST);

            // Validar datos básicos de la lectura
            $alertas = $lectura->validar();

            // Validar que monto_total venga en POST y sea numérico
            if (!isset($_POST['monto_total']) || !is_numeric($_POST['monto_total'])) {
                $alertas['error'][] = 'Monto total inválido o no enviado.';
            } else {
                $lectura->monto_total = floatval($_POST['monto_total']);
            }

            if (empty($alertas)) {
                // Validar que predio exista
                $predio = Predio::find($lectura->predio_id);
                if (!$predio) {
                    $alertas['error'][] = 'El predio seleccionado no existe.';
                } else {
                    // Aquí no recalculamos tarifa porque ya vino de JS
                    if ($lectura->guardar()) {
                        header('Location: /lecturador/lectura/crear?creado=1');
                        exit;
                    } else {
                        $alertas['error'][] = 'Error al guardar la lectura.';
                    }
                }
            }
        }

        $router->render('lecturador/lecturas/crear', [
            'titulo' => 'Registrar Lectura',
            'lectura' => $lectura,
            'predios' => $predios,
            'estados' => $estados,
            'alertas' => $alertas
        ]);
    }
}
