<?php

namespace Controllers;

use MVC\Router;
use Model\Cliente;
use Model\Reclamo;
use Model\Usuario;
use Classes\Paginacion;
use Model\TiposReclamos;
use Intervention\Image\ImageManagerStatic as Image;


class ReclamoController
{

    //user
    public static function crear(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        $alertas = [];
        $reclamo = new Reclamo;

        $id = $_SESSION['id'];
        $usuario = Cliente::find($id);
        $tiposreclamos = TiposReclamos::all('ASC');

        $reclamosUsuario = Reclamo::whereArray(['cliente_id' => $_SESSION['id']]);
        
        foreach ($reclamosUsuario as $reclamoUsuario) {
            $reclamoUsuario->tipo = TiposReclamos::find($reclamoUsuario->tipo_reclamo_id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //* Imágenes (Opcional)
            $imagenesSubidas = [];

            if (!empty($_FILES['evidencias']['tmp_name'][0])) {
                // Crear carpeta de imágenes
                $carpeta_imagenes = '../public/img/evidencias';
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                // Recorrer cada imagen subida
                foreach ($_FILES['evidencias']['tmp_name'] as $index => $tmp_name) {
                    try {
                        // Generar nombre único
                        $nombre_imagen = md5(uniqid(rand(), true));

                        // Procesar imágenes en PNG y WebP
                        $imagen_png = Image::make($tmp_name)->fit(800, 800)->encode('png', 80);
                        $imagen_webp = Image::make($tmp_name)->fit(800, 800)->encode('webp', 80);

                        // Guardar imágenes en el servidor
                        $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                        $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                        // Almacenar nombre en el array
                        $imagenesSubidas[] = $nombre_imagen;
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Error al procesar la imagen.";
                        header('Location: /user/reclamos');
                        exit;
                    }

                    // Limitar a 3 imágenes
                    if (count($imagenesSubidas) >= 4) {
                        break;
                    }
                }
            }

            // Guardar las imágenes en la base de datos como JSON
            $_POST['evidencia'] = !empty($imagenesSubidas) ? json_encode($imagenesSubidas) : null;
            // Sincronizar con el objeto Reclamo
            $reclamo->sincronizar($_POST);
            $alertas = $reclamo->validar();
            // debuguear($_FILES);
            if (empty($alertas)) {
                $resultado = $reclamo->guardar();

                if ($resultado) {
                    $_SESSION['exito'] = true;
                    header('Location: /user/reclamos');
                    exit;
                }
            }
        }

        $router->render('user/reclamos/crear', [
            'titulo' => 'Reclamos',
            'alertas' => $alertas,
            'usuario' => $usuario,
            'reclamosUsuario' => $reclamosUsuario,
            'tiposreclamos' => $tiposreclamos,
            'reclamo' => $reclamo
        ]);
    }

    public static function ver(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        //validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /user/reclamos');
        }
        $reclamo = Reclamo::find($id);

        $idU = $_SESSION['id'];
        $usuario = Cliente::find($idU);
        $reclamo->tipo = TiposReclamos::find($reclamo->tipo_reclamo_id);

        $reclamo->imagen_actual = $reclamo->evidencia;
        $router->render('user/reclamos/ver', [
            'titulo' => 'Tu Reclamo',
            'reclamo' => $reclamo,
            'usuario' => $usuario
        ]);
    }
    public static function eliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $reclamo = Reclamo::find($id);

            if (!$reclamo) {
                header('Location: /user/reclamos');
                exit;
            }

            // Eliminar imágenes asociadas
            if (!empty($reclamo->evidencia)) {
                $imagenes = json_decode($reclamo->evidencia, true);
                $carpeta_imagenes = '../public/img/evidencias/';

                foreach ($imagenes as $imagen) {
                    $rutaPng = $carpeta_imagenes . $imagen . '.png';
                    $rutaWebp = $carpeta_imagenes . $imagen . '.webp';

                    if (file_exists($rutaPng)) {
                        unlink($rutaPng);
                    }
                    if (file_exists($rutaWebp)) {
                        unlink($rutaWebp);
                    }
                }
            }

