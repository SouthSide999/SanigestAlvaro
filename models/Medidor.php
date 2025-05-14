<?php  
namespace Model;

class Medidor extends ActiveRecord {
    protected static $tabla = 'medidores';
    protected static $columnasDB = [
        'id',
        'numero_medidor',
        'numero_personas',
        'padres',
        'hijos',
        'familiares',
        'inquilinos',
        'observaciones',
        'contribuyente_id',
        'predio_id'
    ];

    public $id;
    public $numero_medidor;
    public $numero_personas;
    public $padres;
    public $hijos;
    public $familiares;
    public $inquilinos;
    public $observaciones;
    public $contribuyente_id;
    public $predio_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->numero_medidor = $args['numero_medidor'] ?? '';
        $this->numero_personas = $args['numero_personas'] ?? null;
        $this->padres = $args['padres'] ?? null;
        $this->hijos = $args['hijos'] ?? null;
        $this->familiares = $args['familiares'] ?? null;
        $this->inquilinos = $args['inquilinos'] ?? null;
        $this->observaciones = $args['observaciones'] ?? '';
        $this->contribuyente_id = $args['contribuyente_id'] ?? null;
        $this->predio_id = $args['predio_id'] ?? null;
    }

    public function validar() {
        $alertas = [];

        if (!$this->numero_medidor) {
            $alertas['error'][] = 'El número del medidor es obligatorio';
        }

        if (!$this->contribuyente_id) {
            $alertas['error'][] = 'Debe seleccionar un contribuyente';
        }

        if (!$this->predio_id) {
            $alertas['error'][] = 'Debe seleccionar un predio';
        }

        return $alertas;
    }
}
