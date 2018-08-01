<?php

require_once "../../models/gestorSlide.php";
require_once "../../controllers/gestorSlide.php";

## CLASE Y MÉTODOS
##----------------------------------------------------------------
class Ajax {
    public $imgName;
    public $imgTemp;
    public $imgType;
    public $idSlide;
    public $rutaSlide;

    ## Enviar datos de la imagen al controlador
    public function gestorSlideAjax () {

        $datos = array(
            "name" => $this -> imgName,
            "temp" => $this -> imgTemp,
            "type" => $this -> imgType[1]
        );

        $res = GestorSlideController::mostrarImagenController($datos);

        echo $res;
    }

    ## Enviar datos de la imagen al controlador
    public function eliminarSlideAjax() {

        $datos = array("id" => $this->idSlide, "ruta" => $this->rutaSlide );

        $res = GestorSlideController::eliminarSlideController($datos);

        echo $res;
    }

}

## OBJETOS
##----------------------------------------------------------------

if (isset( $_FILES["img"] ) ) {
    $a = new Ajax();
    $a -> imgName = $_FILES["img"]["name"];
    $a -> imgTemp = $_FILES["img"]["tmp_name"];
    $a -> imgType = explode("/", $_FILES["img"]["type"]);
    $a -> gestorSlideAjax();
}

if ( isset( $_POST["id"] ) ) {
    $b = new Ajax();
    $b -> idSlide = $_POST["id"];
    $b -> rutaSlide = "../../".$_POST["ruta"];
    $b -> eliminarSlideAjax();
}

