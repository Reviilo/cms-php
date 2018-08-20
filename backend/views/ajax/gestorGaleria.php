<?php

require_once "../../models/gestorGaleria.php";
require_once "../../controllers/gestorGaleria.php";

## CLASE Y MÉTODOS
##----------------------------------------------------------------
class Ajax {
    public $imgTemp;
    public $imgType;
    public $id;
    public $ruta;
    // public $orden;

    ## Enviar datos de la imagen al controlador
    public function gestorGaleriaAjax () {

        $datos = array(
            "temp" => $this -> imgTemp,
            "type" => $this -> imgType[1]
        );

        $res = GestorGaleriaController::guardarImagenController($datos);

        echo $res;
    }

    ## Enviar datos de la imagen al controlador
    public function eliminarImagenAjax() {

        $datos = array("id" => $this->id, "ruta" => $this->ruta );

        $res = GestorGaleriaController::eliminarImagenController($datos);

        echo $res;
        
    }

    ## Orden del articulo
    public function actualizarOrdenAjax() {

        $datos = array("id" => $this->id, "orden" => $this->orden );

        $res = GestorGaleriaController::actualizarOrden($datos);

        echo $res;

    }

    public function prueba() {
        $res = GestorGaleriaController::prueba($this -> ruta);
        
        echo $res;

        // echo $this -> ruta;
    }
}

## OBJETOS
##----------------------------------------------------------------

if (isset( $_FILES["img"] ) ) {
    $a = new Ajax();
    $a -> imgTemp = $_FILES["img"]["tmp_name"];
    $a -> imgType = explode("/", $_FILES["img"]["type"]);
    $a -> gestorGaleriaAjax();
}

if ( isset( $_POST["accion"]) ) {
    $accion = $_POST["accion"];
    if ($accion === "ordenar") {
        $d = new Ajax();
        $d -> id = $_POST["id"];
        $d -> orden = $_POST["orden"];
        $d -> actualizarOrdenAjax();
    } else if ($accion === "eliminar") {
        $d = new Ajax();
        $d -> id = $_POST["id"];
        $d -> ruta = $_POST["ruta"];
        $d -> eliminarImagenAjax();
    } else if ($accion === "prueba") {
        $a = new Ajax();
        // $a -> ruta = $_POST["ruta"];
        $a -> ruta = substr($_POST["ruta"], -34);
        $a -> prueba();
    }
}