            // Eliminar el reclamo
            $resultado = $reclamo->eliminar();
            if ($resultado) {
                $_SESSION['eliminado'] = true; // Guardar mensaje en sesión

                // Obtener la URL de referencia y limpiar parámetros GET
                $referer = $_SERVER['HTTP_REFERER'] ?? '/user/reclamos';
                $cleanUrl = strtok($referer, '?'); // Elimina la query string si existe

                header("Location: $cleanUrl"); // Redirección limpia
                exit;
            }
        }
    }
    //admin
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
            header('Location: /admin/reclamos?page=1');
        }

        $por_pagina = 5;
        $total = Reclamo::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $reclamos = Reclamo::paginar($por_pagina, $paginacion->offset());
        foreach ($reclamos as $reclamo) {
            $reclamo->usuario = Cliente::find($reclamo->cliente_id);
            $reclamo->tipo = TiposReclamos::find($reclamo->tipo_reclamo_id);
        }
        // Obtener detalle del reclamo si hay un ID en la URL
        $reclamoDetalle = null;
        if (isset($_GET['id'])) {
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($id) {
                $reclamoDetalle = Reclamo::find($id);
                if ($reclamoDetalle) {
                    $reclamoDetalle->usuario = Cliente::find($reclamoDetalle->cliente_id);
                    $reclamoDetalle->tipo = TiposReclamos::find($reclamoDetalle->tipo_reclamo_id);
                }
                $reclamoDetalle->imagen_actual = $reclamoDetalle->evidencia;
            }
        }


        $router->render('/admin/reclamos/index', [
            'titulo' => 'Reclamos Recibidos',
            'reclamos' => $reclamos,
            'reclamoDetalle' => $reclamoDetalle,
            'paginacion' => $paginacion->paginacion()

        ]);
    }

    public static function editarEstado()
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
            $reclamo = Reclamo::find($id);
            $reclamo->sincronizar($_POST);
            $reclamo->guardar();
            header("Location: /admin/reclamos?page=1&id=$id");

            exit;
        }
    }

    public static function buscar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $reclamos = [];
        $nombreBusqueda = ''; // Para recordar la búsqueda
        $reclamoDetalle = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreBusqueda = $_POST['nombre'] ?? ''; // Guardamos el nombre buscado

            if (!empty($nombreBusqueda)) {
                $usuario = Cliente::buscar('nombre', $nombreBusqueda);

                if (!empty($usuario)) {
                    $usuario_obj = $usuario[0];

                    $reclamos = Reclamo::buscar('cliente_id', $usuario_obj->id);

                    foreach ($reclamos as $reclamo) {
                        $reclamo->usuario = Cliente::find($reclamo->cliente_id);
                        $reclamo->tipo = TiposReclamos::find($reclamo->tipo_reclamo_id);
                    }
                }
            }
        }

        // Obtener detalle del reclamo si hay un ID en la URL
        if (isset($_GET['id'])) {
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($id) {
                $reclamoDetalle = Reclamo::find($id);
                if ($reclamoDetalle) {
                    $reclamoDetalle->usuario = Cliente::find($reclamoDetalle->cliente_id);
                    $reclamoDetalle->tipo = TiposReclamos::find($reclamoDetalle->tipo_reclamo_id);
                    $reclamoDetalle->imagen_actual = $reclamoDetalle->evidencia;
                }

                $nombreBusqueda = $reclamoDetalle->usuario->nombre; // Guardamos el nombre buscado
                if (!empty($nombreBusqueda)) {
                    $usuario = Cliente::buscar('nombre', $nombreBusqueda);

                    if (!empty($usuario)) {
                        $usuario_obj = $usuario[0];

                        $reclamos = Reclamo::buscar('cliente_id', $usuario_obj->id);

                        foreach ($reclamos as $reclamo) {
                            $reclamo->usuario = Cliente::find($reclamo->cliente_id);
                            $reclamo->tipo = TiposReclamos::find($reclamo->tipo_reclamo_id);
                        }
                    }
                }
            }
        }

        $router->render('/admin/reclamos/buscar', [
            'reclamos' => $reclamos,
            'reclamoDetalle' => $reclamoDetalle,
            'nombreBusqueda' => $nombreBusqueda // Enviar el nombre para mantener la búsqueda
        ]);
    }
    public static function editarEstadoB()
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
            $reclamo = Reclamo::find($id);
            $reclamo->sincronizar($_POST);
            $reclamo->guardar();
            header("Location: /admin/reclamos/buscar?id=$id");

            exit;
        }
    }
    public static function eliminarB()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $reclamo = Reclamo::find($id);

            // Eliminar imágenes asociadas
            if (!empty($reclamo->evidencia)) {
                $imagenes = json_decode($reclamo->evidencia, true);
                $carpeta_imagenes = '../public/img/evidencias/';

                foreach ($imagenes as $imagen) {
                    $rutaPng = $carpeta_imagenes . $imagen . '.png';
                    $rutaWebp = $carpeta_imagenes . $imagen . '.webp';

                    if (file_exists($rutaPng)) {
                        unlink($rutaPng);
                    }
                    if (file_exists($rutaWebp)) {
                        unlink($rutaWebp);
                    }
                }
            }

            // Eliminar el reclamo
            $resultado = $reclamo->eliminar();
            if ($resultado) {

                header("Location: /admin/reclamos"); // Redirección limpia
                exit;
            }
        }
    }
}
