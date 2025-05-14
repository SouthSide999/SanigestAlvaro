<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Noticia;
use Model\Ponente;
use Model\Categoria;

class PaginasController
{
    public static function index(Router $router)
    {

        $noticia = Noticia::all('DESC');

        $ponentes_total = Ponente::total(); //obtener ponentes_total

        $conferencia_total = Evento::total('categoria_id', '1'); //obtener conferencia_total

        $workshops_total = Evento::total('categoria_id', '2'); //obtener conferencia_total


        $ponentes = Ponente::all(); //obtener ponentes




        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'noticias' => $noticia,
            'ponentes_total' => $ponentes_total,
            'conferencia_total' => $conferencia_total,
            'workshops_total' => $workshops_total,
            'ponentes' => $ponentes

        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros', [
            'titulo' => 'Sobre Sanigest'
        ]);
    }
    public static function quehacemos(Router $router)
    {

        $router->render('paginas/quehacemos', [
            'titulo' => '¿Qué Hacemos en Sanigest Huaro?'
        ]);
    }
    public static function masinformacion(Router $router)
    {
        //obtener id
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);


        //obtener datos del evento seleccionado
        $noticia = Noticia::find($id);


        $router->render('paginas/masinformacion', [
            'titulo' => 'Mas Informacion',
            'noticia' => $noticia
        ]);
    }

    public static function paquetes(Router $router)
    {

        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes SaniGest'
        ]);
    }

    public static function conferencias(Router $router)
    {
        $eventos = Evento::ordenar('hora_id', 'ASC');
        $eventos_formateados = [];

        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id); //categoria
            $evento->dia = Dia::find($evento->dia_id); //dia
            $evento->hora = Hora::find($evento->hora_id); //ponente
            $evento->ponente = Ponente::find($evento->ponente_id); //dia


            if ($evento->dia_id === "1" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_v'][] = $evento;
            }
            if ($evento->dia_id === "2" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_s'][] = $evento;
            }
            if ($evento->dia_id === "1" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_v'][] = $evento;
            }
            if ($evento->dia_id === "2" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_s'][] = $evento;
            }
        }

        $router->render('paginas/conferencias', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_formateados
        ]);
    }
    public static function noticias(Router $router)
    {

        $noticia = Noticia::all();

        $router->render('paginas/noticias', [
            'titulo' => 'Conferencias & Workshops',
            'noticias' => $noticia
        ]);
    }

    public static function error(Router $router)
    {
        $router->render('paginas/error', [
            'titulo' => 'Página no encontrada'
        ]);
    }
    public static function sinrol(Router $router)
    {
        $router->render('paginas/sinrol', [
            'titulo' => 'Página no encontrada'
        ]);
    }
}
