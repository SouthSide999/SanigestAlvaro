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
        'anio',
        'numero_comprobante',  // agregado
        'usuario_id'           // agregado
    ];

    public $id;
    public $consumo_id;
    public $monto_pagado;
    public $fecha_pago;
    public $created_at;
    public $estado_id;
    public $mes;
    public $anio;
    public $numero_comprobante;  // agregado
    public $usuario_id;           // agregado

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->consumo_id = $args['consumo_id'] ?? '';
        $this->monto_pagado = $args['monto_pagado'] ?? '';
        $this->fecha_pago = $args['fecha_pago'] ?? '';
        $this->created_at = $args['created_at'] ?? date('Y-m-d');
        $this->estado_id = $args['estado_id'] ?? 1;
        $this->mes = $args['mes'] ?? date('n');  // mes numérico actual
        $this->anio = $args['anio'] ?? date('Y');  // año actual
        $this->numero_comprobante = $args['numero_comprobante'] ?? '';
        $this->usuario_id = $args['usuario_id'] ?? null;
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
        // Validación opcional para numero_comprobante (puede dejarse vacío si generas uno automático)
        if ($this->numero_comprobante && strlen($this->numero_comprobante) > 100) {
            self::$alertas['error'][] = 'El número de comprobante es demasiado largo.';
        }
        // Validar que usuario_id sea numérico y no nulo (puede ser obligatorio)
        if (!$this->usuario_id || !is_numeric($this->usuario_id)) {
            self::$alertas['error'][] = 'El usuario que realiza el pago es obligatorio.';
        }

        return self::$alertas;
    }
}
