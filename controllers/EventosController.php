<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\EventoHorario;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class EventosController
{

    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /auth/login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/eventos?page=1');
        }

        $por_pagina = 10;
        $total = Evento::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $eventos = Evento::paginar($por_pagina, $paginacion->offset());

        //acceder a otras tablas
        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id); //categoria
            $evento->dia = Dia::find($evento->dia_id); //dia
            $evento->hora = Hora::find($evento->hora_id); //ponente
            $evento->ponente = Ponente::find($evento->ponente_id); //dia
        }

        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops',
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()


        ]);
    }
    public static function crear(Router $router)
    {
        $alertas = [];
        if (!is_admin()) {
            header('Location: /auth/login');
        }
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        $evento = new Evento;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /auth/login');
            }

            $evento->sincronizar($_POST);


            $alertas = $evento->validar();

            if (empty($alertas)) {
                $resultado = $evento->guardar();

                if ($resultado) {
                    $_SESSION['exito'] = true; // Guardar mensaje en sesión

                    header('Location: /admin/eventos/crear'); // Recargar la misma página
                    exit;
                }
            }
        }

        $router->render('admin/eventos/crear', [
            'titulo' => 'Crear Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento

        ]);
    }

    public static function editar(Router $router)
    {
        $alertas = [];

        if (!is_admin()) {
            header('Location: /auth/login');
        }

        //obtener id
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/eventos');
        }


        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        //obtener datos del evento seleccionado
        $evento = Evento::find($id);
        if (!$evento) {
            header('Location: /admin/eventos');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /auth/login');
            }

            $evento->sincronizar($_POST);


            $alertas = $evento->validar();

            if (empty($alertas)) {
                $resultado = $evento->guardar();

                if ($resultado) {
                    header("Location: /admin/eventos/editar?id=$id&actualizado=1");
                    exit;
                }
            }
        }

        $router->render('admin/eventos/Editar', [
            'titulo' => 'Editar Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento

        ]);
    }
    public static function eliminar()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /auth/login');
            }

            $id = $_POST['id'];
            $evento = Evento::find($id);

            if (isset($ponente)) {
                header('Location: /admin/eventos');
            }

            $resultado = $evento->eliminar();
            if ($resultado) {
                $_SESSION['eliminado'] = true; // Guardar en sesión
                header('Location: /admin/eventos');
                exit;
            }
        }
    }
    public static function buscar(Router $router)
    {
        $eventos = new Evento();
        $eventos = Evento::all();

        //acceder a otras tablas
        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id); //categoria
            $evento->dia = Dia::find($evento->dia_id); //dia
            $evento->hora = Hora::find($evento->hora_id); //ponente
            $evento->ponente = Ponente::find($evento->ponente_id); //dia
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /auth/login');
            }

            $busqueda=$_POST['nombre'];

            $eventos = Evento::buscar('nombre', $busqueda);

            //acceder a otras tablas
            foreach ($eventos as $evento) {
                $evento->categoria = Categoria::find($evento->categoria_id); //categoria
                $evento->dia = Dia::find($evento->dia_id); //dia
                $evento->hora = Hora::find($evento->hora_id); //ponente
                $evento->ponente = Ponente::find($evento->ponente_id); //dia
            }
        }


        $router->render('admin/eventos/buscar', [
            'titulo' => 'Buscar Eventos',
            'eventos' => $eventos,
            'busqueda'=>$busqueda
        ]);
    }
}
