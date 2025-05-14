<?php 

namespace Model;

class TiposSolicitud extends ActiveRecord {
    protected static $tabla = 'tipos_solicitudes';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;
}