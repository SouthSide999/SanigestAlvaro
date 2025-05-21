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
        $por_pagina = 30;
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
    public static function editarLectura(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_lecturador()) {
            header('Location: /auth/login');
            exit;
        }

        $alertas = [];

        // Validar ID
        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /lecturador/lectura');
            exit;
        }

        $predios = Predio::all();
        foreach ($predios as $predio) {
            $predio->tarifa = Tarifa::find($predio->tarifa_id);
        }

        // Obtener la lectura
        $lectura = Consumo::find($id);

        if (!$lectura) {
            header('Location: /lecturador/lectura');
            exit;
        }

        // Si el formulario fue enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Sincronizar datos
            $lectura->sincronizar($_POST);

            // Validar
            $alertas = $lectura->validar();


            if (empty($alertas)) {
                $resultado = $lectura->guardar();

                if ($resultado) {
                    header("Location: /lecturador/lectura/editar?id=$id&editado=1");
                    exit;
                }
            }
        }

        // Renderizar vista
        $router->render('lecturador/lecturas/editar', [
            'titulo' => 'Editar Lectura',
            'alertas' => $alertas,
            'predios' => $predios,
            'lectura' => $lectura
        ]);
    }
    public static function eliminarLectura()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_lecturador()) {
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

            header('Location: /lecturador/lectura');
            exit;
        }
    }
    public static function generarLectura(Router $router)
    {
        if (!is_auth()) {
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mes = $_POST['mes'] ?? null;
            $anio = $_POST['anio'] ?? null;
            $fecha_inicio = $_POST['fecha_inicio'] ?? null;
            $fecha_fin = $_POST['fecha_fin'] ?? null;

            if (!$mes || !$anio || !$fecha_inicio || !$fecha_fin) {
                header('Location: /lecturador/lectura/generar?error=1');
                exit;
            }

            // Obtener predios operativos y morosos
            $todos = Predio::all();
            $predios = array_filter($todos, function ($p) {
                return in_array($p->estado_servicio_id, [1, 4]);
            });


            if (empty($predios)) {
                header('Location: /lecturador/lectura/generar?sinPredios=1');
                exit;
            }

            foreach ($predios as $predio) {
                $lectura = new Consumo([
                    'predio_id' => $predio->id,
                    'mes' => $mes,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'anio' => $anio,
                    'consumo_m3' => 1,
                    'monto_total' => 4
                ]);
                $lectura->guardar();
            }

            header('Location: /lecturador/lectura/generar?exito=1');
            exit;
        }

        $router->render('/lecturador/lecturas/generar', [
            'titulo' => 'Generar Consumos',
            'meses' => $meses
        ]);
    }
}
