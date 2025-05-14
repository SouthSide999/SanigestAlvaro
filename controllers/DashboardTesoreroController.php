<?php

namespace Controllers;

use MVC\Router;


class DashboardTesoreroController
{

    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        $usuario = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];

        $router->render('tesorero/dashboard/index', [
            'titulo' => 'Panel De Tesoreria',
            'nombre' => $usuario

        ]);
    }
}
