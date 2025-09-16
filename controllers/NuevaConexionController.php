<?php

namespace Controllers;

use Classes\Notificaciones;
use MVC\Router;
use Classes\Paginacion;
use Model\Estados;
use Model\NuevaConexion;
use Model\Usuario;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class NuevaConexionController
{
    public static function index(Router $router)
    {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);


        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/nuevaconexion?page=1');
        }


        $por_pagina = 30;
        $total = NuevaConexion::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $nuevaconexion = NuevaConexion::paginar($por_pagina, $paginacion->offset());



        foreach ($nuevaconexion as $nueva) {
            $nueva->estado_id = Estados::find($nueva->estado_id);
        }

        $router->render('admin/nuevaconexion/index', [
            'titulo' => 'Nuevas Conexiones',
            'nuevaconexion' => $nuevaconexion,
            'paginacion' => $paginacion->paginacion()

        ]);
    }
    public static function revisar(Router $router)
    {

        if (!is_auth()) {
            header('Location: /auth/login');
            return;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            return;
        }
        //validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/nuevaconexion');
        }

        $nueva = NuevaConexion::find($id);

        $nueva->estado_id = Estados::find($nueva->estado_id);

        $id = filter_var($id, FILTER_VALIDATE_INT);

        $tecnico = Usuario::buscar('rol_id', '4');

        $nueva->tecnico_id = Usuario::find($nueva->tecnico_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva->sincronizar($_POST);


            if ($nueva->observacion_rechazo === 'ninguna') {
                $nueva->estado_id = '2';
            } else {
                $nueva->estado_id = '3';
            }
            $resultado = $nueva->guardar();

            //notificacion a tecnico
            $idTecnico = $nueva->tecnico_id;
            $tecnicoAsignado = Usuario::find($idTecnico);

            $notificacion = new Notificaciones($tecnicoAsignado->email, $tecnicoAsignado->nombre, $tecnicoAsignado->apellido);
            $notificacion->enviarAsignacionNuevaConexion($nueva->direccion_principal);

            if ($resultado) {
                header("Location: /admin/nuevaconexion");
                exit;
            }
        }

        $router->render('admin/nuevaconexion/revisar', [
            'titulo' => '',
            'nueva' => $nueva,
            'tecnico' => $tecnico

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
        $solicitudes = NuevaConexion::all('ASC'); // Ajusta el modelo si tiene otro nombre

        // Cargar relaciones necesarias
        foreach ($solicitudes as $s) {
            $s->estado = Estados::find($s->estado_id);
            $s->tecnico = Usuario::find($s->tecnico_id);
        }

        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setTitle("Solicitudes");

        // Encabezados sin campos de imagen
        $hoja->fromArray([
            'ID',
            'Tipo Solicitante',
            'Tipo Persona',
            'Tipo Doc. Natural',
            'N° Doc. Natural',
            'Tipo Doc. Jurídico',
            'N° Doc. Jurídico',
            'Razón Social',
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Email',
            'Tipo Servicio',
            'Servicio',
            'Celular',
            'Localidad',
            'Dirección Principal',
            'Referencia Dirección',
            'Fecha Solicitud',
            'Estado',
            'Técnico Asignado',
            'Código Seguimiento',
            'Observación Rechazo'
        ], null, 'A1');

        $fila = 2;
        foreach ($solicitudes as $s) {
            $hoja->setCellValue("A$fila", $s->id);
            $hoja->setCellValue("B$fila", $s->tipo_solicitante ?? '');
            $hoja->setCellValue("C$fila", $s->tipo_persona ?? '');
            $hoja->setCellValue("D$fila", $s->tipo_documento_natural ?? '');
            $hoja->setCellValue("E$fila", $s->numero_documento_natural ?? '');
            $hoja->setCellValue("F$fila", $s->tipo_documento_juridico ?? '');
            $hoja->setCellValue("G$fila", $s->numero_documento_juridico ?? '');
            $hoja->setCellValue("H$fila", $s->razon_social ?? '');
            $hoja->setCellValue("I$fila", $s->nombre ?? '');
            $hoja->setCellValue("J$fila", $s->apellido1 ?? '');
            $hoja->setCellValue("K$fila", $s->apellido2 ?? '');
            $hoja->setCellValue("L$fila", $s->email ?? '');
            $hoja->setCellValue("M$fila", $s->tipo_servicio ?? '');
            $hoja->setCellValue("N$fila", $s->servicio ?? '');
            $hoja->setCellValue("O$fila", $s->celular ?? '');
            $hoja->setCellValue("P$fila", $s->localidad ?? '');
            $hoja->setCellValue("Q$fila", $s->direccion_principal ?? '');
            $hoja->setCellValue("R$fila", $s->referencia_direccion ?? '');
            $hoja->setCellValue("S$fila", $s->fecha_solicitud ?? '');
            $hoja->setCellValue("T$fila", $s->estado->nombre ?? '');
            $hoja->setCellValue("U$fila", trim(($s->tecnico->nombre ?? '') . ' ' . ($s->tecnico->apellido ?? '')));
            $hoja->setCellValue("V$fila", $s->codigo_seguimiento ?? '');
            $hoja->setCellValue("W$fila", $s->observacion_rechazo ?? '');
            $fila++;
        }

        // Descargar archivo
        $filename = 'Solicitudes_NuevaConexion.xlsx';
        
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
