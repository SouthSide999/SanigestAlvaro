<?php

namespace Controllers;

use Model\Zona;
use MVC\Router;
use Model\Predio;
use Model\Sector;
use Model\Tarifa;
use Model\Cliente;
use Model\Contribuyente;
use Classes\Notificaciones;

class PerfilUserController
{
    public static function perfil(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        if (!is_usuario()) {
            header('Location: /auth/login');
            return;
        }

        $id = $_SESSION['id'];
        $cliente = Cliente::find($id);

        // Obtener el predio asociado si existe
        $predio = null;
        if ($cliente->codigo_predio) {
            $predio = Predio::find($cliente->codigo_predio);
            $predio->zona = Zona::find($predio->zona_id);
            $predio->sector = Sector::find($predio->sector_id);
            $predio->tarifa = Tarifa::find($predio->tarifa_id);
            $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Guardamos temporalmente la contraseña original
            $passwordActual = $cliente->password;

            // Sincronizamos los datos del formulario
            $cliente->sincronizar($_POST);

            // Si se ingresó una nueva contraseña, la hasheamos
            if (!empty($_POST['password'])) {
                $cliente->hashPassword();
            } else {
                // Si no se ingresó, restauramos la contraseña anterior
                $cliente->password = $passwordActual;
            }

            //notificacion a cliente
            $notificacion = new Notificaciones($cliente->email, $cliente->nombre, $cliente->apellido);
            $notificacion->enviarActualizacionCuentaCliente($_POST['password']);
            
            // Guardamos en la base de datos
            $resultado = $cliente->guardar();

            if ($resultado) {
                $_SESSION['exito'] = true; // Esto activa el SweetAlert
                header("Location: /user/perfil");
                exit;
            }
        }

        // Renderizamos la vista
        $router->render('user/perfil/perfil', [
            'titulo' => 'Perfil',
            'cliente' => $cliente,
            'predio' => $predio
        ]);
    }
}
