<?php

require_once "../../models/gestorSlide.php";
require_once "../../controllers/gestorSlide.php";

## CLASE Y MÉTODOS
##----------------------------------------------------------------
class Ajax {
    public $imgName;
    public $imgTemp;
    public $imgType;

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

}

## OBJETOS
##----------------------------------------------------------------

$a = new Ajax();
$a -> imgName = $_FILES["img"]["name"];
$a -> imgTemp = $_FILES["img"]["tmp_name"];
$a -> imgType = explode("/", $_FILES["img"]["type"]);
$a -> gestorSlideAjax();