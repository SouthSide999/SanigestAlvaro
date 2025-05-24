<?php

namespace Controllers;

use MVC\Router;
use Model\Predio;
use Model\Cliente;
use Classes\Paginacion;

class ClienteController
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

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/cliente?page=1');
            return;
        }

        $por_pagina = 5;
        $total = Cliente::total(); // Debes tener este método en tu modelo Cliente
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);

        $clientes = Cliente::paginar($por_pagina, $paginacion->offset());

        $router->render('admin/clientes/index', [
            'titulo' => 'Clientes de Sanigest',
            'clientes' => $clientes,
            'paginacion' => $paginacion->paginacion()
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

        // Validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/clientes');
        }

        // Obtener cliente
        $cliente = Cliente::find($id);
        if (!$cliente) {
            header('Location: /admin/clientes');
        }


        $predios = Predio::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $passwordActual = $cliente->password;

            $cliente->sincronizar($_POST);
            $alertas = $cliente->validar_cliente();

            if (empty($alertas)) {
                if (!empty($_POST['password'])) {
                    $cliente->hashPassword();
                } else {
                    $cliente->password = $passwordActual;
                }
                $existePorPredio = Cliente::where('codigo_predio', $cliente->codigo_predio);

                if ($existePorPredio && $existePorPredio->id !== $cliente->id) {
                    // Ya existe otro cliente con ese código de predio
                    Cliente::setAlerta('error', 'Ya existe un cliente registrado con ese código de predio.');
                    $alertas = Cliente::getAlertas();
                } else {
                    $resultado = $cliente->guardar();
                }


                if ($resultado) {
                    header("Location: /admin/cliente/editar?id=$id&actualizado=1");
                    exit;
                }
            }
        }

        $router->render('admin/clientes/editar', [
            'titulo' => 'Editar Cliente',
            'cliente' => $cliente,
            'predios' => $predios, // Mandamos todos los predios disponibles
            'alertas' => $alertas
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
            $cliente = Cliente::find($id);

            if (!$cliente) {
                // Si no se encuentra el cliente con ese ID, redirigir
                header('Location: /admin/clientes');
                return;
            }

            $resultado = $cliente->eliminar();

            if ($resultado) {
                $_SESSION['eliminado'] = true; // Guardar en sesión para mensaje
                header('Location: /admin/cliente');
                exit;
            }

        }
    }
}
