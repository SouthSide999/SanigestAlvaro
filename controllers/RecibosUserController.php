<?php

namespace Controllers;

use MVC\Router;
use Model\Predio;
use Model\Consumo;
use Classes\Paginacion;
use Model\Contribuyente;
use Model\EstadoServicio;


class RecibosUserController
{
    public static function consultarRecibo(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_usuario()) {
            header('Location: /auth/login');
            exit;
        }

        $idpredio=Predio::find($_SESSION["codigo_predio"]);
        $codigo =$idpredio ->codigo_predio ?? null;

        $resultado = null;
        $mensaje = null;

        // 1. Buscar predio
        $predio = Predio::where('codigo_predio', $codigo);

        if ($predio) {

            $contribuyente = Contribuyente::find($predio->contribuyente_id);
            $estadoServicio = EstadoServicio::find($predio->estado_servicio_id);

            $mes = date('n');
            $anio = date('Y');

            // Buscar consumo actual
            $consumo = Consumo::whereMultiple([
                'predio_id' => $predio->id,
                'mes' => $mes,
                'anio' => $anio
            ]);

            if (!$consumo) {
                // Si no hay consumo actual, obtener el último consumo registrado
                $query = "SELECT * FROM consumos WHERE predio_id = {$predio->id} ORDER BY anio DESC, mes DESC LIMIT 1";
                $resultados = Consumo::consultarSQL($query);
                $consumo = $resultados[0] ?? null;

                if ($consumo) {
                    $mensaje = "No se encontró consumo del mes actual. Se muestra el último recibo registrado.";
                } else {
                    $mensaje = "Este predio aún no tiene ningún recibo registrado.";
                }
            }

            // Si hay algún consumo (actual o pasado)
            if ($consumo) {
                $estadoRecibo = EstadoServicio::find($consumo->estado_id);

                $resultado = [
                    'predio' => $predio,
                    'contribuyente' => $contribuyente,
                    'consumo' => $consumo,
                    'estado_servicio' => $estadoServicio,
                    'estado_recibo' => $estadoRecibo
                ];
            }
        } else {
            $mensaje = "No se encontró un predio con ese código.";
        }


        $router->render('user/recibo/reciboConsulta', [
            'resultado' => $resultado,
            'mensaje' => $mensaje,
            'titulo' => 'Recibo Actual:'
        ]);
    }
}
