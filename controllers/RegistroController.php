<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Model\EventosRegistros;
use Model\Regalo;

class RegistroController
{

    public static function crear(Router $router)
    {

        if (!is_auth()) { //verificar inicio de seccion
            header('Location: /auth/login');
            return;
        }
        //verificar si ya se registro
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        if(isset($registro) && ($registro->paquete_id === "3" || $registro->paquete_id === "2" )) {
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }

        if(isset($registro) && $registro->paquete_id === "1") {
            header('Location: /finalizar-registro/conferencias');
            return;
        }

        $router->render('/registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }
    public static function gratis(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) {
                header('Location: /auth/login');
            }
            //verificar registro exitoso 
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if (isset($registro) && $registro->paquete_id === "3") {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            //crear nuevo registro
            $datos = array(
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id'],
            );
            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if ($resultado) {
                header('Location: /boleto?id=' . urlencode($registro->token)); //pasar para crear boleto
            }
        }
    }
    public static function pagar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) {
                header('Location: /auth/login');
            }

            //validar que post no venga vacio 
            if (empty($_POST)) {
                echo json_encode([]);
                return;
            }
            //crear registro
            $datos = $_POST;
            $datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];



            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
        }
    }
    public static function conferencias(Router $router)
    {
        if (!is_auth()) { //inicio de session
            header('Location: /auth/login');
        }

        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);

        if(isset($registro) && $registro->paquete_id === "2") {
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }
        
        if ($registro->paquete_id !== "1") {
            header('Location: /');
            return;
        }
        // Redireccionar a boleto virtual en caso de haber finalizado su registro
        if(isset($registro->regalo_id) && $registro->paquete_id === "1") {
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }


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

        $regalo = Regalo::all('ASC');

        //manejando el registro por post y fetch y asyn 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_auth()) { //inicio de session
                header('Location: /auth/login');
            }

            $eventos = explode(',', $_POST['eventos']);

            if (empty($eventos)) {
                echo json_encode(['resultado' => false]);
                return;
            }
            //obtener demas registros de usuario 
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if (!isset($registro) || $registro->paquete_id !== "1") {
                echo json_encode(['resultado' => false]);
                return;
            }

            $eventos_array = [];
            //validar la disponibilidad de los eventos seleccionados
            foreach ($eventos as $evento_id) {
                $evento = Evento::find($evento_id);

                if (!isset($registro) || $evento->disponibles === "0") { //comprobar que el evento exista y que halla sitios disponibles
                    echo json_encode(['resultado' => false]);
                    return;
                }
                $eventos_array[] = $evento;
            }

            foreach ($eventos_array as $evento) {
                $evento->disponibles -= 1; //disminuir si seleccionas un evento
                $evento->guardar();

                //almacenar en registrados
                $datos_registrados = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];

                $registro_usuario = new EventosRegistros($datos_registrados);
                $registro_usuario->guardar();

                //almacenar el regalo 
                $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
                $resultado = $registro->guardar();

                if ($resultado) {
                    echo json_encode([
                        'resultado' => $resultado,
                        'token' => $registro->token
                    ]);
                } else {
                    echo json_encode(['resultado' => false]);
                }
                return;
            }
        }

        $router->render('registro/conferencias', [
            'titulo' => 'Elije Workshop y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalo
        ]);
    }
    public static function boleto(Router $router)
    {
        //validar url
        //obtener id
        $id = $_GET['id'];

        if (!$id || !strlen($id) === 8) {
            header('Location: /');
        }
        $registro = Registro::where('token', $id);
        if (!$registro) {
            header('Location: /');
        }

        //cruzar informacion 
        $registro->usuario = Usuario::find($registro->usuario_id); //usuario
        $registro->paquete = Paquete::find($registro->paquete_id); //paquete

        $router->render('/registro/boleto', [
            'titulo' => 'Asistencia de SaniGest',
            'registro' => $registro

        ]);
    }
}
