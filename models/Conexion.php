<?php  
namespace Model;

class Conexion extends ActiveRecord {
    protected static $tabla = 'conexiones';
    protected static $columnasDB = [
        'id',
        'numero_conexiones',
        'operativos',
        'no_operativos',
        'predio_id'
    ];

    public $id;
    public $numero_conexiones;
    public $operativos;
    public $no_operativos;
    public $predio_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->numero_conexiones = $args['numero_conexiones'] ?? null;
        $this->operativos = $args['operativos'] ?? null;
        $this->no_operativos = $args['no_operativos'] ?? null;
        $this->predio_id = $args['predio_id'] ?? null;
    }

    // Método para validar los datos de la conexión
    public function validar() {
        $alertas = [];

        if (!$this->numero_conexiones) {
            $alertas['error'][] = 'El número de conexiones es obligatorio';
        }

        if (!$this->predio_id) {
            $alertas['error'][] = 'Debe seleccionar un predio';
        }

        return $alertas;
    }
}
