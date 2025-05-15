<?php 

namespace Model;

class EstadoServicio extends ActiveRecord {
    protected static $tabla = 'estado_servicio';
    protected static $columnasDB = ['id', 'codigo', 'nombre', 'descripcion'];

    public $id;
    public $codigo;
    public $nombre;
    public $descripcion;
}
