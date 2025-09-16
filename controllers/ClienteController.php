<?php

namespace Controllers;

use MVC\Router;
use Model\Predio;
use Model\Cliente;
use Classes\Paginacion;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ClienteController
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

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/cliente?page=1');
            return;
        }

        $por_pagina = 20;
        $total = Cliente::total(); // Debes tener este método en tu modelo Cliente
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);

        $clientes = Cliente::paginar($por_pagina, $paginacion->offset());

        $router->render('admin/clientes/index', [
            'titulo' => 'Clientes de Sanigest',
            'clientes' => $clientes,
            'paginacion' => $paginacion->paginacion()
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

        // Validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/clientes');
        }

        // Obtener cliente
        $cliente = Cliente::find($id);
        if (!$cliente) {
            header('Location: /admin/clientes');
        }


        $predios = Predio::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $passwordActual = $cliente->password;

            $cliente->sincronizar($_POST);
            $alertas = $cliente->validar_cliente();

            if (empty($alertas)) {
                if (!empty($_POST['password'])) {
                    $cliente->hashPassword();
                } else {
                    $cliente->password = $passwordActual;
                }
                $existePorPredio = Cliente::where('codigo_predio', $cliente->codigo_predio);

                if ($existePorPredio && $existePorPredio->id !== $cliente->id) {
                    // Ya existe otro cliente con ese código de predio
                    Cliente::setAlerta('error', 'Ya existe un cliente registrado con ese código de predio.');
                    $alertas = Cliente::getAlertas();
                } else {
                    $resultado = $cliente->guardar();
                }


                if ($resultado) {
                    header("Location: /admin/cliente/editar?id=$id&actualizado=1");
                    exit;
                }
            }
        }

        $router->render('admin/clientes/editar', [
            'titulo' => 'Editar Cliente',
            'cliente' => $cliente,
            'predios' => $predios, // Mandamos todos los predios disponibles
            'alertas' => $alertas
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
            $cliente = Cliente::find($id);

            if (!$cliente) {
                // Si no se encuentra el cliente con ese ID, redirigir
                header('Location: /admin/clientes');
                return;
            }

            $resultado = $cliente->eliminar();

            if ($resultado) {
                $_SESSION['eliminado'] = true; // Guardar en sesión para mensaje
                header('Location: /admin/cliente');
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

        // Obtener todos los clientes
        $clientes = Cliente::all('ASC'); // Asegúrate de tener un modelo Cliente

        // Cargar relación con predio si deseas mostrar su código
        foreach ($clientes as $c) {
            $c->predio = Predio::find($c->codigo_predio); // Ajusta si usas otro nombre
        }

        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setTitle("Clientes");

        // Encabezados
        $hoja->fromArray([
            'ID',
            'Nombre',
            'Apellido',
            'Email',
            'DNI',
            'Celular',
            'Código Predio'
        ], null, 'A1');

        // Llenar datos
        $fila = 2;
        foreach ($clientes as $c) {
            $hoja->setCellValue("A$fila", $c->id);
            $hoja->setCellValue("B$fila", $c->nombre ?? '');
            $hoja->setCellValue("C$fila", $c->apellido ?? '');
            $hoja->setCellValue("D$fila", $c->email ?? '');
            $hoja->setCellValue("E$fila", $c->dni ?? '');
            $hoja->setCellValue("F$fila", $c->celular ?? '');
            $hoja->setCellValue("G$fila", $c->predio->codigo_predio ?? $c->codigo_predio);
            $fila++;
        }

        // Descargar archivo
        $filename = 'Clientes_Sanigest.xlsx';

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
