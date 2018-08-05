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
    public $tituloSlide;
    public $descripcionSlide;
    public $ordenSlide;

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

    ## Actualizar datos de la imagen
    public function actualizarImagenSlideAjax() {

        $datos = array("id" => $this->idSlide, "titulo" => $this->tituloSlide, "descripcion" => $this->descripcionSlide );

        $res = GestorSlideController::actualizarSlideController($datos);

        echo $res;
    }

    ## Actualizar orden de las imagenes
    public function actualizarOrdenSlideAjax() {
        $datos = array("id" => $this->idSlide, "orden" => $this->ordenSlide);

        $res = GestorSlideController::ordenarSlideController($datos);

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
    
}

if ( isset( $_POST["actividad"]) ) {
    $actividad = $_POST["actividad"];
    if ($actividad === "eliminar") {
        $b = new Ajax();
        $b -> idSlide = $_POST["id"];
        $b -> rutaSlide = "../../".$_POST["ruta"];
        $b -> eliminarSlideAjax();
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

