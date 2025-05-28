<?php

namespace Model;

class Recibo extends ActiveRecord
{
    protected static $tabla = 'recibos';
    protected static $columnasDB = ['id', 'pago_id', 'numero_recibo', 'fecha_emision', 'estado_id'];

    public $id;
    public $pago_id;
    public $numero_recibo;
    public $fecha_emision;
    public $estado_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->pago_id = $args['pago_id'] ?? null;
        $this->numero_recibo = $args['numero_recibo'] ?? '';
        $this->fecha_emision = $args['fecha_emision'] ?? date('Y-m-d');
        $this->estado_id = $args['estado_id'] ?? 1;
    }
}
