<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController{
    public static function index(){
        $proyecto_id = $_GET['id'];
        if (!$proyecto_id) header('Location: /dashboard'); 
        //Aca vamos a buscar la url del id y mostrar el id de crear 
        $proyecto = Proyecto::where('url', $proyecto_id);


        session_start();
        //Aca vamos a decirle que si no esta la url de la tarea vamos a redirigirlo
        if (!$proyecto || $proyecto->propietario_id !== $_SESSION['id']) header('Location: /404');

        $tareas = Tarea::belongsTo('proyecto_id', $proyecto->id);


        echo json_encode(['tareas' => $tareas]);
    }
    public static function crear(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $proyecto_id = $_POST['proyecto_id'];

            $proyecto = Proyecto::where('url', $proyecto_id);

            if(!$proyecto || $proyecto->propietario_id !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            } 
            
            // Todo bien, instanciar y crear la tarea
            $tarea = new Tarea($_POST);
            $tarea->proyecto_id = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea Creada Correctamente',
                'proyecto_id' => $proyecto->id
            ];
            echo json_encode($respuesta);
        }
    }
    public static function actualizar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Vamos a validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['proyecto_id']);

            session_start();

            if(!$proyecto || $proyecto->propietario_id !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al actualizar'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->proyecto_id = $proyecto->id;

            $resultado = $tarea->guardar();
            
            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyecto_id' => $proyecto->id
                    /* 'mensaje' => 'actualizado correctamente' */
                    
                ];
                echo json_encode(['respuesta' => $respuesta]);
            }
        }
    }
    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Vamos a validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['proyecto_id']);

            session_start();

            if(!$proyecto || $proyecto->propietario_id !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al actualizar'
                ];
                echo json_encode($respuesta);
                return;
            }

            //Vamos a instanciar la tarea...
            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();

            
            $resultado = [
                'resultado' => $resultado,
                'mensaje' => 'Eliminado correctamente', 
                'tipo' => 'exito'
                
            ];
            echo json_encode($resultado);
        }
    }
    
}