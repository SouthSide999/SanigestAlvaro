<?php

namespace Controllers;

use Model\Zona;
use MVC\Router;
use Model\Predio;
use Model\Sector;
use Model\Tarifa;
use Model\Medidor;
use Model\Conexion;
use Classes\Paginacion;
use Model\Contribuyente;
use Model\EstadoServicio;

class AguaPotableTesoreroController
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
        $router->render('tesorero/agua/dashboard/index', [
            'titulo' => 'Menu Agua Potable'
        ]);
    }

    //*contribuyentes
    // contribuyentes
    public static function contribuyentes(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $contribuyentes = [];
        $total = 0;
        $paginacion = '';

        // Búsqueda por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = $_POST['criterio'] ?? '';
            $dato = sanitizarBusqueda($_POST['dato'] ?? '');

            if ($criterio && $dato) {
                $contribuyentes = Contribuyente::buscar($criterio, $dato);
            }
        } else {
            // Paginación por GET
            $pagina_actual = $_GET['page'] ?? 1;
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
            if (!$pagina_actual || $pagina_actual < 1) {
                header('Location: /tesorero/contribuyentes?page=1');
                exit;
            }

            $por_pagina = 20;
            $total = Contribuyente::total();
            $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
            $contribuyentes = Contribuyente::paginar($por_pagina, $paginacion->offset());
            $paginacion = $paginacion->paginacion();
        }

        $router->render('tesorero/agua/contribuyentes/index', [
            'titulo' => 'Contribuyentes',
            'contribuyentes' => $contribuyentes,
            'paginacion' => $paginacion
        ]);
    }

    public static function contribuyenteEditar(Router $router)
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
        // Validar ID
        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /tesorero/contribuyentes');
            exit;
        }

        $contribuyente = Contribuyente::find($id);
        if (!$contribuyente) {
            header('Location: /tesorero/contribuyentes');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contribuyente->sincronizar($_POST);
            $alertas = $contribuyente->validar();

            if (empty($alertas)) {
                $resultado = $contribuyente->guardar();

                if ($resultado) {
                    header("Location: /tesorero/contribuyentes/editar?id=$id&actualizado=1");
                    exit;
                }
            }
        }

        $router->render('tesorero/agua/contribuyentes/editar', [
            'titulo' => 'Editar Contribuyente',
            'alertas' => $alertas,
            'contribuyente' => $contribuyente
        ]);
    }
    public static function contribuyenteCrear(Router $router)
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
        $contribuyente = new Contribuyente;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Generación del código de contribuyente
            if (empty($_POST['codigo_contribuyente'])) {
                $ultimo_codigo = Contribuyente::ultimoValor('codigo_contribuyente', 'contribuyentes');
                if (!$ultimo_codigo) {
                    $contribuyente->codigo_contribuyente = 'COSG00001';
                } else {
                    $numero = (int) substr($ultimo_codigo, 4);
                    $numero++;
                    $contribuyente->codigo_contribuyente = 'COSG' . str_pad($numero, 5, '0', STR_PAD_LEFT);
                }
            }

            // Sincronizar los datos del formulario con el objeto contribuyente
            $contribuyente->sincronizar($_POST);

            // Validar los datos
            $alertas = $contribuyente->validar();
            if (empty($alertas)) {
                // Guardar el nuevo contribuyente
                $contribuyente->guardar();
                header('Location: /tesorero/contribuyentes/crear?creado=1');
                exit;
            }
        }

        $router->render('tesorero/agua/contribuyentes/crear', [
            'titulo' => 'Registrar Contribuyente',
            'contribuyente' => $contribuyente,
            'alertas' => $alertas
        ]);
    }

    public static function contribuyenteEliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $contribuyente = Contribuyente::find($id);

            if ($contribuyente) {
                $predios = Predio::whereArray(['contribuyente_id' => $id]);

                if (!empty($predios)) {
                    $_SESSION['error'] = 'No se puede eliminar el contribuyente porque tiene predios asociados.';
                } else {
                    $contribuyente->eliminar();
                    $_SESSION['eliminado'] = 'Contribuyente eliminado correctamente.';
                }

                header('Location: /tesorero/contribuyentes');
                exit;
            }
        }
    }

    //*predios
    // Listar y buscar predios
    public static function predios(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $predios = [];
        $total = 0;
        $paginacion = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $criterio = $_POST['criterio'] ?? '';
            $dato = sanitizarBusqueda($_POST['dato'] ?? '');

            if ($criterio && $dato) {
                // Búsqueda normal (LIKE)
                $predios = Predio::buscar($criterio, $dato);

                foreach ($predios as $predio) {
                    $predio->zona = Zona::find($predio->zona_id);
                    $predio->sector = Sector::find($predio->sector_id);
                    $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
                    $predio->estado_servicio = EstadoServicio::find($predio->estado_servicio_id);
                }
            }
        } else {
            $pagina_actual = $_GET['page'] ?? 1;
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
            if (!$pagina_actual || $pagina_actual < 1) {
                header('Location: /admin/predios?page=1');
            }

            $por_pagina = 20;
            $total = Predio::total();
            $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
            $predios = Predio::paginar($por_pagina, $paginacion->offset());
            foreach ($predios as $predio) {
                $predio->zona = Zona::find($predio->zona_id);
                $predio->sector = Sector::find($predio->sector_id);
                $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
                $predio->estado_servicio = EstadoServicio::find($predio->estado_servicio_id);
            }
            $paginacion = $paginacion->paginacion();
        }

        $router->render('tesorero/agua/predios/index', [
            'titulo' => 'Predios',
            'predios' => $predios,
            'paginacion' => $paginacion
        ]);
    }

    // Crear predio
    public static function predioCrear(Router $router)
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
        $predio = new Predio;
        $zonas = Zona::all();
        $sectores = Sector::all();
        $tarifas = Tarifa::all();
        $contribuyentes = Contribuyente::all();
        $estado = EstadoServicio::all();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['codigo_predio'])) {
                $ultimo_codigo = Predio::ultimoValor('codigo_predio', 'predios');
                $predio->codigo_predio = $ultimo_codigo ? 'PESG' . str_pad((int)substr($ultimo_codigo, 4) + 1, 5, '0', STR_PAD_LEFT) : 'PESG00001';
            }

            $ultimo_secuencia = Predio::ultimoValor('secuencia', 'predios');
            $predio->secuencia = $ultimo_secuencia ? 'SE' . str_pad((int)substr($ultimo_secuencia, 2) + 1, 4, '0', STR_PAD_LEFT) : 'SE0001';

            $predio->sincronizar($_POST);
            $alertas = $predio->validar();

            if (empty($alertas)) {
                $predio->guardar();
                header('Location: /tesorero/predios/crear?creado=1');
                exit;
            }
        }

        $router->render('tesorero/agua/predios/crear', [
            'titulo' => 'Registrar Predio',
            'predio' => $predio,
            'zonas' => $zonas,
            'sectores' => $sectores,
            'contribuyentes' => $contribuyentes,
            'tarifas' => $tarifas,
            'alertas' => $alertas,
            'estado' => $estado

        ]);
    }

    // Editar predio
    public static function predioEditar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        $predio = Predio::find($id);
        if (!$predio) {
            header('Location: /tesorero/predios');
            exit;
        }

        $tarifas = Tarifa::all();
        $zonas = Zona::all();
        $sectores = Sector::all();
        $contribuyentes = Contribuyente::all();
        $estado = EstadoServicio::all();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $predio->sincronizar($_POST);
            $alertas = $predio->validar();

            if (empty($alertas)) {
                $predio->guardar();
                header("Location: /tesorero/predios/editar?id=$id&actualizado=1");
                exit;
            }
        }

        $router->render('tesorero/agua/predios/editar', [
            'titulo' => 'Editar Predio',
            'predio' => $predio,
            'zonas' => $zonas,
            'sectores' => $sectores,
            'contribuyentes' => $contribuyentes,
            'tarifas' => $tarifas,
            'alertas' => $alertas,
            'estado' => $estado

        ]);
    }

    // Eliminar predio
    public static function predioEliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $predio = Predio::find($id);

            if ($predio) {
                $medidores = Medidor::whereArray(['predio_id' => $id]);
                $conexiones = Conexion::whereArray(['predio_id' => $id]);

                if (!empty($medidores) || !empty($conexiones)) {
                    $_SESSION['error'] = 'No se puede eliminar el predio porque tiene medidores o conexiones asociadas.';
                } else {
                    $predio->eliminar();
                    $_SESSION['eliminado'] = 'Predio eliminado correctamente.';
                }

                header('Location: /tesorero/predios');
                exit;
            }
        }
    }

    //resumen
    public static function resumen(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $registros = [];
        $total = 0;
        $paginacion = '';

        // Búsqueda por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = $_POST['criterio'] ?? '';
            $dato = $_POST['dato'] ?? '';

            if ($criterio && $dato) {
                // Buscar en Predio si es direccion o codigo_predio
                if ($criterio === 'direccion' || $criterio === 'codigo_predio') {
                    $registros = Predio::buscar($criterio, $dato); // Método debe estar en el modelo Predio
                    foreach ($registros as $registro) {
                        $registro->contribuyente = Contribuyente::find($registro->contribuyente_id);
                    }
                }

                // Buscar en Contribuyente si es nombres, apellidos o codigo_contribuyente
                if ($criterio === 'nombres' || $criterio === 'apellidos' || $criterio === 'codigo_contribuyente') {
                    $contribuyentes = Contribuyente::buscar($criterio, $dato); // Método en modelo Contribuyente
                    foreach ($contribuyentes as $contribuyente) {
                        $predios = Predio::buscar('contribuyente_id', $contribuyente->id); // Método que retorna predios por contribuyente_id
                        foreach ($predios as $predio) {
                            $predio->contribuyente = $contribuyente;
                            $registros[] = $predio;
                        }
                    }
                }
            }
        } else {
            // Paginación por GET
            $pagina_actual = $_GET['page'] ?? 1;
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

            if (!$pagina_actual || $pagina_actual < 1) {
                header('Location: /tesorero/registros?page=1');
                exit;
            }

            $por_pagina = 20;
            $total = Predio::total();
            $paginacion_obj = new Paginacion($pagina_actual, $por_pagina, $total);
            $registros = Predio::paginar($por_pagina, $paginacion_obj->offset());

            foreach ($registros as $registro) {
                $registro->contribuyente = Contribuyente::find($registro->contribuyente_id);
            }

            $paginacion = $paginacion_obj->paginacion();
        }

        $router->render('tesorero/agua/resumen/index', [
            'titulo' => 'Registros Resumen',
            'registros' => $registros,
            'paginacion' => $paginacion
        ]);
    }

    public static function resumenEditar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_tesorero()) {
            header('Location: /auth/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        $predio = Predio::find($id);
        $tarifas = Tarifa::all();
        $zonas = Zona::all();
        $sectores = Sector::all();
        $contribuyentes = Contribuyente::all();
        $estado = EstadoServicio::all();
        // Buscar medidor y conexión por predio_id, no por id directo
        $medidor = Medidor::where('predio_id', $id) ?? new Medidor();
        $conexion = Conexion::where('predio_id', $id) ?? new Conexion();

        $alertas = [];

        if (!$predio) {
            header('Location: /tesorero/predios');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar los datos
            $predio->sincronizar($_POST);
            $medidor->sincronizar($_POST);
            $conexion->sincronizar($_POST);

            // Asignar el predio_id si es nuevo
            $medidor->predio_id = $predio->id;
            $conexion->predio_id = $predio->id;

            // Validaciones combinadas
            $alertas = array_merge(
                $predio->validar(),
                $medidor->validar(),
                $conexion->validar()
            );

            if (empty($alertas)) {
                $predio->guardar();
                $medidor->guardar();
                $conexion->guardar();

                header("Location: /tesorero/resumen");
                exit;
            }
        }

        $router->render('tesorero/agua/resumen/editar', [
            'titulo' => 'Detalle Completo',
            'predio' => $predio,
            'zonas' => $zonas,
            'sectores' => $sectores,
            'contribuyentes' => $contribuyentes,
            'tarifas' => $tarifas,
            'medidor' => $medidor,
            'conexion' => $conexion,
            'estado' => $estado,
            'alertas' => $alertas
        ]);
    }
}
