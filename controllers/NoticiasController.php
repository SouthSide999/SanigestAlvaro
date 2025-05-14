<?php

namespace Controllers;

use MVC\Router;
use Model\Noticia;
use Model\Ponente;
use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image;

class NoticiasController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /auth/login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/noticias?page=1');
        }
        $por_pagina = 3;
        $total = Noticia::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $noticias = Noticia::paginar($por_pagina, $paginacion->offset());



        $router->render('admin/noticias/index', [
            'titulo' => 'Noticias o Avisos',
            'noticias' => $noticias,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
    public static function crear(Router $router)
    {
        $alertas = [];
        $noticia = new Noticia;

        if (!is_admin()) {
            header('Location: /auth/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /auth/login');
            }

            //*imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {

                // crear carpeta de imagenes
                $carperta_imagenes = '../public/img/noticias';
                if (!is_dir($carperta_imagenes)) {
                    mkdir($carperta_imagenes, 0755, true);
                }

                //generar versiones 
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid((rand()), true));
                $_POST['imagen'] = $nombre_imagen;
            }

            $noticia->sincronizar($_POST);
            $alertas = $noticia->validar();

            if (empty($alertas)) {
                //guardar imagenes
                $imagen_png->save($carperta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carperta_imagenes . '/' . $nombre_imagen . ".webp");

                $resultado = $noticia->guardar();

                if ($resultado) {
                    $_SESSION['exito'] = true; // Guardar mensaje en sesión

                    header('Location: /admin/noticias/crear'); // Recargar la misma página
                    exit;
                }
            }
        }

        $router->render('admin/noticias/crear', [
            'titulo' => 'Crear una nueva Noticia o Aviso',
            'alertas' => $alertas,
            'noticia' => $noticia

        ]);
    }
    public static function eliminar()
    {
        if (!is_admin()) {
            header('Location: /auth/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $noticia = Noticia::find($id);

            if (isset($noticia)) {
                header('Location: /admin/noticias');
            }

            $resultado = $noticia->eliminar();
            if ($resultado) {
                $_SESSION['eliminado'] = true; // Guardar en sesión
                header('Location: /admin/noticias');
                exit;
            }
        }
    }
    public static function editar(Router $router)
    {
        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }

        $alertas = [];
        //validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/noticias');
        }
        //obtener ponente
        $noticia = Noticia::find($id);
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$noticia) {
            header('Location: /admin/noticias');
        }
        $noticia->imagen_actual = $noticia->imagen;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_FILES['imagen']['tmp_name'])) {

                // crear carpeta de imagenes
                $carperta_imagenes = '../public/img/noticias';
                if (!is_dir($carperta_imagenes)) {
                    mkdir($carperta_imagenes, 0755, true);
                }
                //generar versiones 
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid((rand()), true));
                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $imagen_actual;
            }

            $noticia->sincronizar($_POST);
            $alertas = $noticia->validar();

            if (empty($alertas)) {
                
                if (isset($nombre_imagen)) {
                    //guardar imagenes
                    $imagen_png->save($carperta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carperta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                //guardar en la base de datos
                $resultado = $noticia->guardar();

                if ($resultado) {
                    header("Location: /admin/noticias/editar?id=$id&actualizado=1");
                    exit;
                }
            }
        }
        $router->render('admin/noticias/editar', [
            'titulo' => 'Editar Ponentes',
            'alertas' => $alertas,
            'noticia' => $noticia
        ]);
    }
    public static function buscar(Router $router)
    {
        $noticia = new Noticia();
        $noticia = Noticia::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $noticia = Noticia::buscar('nombre', $_POST['nombre']);
        }

        if (!is_admin()) {
            header('Location: /auth/login');
        }

        $router->render('admin/noticias/buscar', [
            'titulo' => 'Buscar la Noticia',
            'noticias' => $noticia
        ]);
    }
}
