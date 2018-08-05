<?php

require_once "../../controllers/gestorArticulos.php";

## CLASE Y MÉTODOS
##----------------------------------------------------------------
class Ajax {
    public $imgTemp;
    public $imgType;
    public $id;
    public $ruta;

    ## Enviar datos de la imagen al controlador
    public function gestorArticuloAjax () {

        $datos = array(
            "temp" => $this -> imgTemp,
            "type" => $this -> imgType[1]
        );

        $res = GestorArticulosController::mostrarImagenController($datos);

        echo $res;
    }

    ## Enviar datos de la imagen al controlador
    public function eliminarArticuloAjax() {

        $datos = array("id" => $this->id, "ruta" => $this->ruta );

        $res = GestorArticulosController::eliminarArticuloController($datos);

        echo $res;
    }
}

## OBJETOS
##----------------------------------------------------------------

if (isset( $_FILES["img"] ) ) {
    $a = new Ajax();
    $a -> imgTemp = $_FILES["img"]["tmp_name"];
    $a -> imgType = explode("/", $_FILES["img"]["type"]);
    $a -> gestorArticuloAjax();
}

if ( isset( $_POST["actividad"]) ) {
    $actividad = $_POST["actividad"];
    if ($actividad === "eliminar") {
        $b = new Ajax();
        $b -> id = $_POST["id"];
        $b -> ruta = "../../".$_POST["ruta"];
        $b -> eliminarArticuloAjax();
    } else if ($actividad === "actualizar") {
        $c = new Ajax();
        $c -> idSlide = $_POST["id"];
        $c -> tituloSlide = $_POST["titulo"];
        $c -> descripcionSlide = $_POST["descripcion"];
        $c -> actualizarImagenSlideAjax();
    } else if ($actividad === "ordenar") {
        $d = new Ajax();
        $d -> idSlide = $_POST["id"];
        $d -> ordenSlide = $_POST["orden"];
        $d -> actualizarOrdenSlideAjax();
    }
    
}