<?php  
namespace Model;

class Consumo extends ActiveRecord {
    protected static $tabla = 'consumos';
    protected static $columnasDB = [
        'id',
        'predio_id',
        'mes',
        'fecha_inicio',
        'fecha_fin',
        'anio',
        'consumo_m3',
        'monto_total',
        'created_at',
        'estado_id'
    ];

    public $id;
    public $predio_id;
    public $mes;
    public $fecha_inicio;
    public $fecha_fin;
    public $anio;
    public $consumo_m3;
    public $monto_total;
    public $created_at;
    public $estado_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->predio_id = $args['predio_id'] ?? null;
        $this->mes = $args['mes'] ?? null;
        $this->fecha_inicio = $args['fecha_inicio'] ?? null;
        $this->fecha_fin = $args['fecha_fin'] ?? null;
        $this->anio = $args['anio'] ?? null;
        $this->consumo_m3 = $args['consumo_m3'] ?? null;
        $this->monto_total = $args['monto_total'] ?? null;
        $this->created_at = $args['created_at'] ?? null;
        $this->estado_id = $args['estado_id'] ?? 1; // Por defecto estado 1
    }

    // Método para validar los datos del consumo
    public function validar() {
        $alertas = [];

        if (!$this->predio_id) {
            $alertas['error'][] = 'Debe seleccionar un predio';
        }

        if (!$this->mes || $this->mes < 1 || $this->mes > 12) {
            $alertas['error'][] = 'El mes es obligatorio y debe estar entre 1 y 12';
        }

        if (!$this->anio || $this->anio < 2000) {
            $alertas['error'][] = 'Debe ingresar un año válido';
        }

        if (!$this->fecha_inicio) {
            $alertas['error'][] = 'La fecha de inicio es obligatoria';
        }

        if (!$this->fecha_fin) {
            $alertas['error'][] = 'La fecha de fin es obligatoria';
        }

        if (!$this->consumo_m3 || $this->consumo_m3 < 0) {
            $alertas['error'][] = 'Debe ingresar un consumo válido en m³';
        }

        if (!$this->monto_total || $this->monto_total < 0) {
            $alertas['error'][] = 'Debe ingresar un monto total válido';
        }

        return $alertas;
    }
}
