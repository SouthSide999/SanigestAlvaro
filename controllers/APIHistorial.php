<?php

namespace Controllers;

use Model\Consumo;


class APIHistorial
{

    public static function index()
    {
        if (!is_auth() || !is_usuario()) {
            header('Location: /');
            return;
        }

        $historial = Consumo::buscarestricto('predio_id', $_SESSION['codigo_predio']);

        echo json_encode($historial);
        return;
    }
}
