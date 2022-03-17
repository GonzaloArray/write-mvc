<?php

namespace Model;

use Model\ActiveRecord;

class Proyecto extends ActiveRecord{
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietario_id'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietario_id = $args['propietario_id'] ?? '';
    }

    public function validarProyecto(){
        //Solo vamos a validar el nombre del proyecto
        if (!$this->proyecto) {
            self::$alertas['error'][] = 'El nombre del proyecto es obligatorio';
        }
        return self::$alertas;
    }
}