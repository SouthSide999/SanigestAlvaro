<?php

namespace Controllers;

use Classes\Notificaciones;
use MVC\Router;
use Classes\Paginacion;
use Model\Estados;
use Model\NuevaConexion;
use Model\Usuario;

class NuevaConexionController
{
    public static function index(Router $router)
    {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);


        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/nuevaconexion?page=1');
        }


        $por_pagina = 10;
        $total = NuevaConexion::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $nuevaconexion = NuevaConexion::paginar($por_pagina, $paginacion->offset());



        foreach ($nuevaconexion as $nueva) {
            $nueva->estado_id = Estados::find($nueva->estado_id);
        }

        $router->render('admin/nuevaconexion/index', [
            'titulo' => 'Nuevas Conexiones',
            'nuevaconexion' => $nuevaconexion,
            'paginacion' => $paginacion->paginacion()

        ]);
    }


    public static function revisar(Router $router)
    {

        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }
        //validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/nuevaconexion');
        }

        $nueva = NuevaConexion::find($id);

        $nueva->estado_id = Estados::find($nueva->estado_id);

        $id = filter_var($id, FILTER_VALIDATE_INT);

        $tecnico = Usuario::buscar('rol_id', '4');

        $nueva->tecnico_id = Usuario::find($nueva->tecnico_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva->sincronizar($_POST);


            if ($nueva->observacion_rechazo === 'ninguna') {
                $nueva->estado_id = '2';
            } else {
                $nueva->estado_id = '3';
            }
            $resultado = $nueva->guardar();

            //notificacion a tecnico
            $idTecnico = $nueva->tecnico_id;
            $tecnicoAsignado = Usuario::find($idTecnico);

            $notificacion = new Notificaciones($tecnicoAsignado->email, $tecnicoAsignado->nombre, $tecnicoAsignado->apellido);
            $notificacion->enviarAsignacionNuevaConexion($nueva->direccion_principal);

            if ($resultado) {
                header("Location: /admin/nuevaconexion");
                exit;
            }
        }

        $router->render('admin/nuevaconexion/revisar', [
            'titulo' => '',
            'nueva' => $nueva,
            'tecnico' => $tecnico

        ]);
    }
}
