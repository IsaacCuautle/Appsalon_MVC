<?php 

namespace Controllers;

use Model\Cita;
use Model\CitasServicio;
use Model\servicio;

class APIController{
    public static function index() {
        $servicios = servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar(){
        //Almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita -> guardar();
        $id = $resultado['id'];

        //Almacena los servicios con el id de la cita
        $idServicios = explode("," , $_POST['servicios']);
        foreach ($idServicios as $idServicio){
            $args = [
                'citaId' =>  $id,
                'servicioid' => $idServicio
            ];
            $citaServicio = new CitasServicio($args);
            $citaServicio -> guardar();
        }
        
        //retorna una respuesta
        echo json_encode(['resultado' => $resultado]);
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $cita =Cita::find($id);
            $cita -> eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}

?>