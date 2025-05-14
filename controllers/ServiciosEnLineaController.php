<?php

namespace Controllers;

use MVC\Router;
use Model\Estados;
use Model\Solicitud;
use Model\NuevaConexion;
use Model\TiposSolicitud;
use Classes\Notificaciones;
use Intervention\Image\ImageManagerStatic as Image;

class ServiciosEnLineaController
{
    public static function serviciosenlinea(Router $router)
    {

        $router->render('paginas/servicios/serviciosenlinea', [
            'titulo' => 'Sobre Sanigest'
        ]);
    }

    public static function requisitos(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            debuguear($_POST);
        }

        $router->render('paginas/servicios/requisitos', [
            'titulo' => 'Sobre Sanigest'
        ]);
    }

    public static function nuevaconexion(Router $router)
    {
        $alertas = [];
        $nuevaconexion = new NuevaConexion;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Ruta de la carpeta donde se guardarán las imágenes
            $carpeta_imagenes = '../public/img/nuevaconexion';

            // Crear la carpeta si no existe
            if (!is_dir($carpeta_imagenes)) {
                mkdir($carpeta_imagenes, 0755, true);
            }

            // Lista de campos de imágenes en el formulario
            $campos_imagenes = [
                'documento_propiedad',
                'dni_documento',
                'croquis',
                'foto_instalacion',
                'foto_recibo',
                'foto_autorizacion_notarial',
                'foto_vigencia_poder'
            ];

            // Array para almacenar los nombres de las imágenes
            $imagenesSubidas = [];

            foreach ($campos_imagenes as $campo) {
                if (!empty($_FILES[$campo]['tmp_name'])) {
                    try {
                        // Generar un nombre único
                        $nombre_imagen = md5(uniqid(rand(), true));

                        // Procesar en PNG y WebP
                        $imagen_png = Image::make($_FILES[$campo]['tmp_name'])->fit(800, 800)->encode('png', 80);
                        $imagen_webp = Image::make($_FILES[$campo]['tmp_name'])->fit(800, 800)->encode('webp', 80);

                        // Guardar en la carpeta
                        $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                        $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                        // Guardar el nombre en el array con la clave del campo
                        $_POST[$campo] = $nombre_imagen;
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Error al procesar la imagen $campo: " . $e->getMessage();
                        header('Location: /servicios/nuevaconexion/crear');
                        exit;
                    }
                } else {
                    $_POST[$campo] = null; // Si no se subió una imagen, guardar NULL
                }
            }

            // Sincronizar los datos en la clase



            $nuevaconexion->sincronizar($_POST);
            $alertas = $nuevaconexion->validar();


            if (empty($alertas)) {
                // Generar código único corto con fecha y número aleatorio
                $codigo_seguimiento = 'SG' . date('ymd') . "-" . rand(100, 999);

                // Asignar el código generado
                $nuevaconexion->codigo_seguimiento = $codigo_seguimiento;

                // Guardar en la base de datos
                $resultado = $nuevaconexion->guardar();
                $notificacion = new Notificaciones($nuevaconexion->email, $nuevaconexion->nombre, $nuevaconexion->apellido1);
                $notificacion->enviarNotificacionNuevaConexion($codigo_seguimiento);

                if ($resultado) {
                    header("Location: /serviciosenlinea?codigo=" . urlencode($codigo_seguimiento));
                    exit;
                }
            }
        }
        $router->render('paginas/servicios/nuevaconexion', [
            'titulo' => 'Sobre Sanigest',
            'alertas' => $alertas,
            'nuevaconexion' => $nuevaconexion,
        ]);
    }
    public static function estado(Router $router)
    {
        $estado = null;
        $tipoBusqueda = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criterio = $_POST['criterio'] ?? null;
            $dato = $_POST['dato'] ?? null;
            $tipoBusqueda = $criterio;

            if ($criterio === 'nueva_conexion') {
                $estado = NuevaConexion::where('codigo_seguimiento', $dato);

                if ($estado) {
                    // Obtener objeto estado y tipo de solicitud (si existe)
                    $estado->estado_id = Estados::find($estado->estado_id);
                }
            } elseif ($criterio === 'solicitudes') {
                $estado = Solicitud::where('codigo_seguimiento', $dato);

                if ($estado) {
                    $estado->estado_id = Estados::find($estado->estado_id);
                    $estado->tipo_solicitud_id = TiposSolicitud::find($estado->tipo_solicitud_id);
                }
            }
        }

        // Renderizar vista con estado y tipo de búsqueda
        $router->render('paginas/servicios/estadoconexion', [
            'estado' => $estado,
            'tipoBusqueda' => $tipoBusqueda
        ]);
    }
    public static function solicitud(Router $router)
    {
        $alertas = [];
        $solicitud = new Solicitud;
        $tipoSolicitud = TiposSolicitud::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Verificar si se subió una imagen
            $imagenSubida = !empty($_FILES['evidencia']['tmp_name']);
            $nombre_imagen = null;

            if ($imagenSubida) {
                $carpeta_imagenes = '../public/img/evidenciasSolicitudes';
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['evidencia']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['evidencia']['tmp_name'])->fit(800, 800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['evidencia'] = $nombre_imagen;
            }

            // Sincronizar datos
            $solicitud->sincronizar($_POST);

            // Validar
            $alertas = $solicitud->validar();

            if (empty($alertas)) {
                // Generar código de seguimiento
                $codigo_seguimiento = 'SG' . date('ymd') . "-" . rand(100, 999);
                $solicitud->codigo_seguimiento = $codigo_seguimiento;

                // Guardar la imagen si se subió
                if ($imagenSubida) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                // Guardar en la base de datos
                $resultado = $solicitud->guardar();

                // Enviar notificación por correo
                $notificacion = new Notificaciones($solicitud->email, $solicitud->nombres, $solicitud->apellidos);
                $notificacion->enviarNotificacionSolicitud($codigo_seguimiento);

                if ($resultado) {
                    header("Location: /serviciosenlinea?codigo=" . urlencode($codigo_seguimiento));
                    exit;
                }
            }
        }

        $router->render('paginas/servicios/solicitud', [
            'alertas' => $alertas,
            'tipoSolicitud' => $tipoSolicitud,
            'solicitud' => $solicitud
        ]);
    }
}
