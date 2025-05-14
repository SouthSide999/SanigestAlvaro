<?php

namespace Model;

class Predio extends ActiveRecord
{
    protected static $tabla = 'predios';
    protected static $columnasDB = [
        'id',
        'codigo_predio',
        'contribuyente_id',
        'tarifa_id', // agregado
        'zona_id',
        'sector_id',
        'manzana',
        'lote_numero',
        'direccion',
        'secuencia',
        'situacion',
        'fecha_registro',
        'created_at'
    ];

    public $id;
    public $codigo_predio;
    public $contribuyente_id;
    public $tarifa_id; // agregado
    public $zona_id;
    public $sector_id;
    public $manzana;
    public $lote_numero;
    public $direccion;
    public $secuencia;
    public $situacion;
    public $fecha_registro;
    public $created_at;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->codigo_predio = $args['codigo_predio'] ?? '';
        $this->contribuyente_id = $args['contribuyente_id'] ?? null;
        $this->tarifa_id = $args['tarifa_id'] ?? null; // agregado
        $this->zona_id = $args['zona_id'] ?? null;
        $this->sector_id = $args['sector_id'] ?? null;
        $this->manzana = $args['manzana'] ?? '';
        $this->lote_numero = $args['lote_numero'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->secuencia = $args['secuencia'] ?? '';
        $this->situacion = $args['situacion'] ?? 'activo';
        $this->fecha_registro = $args['fecha_registro'] ?? date('Y-m-d');
        $this->created_at = $args['created_at'] ?? date('Y-m-d H:i:s');
    }

    public function validar()
    {
        if (!$this->codigo_predio) {
            self::$alertas['error'][] = 'El código del predio es obligatorio.';
        }
        if (!$this->contribuyente_id) {
            self::$alertas['error'][] = 'El contribuyente es obligatorio.';
        }
        if (!$this->tarifa_id) {
            self::$alertas['error'][] = 'La tarifa es obligatoria.';
        }
        if (!$this->zona_id) {
            self::$alertas['error'][] = 'La zona es obligatoria.';
        }
        if (!$this->sector_id) {
            self::$alertas['error'][] = 'El sector es obligatorio.';
        }
        if (!$this->direccion) {
            self::$alertas['error'][] = 'La dirección es obligatoria.';
        }
        if (!$this->situacion) {
            self::$alertas['error'][] = 'La situación es obligatoria.';
        }
        if (!$this->fecha_registro) {
            self::$alertas['error'][] = 'La fecha de registro es obligatoria.';
        }
        return self::$alertas;
    }
}
