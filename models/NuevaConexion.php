<?php

namespace Model;

class NuevaConexion extends ActiveRecord
{
    protected static $tabla = 'nueva_conexion';
    protected static $columnasDB = [
        'id',
        'tipo_solicitante',
        'tipo_persona',
        'tipo_documento_natural',
        'numero_documento_natural',
        'tipo_documento_juridico',
        'numero_documento_juridico',
        'razon_social',
        'nombre',
        'apellido1',
        'apellido2',
        'email',
        'tipo_servicio',
        'servicio',
        'celular',
        'localidad',
        'direccion_principal',
        'referencia_direccion',
        'documento_propiedad',
        'dni_documento',
        'croquis',
        'foto_instalacion',
        'foto_recibo',
        'foto_autorizacion_notarial',
        'foto_vigencia_poder',
        'fecha_solicitud',
        'codigo_seguimiento',
        'estado_id',
        'tecnico_id',
        'observacion_rechazo'
    ];

    public $id;
    public $tipo_solicitante;
    public $tipo_persona;
    public $tipo_documento_natural;
    public $numero_documento_natural;
    public $tipo_documento_juridico;
    public $numero_documento_juridico;
    public $razon_social;
    public $nombre;
    public $apellido1;
    public $apellido2;
    public $email;
    public $tipo_servicio;
    public $servicio;
    public $celular;
    public $localidad;
    public $direccion_principal;
    public $referencia_direccion;
    public $documento_propiedad;
    public $dni_documento;
    public $croquis;
    public $foto_instalacion;
    public $foto_recibo;
    public $foto_autorizacion_notarial;
    public $foto_vigencia_poder;
    public $fecha_solicitud;
    public $codigo_seguimiento;
    public $estado_id;
    public $tecnico_id;
    public $observacion_rechazo;







    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->tipo_solicitante = $args['tipo_solicitante'] ?? '';
        $this->tipo_persona = $args['tipo_persona'] ?? '';
        $this->tipo_documento_natural = $args['tipo_documento_natural'] ?? '';
        $this->numero_documento_natural = $args['numero_documento_natural'] ?? '';
        $this->tipo_documento_juridico = $args['tipo_documento_juridico'] ?? '';
        $this->numero_documento_juridico = $args['numero_documento_juridico'] ?? '';
        $this->razon_social = $args['razon_social'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido1 = $args['apellido1'] ?? '';
        $this->apellido2 = $args['apellido2'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->tipo_servicio = $args['tipo_servicio'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->celular = $args['celular'] ?? '';
        $this->localidad = $args['localidad'] ?? '';
        $this->direccion_principal = $args['direccion_principal'] ?? '';
        $this->referencia_direccion = $args['referencia_direccion'] ?? '';
        $this->documento_propiedad = $args['documento_propiedad'] ?? '';
        $this->dni_documento = $args['dni_documento'] ?? '';
        $this->croquis = $args['croquis'] ?? '';
        $this->foto_instalacion = $args['foto_instalacion'] ?? '';
        $this->foto_recibo = $args['foto_recibo'] ?? '';
        $this->foto_autorizacion_notarial = $args['foto_autorizacion_notarial'] ?? '';
        $this->foto_vigencia_poder = $args['foto_vigencia_poder'] ?? '';
        $this->fecha_solicitud = $args['fecha_solicitud'] ?? date('Y-m-d');
        $this->codigo_seguimiento = $args['codigo_seguimiento'] ?? '';
        $this->estado_id = $args['estado_id'] ?? '1';
        $this->tecnico_id = $args['tecnico_id'] ?? '100';
        $this->observacion_rechazo = $args['observacion_rechazo'] ?? 'ninguna';



    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es obligatorio';
        }
        if (!$this->apellido1) {
            self::$alertas['error'][] = 'El Primer Apellido es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Correo es obligatorio';
        }
        if (!$this->celular) {
            self::$alertas['error'][] = 'El Celular es obligatorio';
        }
        if (!$this->direccion_principal) {
            self::$alertas['error'][] = 'La Dirección Principal es obligatoria';
        }

        // Validación de archivos obligatorios
        if (!$this->documento_propiedad) {
            self::$alertas['error'][] = 'El Documento de Propiedad es obligatorio';
        }
        if (!$this->dni_documento) {
            self::$alertas['error'][] = 'El Documento de Identidad (DNI) es obligatorio';
        }
        if (!$this->croquis) {
            self::$alertas['error'][] = 'El Croquis del Predio es obligatorio';
        }
        if (!$this->foto_instalacion) {
            self::$alertas['error'][] = 'La Foto de la Instalación es obligatoria';
        }
        if (!$this->foto_recibo) {
            self::$alertas['error'][] = 'El Último Recibo es obligatorio';
        }

        return self::$alertas;
    }
}
