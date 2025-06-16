<?php

namespace Controllers;

use MVC\Router;


class DashboardLecturadorController
{

    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        if (!is_lecturador()) {
            header('Location: /auth/login');
            return;
        }
        $usuario = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];

        $router->render('lecturador/dashboard/index', [
            'titulo' => 'Panel del Lecturador',
            'nombre' => $usuario

        ]);
    }

    public static function ayuda(Router $router)
    {
        $router->render('lecturador/dashboard/ayuda', [
            'titulo' => 'Necesitas Ayuda'
        ]);
    }
}
