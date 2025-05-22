<?php

namespace Controllers;

use Model\Zona;
use MVC\Router;
use Model\Predio;
use Model\Sector;
use Model\Medidor;
use Model\Conexion;
use Model\EstadoServicio;


class EstadoServicioController
{
    public static function estadoServicio(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/loginUser');
            exit;
        }
        if (!is_usuario()) {
            header('Location: /auth/loginUser');
            exit;
        }

        $codigoPredio = $_SESSION["codigo_predio"] ?? null;

        if (!$codigoPredio) {
            header('Location: /user/dashboard');
            exit;
        }
        $predio = Predio::find($codigoPredio);
        
        // Buscar datos relacionados
        $zona = Zona::find($predio->zona_id);
        $sector = Sector::find($predio->sector_id);
        $estadoServicio = EstadoServicio::find($predio->estado_servicio_id);
        
        // Obtener la primera conexión asociada al predio (o todas según necesites)
        $conexion = Conexion::where('predio_id', $predio->id);
        
        // Obtener primer medidor asociado al predio
        $medidor = Medidor::where('predio_id', $predio->id);

        $router->render('user/servicio/estadoServicio', [
            'titulo' => 'Estado De Servicio',
            'predio' => $predio,
            'zona' => $zona,
            'sector' => $sector,
            'estadoServicio' => $estadoServicio,
            'conexion' => $conexion,
            'medidor' => $medidor,
        ]);
    }
}
