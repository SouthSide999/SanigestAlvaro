<?php

namespace Model;

class Noticia extends ActiveRecord
{
    protected static $tabla = 'noticias';
    protected static $columnasDB = ['id', 'nombre', 'contenido', 'imagen'];

    public $id;
    public $nombre;
    public $contenido;
    public $imagen;



    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
        $this->imagen = $args['imagen'] ?? '';

    }

    // Mensajes de validación para la creación de un evento
    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->contenido) {
            self::$alertas['error'][] = 'El contenido es Obligatorio';
        }
        if(!$this->imagen) {
            self::$alertas['error'][] = 'La imagen es obligatoria';
        }
        return self::$alertas;
    }
}
