<?php

namespace Model;

class Contacto extends ActiveRecord
{
    protected static $tabla = 'contacto';
    protected static $columnasDB = ['id', 'nombre', 'numero', 'mensaje','estado','asunto'];

    public $id;
    public $nombre;
    public $numero;
    public $mensaje;
    public $estado;
    public $asunto;





    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->numero = $args['numero'] ?? '';
        $this->mensaje = $args['mensaje'] ?? '';
        $this->estado = $args['mensaje'] ?? 0;
        $this->asunto = $args['asunto'] ?? '';



    }

    // Mensajes de validación para la creación de un evento
    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->numero) {
            self::$alertas['error'][] = 'El numero es Obligatorio';
        }
        if(!$this->mensaje) {
            self::$alertas['error'][] = 'El mensaje es obligatorio';
        }
        if(!$this->asunto) {
            self::$alertas['error'][] = 'El asunto es obligatorio';
        }
        return self::$alertas;
    }
}
