<?php

namespace Controllers;

use MVC\Router;



class HistorialController
{
    public static function historial(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/loginUser');
            exit;
        }
        if (!is_usuario()) {
            header('Location: /auth/loginUser');
            exit;
        }
        $router->render('user/historial/historial', [
            'titulo' => 'Historial De Consumos',
        ]);
    }
}
