<?php 

namespace Model;

class EstadoPago extends ActiveRecord {
    protected static $tabla = 'estado_pago';
    protected static $columnasDB = ['id', 'codigo', 'nombre', 'descripcion'];

    public $id;
    public $codigo;
    public $nombre;
    public $descripcion;
}
