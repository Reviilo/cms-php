<?php

require_once "../../models/gestorArticulos.php";
require_once "../../controllers/gestorArticulos.php";

## CLASE Y MÉTODOS
##----------------------------------------------------------------
class Ajax {
    public $imgTemp;
    public $imgType;
    public $id;
    public $ruta;
    public $orden;

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

    ## Orden del articulo
    public function actualizarOrdenArticuloAjax() {

        $datos = array("id" => $this->id, "orden" => $this->orden );

        $res = GestorArticulosController::actualizarOrdenArticuloController($datos);

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

if ( isset( $_POST["accion"]) ) {
    $accion = $_POST["accion"];
    if ($accion === "ordenar") {
        $d = new Ajax();
        $d -> id = $_POST["id"];
        $d -> orden = $_POST["orden"];
        $d -> actualizarOrdenArticuloAjax();
    }
}