<?php

namespace Controllers;


use MVC\Router;
use Model\Contacto;
use Classes\Paginacion;


class ContactoController
{
    public static function crear(Router $router)
    {
        $alertas = [];
        $contacto = new Contacto;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $contacto->sincronizar($_POST);
            $alertas = $contacto->validar();

            if (empty($alertas)) {

                $resultado = $contacto->guardar();

                if ($resultado) {
                    header('Location: /contacto/crear?exito=1'); // Pasar un parámetro en la URL
                    exit;
                }
            }
        }

        $router->render('admin/contacto/crear', [
            'titulo' => 'Contactanos',
            'alertas' => $alertas,
            'contacto' => $contacto
        ]);
    }

    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /auth/login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);


        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/contacto?page=1');
        }
        $por_pagina = 5;
        $total = Contacto::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $contacto = Contacto::paginar($por_pagina, $paginacion->offset());



        $router->render('admin/contacto/index', [
            'titulo' => 'Contacto Realizados',
            'contactos' => $contacto,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
    public static function editarTarea()
    {
        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $contacto = Contacto::find($id);
            $contacto->sincronizar($_POST);
            $contacto->guardar();
            header('Location: /admin/contacto'); // Redirige después de actualizar
            exit;
        }
    }
    public static function eliminar()
    {
        if (!is_admin()) {
            header('Location: /auth/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $contacto = Contacto::find($id);

            if (isset($noticia)) {
                header('Location: /admin/noticias');
            }

            $resultado = $contacto->eliminar();
            if ($resultado) {
                $_SESSION['eliminado'] = true; // Guardar en sesión
                header('Location: /admin/contacto');
                exit;
            }
        }
    }
    public static function pendiente(Router $router)
    {
        if (!is_admin()) {
            header('Location: /auth/login');
        }

        $contacto = Contacto::whereArray(['estado' => '0']);

        $router->render('admin/contacto/pendientes', [
            'titulo' => 'Contacto Realizados',
            'contactos' => $contacto
        ]);
    }
    public static function atendido(Router $router)
    {
        if (!is_admin()) {
            header('Location: /auth/login');
        }

        $contacto = Contacto::whereArray(['estado' => '1']);

        $router->render('admin/contacto/atendidos', [
            'titulo' => 'Contacto Realizados',
            'contactos' => $contacto
        ]);
    }
    public static function buscar(Router $router)
    {
        $contacto = new Contacto();
        $contacto = Contacto::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contacto = Contacto::buscar('nombre', $_POST['nombre']);
        }

        if (!is_admin()) {
            header('Location: /auth/login');
        }

        $router->render('admin/contacto/buscar', [
            'titulo' => 'Buscar Contactos Realizados',
            'contactos' => $contacto
        ]);
    }
}
