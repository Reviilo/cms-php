<?php

require_once "../../controllers/gestorArticulos.php";

## CLASE Y MÉTODOS
##----------------------------------------------------------------
class Ajax {
    public $imgTemp;
    public $imgType;

    ## Enviar datos de la imagen al controlador
    public function gestorArticuloAjax () {

        $datos = array(
            "temp" => $this -> imgTemp,
            "type" => $this -> imgType[1]
        );

        $res = GestorArticulosController::mostrarImagenController($datos);

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