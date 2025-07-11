<?php

namespace Model;

class Tarifa extends ActiveRecord
{
    protected static $tabla = 'tarifas';
    protected static $columnasDB = [
        'id',
        'codigo_tarifa',
        'nombre_tarifa',
        'clase',
        'categoria',
        'rango_min',
        'rango_max',
        'tarifa_agua',
        'tarifa_desague',
        'cargo_fijo'
    ];

    public $id;
    public $codigo_tarifa;
    public $nombre_tarifa;
    public $clase;
    public $categoria;
    public $rango_min;
    public $rango_max;
    public $tarifa_agua;
    public $tarifa_desague;
    public $cargo_fijo;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->codigo_tarifa = $args['codigo_tarifa'] ?? '';
        $this->nombre_tarifa = $args['nombre_tarifa'] ?? '';
        $this->clase = $args['clase'] ?? '';
        $this->categoria = $args['categoria'] ?? 'General';
        $this->rango_min = $args['rango_min'] ?? 0;
        $this->rango_max = $args['rango_max'] ?? 9999;
        $this->tarifa_agua = $args['tarifa_agua'] ?? 0.0000;
        $this->tarifa_desague = $args['tarifa_desague'] ?? 0.0000;
        $this->cargo_fijo = $args['cargo_fijo'] ?? 0.00;
    }

    public function validar()
    {
        if (!$this->codigo_tarifa) {
            self::$alertas['error'][] = 'El código de tarifa es obligatorio.';
        }

        if (!$this->nombre_tarifa) {
            self::$alertas['error'][] = 'El nombre de la tarifa es obligatorio.';
        }

        if (!$this->clase) {
            self::$alertas['error'][] = 'La clase es obligatoria.';
        }

        if (!is_numeric($this->rango_min)) {
            self::$alertas['error'][] = 'El rango mínimo debe ser numérico.';
        }

        if (!is_numeric($this->rango_max)) {
            self::$alertas['error'][] = 'El rango máximo debe ser numérico.';
        }

        if (!is_numeric($this->tarifa_agua)) {
            self::$alertas['error'][] = 'La tarifa de agua debe ser numérica.';
        }

        if (!is_numeric($this->tarifa_desague)) {
            self::$alertas['error'][] = 'La tarifa de desagüe debe ser numérica.';
        }

        if (!is_numeric($this->cargo_fijo)) {
            self::$alertas['error'][] = 'El cargo fijo debe ser numérico.';
        }

        return self::$alertas;
    }
}
