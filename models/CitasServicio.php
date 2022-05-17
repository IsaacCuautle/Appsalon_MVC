<?php 

namespace Model;

class CitasServicio extends ActiveRecord {
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'citaId', 'servicioid'];

    public $id;
    public $citaId;
    public $servicioid;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->citaId = $args['citaId'] ?? '';
        $this->servicioid = $args['servicioid'] ?? '';
    }
}

?>