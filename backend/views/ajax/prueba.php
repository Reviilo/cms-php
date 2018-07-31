
<?php

class Prueba {

    public $imgAll;
    public $imgName;
    public $imgTemp;
    public $imgType;
    public function mostrarInformacion () {
            
        $datos = array(
            "all" => $this-> imgAll,
            "name" => $this -> imgName,
            "temp" => $this -> imgTemp,
            "type" => $this -> imgType[1],
            "ruta" => "../../views/images/slide/slide.".$this -> imgType[1]
        );

        echo json_encode($datos);
    }
}

$p = new Prueba();
$p -> imgAll = $_FILES["img"];
$p -> imgName = $_FILES["img"]["name"];
$p -> imgTemp = $_FILES["img"]["tmp_name"];
$p -> imgType = explode("/", $_FILES["img"]["type"]);
$p -> mostrarInformacion();