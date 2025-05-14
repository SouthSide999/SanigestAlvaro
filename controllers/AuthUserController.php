<?php

namespace Controllers;

use MVC\Router;
use Model\Predio;
use Model\Cliente;
use Classes\Notificaciones;

class AuthUserController
{
    public static function login(Router $router)
    {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $cliente = new Cliente($_POST);
            $alertas = $cliente->validarLogin();
            if (empty($alertas)) {

                $cliente = Cliente::where('email', $cliente->email);
                if (!$cliente) {
                    Cliente::setAlerta('error', 'El CLiente No Existe');
                } else {
                    // El Usuario existe
                    if (password_verify($_POST['password'], $cliente->password)) {

                        // Iniciar la sesión
                        session_start();
                        $_SESSION['id'] = $cliente->id;
                        $_SESSION['nombre'] = $cliente->nombre;
                        $_SESSION['apellido'] = $cliente->apellido;
                        $_SESSION['email'] = $cliente->email;
                        $_SESSION['codigo_predio'] = $cliente->codigo_predio;
                        $_SESSION['usuario'] = true;


                        header('Location: /user/dashboard');
                    } else {
                        Cliente::setAlerta('error', 'Password Incorrecto');
                    }
                }
            }
        }
        $alertas = Cliente::getAlertas();
        // Render a la vista 
        $router->render('user/auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas

        ]);
    }
    public static function registro(Router $router)
    {
        $alertas = [];
        $cliente = new Cliente;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $cliente->sincronizar($_POST);

            // Validar campos
            $alertas = $cliente->validar_cuenta();

            if (empty($alertas)) {
                // Verificar si el código de predio ya está registrado
                $existePredio = Predio::where('codigo_predio', $cliente->codigo_predio);

                // Verificar si ya existe un cliente con el mismo código de predio
                $existePorPredio = Cliente::where('codigo_predio', $existePredio->id);

                // Verificar si ya existe un cliente con el mismo email
                $existePorEmail = Cliente::where('email', $cliente->email);

                if (!$existePredio) {
                    // Si el predio no existe, agregar alerta
                    Cliente::setAlerta('error', 'El código de predio no existe.');
                    $alertas = Cliente::getAlertas();
                } elseif ($existePorPredio) {
                    // Si el cliente ya está registrado con ese código de predio
                    Cliente::setAlerta('error', 'Ya existe un cliente registrado con ese código de predio.');
                    $alertas = Cliente::getAlertas();
                } elseif ($existePorEmail) {
                    // Si ya existe un cliente con el mismo email
                    Cliente::setAlerta('error', 'El email ya está registrado.');
                    $alertas = Cliente::getAlertas();
                } else {
                    // Hashear el password
                    $cliente->hashPassword();

                    // Eliminar password2 antes de guardar
                    unset($cliente->password2);
                    //guarda el predio
                    $cliente->codigo_predio = $existePredio->id;
                    //notificacion a cliente
                    $notificacion = new Notificaciones($cliente->email, $cliente->nombre, $cliente->apellido);
                    $notificacion->enviarBienvenidaCliente();

                    // Guardar el cliente en la base de datos
                    $resultado = $cliente->guardar();

                    if ($resultado) {
                        $_SESSION['registro_exitoso'] = true;
                        header('Location: /loginUser');
                        exit;
                    }
                }
            }
        }

        // Renderizar la vista
        $router->render('user/auth/login', [
            'titulo' => 'Crea tu cuenta en SaniGest',
            'cliente' => $cliente,
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
    }
}
