<?php

namespace Model;

class Zona extends ActiveRecord
{
    protected static $tabla = 'zonas';
    protected static $columnasDB = [
        'id',
        'codigo_zona',
        'nombre_zona',
        'created_at'
    ];

    public $id;
    public $codigo_zona;
    public $nombre_zona;
    public $created_at;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->codigo_zona = $args['codigo_zona'] ?? '';
        $this->nombre_zona = $args['nombre_zona'] ?? '';
        $this->created_at = $args['created_at'] ?? date('Y-m-d H:i:s');
    }

    public function validar()
    {
        if (!$this->nombre_zona) {
            self::$alertas['error'][] = 'El nombre de la zona es obligatorio.';
        }
        return self::$alertas;
    }
}
