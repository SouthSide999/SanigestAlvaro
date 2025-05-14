<?php

namespace Model;

class Tarifa extends ActiveRecord
{
    protected static $tabla = 'tarifas';
    protected static $columnasDB = [
        'id',
        'codigo_tarifa',
        'nombre_tarifa',
        'valor_tarifa'
    ];

    public $id;
    public $codigo_tarifa;
    public $nombre_tarifa;
    public $valor_tarifa;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->codigo_tarifa = $args['codigo_tarifa'] ?? '';
        $this->nombre_tarifa = $args['nombre_tarifa'] ?? '';
        $this->valor_tarifa = $args['valor_tarifa'] ?? 0.00;
    }

    public function validar()
    {
        if (!$this->codigo_tarifa) {
            self::$alertas['error'][] = 'El código de tarifa es obligatorio.';
        }

        if (!$this->nombre_tarifa) {
            self::$alertas['error'][] = 'El nombre de la tarifa es obligatorio.';
        }

        if ($this->valor_tarifa === null || $this->valor_tarifa === '') {
            self::$alertas['error'][] = 'El valor de la tarifa es obligatorio.';
        } elseif (!is_numeric($this->valor_tarifa)) {
            self::$alertas['error'][] = 'El valor de la tarifa debe ser numérico.';
        }

        return self::$alertas;
    }
}
