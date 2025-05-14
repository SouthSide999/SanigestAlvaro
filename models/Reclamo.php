<?php 

namespace Model;

class Reclamo extends ActiveRecord {
    protected static $tabla = 'reclamos';
    protected static $columnasDB = ['id', 'cliente_id', 'tipo_reclamo_id', 'numero', 'descripcion', 'evidencia', 'fecha','estado'];

    public $id;
    public $cliente_id;
    public $tipo_reclamo_id;
    public $numero;
    public $descripcion;
    public $evidencia;
    public $fecha;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cliente_id = $args['cliente_id'] ?? null;
        $this->tipo_reclamo_id = $args['tipo_reclamo_id'] ?? null;
        $this->numero = $args['numero'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->evidencia = $args['evidencia'] ?? null;
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
        $this->estado = $args['mensaje'] ?? 0;
    }

    public function validar() {
        if(!$this->cliente_id) {
            self::$alertas['error'][] = 'El usuario es obligatorio';
        }
        if(!$this->tipo_reclamo_id) {
            self::$alertas['error'][] = 'El tipo de reclamo es obligatorio';
        }
        if(!$this->numero) {
            self::$alertas['error'][] = 'El número de contacto es obligatorio';
        }
        if(!$this->descripcion) {
            self::$alertas['error'][] = 'La descripción es obligatoria';
        }
    
        return self::$alertas;
    }
}
