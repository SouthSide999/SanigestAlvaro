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

class AguaPotableController
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
        $router->render('admin/agua/dashboard/index', [
            'titulo' => 'Menu Agua Potable'
        ]);
    }

    //*contribuyentes
    public static function contribuyentes(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $contribuyentes = [];
        $total = 0;
        $paginacion = '';

        // Búsqueda por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = $_POST['criterio'] ?? '';
            $dato = $_POST['dato'] ?? '';

            if ($criterio && $dato) {
                $contribuyentes = Contribuyente::buscar($criterio, $dato);
            }
        } else {
            // Paginación por GET
            $pagina_actual = $_GET['page'] ?? 1;
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
            if (!$pagina_actual || $pagina_actual < 1) {
                header('Location: /admin/contribuyentes?page=1');
            }

            $por_pagina = 20;
            $total = Contribuyente::total();
            $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
            $contribuyentes = Contribuyente::paginar($por_pagina, $paginacion->offset());
            $paginacion = $paginacion->paginacion();
        }

        $router->render('admin/agua/contribuyentes/index', [
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
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $alertas = [];
        //validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/noticias');
        }
        //obtener ponente
        $contribuyente = Contribuyente::find($id);
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$contribuyente) {
            header('Location: admin/agua/contribuyentes/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $contribuyente->sincronizar($_POST);
            $alertas = $contribuyente->validar();

            if (empty($alertas)) {
                //guardar en la base de datos
                $resultado = $contribuyente->guardar();

                if ($resultado) {
                    header("Location: /admin/contribuyentes/editar?id=$id&actualizado=1");
                    exit;
                }
            }
        }


        $router->render('admin/agua/contribuyentes/editar', [
            'titulo' => 'Editar Contribuyente',
            'alertas' => $alertas,
            'contribuyente' => $contribuyente
        ]);
    }
    public static function contribuyenteEliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $contribuyente = Contribuyente::find($id);

            if ($contribuyente) {
                // Verificar si existen predios asociados al contribuyente
                $predios = Predio::whereArray(['contribuyente_id' => $id]);

                if (!empty($predios)) {
                    // Hay predios asociados, no eliminar
                    $_SESSION['error'] = 'No se puede eliminar el contribuyente porque tiene predios asociados.';
                } else {
                    // No hay predios, proceder con la eliminación
                    $contribuyente->eliminar();
                    $_SESSION['eliminado'] = 'Contribuyente eliminado correctamente.';
                }

                header('Location: /admin/contribuyentes');
                exit;
            }
        }
    }

    //*zonas
    // Listar y buscar zonas
    public static function zonas(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $zonas = [];
        $total = 0;
        $paginacion = '';

        // Búsqueda por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = 'nombre_zona';
            $dato = $_POST['nombre_zona'] ?? '';

            if ($criterio && $dato) {
                $zonas = Zona::buscar($criterio, $dato);
            }
        } else {
            // Paginación por GET
            $pagina_actual = $_GET['page'] ?? 1;
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
            if (!$pagina_actual || $pagina_actual < 1) {
                header('Location: /admin/zonas?page=1');
            }

            $por_pagina = 10;
            $total = Zona::total();
            $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
            $zonas = Zona::paginar($por_pagina, $paginacion->offset());
            $paginacion = $paginacion->paginacion();
        }

        $router->render('admin/agua/zonas/index', [
            'titulo' => 'Zonas',
            'zonas' => $zonas,
            'paginacion' => $paginacion
        ]);
    }

    // Crear zona
    public static function zonaCrear(Router $router)
    {

        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }
        $alertas = [];
        $zona = new Zona();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Generar el código de zona automáticamente si no se envió un valor
            if (empty($_POST['codigo_zona'])) {
                // Obtener el último código de zona registrado en la base de datos
                $ultimo_codigo = Zona::ultimoValor('codigo_zona', 'zonas');

                // Si no hay registros, el primer código será 'Z001'
                if (!$ultimo_codigo) {
                    $zona->codigo_zona = 'Z001';
                } else {
                    // Extraer el número del último código, incrementar y generar el siguiente
                    $numero = (int) substr($ultimo_codigo, 1); // Extraemos el número después de 'Z'
                    $numero++; // Incrementamos el número

                    // Asignar el nuevo código a la zona, asegurándonos de que tenga 3 dígitos
                    $zona->codigo_zona = 'Z' . str_pad($numero, 5, '0', STR_PAD_LEFT);
                }
            }
            $zona->sincronizar($_POST);
            $alertas = $zona->validar();
            if (empty($alertas)) {
                $zona->guardar();
                header("Location: /admin/zonas/crear?creado=1");
                exit;
            }
        }


        $router->render('admin/agua/zonas/crear', [
            'titulo' => 'Registrar Zona',
            'zona' => $zona,
            'alertas' => $alertas
        ]);
    }

    // Editar zona
    public static function zonaEditar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }
        $alertas = [];
        $id = $_GET['id'] ?? null;
        $zona = Zona::find($id);

        if (!$zona) {
            header('Location: /admin/zonas');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $zona->sincronizar($_POST);
            $alertas = $zona->validar();

            if (empty($alertas)) {
                $zona->guardar();
                header("Location: /admin/zonas/editar?id=$id&actualizado=1");
                exit;
            }
        }

        $router->render('admin/agua/zonas/editar', [
            'titulo' => 'Editar Zona',
            'zona' => $zona,
            'alertas' => $alertas
        ]);
    }
    // Eliminar zona
    public static function zonaEliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $zona = Zona::find($id);

            if ($zona) {
                // Verificar si existen sectores asociados a la zona
                $sectores = Sector::whereArray(['zona_id' => $id]);


                if (!empty($sectores)) {
                    // Hay sectores, no eliminar
                    $_SESSION['error'] = 'No se puede eliminar la zona porque tiene sectores asociados.';
                } else {
                    // No hay sectores, eliminar
                    $zona->eliminar();
                    $_SESSION['exito'] = 'Zona eliminada correctamente.';
                }

                header('Location: /admin/zonas');
                exit;
            }
        }
    }
    //*sectores
    // Listar y buscar sectores
    public static function sectores(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $sectores = [];
        $total = 0;
        $paginacion = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = 'nombre_sector';
            $dato = $_POST['nombre_sector'] ?? '';

            if ($criterio && $dato) {
                $sectores = Sector::buscar($criterio, $dato);
                foreach ($sectores as $sector) {
                    $sector->zona = Zona::find($sector->zona_id);
                }
            }
        } else {
            $pagina_actual = $_GET['page'] ?? 1;
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
            if (!$pagina_actual || $pagina_actual < 1) {
                header('Location: /admin/sectores?page=1');
            }

            $por_pagina = 10;
            $total = Sector::total();
            $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
            $sectores = Sector::paginar($por_pagina, $paginacion->offset());
            foreach ($sectores as $sector) {
                $sector->zona = Zona::find($sector->zona_id);
            }
            $paginacion = $paginacion->paginacion();
        }

        $router->render('admin/agua/sectores/index', [
            'titulo' => 'Sectores',
            'sectores' => $sectores,
            'paginacion' => $paginacion
        ]);
    }

    // Crear sector
    public static function sectorCrear(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }
        $alertas = [];
        $sector = new Sector();

        $zonas = Zona::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['codigo_sector'])) {
                $ultimo_codigo = Sector::ultimoValor('codigo_sector', 'sectores');
                if (!$ultimo_codigo) {
                    $sector->codigo_sector = 'S001';
                } else {
                    $numero = (int) substr($ultimo_codigo, 1);
                    $numero++;
                    $sector->codigo_sector = 'S' . str_pad($numero, 5, '0', STR_PAD_LEFT);
                }
            }

            $sector->sincronizar($_POST);
            $alertas = $sector->validar();
            if (empty($alertas)) {
                $sector->guardar();
                header('Location: /admin/sectores/crear?creado=1');
                exit;
            }
        }

        $router->render('admin/agua/sectores/crear', [
            'titulo' => 'Registrar Sector',
            'sector' => $sector,
            'zonas' => $zonas,
            'alertas' => $alertas
        ]);
    }

    // Editar sector
    public static function sectorEditar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        $sector = Sector::find($id);
        $zonas = Zona::all();
        $alertas = [];

        if (!$sector) {
            header('Location: /admin/sectores');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sector->sincronizar($_POST);
            $alertas = $sector->validar();

            if (empty($alertas)) {
                $sector->guardar();
                header("Location: /admin/sectores/editar?id=$id&actualizado=1");
                exit;
            }
        }

        $router->render('admin/agua/sectores/editar', [
            'titulo' => 'Editar Sector',
            'sector' => $sector,
            'zonas' => $zonas,
            'alertas' => $alertas
        ]);
    }

    // Eliminar sector
    public static function sectorEliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $sector = Sector::find($id);

            if ($sector) {
                $sector->eliminar();
                $_SESSION['eliminado'] = true; // Guardar en sesión
                header('Location: /admin/sectores');
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
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $predios = [];
        $total = 0;
        $paginacion = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $criterio = $_POST['criterio'] ?? '';
            $dato = $_POST['dato'] ?? '';

            if ($criterio && $dato) {
                if ($criterio === 'situacion') {
                    // Búsqueda estricta e insensible a mayúsculas/minúsculas para 'situacion'
                    $predios = Predio::buscarestricto($criterio, $dato);
                } else {
                    // Búsqueda normal (LIKE)
                    $predios = Predio::buscar($criterio, $dato);
                }

                foreach ($predios as $predio) {
                    $predio->zona = Zona::find($predio->zona_id);
                    $predio->sector = Sector::find($predio->sector_id);
                    $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
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
            }
            $paginacion = $paginacion->paginacion();
        }

        $router->render('admin/agua/predios/index', [
            'titulo' => 'Predios',
            'predios' => $predios,
            'paginacion' => $paginacion
        ]);
    }
    //crear predio
    public static function predioCrear(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $alertas = [];
        $predio = new Predio;
        $zonas = Zona::all();
        $sectores = Sector::all();
        $tarifas = Tarifa::all();

        $contribuyentes = Contribuyente::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Generación del código de predio
            if (empty($_POST['codigo_predio'])) {
                $ultimo_codigo = Predio::ultimoValor('codigo_predio', 'predios');
                if (!$ultimo_codigo) {
                    $predio->codigo_predio = 'P00001';
                } else {
                    $numero = (int) substr($ultimo_codigo, 1);
                    $numero++;
                    $predio->codigo_predio = 'P' . str_pad($numero, 5, '0', STR_PAD_LEFT);
                }
            }

            // Generación del código de secuencia

            $ultimo_secuencia = Predio::ultimoValor('secuencia', 'predios');
            if (!$ultimo_secuencia) {
                $predio->secuencia = 'SE0001';
            } else {
                $numero_secuencia = (int) substr($ultimo_secuencia, 2);
                $numero_secuencia++;
                $predio->secuencia = 'SE' . str_pad($numero_secuencia, 4, '0', STR_PAD_LEFT);
            }


            // Sincronizar los datos del formulario con el objeto predio
            $predio->sincronizar($_POST);
            // debuguear($predio);

            // Validar los datos
            $alertas = $predio->validar();
            if (empty($alertas)) {
                // Guardar el nuevo predio
                $predio->guardar();
                header('Location: /admin/predios/crear?creado=1');
                exit;
            }
        }

        $router->render('admin/agua/predios/crear', [
            'titulo' => 'Registrar Predio',
            'predio' => $predio,
            'zonas' => $zonas,
            'sectores' => $sectores,
            'contribuyentes' => $contribuyentes,
            'tarifas' => $tarifas,
            'alertas' => $alertas
        ]);
    }
    // Editar predio
    public static function predioEditar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        $predio = Predio::find($id);
        $tarifas = Tarifa::all();
        $zonas = Zona::all();
        $sectores = Sector::all();
        $contribuyentes = Contribuyente::all();
        $alertas = [];

        if (!$predio) {
            header('Location: /admin/predios');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $predio->sincronizar($_POST);
            $alertas = $predio->validar();

            if (empty($alertas)) {
                $predio->guardar();
                header("Location: /admin/predios/editar?id=$id&actualizado=1");
                exit;
            }
        }

        $router->render('admin/agua/predios/editar', [
            'titulo' => 'Editar Predio',
            'predio' => $predio,
            'zonas' => $zonas,
            'sectores' => $sectores,
            'contribuyentes' => $contribuyentes,
            'tarifas' => $tarifas,
            'alertas' => $alertas
        ]);
    }

    public static function predioEliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $predio = Predio::find($id);

            if ($predio) {
                // Verificar si existen medidores asociados al predio
                $medidores = Medidor::whereArray(['predio_id' => $id]);

                // Verificar si existen conexiones asociadas al predio
                $conexiones = Conexion::whereArray(['predio_id' => $id]);

                if (!empty($medidores) || !empty($conexiones)) {
                    // Existen medidores o conexiones, no eliminar
                    $_SESSION['error'] = 'No se puede eliminar el predio porque tiene medidores o conexiones asociadas.';
                } else {
                    // No hay medidores ni conexiones, proceder con la eliminación
                    $predio->eliminar();
                    $_SESSION['eliminado'] = 'Predio eliminado correctamente.';
                }

                header('Location: /admin/predios');
                exit;
            }
        }
    }

    //*tarifas
    //listar
    public static function tarifas(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $tarifas = [];
        $total = 0;
        $paginacion = '';

        // Búsqueda por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = $_POST['criterio'] ?? '';
            $dato = $_POST['dato'] ?? '';

            if ($criterio && $dato) {
                $tarifas = Tarifa::buscar($criterio, $dato);
            }
        } else {
            // Paginación por GET
            $pagina_actual = $_GET['page'] ?? 1;
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

            if (!$pagina_actual || $pagina_actual < 1) {
                header('Location: /admin/tarifas?page=1');
            }

            $por_pagina = 20;
            $total = Tarifa::total();
            $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
            $tarifas = Tarifa::paginar($por_pagina, $paginacion->offset());
            $paginacion = $paginacion->paginacion();
        }

        $router->render('admin/agua/tarifas/index', [
            'titulo' => 'Tarifas',
            'tarifas' => $tarifas,
            'paginacion' => $paginacion
        ]);
    }
    public static function tarifaCrear(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }
        $alertas = [];
        $tarifa = new Tarifa();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['codigo_tarifa'])) {
                $ultimo_codigo = Tarifa::ultimoValor('codigo_tarifa', 'tarifas');
                if (!$ultimo_codigo) {
                    $tarifa->codigo_tarifa = 'T001';
                } else {
                    $numero = (int) substr($ultimo_codigo, 1);
                    $numero++;
                    $tarifa->codigo_tarifa = 'T' . str_pad($numero, 3, '0', STR_PAD_LEFT);
                }
            }

            $tarifa->sincronizar($_POST);
            $alertas = $tarifa->validar();
            if (empty($alertas)) {
                $tarifa->guardar();
                header('Location: /admin/tarifas/crear?creado=1');
                exit;
            }
        }

        $router->render('admin/agua/tarifas/crear', [
            'titulo' => 'Registrar Sector',
            'tarifa' => $tarifa,
            'alertas' => $alertas
        ]);
    }
    public static function tarifaEditar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        $tarifa = Tarifa::find($id);  // Asumimos que tienes un modelo Tarifa
        $alertas = [];

        if (!$tarifa) {
            header('Location: /admin/tarifas');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tarifa->sincronizar($_POST);
            $alertas = $tarifa->validar();

            if (empty($alertas)) {
                $tarifa->guardar();
                header("Location: /admin/tarifas/editar?id=$id&actualizado=1");
                exit;
            }
        }

        $router->render('admin/agua/tarifas/editar', [
            'titulo' => 'Editar Tarifa',
            'tarifa' => $tarifa,
            'alertas' => $alertas
        ]);
    }
    public static function tarifaEliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $tarifa = Tarifa::find($id); // Se cambia Predio por Tarifa

            if ($tarifa) {
                $tarifa->eliminar(); // Llamamos a eliminar en el modelo Tarifa
                $_SESSION['eliminado'] = true; // Guardar en sesión
                header('Location: /admin/tarifas'); // Redirigir a la lista de tarifas
                exit;
            }
        }
    }
    //*medidores
    // Listar
    public static function medidores(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $medidores = [];
        $total = 0;
        $paginacion = '';

        // Búsqueda por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = $_POST['criterio'] ?? '';
            $dato = $_POST['dato'] ?? '';

            if ($criterio && $dato) {
                $medidores = Medidor::buscar($criterio, $dato);
                foreach ($medidores as $medidor) {
                    $medidor->contribuyente = Contribuyente::find($medidor->contribuyente_id);
                    $medidor->predio = Predio::find($medidor->predio_id);
                }
            }
        } else {
            // Paginación por GET
            $pagina_actual = $_GET['page'] ?? 1;
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

            if (!$pagina_actual || $pagina_actual < 1) {
                header('Location: /admin/medidores?page=1');
            }

            $por_pagina = 20;
            $total = Medidor::total();
            $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
            $medidores = Medidor::paginar($por_pagina, $paginacion->offset());
            $paginacion = $paginacion->paginacion();
            foreach ($medidores as $medidor) {
                $medidor->contribuyente = Contribuyente::find($medidor->contribuyente_id);
                $medidor->predio = Predio::find($medidor->predio_id);
            }
        }

        $router->render('admin/agua/medidores/index', [
            'titulo' => 'Medidores',
            'medidores' => $medidores,
            'paginacion' => $paginacion
        ]);
    }
    public static function medidorCrear(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $alertas = [];
        $medidor = new Medidor;
        $contribuyentes = Contribuyente::all();
        $predios = Predio::all();

        // Enlazamos cada predio con su contribuyente
        foreach ($predios as $predio) {
            $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $medidor->sincronizar($_POST);
            $alertas = $medidor->validar();

            if (empty($alertas)) {
                $medidor->guardar();
                header('Location: /admin/medidores/crear?creado=1');
                exit;
            }
        }

        $router->render('admin/agua/medidores/crear', [
            'titulo' => 'Registrar Medidor',
            'medidor' => $medidor,
            'alertas' => $alertas,
            'contribuyentes' => $contribuyentes,
            'predios' => $predios // ahora con contribuyente incluido
        ]);
    }

    public static function medidorEditar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        $medidor = Medidor::find($id);
        $alertas = [];
        $contribuyentes = Contribuyente::all();
        $predios = Predio::all();
        // Enlazamos cada predio con su contribuyente
        foreach ($predios as $predio) {
            $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
        }


        if (!$medidor) {
            header('Location: /admin/medidores');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $medidor->sincronizar($_POST);
            $alertas = $medidor->validar();

            if (empty($alertas)) {
                $medidor->guardar();
                header("Location: /admin/medidores/editar?id=$id&actualizado=1");
                exit;
            }
        }

        $router->render('admin/agua/medidores/editar', [
            'titulo' => 'Editar Medidor',
            'medidor' => $medidor,
            'alertas' => $alertas,
            'contribuyentes' => $contribuyentes,
            'predios' => $predios
        ]);
    }
    public static function medidorEliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $medidor = Medidor::find($id);

            if ($medidor) {
                $medidor->eliminar();
                $_SESSION['eliminado'] = true;
                header('Location: /admin/medidores');
                exit;
            }
        }
    }
    //conexiones
    public static function conexiones(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $conexiones = [];
        $total = 0;
        $paginacion = '';

        // Búsqueda por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = $_POST['criterio'] ?? '';
            $dato = $_POST['dato'] ?? '';

            if ($criterio && $dato) {
                $conexiones = Conexion::buscar($criterio, $dato);
                foreach ($conexiones as $conexion) {
                    $conexion->predio = Predio::find($conexion->predio_id);
                    if ($conexion->predio) {
                        $conexion->contribuyente = Contribuyente::find($conexion->predio->contribuyente_id);
                    }
                }
            }
        } else {
            // Paginación por GET
            $pagina_actual = $_GET['page'] ?? 1;
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

            if (!$pagina_actual || $pagina_actual < 1) {
                header('Location: /admin/conexiones?page=1');
            }

            $por_pagina = 20;
            $total = Conexion::total();
            $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
            $conexiones = Conexion::paginar($por_pagina, $paginacion->offset());
            $paginacion = $paginacion->paginacion();

            foreach ($conexiones as $conexion) {
                $conexion->predio = Predio::find($conexion->predio_id);
                if ($conexion->predio) {
                    $conexion->contribuyente = Contribuyente::find($conexion->predio->contribuyente_id);
                }
            }
        }

        $router->render('admin/agua/conexiones/index', [
            'titulo' => 'Conexiones',
            'conexiones' => $conexiones,
            'paginacion' => $paginacion
        ]);
    }

    public static function conexionCrear(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $alertas = [];
        $conexion = new Conexion();
        $predios = Predio::all(); // Asegúrate de tener un modelo Predio
        foreach ($predios as $predio) {
            $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $conexion->sincronizar($_POST);
            $alertas = $conexion->validar();

            if (empty($alertas)) {
                $conexion->guardar();
                header('Location: /admin/conexiones/crear?creado=1');
                exit;
            }
        }

        $router->render('admin/agua/conexiones/crear', [
            'titulo' => 'Registrar Conexión',
            'conexion' => $conexion,
            'alertas' => $alertas,
            'predios' => $predios
        ]);
    }
    public static function conexionEditar(Router $router)
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        $conexion = Conexion::find($id);
        $alertas = [];
        $predios = Predio::all();
        foreach ($predios as $predio) {
            $predio->contribuyente = Contribuyente::find($predio->contribuyente_id);
        }
        if (!$conexion) {
            header('Location: /admin/conexiones');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $conexion->sincronizar($_POST);
            $alertas = $conexion->validar();

            if (empty($alertas)) {
                $conexion->guardar();
                header("Location: /admin/conexiones/editar?id=$id&actualizado=1");
                exit;
            }
        }

        $router->render('admin/agua/conexiones/editar', [
            'titulo' => 'Editar Conexión',
            'conexion' => $conexion,
            'alertas' => $alertas,
            'predios' => $predios
        ]);
    }
    public static function conexionEliminar()
    {
        if (!is_auth()) {
            header('Location: /auth/login');
            exit;
        }

        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $conexion = Conexion::find($id);

            if ($conexion) {
                $conexion->eliminar();
                $_SESSION['eliminado'] = true;
                header('Location: /admin/conexiones');
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

        if (!is_admin()) {
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
                header('Location: /admin/registros?page=1');
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

        $router->render('admin/agua/resumen/index', [
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
        if (!is_admin()) {
            header('Location: /auth/login');
            exit;
        }
    
        $id = $_GET['id'] ?? null;
        $predio = Predio::find($id);
        $tarifas = Tarifa::all();
        $zonas = Zona::all();
        $sectores = Sector::all();
        $contribuyentes = Contribuyente::all();
    
        // Buscar medidor y conexión por predio_id, no por id directo
        $medidor = Medidor::where('predio_id', $id) ?? new Medidor();
        $conexion = Conexion::where('predio_id', $id) ?? new Conexion();
    
        $alertas = [];
    
        if (!$predio) {
            header('Location: /admin/predios');
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
    
                header("Location: /admin/resumen");
                exit;
            }
        }
    
        $router->render('admin/agua/resumen/editar', [
            'titulo' => 'Detalle Completo',
            'predio' => $predio,
            'zonas' => $zonas,
            'sectores' => $sectores,
            'contribuyentes' => $contribuyentes,
            'tarifas' => $tarifas,
            'medidor' => $medidor,
            'conexion' => $conexion,
            'alertas' => $alertas
        ]);
    }
    
}
