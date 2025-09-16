<?php

namespace Controllers;


use MVC\Router;
use Model\Estados;
use Model\Usuario;
use Model\Solicitud;
use Classes\Paginacion;
use Model\TiposSolicitud;
use Classes\Notificaciones;
use Model\Roles;
use Model\TiposReclamos;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class SolicitudController
{
    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }
        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/solicitudes?page=1');
            exit;
        }

        $por_pagina = 30;
        $total = Solicitud::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $solicitudes = Solicitud::paginar($por_pagina, $paginacion->offset());

        foreach ($solicitudes as $solicitud) {
            $solicitud->estado = Estados::find($solicitud->estado_id);
            $solicitud->tipo_solicitud = TiposSolicitud::find($solicitud->tipo_solicitud_id);
        }

        $router->render('admin/solicitudes/index', [
            'titulo' => 'Solicitudes Registradas',
            'solicitudes' => $solicitudes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
    public static function revisar(Router $router)
    {
        // Verificar si el usuario está autenticado
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        // Verificar si el usuario tiene rol de administrador
        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }

        // Validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/solicitudes');
            return;
        }

        // Buscar la solicitud por ID
        $solicitud = Solicitud::find($id);

        // Cargar el estado de la solicitud
        $solicitud->estado_id = Estados::find($solicitud->estado_id);
        $solicitud->tipo_solicitud = TiposSolicitud::find($solicitud->tipo_solicitud_id);

        // Buscar el técnico asignado (si existe)
        $personal = Usuario::all();
        foreach ($personal as $persona) {
            $persona->rol_id = Roles::find($persona->rol_id);
        }
        $solicitud->personal_asignado = Usuario::find($solicitud->personal_asignado);

        // Procesar la solicitud si se envía un POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $solicitud->sincronizar($_POST);
            // Actualizar el estado de la solicitud según la observación
            if ($solicitud->observaciones === 'ninguna') {
                $solicitud->estado_id = '4'; // Estado aceptado o algo similar
            } else {
                $solicitud->personal_asignado = '1';
                $solicitud->estado_id = '3'; // Estado rechazado o algo similar
            }

            // Guardar los cambios
            $resultado = $solicitud->guardar();

            // Enviar notificación al técnico asignado
            $idPersonal = $solicitud->personal_asignado;
            $tecnicoAsignado = Usuario::find($idPersonal);


            // Crear y enviar la notificación
            $notificacion = new Notificaciones($tecnicoAsignado->email, $tecnicoAsignado->nombre, $tecnicoAsignado->apellido);
            $notificacion->enviarAsignacionSolicitud($solicitud->tipo_solicitud->nombre, $solicitud->descripcion);

            // Si la solicitud se guarda correctamente, redirigir
            if ($resultado) {
                header("Location: /admin/solicitudes?mensaje=asignado");
                exit;
            }
        }

        // Renderizar la vista de revisar solicitud
        $router->render('admin/solicitudes/revisar', [
            'titulo' => 'Revisar Solicitud',
            'solicitud' => $solicitud,
            'personal' => $personal
        ]);
    }
    public static function lista(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /tesorero/solicitudes?page=1');
            exit;
        }
        $id = $_SESSION["id"];
        $usuariorol = $_SESSION["rol_id"];

        $solicitudes = Solicitud::buscarestricto('personal_asignado', $id);


        foreach ($solicitudes as $solicitud) {
            $solicitud->estado = Estados::find($solicitud->estado_id);
            $solicitud->tipo_solicitud = TiposSolicitud::find($solicitud->tipo_solicitud_id);
        }

        $router->render('solicitudes/index', [
            'titulo' => 'Solicitudes Registradas',
            'solicitudes' => $solicitudes,
            'usuariorol' => $usuariorol
        ]);
    }
    public static function finalizar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /tesorero/solicitudes');
            exit;
        }
        $usuariorol = $_SESSION["rol_id"];

        $solicitud = Solicitud::find($id);
        if (!$solicitud) {
            header('Location: /tesorero/solicitudes');
            exit;
        }
        $solicitud->estado = Estados::find($solicitud->estado_id);
        $solicitud->personal = Usuario::find($solicitud->personal_asignado);
        $solicitud->tipo = TiposSolicitud::find($solicitud->tipo_solicitud_id);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $solicitud->sincronizar($_POST);
            $notificacion = new Notificaciones(
                $solicitud->email,
                $solicitud->nombres,
                $solicitud->apellidos
            );


            if ($solicitud->estado_id === '3') {
                $solicitud->personal_asignado = 1; // Reasignar al técnico con ID 100
                $notificacion->enviarSolicitudRechazadaCliente($tipo->nombre, $solicitud->descripcion, $solicitud->observaciones);
            } else {
                $solicitud->estado_id = '5';
                $solicitud->observaciones = $_POST['observacionesConcluido'];
                // Observado / Rechazado
                $notificacion->enviarSolicitudFinalizadaCliente($solicitud->tipo->nombre, $solicitud->descripcion, $solicitud->observaciones);
            }
            $resultado = $solicitud->guardar();

            if ($resultado) {
                $_SESSION['exito'] = true;
                header('Location: /tesorero/solicitudes');
                exit;
            }
        }

        $router->render('/solicitudes/finalizar', [
            'titulo' => 'Gestión de Solicitud',
            'solicitud' => $solicitud,
            'usuariorol' => $usuariorol

        ]);
    }
    public static function listatecnico(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /tecnico/solicitudes?page=1');
            exit;
        }
        $id = $_SESSION["id"];
        $usuariorol = $_SESSION["rol_id"];

        $solicitudes = Solicitud::buscarestricto('personal_asignado', $id);


        foreach ($solicitudes as $solicitud) {
            $solicitud->estado = Estados::find($solicitud->estado_id);
            $solicitud->tipo_solicitud = TiposSolicitud::find($solicitud->tipo_solicitud_id);
        }

        $router->render('solicitudes/index', [
            'titulo' => 'Solicitudes Registradas',
            'solicitudes' => $solicitudes,
            'usuariorol' => $usuariorol
        ]);
    }
    public static function finalizartecnico(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /tecnico/solicitudes');
            exit;
        }
        $usuariorol = $_SESSION["rol_id"];

        $solicitud = Solicitud::find($id);
        if (!$solicitud) {
            header('Location: /tecnico/solicitudes');
            exit;
        }
        $solicitud->estado = Estados::find($solicitud->estado_id);
        $solicitud->personal = Usuario::find($solicitud->personal_asignado);
        $solicitud->tipo = TiposSolicitud::find($solicitud->tipo_solicitud_id);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $solicitud->sincronizar($_POST);
            $notificacion = new Notificaciones(
                $solicitud->email,
                $solicitud->nombres,
                $solicitud->apellidos
            );


            if ($solicitud->estado_id === '3') {
                $solicitud->personal_asignado = 1; // Reasignar al técnico con ID 100
                $notificacion->enviarSolicitudRechazadaCliente($tipo->nombre, $solicitud->descripcion, $solicitud->observaciones);
            } else {
                $solicitud->estado_id = '5';
                $solicitud->observaciones = $_POST['observacionesConcluido'];
                // Observado / Rechazado
                $notificacion->enviarSolicitudFinalizadaCliente($solicitud->tipo->nombre, $solicitud->descripcion, $solicitud->observaciones);
            }
            $resultado = $solicitud->guardar();

            if ($resultado) {
                $_SESSION['exito'] = true;
                header('Location: /tecnico/solicitudes');
                exit;
            }
        }

        $router->render('/solicitudes/finalizar', [
            'titulo' => 'Gestión de Solicitud',
            'solicitud' => $solicitud,
            'usuariorol' => $usuariorol

        ]);
    }
    public static function listalecturador(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /lecturador/solicitudes?page=1');
            exit;
        }

        $id = $_SESSION["id"];
        $usuariorol = $_SESSION["rol_id"];

        $solicitudes = Solicitud::buscarestricto('personal_asignado', $id);

        foreach ($solicitudes as $solicitud) {
            $solicitud->estado = Estados::find($solicitud->estado_id);
            $solicitud->tipo_solicitud = TiposSolicitud::find($solicitud->tipo_solicitud_id);
        }

        $router->render('solicitudes/index', [
            'titulo' => 'Solicitudes Registradas',
            'solicitudes' => $solicitudes,
            'usuariorol' => $usuariorol
        ]);
    }
    public static function finalizarlecturador(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }

        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /lecturador/solicitudes');
            exit;
        }

        $usuariorol = $_SESSION["rol_id"];
        $solicitud = Solicitud::find($id);

        if (!$solicitud) {
            header('Location: /lecturador/solicitudes');
            exit;
        }

        $solicitud->estado = Estados::find($solicitud->estado_id);
        $solicitud->personal = Usuario::find($solicitud->personal_asignado);
        $solicitud->tipo = TiposSolicitud::find($solicitud->tipo_solicitud_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $solicitud->sincronizar($_POST);
            $notificacion = new Notificaciones(
                $solicitud->email,
                $solicitud->nombres,
                $solicitud->apellidos
            );

            if ($solicitud->estado_id === '3') {
                $solicitud->personal_asignado = 1;
                $notificacion->enviarSolicitudRechazadaCliente(
                    $solicitud->tipo->nombre,
                    $solicitud->descripcion,
                    $solicitud->observaciones
                );
            } else {
                $solicitud->estado_id = '5';
                $solicitud->observaciones = $_POST['observacionesConcluido'];
                $notificacion->enviarSolicitudFinalizadaCliente(
                    $solicitud->tipo->nombre,
                    $solicitud->descripcion,
                    $solicitud->observaciones
                );
            }

            $resultado = $solicitud->guardar();

            if ($resultado) {
                $_SESSION['exito'] = true;
                header('Location: /lecturador/solicitudes');
                exit;
            }
        }

        $router->render('/solicitudes/finalizar', [
            'titulo' => 'Gestión de Solicitud',
            'solicitud' => $solicitud,
            'usuariorol' => $usuariorol
        ]);
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

        // Obtener todas las solicitudes
        $solicitudes = Solicitud::all('ASC'); // Ajusta si tu modelo tiene otro nombre

        // Cargar relaciones
        foreach ($solicitudes as $s) {
            $s->tipo = TiposSolicitud::find($s->tipo_solicitud_id);
            $s->estado = Estados::find($s->estado_id);
            $s->personal = Usuario::find($s->personal_asignado);
        }

        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setTitle("Solicitudes");

        // Encabezados (sin campo evidencia)
        $hoja->fromArray([
            'ID',
            'Nombres',
            'Apellidos',
            'DNI',
            'Email',
            'Tipo de Solicitud',
            'Descripción',
            'Fecha',
            'Estado',
            'Personal Asignado',
            'Código de Seguimiento',
            'Observaciones'
        ], null, 'A1');

        // Llenar datos
        $fila = 2;
        foreach ($solicitudes as $s) {
            $hoja->setCellValue("A$fila", $s->id);
            $hoja->setCellValue("B$fila", $s->nombres ?? '');
            $hoja->setCellValue("C$fila", $s->apellidos ?? '');
            $hoja->setCellValue("D$fila", $s->dni ?? '');
            $hoja->setCellValue("E$fila", $s->email ?? '');
            $hoja->setCellValue("F$fila", $s->tipo->nombre ?? '');
            $hoja->setCellValue("G$fila", $s->descripcion ?? '');
            $hoja->setCellValue("H$fila", $s->fecha ?? '');
            $hoja->setCellValue("I$fila", $s->estado->nombre ?? '');
            $hoja->setCellValue("J$fila", trim(($s->personal->nombre ?? '') . ' ' . ($s->personal->apellido ?? '')));
            $hoja->setCellValue("K$fila", $s->codigo_seguimiento ?? '');
            $hoja->setCellValue("L$fila", $s->observaciones ?? '');
            $fila++;
        }

        // Descargar archivo
        $filename = 'Solicitudes_Sanigest.xlsx';

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
