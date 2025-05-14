<?php

namespace Controllers;

use MVC\Router;
use Model\Estados;
use Model\Usuario;
use Model\NuevaConexion;


class DashboardTecnicoController
{

    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        $usuario = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];

        $router->render('tecnico/dashboard/index', [
            'titulo' => 'Panel del Area Tecnica',
            'nombre' => $usuario

        ]);
    }

}
