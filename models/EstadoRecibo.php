<?php 

namespace Model;

class EstadoRecibo extends ActiveRecord {
    protected static $tabla = 'estado_recibo';
    protected static $columnasDB = ['id', 'codigo', 'nombre', 'descripcion'];

    public $id;
    public $codigo;
    public $nombre;
    public $descripcion;
}
