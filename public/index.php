<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIEventos;
use Controllers\APIRegalos;
use Controllers\APIPonentes;
use Controllers\APIHistorial;
use Controllers\AuthController;
use Controllers\ClienteController;
use Controllers\EventosController;
use Controllers\PaginasController;
use Controllers\ReclamoController;
use Controllers\RegalosController;
use Controllers\AuthUserController;
use Controllers\ContactoController;
use Controllers\NoticiasController;
use Controllers\PersonalController;
use Controllers\PonentesController;
use Controllers\RegistroController;
use Controllers\DashboardController;
use Controllers\HistorialController;
use Controllers\SolicitudController;
use Controllers\PerfilUserController;
use Controllers\AguaPotableController;
use Controllers\RecibosUserController;
use Controllers\RegistradosController;
use Controllers\DashboardUserController;
use Controllers\NuevaConexionController;
use Controllers\AreaConmercialController;
use Controllers\EstadoServicioController;
use Controllers\DashboardTecnicoController;
use Controllers\ServiciosEnLineaController;
use Controllers\DashboardTesoreroController;
use Controllers\AguaPotableTesoreroController;
use Controllers\DashboardLecturadorController;
use Controllers\FacturacionLecturadorController;
use Controllers\NuevasConexionesTecnicoController;

$router = new Router();

//*intranet
// Login
$router->get('/auth/login', [AuthController::class, 'login']);
$router->post('/auth/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/auth/registro', [AuthController::class, 'registro']);
$router->post('/auth/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/auth/olvide', [AuthController::class, 'olvide']);
$router->post('/auth/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/auth/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/auth/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/auth/mensaje', [AuthController::class, 'mensaje']);
$router->get('/auth/confirmar-cuenta', [AuthController::class, 'confirmar']);

