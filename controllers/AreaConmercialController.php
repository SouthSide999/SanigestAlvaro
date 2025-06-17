<?php

namespace Controllers;

use MVC\Router;
use Model\Predio;
use Model\Tarifa;
use Model\Consumo;
use Classes\Paginacion;
use Model\EstadoConsumo;

class AreaConmercialController
{
    public static function indexConsumos(Router $router)
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
            header('Location: /tesorero/consumos?page=1');
            exit;
        }

        $consumos = [];
        $por_pagina = 50;
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

        $router->render('tesorero/agua/consumos/index', [
            'titulo' => 'Lista de Consumos',
            'consumos' => $consumos,
            'paginacion' => $paginacion ? $paginacion->paginacion() : ''
        ]);
    }
    public static function crearConsumos(Router $router)
    {
        if (!is_auth() || !is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $alertas = [];
        $consumo = new Consumo();

        // Obtener datos necesarios para el formulario
        $predios = Predio::all();
        $estados = EstadoConsumo::all();

        // Cargar tarifa para cada predio (si la necesitas para el formulario)
        foreach ($predios as $predio) {
            $predio->tarifa = Tarifa::find($predio->tarifa_id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $consumo->sincronizar($_POST);

            // Validar datos básicos de la lectura
            $alertas = $consumo->validar();

            // Validar que monto_total venga en POST y sea numérico
            if (!isset($_POST['monto_total']) || !is_numeric($_POST['monto_total'])) {
                Consumo::setAlerta('error', 'Monto total inválido o no enviado.');
            } else {
                $consumo->monto_total = floatval($_POST['monto_total']);
            }
            if (empty($alertas)) {
                // Validar que el predio exista
                $predio = Predio::find($consumo->predio_id);
                if (!$predio) {
                    Consumo::setAlerta('error', 'El predio seleccionado no existe.');
                } else {
                    $consumoExistente = Consumo::whereArray(['predio_id' => $consumo->predio_id, 'mes' => $consumo->mes, 'anio' => $consumo->anio]) ?? [];
                    if ($consumoExistente) {
                        Consumo::setAlerta('error', 'Ya existe un consumo registrado para este predio en el mismo mes y año.');
                    } else {
                        if ($consumo->guardar()) {
                            header('Location: /tesorero/consumos/crear?creado=1');
                            exit;
                        } else {
                            Consumo::setAlerta('error', 'Error al guardar la lectura.');
                        }
                    }
                }
            }
        }
        $alertas = Consumo::getAlertas();

        $router->render('tesorero/agua/consumos/crear', [
            'titulo' => 'Registrar Lectura',
            'lectura' => $consumo,
            'predios' => $predios,
            'estados' => $estados,
            'alertas' => $alertas
        ]);
    }
    public static function editarConsumos(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $alertas = [];

        // Validar ID
        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /tesorero/lectura');
            exit;
        }

        $predios = Predio::all();
        foreach ($predios as $predio) {
            $predio->tarifa = Tarifa::find($predio->tarifa_id);
        }

        // Obtener la lectura
        $consumo = Consumo::find($id);

        if (!$consumo) {
            header('Location: /tesorero/lectura');
            exit;
        }

        // Si el formulario fue enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Sincronizar datos
            $consumo->sincronizar($_POST);

            // Validar
            $alertas = $consumo->validar();


            if (empty($alertas)) {
                $resultado = $consumo->guardar();

                if ($resultado) {
                    header("Location: /tesorero/consumos/editar?id=$id&editado=1");
                    exit;
                }
            }
        }

        // Renderizar vista
        $router->render('tesorero/agua/consumos/editar', [
            'titulo' => 'Editar Lectura',
            'alertas' => $alertas,
            'predios' => $predios,
            'lectura' => $consumo
        ]);
    }
    public static function eliminarConsumos()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $lectura = Consumo::find($id);

            if ($lectura) {
                $lectura->eliminar();
                $_SESSION['eliminado'] = 'Lectura eliminada correctamente.';
            } else {
                $_SESSION['error'] = 'La lectura no fue encontrada.';
            }

            header('Location: /tesorero/consumos');
            exit;
        }
    }
    public static function generarConsumos(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mes = $_POST['mes'] ?? null;
            $anio = $_POST['anio'] ?? null;
            $fecha_inicio = $_POST['fecha_inicio'] ?? null;
            $fecha_fin = $_POST['fecha_fin'] ?? null;

            if (!$mes || !$anio || !$fecha_inicio || !$fecha_fin) {
                header('Location: /tesorero/consumos/generar?error=1');
                exit;
            }

            // Obtener predios operativos y morosos
            $todos = Predio::all();
            $predios = array_filter($todos, function ($p) {
                return in_array($p->estado_servicio_id, [1, 4]);
            });

            if (empty($predios)) {
                header('Location: /tesorero/consumos/generar?sinPredios=1');
                exit;
            }

            // Verificar si ya existen consumos para al menos un predio
            $hayDuplicados = false;
            foreach ($predios as $predio) {
                $existente = Consumo::whereArray([
                    'predio_id' => $predio->id,
                    'mes' => $mes,
                    'anio' => $anio
                ]);

                if ($existente) {
                    $hayDuplicados = true;
                    break;
                }
            }

            if ($hayDuplicados) {
                Consumo::setAlerta('error', 'Ya existen consumos registrados para al menos un predio en el mismo mes y año.');
            } else {
                // Generar consumos
                foreach ($predios as $predio) {
                    $lectura = new Consumo([
                        'predio_id' => $predio->id,
                        'mes' => $mes,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin' => $fecha_fin,
                        'anio' => $anio,
                        'consumo_m3' => 1, // Puedes reemplazar por el cálculo real
                        'monto_total' => 4  // Puedes reemplazar por el cálculo real
                    ]);
                    $lectura->guardar();
                }

                header('Location: /tesorero/consumos/generar?exito=1');
                exit;
            }
        }
        $alertas = Consumo::getAlertas();

        $router->render('/tesorero/agua/consumos/generar', [
            'titulo' => 'Generar Consumos',
            'meses' => $meses,
            'alertas' => $alertas
        ]);
    }
}
