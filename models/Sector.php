<?php

namespace Model;

class Sector extends ActiveRecord
{
    protected static $tabla = 'sectores';
    protected static $columnasDB = [
        'id',
        'codigo_sector',
        'nombre_sector',
        'zona_id',
        'created_at'
    ];

    public $id;
    public $codigo_sector;
    public $nombre_sector;
    public $zona_id;
    public $created_at;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->codigo_sector = $args['codigo_sector'] ?? '';
        $this->nombre_sector = $args['nombre_sector'] ?? '';
        $this->zona_id = $args['zona_id'] ?? '';
        $this->created_at = $args['created_at'] ?? date('Y-m-d H:i:s');
    }

    public function validar()
    {
        if (!$this->nombre_sector) {
            self::$alertas['error'][] = 'El nombre del sector es obligatorio.';
        }

        if (!$this->zona_id) {
            self::$alertas['error'][] = 'Debe seleccionar una zona.';
        }

        return self::$alertas;
    }
}
