<?php

namespace Model;

class Contribuyente extends ActiveRecord
{
    protected static $tabla = 'contribuyentes';
    protected static $columnasDB = [
        'id',
        'codigo_contribuyente',
        'nombres',
        'apellidos',
        'tipo_usuario',
        'estado_civil',
        'documento_identidad',
        'fecha_inscripcion',
        'observaciones'

    ];

    public $id;
    public $codigo_contribuyente;
    public $nombres;
    public $apellidos;
    public $tipo_usuario;
    public $estado_civil;
    public $documento_identidad;
    public $fecha_inscripcion;
    public $observaciones;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->codigo_contribuyente = $args['codigo_contribuyente'] ?? null;
        $this->nombres = $args['nombres'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->tipo_usuario = $args['tipo_usuario'] ?? '';
        $this->estado_civil = $args['estado_civil'] ?? '';
        $this->documento_identidad = $args['documento_identidad'] ?? '';
        $this->fecha_inscripcion = $args['fecha_inscripcion'] ?? date('Y-m-d');
        $this->observaciones = $args['observaciones'] ?? '';

    }

    // Validaciones básicas
    public function validar()
    {
        if (!$this->nombres) {
            self::$alertas['error'][] = 'El nombre es obligatorio.';
        }

        if (!$this->apellidos) {
            self::$alertas['error'][] = 'El apellido es obligatorio.';
        }

        if (!$this->documento_identidad) {
            self::$alertas['error'][] = 'El documento (DNI o RUC) es obligatorio.';
        }

        return self::$alertas;
    }


}
