<?php 

namespace Model;

class EstadoConsumo extends ActiveRecord {
    protected static $tabla = 'estado_consumo';
    protected static $columnasDB = ['id', 'codigo', 'nombre', 'descripcion'];

    public $id;
    public $codigo;
    public $nombre;
    public $descripcion;
}
