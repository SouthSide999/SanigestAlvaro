<?php

namespace Controllers;

use MVC\Router;
use Model\Estados;
use Model\Usuario;
use Model\NuevaConexion;
use Classes\Notificaciones;


class NuevasConexionesTecnicoController
{

    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        $usuario = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];

        $router->render('tecnico/nuevasconexiones/index', [
            'titulo' => 'Panel del Área Técnica - Nuevas Conexiones',
            'nombre' => $usuario
        ]);
    }

    public static function trabajos(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        if (!is_tecnico()) {
            header('Location: /auth/login');
            return;
        }

        $usuario = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
        $usuarioId = $_SESSION['id'];

        $trabajos = NuevaConexion::buscarestricto('tecnico_id', $usuarioId);

        foreach ($trabajos as $trabajo) {
            $trabajo->estado_id = Estados::find($trabajo->estado_id);
        }

        $router->render('tecnico/nuevasconexiones/trabajos', [
            'titulo' => 'Todas las Nuevas Conexiones',
            'nombre' => $usuario,
            'trabajos' => $trabajos
        ]);
    }
    public static function ver(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        if (!is_tecnico()) {
            header('Location: /auth/login');
            return;
        }

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /tecnico/dashboard');
        }

        $nueva = NuevaConexion::find($id);
        $nueva->estado_id = Estados::find($nueva->estado_id);
        $tecnico = Usuario::buscar('rol_id', '4');
        $nueva->tecnico_id = Usuario::find($nueva->tecnico_id);

        $router->render('tecnico/nuevasconexiones/ver', [
            'titulo' => '',
            'nueva' => $nueva,
            'tecnico' => $tecnico
        ]);
    }


    public static function pendientes(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        if (!is_tecnico()) {
            header('Location: /auth/login');
            return;
        }

        $usuario = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
        $usuarioId = $_SESSION['id'];

        $trabajos = NuevaConexion::whereArray(['tecnico_id' => $usuarioId, 'estado_id' => '2']) ?? [];

        foreach ($trabajos as $trabajo) {
            $trabajo->estado_id = Estados::find($trabajo->estado_id);
        }

        $router->render('tecnico/nuevasconexiones/pendientes', [
            'titulo' => 'Nuevas Conexiones Pendientes',
            'nombre' => $usuario,
            'trabajos' => $trabajos
        ]);
    }

    public static function revisar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        if (!is_tecnico()) {
            header('Location: /auth/login');
            return;
        }

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /tecnico/dashboard');
        }

        $nueva = NuevaConexion::find($id);
        $nueva->estado_id = Estados::find($nueva->estado_id);
        $tecnico = Usuario::buscar('rol_id', '4');
        $nueva->tecnico_id = Usuario::find($nueva->tecnico_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva->sincronizar($_POST);
            $nueva->estado_id = '4';
            $nueva->tecnico_id = $nueva->tecnico_id->id;

            $resultado = $nueva->guardar();
            if ($resultado) {
                $_SESSION['exito'] = true; // Guardar mensaje en sesión
                header("Location: /tecnico/nuevasconexiones/pendientes");
                exit;
            }
        }

        $router->render('tecnico/nuevasconexiones/revisar', [
            'titulo' => '',
            'nueva' => $nueva,
            'tecnico' => $tecnico
        ]);
    }


    public static function encurso(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        if (!is_tecnico()) {
            header('Location: /auth/login');
            return;
        }

        $usuario = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
        $usuarioId = $_SESSION['id'];

        $trabajos = NuevaConexion::whereArray(['tecnico_id' => $usuarioId, 'estado_id' => '4']) ?? [];

        foreach ($trabajos as $trabajo) {
            $trabajo->estado_id = Estados::find($trabajo->estado_id);
        }

        $router->render('tecnico/nuevasconexiones/encurso', [
            'titulo' => 'Nuevas Conexiones en Curso',
            'nombre' => $usuario,
            'trabajos' => $trabajos
        ]);
    }

    public static function proceso(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        if (!is_tecnico()) {
            header('Location: /auth/login');
            return;
        }

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/nuevaconexion');
        }

        $nueva = NuevaConexion::find($id);
        $nueva->estado_id = Estados::find($nueva->estado_id);
        $tecnico = Usuario::buscar('rol_id', '4');
        $nueva->tecnico_id = Usuario::find($nueva->tecnico_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva->sincronizar($_POST);

            // Crear instancia de notificación
            $notificacion = new Notificaciones(
                $nueva->email,
                $nueva->nombre,
                $nueva->apellido1               
            );
            if ($nueva->observacion_rechazo === 'ninguna') {
                $nueva->estado_id = '5'; // Finalizado
                $nueva->tecnico_id = $_SESSION['id']; // Técnico actual
                $notificacion->enviarConexionFinalizadaCliente($nueva->direccion_principal);
            } else {
                $nueva->estado_id = '3'; // Observado / Rechazado
                $nueva->tecnico_id = 1; // Reasignar al técnico con ID 100
                $notificacion->enviarObservacionRechazoCliente($nueva->direccion_principal, $nueva->observacion_rechazo);
            }

            $resultado = $nueva->guardar();

            if ($resultado) {
                $_SESSION['exito'] = true;
                header("Location: /tecnico/nuevasconexiones/encurso");
                exit;
            }
        }

        $router->render('tecnico/nuevasconexiones/proceso', [
            'titulo' => '',
            'nueva' => $nueva,
            'tecnico' => $tecnico
        ]);
    }
}
