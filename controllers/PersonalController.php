<?php

namespace Controllers;

use MVC\Router;

use Classes\Paginacion;
use Model\Roles;
use Model\Usuario;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PersonalController
{

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
            header('Location: /admin/personal?page=1');
        }

        $por_pagina = 10;
        $total = Usuario::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $personal = Usuario::paginar($por_pagina, $paginacion->offset());

        foreach ($personal as $persona) {
            $persona->rol = Roles::find($persona->rol_id);
        }

        $id_usuario_actual = $_SESSION['id'];
        $router->render('admin/personal/index', [
            'titulo' => 'Personal De Sanigest',
            'personal' => $personal,
            'paginacion' => $paginacion->paginacion(),
            'id_usuario_actual' => $id_usuario_actual

        ]);
    }


    public static function editar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }

        $alertas = [];
        //validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/personal');
        }

        //obtener ponente
        $personal = Usuario::find($id);
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $roles = Roles::all();

        if (!$personal) {
            header('Location: /admin/personal');
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Guardamos temporalmente la contraseña original
            $passwordActual = $personal->password;

            // Sincronizamos los datos del formulario
            $personal->sincronizar($_POST);

            // Validamos los datos
            $alertas = $personal->validar_personal();

            if (empty($alertas)) {
                // Si se ingresó una nueva contraseña, la hasheamos
                if (!empty($_POST['password'])) {
                    $personal->hashPassword();
                } else {
                    // Si no se ingresó, restauramos la contraseña anterior
                    $personal->password = $passwordActual;
                }

                // Guardamos en la base de datos
                $resultado = $personal->guardar();

                if ($resultado) {
                    header("Location: /admin/personal/editar?id=$id&actualizado=1");
                    exit;
                }
            }
        }


        // debuguear($personal);
        $router->render('admin/personal/editar', [
            'titulo' => 'Editar Personal',
            'alertas' => $alertas,
            'personal' => $personal,
            'roles' => $roles,

        ]);
    }

    public static function eliminar()
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
            $personal = Usuario::find($id);

            if (isset($personal)) {
                header('Location: /admin/personal');
            }

            $resultado = $personal->eliminar();
            if ($resultado) {
                $_SESSION['eliminado'] = true; // Guardar en sesión
                header('Location: /admin/personal');
                exit;
            }
        }
    }
    public static function exportarExcel()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        // Obtener todos los usuarios
        $usuarios = Usuario::all('ASC'); // Asegúrate de que tu modelo se llame "Usuario"

        // Cargar relación con rol
        foreach ($usuarios as $u) {
            $u->rol = Roles::find($u->rol_id); // Si el usuario tiene relación con roles
        }

        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setTitle("Usuarios");

        // Encabezados seguros
        $hoja->fromArray([
            'ID',
            'Nombre',
            'Apellido',
            'Email',
            'Confirmado',
            'Rol'
        ], null, 'A1');

        $fila = 2;
        foreach ($usuarios as $u) {
            $confirmado = ($u->confirmado == 1) ? 'Sí' : 'No';
            $rolNombre = $u->rol->nombre ?? '';

            $hoja->setCellValue("A$fila", $u->id);
            $hoja->setCellValue("B$fila", $u->nombre ?? '');
            $hoja->setCellValue("C$fila", $u->apellido ?? '');
            $hoja->setCellValue("D$fila", $u->email ?? '');
            $hoja->setCellValue("E$fila", $confirmado);
            $hoja->setCellValue("F$fila", $rolNombre);
            $fila++;
        }

        // Descargar archivo
        $filename = 'Usuarios_Sanigest.xlsx';

        if (ob_get_length()) {
            ob_end_clean(); 
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
