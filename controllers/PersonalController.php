<?php

namespace Controllers;

use MVC\Router;

use Classes\Paginacion;
use Model\Roles;
use Model\Usuario;

class PersonalController
{

    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/personal?page=1');
        }

        $por_pagina = 10;
        $total = Usuario::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $personal = Usuario::paginar($por_pagina, $paginacion->offset());

        foreach ($personal as $persona) {
            $persona->rol = Roles::find($persona->rol_id);
        }

        $id_usuario_actual = $_SESSION['id'];
        $router->render('admin/personal/index', [
            'titulo' => 'Personal De Sanigest',
            'personal' => $personal,
            'paginacion' => $paginacion->paginacion(),
            'id_usuario_actual' => $id_usuario_actual

        ]);
    }


    public static function editar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }

        $alertas = [];
        //validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/personal');
        }

        //obtener ponente
        $personal = Usuario::find($id);
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $roles=Roles::all();

        if (!$personal) {
            header('Location: /admin/personal');
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Guardamos temporalmente la contraseña original
            $passwordActual = $personal->password;
        
            // Sincronizamos los datos del formulario
            $personal->sincronizar($_POST);
        
            // Validamos los datos
            $alertas = $personal->validar_personal();
        
            if (empty($alertas)) {
                // Si se ingresó una nueva contraseña, la hasheamos
                if (!empty($_POST['password'])) {
                    $personal->hashPassword();
                } else {
                    // Si no se ingresó, restauramos la contraseña anterior
                    $personal->password = $passwordActual;
                }
        
                // Guardamos en la base de datos
                $resultado = $personal->guardar();
        
                if ($resultado) {
                    header("Location: /admin/personal/editar?id=$id&actualizado=1");
                    exit;
                }
            }
        }
        
        
        // debuguear($personal);
        $router->render('admin/personal/editar', [
            'titulo' => 'Editar Personal',
            'alertas' => $alertas,
            'personal' => $personal,
            'roles' => $roles,

        ]);
    }

    public static function eliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $personal = Usuario::find($id);

            if (isset($personal)) {
                header('Location: /admin/personal');
            }

            $resultado = $personal->eliminar();
            if ($resultado) {
                $_SESSION['eliminado'] = true; // Guardar en sesión
                header('Location: /admin/personal');
                exit;
            }
        }
    }
}
