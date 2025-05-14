<?php 

namespace Model;

class Roles extends ActiveRecord {
    protected static $tabla = 'roles';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;
}