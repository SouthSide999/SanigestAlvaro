<?php

namespace Controllers;

use MVC\Router;
use Model\Evento;
use Model\Usuario;
use Model\Registro;

class DashboardController
{

    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /');
        }
        //obtener ultimos registros 
        $registros = Registro::get(5);
        foreach ($registros as $registro) {
            $registro->usuario = Usuario::find($registro->usuario_id);
        }

        // Calcular los ingresos
        $virtuales = Registro::total('paquete_id', 2);
        $presenciales = Registro::total('paquete_id', 1);

        $ingresos = ($virtuales * 46.41) + ($presenciales * 189.54);

        // Obtener eventos con más y menos lugares disponibles
        $menos_disponibles = Evento::ordenarLimite('disponibles', 'ASC', 5);
        $mas_disponibles = Evento::ordenarLimite('disponibles', 'DESC', 5);

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
<<<<<<< Updated upstream
            'registros' => $registros,
            'ingresos' => $ingresos,
            'menos_disponibles' => $menos_disponibles,
            'mas_disponibles' => $mas_disponibles

=======
            'solicitudes_recientes' => $solicitudes_recientes,
            'ingresos_mes' => $ingresos_mes,
            'predios_endeudados' => $predios_endeudados,
            'reclamos_pendientes' => $reclamos_pendientes,
            'trabajos_programados' => $trabajos_programados
        ]);
    }

    public static function estadisticas(Router $router)
    {
        if (!is_auth()) {
            header('Location: /');
        }
        if (!is_admin()) {
            header('Location: /');
        }

        $router->render('admin/dashboard/estadisticas', [
            'titulo' => 'Estadisticas',

        ]);
    }
    
    public static function ayuda(Router $router)
    {
        $router->render('admin/dashboard/ayuda', [
            'titulo' => 'Necesitas Ayuda'
>>>>>>> Stashed changes
        ]);
    }
}