// Area de administración
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/ponentes', [PonentesController::class, 'index']);
$router->get('/admin/ponentes/buscar', [PonentesController::class, 'buscar']);
$router->post('/admin/ponentes/buscar', [PonentesController::class, 'buscar']);
$router->get('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->post('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->get('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/eliminar', [PonentesController::class, 'eliminar']);

$router->get('/admin/eventos', [EventosController::class, 'index']);
$router->get('/admin/eventos/buscar', [EventosController::class, 'buscar']);
$router->post('/admin/eventos/buscar', [EventosController::class, 'buscar']);
$router->get('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->post('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->get('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/eliminar', [EventosController::class, 'eliminar']);

$router->get('/admin/noticias', [NoticiasController::class, 'index']);
$router->get('/admin/noticias/buscar', [NoticiasController::class, 'buscar']);
$router->post('/admin/noticias/buscar', [NoticiasController::class, 'buscar']);
$router->get('/admin/noticias/crear', [NoticiasController::class, 'crear']);
$router->post('/admin/noticias/crear', [NoticiasController::class, 'crear']);
$router->get('/admin/noticias/editar', [NoticiasController::class, 'editar']);
$router->post('/admin/noticias/editar', [NoticiasController::class, 'editar']);
$router->post('/admin/noticias/eliminar', [NoticiasController::class, 'eliminar']);

//admin-contacto
$router->get('/admin/contacto', [ContactoController::class, 'index']);

$router->get('/contacto/crear', [ContactoController::class, 'crear']);
$router->post('/contacto/crear', [ContactoController::class, 'crear']);

$router->post('/admin/contacto/editar', [ContactoController::class, 'editarTarea']);

$router->get('/admin/contacto/buscar', [ContactoController::class, 'buscar']);
$router->post('/admin/contacto/buscar', [ContactoController::class, 'buscar']);

$router->get('/admin/contacto/pendiente', [ContactoController::class, 'pendiente']);
$router->post('/admin/contacto/pendiente', [ContactoController::class, 'pendiente']);

$router->get('/admin/contacto/atendido', [ContactoController::class, 'atendido']);
$router->post('/admin/contacto/atendido', [ContactoController::class, 'atendido']);

$router->post('/admin/contacto/eliminar', [ContactoController::class, 'eliminar']);


//admin-reclamos
$router->get('/admin/reclamos', [ReclamoController::class, 'index']);
$router->post('/admin/reclamos', [ReclamoController::class, 'index']);
$router->get('/admin/reclamos/editar', [ReclamoController::class, 'editarEstado']);
$router->post('/admin/reclamos/editar', [ReclamoController::class, 'editarEstado']);
$router->get('/admin/reclamos/buscar', [ReclamoController::class, 'buscar']);
$router->post('/admin/reclamos/buscar', [ReclamoController::class, 'buscar']);
$router->get('/admin/reclamos/editarB', [ReclamoController::class, 'editarEstadoB']);
$router->post('/admin/reclamos/editarB', [ReclamoController::class, 'editarEstadoB']);
$router->post('/admin/reclamos/eliminarB', [ReclamoController::class, 'eliminarB']);

//admin-personal
$router->get('/admin/personal', [PersonalController::class, 'index']);
$router->get('/admin/personal/editar', [PersonalController::class, 'editar']);
$router->post('/admin/personal/editar', [PersonalController::class, 'editar']);
$router->get('/admin/personal/eliminar', [PersonalController::class, 'eliminar']);
$router->post('/admin/personal/eliminar', [PersonalController::class, 'eliminar']);


//admin-clientes
$router->get('/admin/cliente', [ClienteController::class, 'index']);
$router->get('/admin/cliente/editar', [ClienteController::class, 'editar']);
$router->post('/admin/cliente/editar', [ClienteController::class, 'editar']);
$router->get('/admin/cliente/eliminar', [ClienteController::class, 'eliminar']);
$router->post('/admin/cliente/eliminar', [ClienteController::class, 'eliminar']);

//nueva-conexion
$router->get('/admin/nuevaconexion', [NuevaConexionController::class, 'index']);
$router->get('/admin/nuevaconexion/revisar', [NuevaConexionController::class, 'revisar']);
$router->post('/admin/nuevaconexion/revisar', [NuevaConexionController::class, 'revisar']);


//solicitudesAdmin
$router->get('/admin/solicitudes', [SolicitudController::class, 'index']);
$router->get('/admin/solicitudes/revisar', [SolicitudController::class, 'revisar']);
$router->post('/admin/solicitudes/revisar', [SolicitudController::class, 'revisar']);


//*agua-potable
$router->get('/admin/agua', [AguaPotableController::class, 'index']);
//controbuyentes
$router->get('/admin/contribuyentes', [AguaPotableController::class, 'contribuyentes']);
$router->post('/admin/contribuyentes', [AguaPotableController::class, 'contribuyentes']);
$router->get('/admin/contribuyentes/crear', [AguaPotableController::class, 'contribuyenteCrear']);
$router->post('/admin/contribuyentes/crear', [AguaPotableController::class, 'contribuyenteCrear']);
$router->get('/admin/contribuyentes/editar', [AguaPotableController::class, 'contribuyenteEditar']);
$router->post('/admin/contribuyentes/editar', [AguaPotableController::class, 'contribuyenteEditar']);
$router->post('/admin/contribuyentes/eliminar', [AguaPotableController::class, 'contribuyenteEliminar']);
//zonas
$router->get('/admin/zonas', [AguaPotableController::class, 'zonas']);
$router->post('/admin/zonas', [AguaPotableController::class, 'zonas']);
$router->get('/admin/zonas/crear', [AguaPotableController::class, 'zonaCrear']);
$router->post('/admin/zonas/crear', [AguaPotableController::class, 'zonaCrear']);
$router->get('/admin/zonas/editar', [AguaPotableController::class, 'zonaEditar']);
$router->post('/admin/zonas/editar', [AguaPotableController::class, 'zonaEditar']);
$router->post('/admin/zonas/eliminar', [AguaPotableController::class, 'zonaEliminar']);
// sectores
$router->get('/admin/sectores', [AguaPotableController::class, 'sectores']);
$router->post('/admin/sectores', [AguaPotableController::class, 'sectores']);
$router->get('/admin/sectores/crear', [AguaPotableController::class, 'sectorCrear']);
$router->post('/admin/sectores/crear', [AguaPotableController::class, 'sectorCrear']);
$router->get('/admin/sectores/editar', [AguaPotableController::class, 'sectorEditar']);
$router->post('/admin/sectores/editar', [AguaPotableController::class, 'sectorEditar']);
$router->post('/admin/sectores/eliminar', [AguaPotableController::class, 'sectorEliminar']);
// predios
$router->get('/admin/predios', [AguaPotableController::class, 'predios']);
$router->post('/admin/predios', [AguaPotableController::class, 'predios']);
$router->get('/admin/predios/crear', [AguaPotableController::class, 'predioCrear']);
$router->post('/admin/predios/crear', [AguaPotableController::class, 'predioCrear']);
$router->get('/admin/predios/editar', [AguaPotableController::class, 'predioEditar']);
$router->post('/admin/predios/editar', [AguaPotableController::class, 'predioEditar']);
$router->post('/admin/predios/eliminar', [AguaPotableController::class, 'predioEliminar']);
//tarifa
$router->get('/admin/tarifas', [AguaPotableController::class, 'tarifas']);
$router->post('/admin/tarifas', [AguaPotableController::class, 'tarifas']);
$router->get('/admin/tarifas/crear', [AguaPotableController::class, 'tarifaCrear']);
$router->post('/admin/tarifas/crear', [AguaPotableController::class, 'tarifaCrear']);
$router->get('/admin/tarifas/editar', [AguaPotableController::class, 'tarifaEditar']);
$router->post('/admin/tarifas/editar', [AguaPotableController::class, 'tarifaEditar']);
$router->post('/admin/tarifas/eliminar', [AguaPotableController::class, 'tarifaEliminar']);
// Medidor
$router->get('/admin/medidores', [AguaPotableController::class, 'medidores']);
$router->post('/admin/medidores', [AguaPotableController::class, 'medidores']);
$router->get('/admin/medidores/crear', [AguaPotableController::class, 'medidorCrear']);
$router->post('/admin/medidores/crear', [AguaPotableController::class, 'medidorCrear']);
$router->get('/admin/medidores/editar', [AguaPotableController::class, 'medidorEditar']);
$router->post('/admin/medidores/editar', [AguaPotableController::class, 'medidorEditar']);
$router->post('/admin/medidores/eliminar', [AguaPotableController::class, 'medidorEliminar']);
// Conexión
$router->get('/admin/conexiones', [AguaPotableController::class, 'conexiones']);
$router->post('/admin/conexiones', [AguaPotableController::class, 'conexiones']);
$router->get('/admin/conexiones/crear', [AguaPotableController::class, 'conexionCrear']);
$router->post('/admin/conexiones/crear', [AguaPotableController::class, 'conexionCrear']);
$router->get('/admin/conexiones/editar', [AguaPotableController::class, 'conexionEditar']);
$router->post('/admin/conexiones/editar', [AguaPotableController::class, 'conexionEditar']);
$router->post('/admin/conexiones/eliminar', [AguaPotableController::class, 'conexionEliminar']);
//resumen
$router->get('/admin/resumen', [AguaPotableController::class, 'resumen']);
$router->post('/admin/resumen', [AguaPotableController::class, 'resumen']);
$router->get('/admin/resumen/detalle', [AguaPotableController::class, 'resumenEditar']);
$router->post('/admin/resumen/detalle', [AguaPotableController::class, 'resumenEditar']);

// $router->get('/api/eventos-horario', [APIEventos::class, 'index']);
// $router->get('/api/ponentes', [APIPonentes::class, 'index']);
// $router->get('/api/ponente', [APIPonentes::class, 'ponente']);
// $router->get('/admin/registrados', [RegistradosController::class, 'index']);
$router->get('/api/regalos', [APIRegalos::class, 'index']);//para grafica de regalos
$router->get('/admin/regalos', [RegalosController::class, 'index']);


//*area publica
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/quehacemos', [PaginasController::class, 'quehacemos']);
$router->get('/noticias', [PaginasController::class, 'noticias']);
$router->get('/noticias', [PaginasController::class, 'noticias']);
$router->get('/paquetes', [PaginasController::class, 'paquetes']);
$router->get('/workshops-conferencias', [PaginasController::class, 'conferencias']);
$router->get('/masinformacion', [PaginasController::class, 'masinformacion']);

//servicios en linea
$router->get('/serviciosenlinea', [ServiciosEnLineaController::class, 'serviciosenlinea']);
$router->get('/servicios/nuevaconexion', [ServiciosEnLineaController::class, 'requisitos']);
$router->get('/servicios/nuevaconexion/crear', [ServiciosEnLineaController::class, 'nuevaconexion']);
$router->post('/servicios/nuevaconexion/crear', [ServiciosEnLineaController::class, 'nuevaconexion']);

$router->get('/servicios/estado', [ServiciosEnLineaController::class, 'estado']);
$router->post('/servicios/estado', [ServiciosEnLineaController::class, 'estado']);

$router->get('/servicios/solicitud/crear', [ServiciosEnLineaController::class, 'solicitud']);
$router->post('/servicios/solicitud/crear', [ServiciosEnLineaController::class, 'solicitud']);

$router->get('/servicios/consultar-recibo', [ServiciosEnLineaController::class, 'consultarRecibo']);
$router->post('/servicios/consultar-recibo', [ServiciosEnLineaController::class, 'consultarRecibo']);



//paginas helper
$router->get('/404', [PaginasController::class, 'error']);
$router->get('/sin-rol', [PaginasController::class, 'sinrol']);

//* Registro de Usuarios
$router->get('/finalizar-registro', [RegistroController::class, 'crear']);
$router->post('/finalizar-registro/gratis', [RegistroController::class, 'gratis']);
$router->post('/finalizar-registro/pagar', [RegistroController::class, 'pagar']);
$router->get('/finalizar-registro/conferencias', [RegistroController::class, 'conferencias']);
$router->post('/finalizar-registro/conferencias', [RegistroController::class, 'conferencias']);

// Boleto virtual
$router->get('/boleto', [RegistroController::class, 'boleto']);

//*area de usuario
//*login clientes

$router->get('/loginUser', [AuthUserController::class, 'login']);
$router->post('/loginUser', [AuthUserController::class, 'login']);
$router->post('/logoutUser', [AuthUserController::class, 'logout']);
$router->get('/registroUser', [AuthUserController::class, 'registro']);
$router->post('/registroUser', [AuthUserController::class, 'registro']);

$router->get('/user/dashboard', [DashboardUserController::class, 'index']);
//reclamos
$router->get('/user/reclamos', [ReclamoController::class, 'crear']);
$router->post('/user/reclamos', [ReclamoController::class, 'crear']);
$router->get('/user/reclamos/ver', [ReclamoController::class, 'ver']);
$router->post('/user/reclamos/ver', [ReclamoController::class, 'ver']);
$router->post('/user/reclamos/eliminar', [ReclamoController::class, 'eliminar']);

//perfil
$router->get('/user/perfil', [PerfilUserController::class, 'perfil']);
$router->post('/user/perfil', [PerfilUserController::class, 'perfil']);

//recibos
$router->get('/user/recibo-actual', [RecibosUserController::class, 'consultarRecibo']);

//servicio
$router->get('/user/estado-servicio', [EstadoServicioController::class, 'estadoServicio']);

//historial
$router->get('/api/historial', [APIHistorial::class, 'index']);//para grafica
$router->get('/user/historial', [HistorialController::class, 'historial']);



//*area tecnico
$router->get('/tecnico/dashboard', [DashboardTecnicoController::class, 'index']);
//nuevas conexiones
$router->get('/tecnico/nuevasconexiones/index', [NuevasConexionesTecnicoController::class, 'index']);
$router->get('/tecnico/nuevasconexiones', [NuevasConexionesTecnicoController::class, 'trabajos']);
$router->get('/tecnico/nuevasconexiones/ver', [NuevasConexionesTecnicoController::class, 'ver']);
$router->get('/tecnico/nuevasconexiones/pendientes', [NuevasConexionesTecnicoController::class, 'pendientes']);
$router->post('/tecnico/nuevasconexiones/pendientes', [NuevasConexionesTecnicoController::class, 'pendientes']);
$router->get('/tecnico/nuevasconexiones/revisar', [NuevasConexionesTecnicoController::class, 'revisar']);
$router->post('/tecnico/nuevasconexiones/revisar', [NuevasConexionesTecnicoController::class, 'revisar']);
$router->get('/tecnico/nuevasconexiones/encurso', [NuevasConexionesTecnicoController::class, 'encurso']);
$router->get('/tecnico/nuevasconexiones/proceso', [NuevasConexionesTecnicoController::class, 'proceso']);
$router->post('/tecnico/nuevasconexiones/proceso', [NuevasConexionesTecnicoController::class, 'proceso']);

//solicitudes
$router->get('/tecnico/solicitudes', [SolicitudController::class, 'listatecnico']);
$router->get('/tecnico/solicitudes/finalizar', [SolicitudController::class, 'finalizartecnico']);
$router->post('/tecnico/solicitudes/finalizar', [SolicitudController::class, 'finalizartecnico']);


//*area tesorero 
$router->get('/tesorero/dashboard', [DashboardTesoreroController::class, 'index']);

//agua-potable
$router->get('/tesorero/agua', [AguaPotableTesoreroController::class, 'index']);


// contribuyentes
$router->get('/tesorero/contribuyentes', [AguaPotableTesoreroController::class, 'contribuyentes']);
$router->post('/tesorero/contribuyentes', [AguaPotableTesoreroController::class, 'contribuyentes']);
$router->get('/tesorero/contribuyentes/crear', [AguaPotableTesoreroController::class, 'contribuyenteCrear']);
$router->post('/tesorero/contribuyentes/crear', [AguaPotableTesoreroController::class, 'contribuyenteCrear']);
$router->get('/tesorero/contribuyentes/editar', [AguaPotableTesoreroController::class, 'contribuyenteEditar']);
$router->post('/tesorero/contribuyentes/editar', [AguaPotableTesoreroController::class, 'contribuyenteEditar']);
$router->post('/tesorero/contribuyentes/eliminar', [AguaPotableTesoreroController::class, 'contribuyenteEliminar']);

// predios
$router->get('/tesorero/predios', [AguaPotableTesoreroController::class, 'predios']);
$router->post('/tesorero/predios', [AguaPotableTesoreroController::class, 'predios']);
$router->get('/tesorero/predios/crear', [AguaPotableTesoreroController::class, 'predioCrear']);
$router->post('/tesorero/predios/crear', [AguaPotableTesoreroController::class, 'predioCrear']);
$router->get('/tesorero/predios/editar', [AguaPotableTesoreroController::class, 'predioEditar']);
$router->post('/tesorero/predios/editar', [AguaPotableTesoreroController::class, 'predioEditar']);
$router->post('/tesorero/predios/eliminar', [AguaPotableTesoreroController::class, 'predioEliminar']);

// resumen
$router->get('/tesorero/resumen', [AguaPotableTesoreroController::class, 'resumen']);
$router->post('/tesorero/resumen', [AguaPotableTesoreroController::class, 'resumen']);
$router->get('/tesorero/resumen/detalle', [AguaPotableTesoreroController::class, 'resumenEditar']);
$router->post('/tesorero/resumen/detalle', [AguaPotableTesoreroController::class, 'resumenEditar']);

//solicitudes
$router->get('/tesorero/solicitudes', [SolicitudController::class, 'lista']);
$router->get('/tesorero/solicitudes/finalizar', [SolicitudController::class, 'finalizar']);
$router->post('/tesorero/solicitudes/finalizar', [SolicitudController::class, 'finalizar']);

//area conmercial tesorero
//consumos
$router->get('/tesorero/consumos', [AreaConmercialController::class, 'indexConsumos']);
$router->post('/tesorero/consumos', [AreaConmercialController::class, 'indexConsumos']);
$router->get('/tesorero/consumos/crear', [AreaConmercialController::class, 'crearConsumos']);
$router->post('/tesorero/consumos/crear', [AreaConmercialController::class, 'crearConsumos']);
$router->get('/tesorero/consumos/editar', [AreaConmercialController::class, 'editarConsumos']);
$router->post('/tesorero/consumos/editar', [AreaConmercialController::class, 'editarConsumos']);
$router->post('/tesorero/consumos/eliminar', [AreaConmercialController::class, 'eliminarConsumos']);
$router->get('/tesorero/consumos/generar', [AreaConmercialController::class, 'generarConsumos']);
$router->post('/tesorero/consumos/generar', [AreaConmercialController::class, 'generarConsumos']);


//*lecturador
$router->get('/lecturador/dashboard', [DashboardLecturadorController::class, 'index']);

//consumos lecturador
$router->get('/lecturador/lectura', [FacturacionLecturadorController::class, 'indexLectura']);
$router->post('/lecturador/lectura', [FacturacionLecturadorController::class, 'indexLectura']);
$router->get('/lecturador/lectura/crear', [FacturacionLecturadorController::class, 'crearLectura']);
$router->post('/lecturador/lectura/crear', [FacturacionLecturadorController::class, 'crearLectura']);
$router->get('/lecturador/lectura/editar', [FacturacionLecturadorController::class, 'editarLectura']);
$router->post('/lecturador/lectura/editar', [FacturacionLecturadorController::class, 'editarLectura']);
$router->post('/lecturador/lectura/eliminar', [FacturacionLecturadorController::class, 'eliminarLectura']);
$router->get('/lecturador/lectura/generar', [FacturacionLecturadorController::class, 'generarLectura']);
$router->post('/lecturador/lectura/generar', [FacturacionLecturadorController::class, 'generarLectura']);


// solicitudes para lecturador
$router->get('/lecturador/solicitudes', [SolicitudController::class, 'listaLecturador']);
$router->get('/lecturador/solicitudes/finalizar', [SolicitudController::class, 'finalizarLecturador']);
$router->post('/lecturador/solicitudes/finalizar', [SolicitudController::class, 'finalizarLecturador']);


$router->comprobarRutas();
