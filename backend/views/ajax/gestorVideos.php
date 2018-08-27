<?php

require_once "../../models/gestorVideos.php";
require_once "../../controllers/gestorVideos.php";

## CLASE Y MÉTODOS
##----------------------------------------------------------------
class Ajax {
    public $videoName;
    public $videoTemp;
    public $videoType;

    public $id;
    public $ruta;
    public $orden;

    ## Enviar datos de la imagen al controlador
    public function gestorVideoAjax () {

        $datos = array(
            "name" => $this -> videoName,
            "temp" => $this -> videoTemp,
            "type" => $this -> videoType[1]
        );

        $res = GestorVideosController::mostrarVideoController($datos);

        echo $res;
    }

    ## Enviar datos de la imagen al controlador
    public function eliminarVideo() {

        $datos = array("id" => $this->id, "ruta" => $this->ruta );

        $res = GestorVideosController::eliminarVideo($datos);

        echo $res;
    }


    ## Actualizar orden de las imagenes
    public function actualizarOrden() {
        $datos = array("id" => $this->id, "orden" => $this->orden);

        $res = GestorVideosController::ordenarVideo($datos);

        echo $res;
    }

}

## OBJETOS
##----------------------------------------------------------------

if (isset( $_FILES["video"] ) ) {
    $a = new Ajax();
    $a -> videoName = $_FILES["video"]["name"];
    $a -> videoTemp = $_FILES["video"]["tmp_name"];
    $a -> videoType = explode("/", $_FILES["video"]["type"]);
    $a -> gestorVideoAjax();
}

if ( isset( $_POST["accion"]) ) {
    $accion = $_POST["accion"];
    if ($accion === "eliminar") {
        $b = new Ajax();
        $b -> id = $_POST["id"];
        $b -> ruta = $_POST["ruta"];
        $b -> eliminarVideo();
    } else if ($accion === "ordenar") {
        $d = new Ajax();
        $d -> id = $_POST["id"];
        $d -> orden = $_POST["orden"];
        $d -> actualizarOrden();
    }
}