<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        $url_actual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        // $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            header('Location: /404');
        }
    }

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        // Utilizar el Layout de acuerdo a la URL
        $url_actual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';


        if (str_contains($url_actual, '/admin')) {
            include_once __DIR__ . '/views/admin-layout.php';
        } elseif (str_contains($url_actual, '/user')) {
            include_once __DIR__ . '/views/user-layout.php';
        } elseif (str_contains($url_actual, '/tesorero')) {
            include_once __DIR__ . '/views/tesorero-layout.php';
        } elseif (str_contains($url_actual, '/tecnico')) {
            include_once __DIR__ . '/views/tecnico-layout.php';
        } elseif (str_contains($url_actual, '/auth')) {
            include_once __DIR__ . '/views/auth-layout.php';
        } elseif (str_contains($url_actual, '/lecturador')) {
            include_once __DIR__ . '/views/lecturador-layout.php';
        } elseif (str_contains($url_actual, '/sin-rol')) {
            include_once __DIR__ . '/views/layout-limpio.php';
        } else {
            include_once __DIR__ . '/views/layout.php';
        }
    }
}
