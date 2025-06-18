<?php

namespace Controllers;

use Model\Pago;
use Model\Zona;
use MVC\Router;
use Classes\PDF;
use Model\Predio;
use Model\Recibo;
use Model\Sector;
use Model\Consumo;
use Model\Usuario;
use Classes\Paginacion;
use Model\Contribuyente;

class PagoController
{
    public static function index(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /tesorero/pagos?page=1');
            exit;
        }

        $por_pagina = 50;
        $predios_con_consumo = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = $_POST['criterio'] ?? '';
            $dato = sanitizarBusqueda($_POST['dato'] ?? '');

            if ($criterio && $dato) {
                // Filtrar todos los predios según criterio y dato
                $predios = Predio::buscar($criterio, $dato);

                // De esos, filtrar solo los que tienen consumo
                foreach ($predios as $predio) {
                    $hayConsumo = Consumo::where('predio_id', $predio->id);
                    if (!empty($hayConsumo)) {
                        $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
                        $predio->zona = Zona::find($predio->zona_id);
                        $predio->sector = Sector::find($predio->sector_id);
                        $predio->deudas = Consumo::totalArray(['predio_id' => $predio->id, 'estado_id' => '1']);
                        $predios_con_consumo[] = $predio;
                    }
                }
            }
        } else {
            // Sin búsqueda, cargamos todos los predios con consumo
            $predios = Predio::all();
            foreach ($predios as $predio) {
                $hayConsumo = Consumo::where('predio_id', $predio->id);
                if (!empty($hayConsumo)) {
                    $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
                    $predio->zona = Zona::find($predio->zona_id);
                    $predio->sector = Sector::find($predio->sector_id);
                    $predio->deudas = Consumo::totalArray(['predio_id' => $predio->id, 'estado_id' => '1']);
                    $predios_con_consumo[] = $predio;
                }
            }
        }

        $total_predios = count($predios_con_consumo);
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total_predios);

        // Paginamos el array filtrado
        $offset = $paginacion->offset();
        $predios_paginados = array_slice($predios_con_consumo, $offset, $por_pagina);

        $router->render('tesorero/agua/pagos/index', [
            'titulo' => 'Lista de Predio por Contribuyente para Realizar los Pagos',
            'predios' => $predios_paginados,
            'paginacion' => $paginacion->paginacion(),
        ]);
    }

    public static function detallePagos(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $predio_id = $_GET['predio_id'] ?? null;

        if (!$predio_id) {
            header('Location: /tesorero/pagos');
            exit;
        }

        // Pagos pendientes: consumos con estado_id = 1 (registrado)
        $consumos = Consumo::buscarestricto('predio_id', $predio_id);
        $consumos_pendientes = array_filter($consumos, function ($c) {
            return $c->estado_id == 1;
        });

        // Pagos realizados (JOIN con consumo para obtener predio_id)
        $pagos = Pago::all(); // o usar un método específico
        $pagos_realizados = [];

        foreach ($pagos as $pago) {
            $consumo = Consumo::find($pago->consumo_id);
            if ($consumo && $consumo->predio_id == $predio_id) {
                $pago->mes = $consumo->mes;
                $pago->anio = $consumo->anio;
                $pagos_realizados[] = $pago;
            }
        }

        $router->render('tesorero/agua/pagos/detalle', [
            'titulo' => 'Lista Pagos Realizados y Pendientes',
            'consumos' => $consumos_pendientes,
            'pagos' => $pagos_realizados,
        ]);
    }
    public static function realizarPago(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $alertas = [];
        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header("Location:/tesorero/pagos");
            exit;
        }

        $consumo = Consumo::find($id);
        if (!$consumo) {
            header('Location: /tesorero/pagos');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $existepago = Pago::where('consumo_id', $consumo->id);
            if ($existepago) {
                header('Location: /tesorero/pagos');
                exit;
            } else {
                $pago = new Pago($_POST);
                $pago->consumo_id = $id;

                $anio_actual = date('Y');
                $prefijo = "SG-CO-HUARO-{$anio_actual}-";
                $ultimo_comprobante = Pago::ultimoValor('numero_comprobante', 'pagos', $prefijo);

                if (!$ultimo_comprobante) {
                    $pago->numero_comprobante = $prefijo . '00001';
                } else {
                    $numero = (int) substr($ultimo_comprobante, strlen($prefijo));
                    $numero++;
                    $pago->numero_comprobante = $prefijo . str_pad($numero, 5, '0', STR_PAD_LEFT);
                }


                $pago->usuario_id = $_SESSION['id'] ?? null;
                $pago->mes = $consumo->mes ?? date('n');
                $pago->anio = $consumo->anio ?? date('Y');
                $pago->fecha_pago = $_POST['fecha_pago'] ?? date('Y-m-d');
                $pago->monto_pagado = $_POST['monto_pagado'] ?? $consumo->monto_total;


                $consumo->estado_id = '2';


                $alertas = $pago->validar();

                if (empty($alertas)) {
                    $consumo->guardar();
                    $resultado = $pago->guardar();
                    $id = $resultado['id'];
                    if ($resultado) {
                        $recibo = new Recibo;
                        $recibo->pago_id = $id;
                        $recibo->numero_recibo = $pago->numero_comprobante;
                        $recibo->fecha_emision = date('Y-m-d');
                        $recibo->estado_id = '1';
                        $recibo->guardar();

                        // Obtener datos para el PDF
                        $consumo = Consumo::find($pago->consumo_id);
                        $predio = Predio::find($consumo->predio_id);
                        $contribuyente = $predio ? Contribuyente::find($predio->contribuyente_id) : null;
                        $usuario = Usuario::find($pago->usuario_id);

                        // Generar PDF
                        $nombreArchivo = \Classes\PDF::generarComprobante($pago, $consumo, $contribuyente, $predio, $usuario);
                        $rutaPublica = "/comprobantePago/$nombreArchivo";

                        // Redirigir y abrir PDF
                        echo "
                        <!DOCTYPE html>
                        <html lang='es'>
                        <head><meta charset='UTF-8'><title>Generando Comprobante...</title></head>
                        <body>
                            <p>Haga clic en el botón para ver el comprobante:</p>
                            <form action='/tesorero/pagos/detalle?predio_id={$consumo->predio_id}' method='get' onsubmit=\"window.open('$rutaPublica', '_blank');\">
                                <button type='submit'>Ver Comprobante</button>
                            </form>
                        </body>
                        </html>
                        ";
                        exit;
                    }
                }
            }
        }


        $router->render('tesorero/agua/pagos/pagar', [
            'titulo' => 'Detalle de Deuda',
            'pago' => $consumo,
            'alertas' => $alertas
        ]);
    }
}
