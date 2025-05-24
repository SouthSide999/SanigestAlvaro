<?php

namespace Model;

class Pago extends ActiveRecord
{
    protected static $tabla = 'pagos';
    protected static $columnasDB = [
        'id',
        'consumo_id',
        'monto_pagado',
        'fecha_pago',
        'created_at',
        'estado_id',
        'mes',
        'anio'
    ];

    public $id;
    public $consumo_id;
    public $monto_pagado;
    public $fecha_pago;
    public $created_at;
    public $estado_id;
    public $mes;
    public $anio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->consumo_id = $args['consumo_id'] ?? '';
        $this->monto_pagado = $args['monto_pagado'] ?? '';
        $this->fecha_pago = $args['fecha_pago'] ?? '';
        $this->created_at = $args['created_at'] ?? date('Y-m-d H:i:s');
        $this->estado_id = $args['estado_id'] ?? 1;
        $this->mes = $args['mes'] ?? date('n');  // mes numérico actual
        $this->anio = $args['anio'] ?? date('Y');  // año actual
    }

    public function validar()
    {
        if (!$this->consumo_id) {
            self::$alertas['error'][] = 'El consumo es obligatorio.';
        }
        if (!$this->monto_pagado || !is_numeric($this->monto_pagado)) {
            self::$alertas['error'][] = 'El monto pagado es obligatorio y debe ser numérico.';
        }
        if (!$this->fecha_pago) {
            self::$alertas['error'][] = 'La fecha de pago es obligatoria.';
        }
        if (!$this->mes || !is_numeric($this->mes)) {
            self::$alertas['error'][] = 'El mes es obligatorio y debe ser un número.';
        }
        if (!$this->anio || !is_numeric($this->anio)) {
            self::$alertas['error'][] = 'El año es obligatorio y debe ser un número.';
        }

        return self::$alertas;
    }
}
