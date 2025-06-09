<?php

namespace Model;

class Solicitud extends ActiveRecord
{
    protected static $tabla = 'solicitudes';
    protected static $columnasDB = [
        'id',
        'nombres',
        'apellidos',
        'dni',
        'email',
        'tipo_solicitud_id',
        'descripcion',
        'evidencia',
        'fecha',
        'estado_id',
        'personal_asignado',
        'codigo_seguimiento',
        'observaciones'
    ];

    public $id;
    public $nombres;
    public $apellidos;
    public $dni;
    public $email;
    public $tipo_solicitud_id;
    public $descripcion;
    public $evidencia;
    public $fecha;
    public $estado_id;
    public $personal_asignado;
    public $codigo_seguimiento;
    public $observaciones;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombres = $args['nombres'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->dni = $args['dni'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->tipo_solicitud_id = $args['tipo_solicitud_id'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->evidencia = $args['evidencia'] ?? '';
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
        $this->estado_id = $args['estado_id'] ??'1';
        $this->personal_asignado = $args['personal_asignado'] ?? '1';
        $this->codigo_seguimiento = $args['codigo_seguimiento'] ?? '';
        $this->observaciones = $args['observaciones'] ?? 'ninguna';
    }

    public function validar()
    {
        if (!$this->nombres) {
            self::$alertas['error'][] = 'El Nombre es obligatorio';
        }
        if (!$this->apellidos) {
            self::$alertas['error'][] = 'El Apellido es obligatorio';
        }
        if (!$this->dni) {
            self::$alertas['error'][] = 'El DNI es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Correo Electrónico es obligatorio';
        }
        if (!$this->tipo_solicitud_id) {
            self::$alertas['error'][] = 'El Tipo de Solicitud es obligatorio';
        }
        if (!$this->descripcion) {
            self::$alertas['error'][] = 'La Descripción es obligatoria';
        }

        return self::$alertas;
    }
}
