<?php

namespace Controllers;

use MVC\Router;


class DashboardUserController
{

    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        $usuario = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];

        $router->render('user/dashboard/index', [
            'titulo' => 'Panel de Usuario',
            'nombre' => $usuario

        ]);
    }
}
