<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController
{

    public static function index(Router $router)
    {
        //*paginacion
        //obtener la pagina actual
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/ponentes?page=1');
        }
        $registros_por_pagina = 10;
        $total = Ponente::total();

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        }

        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());



        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }


        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function buscar(Router $router)
    {
        $ponente = new Ponente();
        $ponente = Ponente::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ponente = Ponente::buscar('nombre', $_POST['nombre']);
        }

        if (!is_admin()) {
            header('Location: /auth/login');
        }

        $router->render('admin/ponentes/buscar', [
            'titulo' => 'Buscar Ponentes',
            'ponentes' => $ponente
        ]);
    }

    public static function crear(Router $router)
    {

        $alertas = [];
        $ponente = new Ponente();

        if (!is_admin()) {
            header('Location: /auth/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //*imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {

                // crear carpeta de imagenes
                $carperta_imagenes = '../public/img/speakers';
                if (!is_dir($carperta_imagenes)) {
                    mkdir($carperta_imagenes, 0755, true);
                }

                //generar versiones 
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid((rand()), true));
                $_POST['imagen'] = $nombre_imagen;
            }

            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);  //convertir redes de array a string

            $ponente->sincronizar($_POST);

            $alertas = $ponente->validar();

            if (empty($alertas)) {
                //guardar imagenes
                $imagen_png->save($carperta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carperta_imagenes . '/' . $nombre_imagen . ".webp");

                //guardar en la base de datos
                $resultado = $ponente->guardar();

                if ($resultado) {
                    $_SESSION['exito'] = true; // Guardar mensaje en sesión

                    header('Location: /admin/ponentes/crear'); // Recargar la misma página
                    exit;
                }
            }
        }
        $router->render('admin/ponentes/crear', [
            'titulo' => 'Ponentes / Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function editar(Router $router)
    {
        if (!is_admin()) {
            header('Location: /auth/login');
        }

        $alertas = [];
        //validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/ponentes');
        }
        //obtener ponente
        $ponente = Ponente::find($id);
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$ponente) {
            header('Location: /admin/ponentes');
        }
        $ponente->imagen_actual = $ponente->imagen;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_FILES['imagen']['tmp_name'])) {

                // crear carpeta de imagenes
                $carperta_imagenes = '../public/img/speakers';
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
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);  //convertir redes de array a string

            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();

            if (empty($alertas)) {
                if (isset($nombre_imagen)) {
                    //guardar imagenes
                    $imagen_png->save($carperta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carperta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                //guardar en la base de datos
                $resultado = $ponente->guardar();

                if ($resultado) {
                    header("Location: /admin/ponentes/editar?id=$id&actualizado=1");
                    exit;
                }
            }
        }
        $router->render('admin/ponentes/editar', [
            'titulo' => 'Editar Ponentes',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes) //convertir redes de string a array
        ]);
    }

    public static function eliminar()
    {
        if (!is_admin()) {
            header('Location: /auth/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $ponente = Ponente::find($id);

            if (isset($ponente)) {
                header('Location: /admin/ponentes');
            }

            $resultado = $ponente->eliminar();
            if ($resultado) {
                $_SESSION['eliminado'] = true; // Guardar en sesión
                header('Location: /admin/ponentes');
                exit;
            }
        }
    }
}
