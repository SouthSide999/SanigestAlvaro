<?php 

namespace Model;

class TiposReclamos extends ActiveRecord {
    protected static $tabla = 'tipos_reclamos';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;
}