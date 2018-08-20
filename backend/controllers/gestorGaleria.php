<?php 

include_once "testInformation.php";

class GestorGaleriaController {

    ## Funcion para crear una imagen
    ##----------------------------------------------------------------
    public function crearImagen ($type, $temp, $rutaCrear, $ancho, $alto) {

        switch ($type) {
            case 'jpg':
            case 'jpeg':
                $origin = imagecreatefromjpeg($temp);
                $imagen = imagecreatetruecolor(1024, 768);
                imagecopyresized($imagen, $origin, 0, 0, 0, 0, 1024, 768, $ancho, $alto);

                // $imagen = imagecrop($origin, ["x" => 0, "y" => 0, "width" => 800, "height" => 400 ]);
                imagejpeg($imagen , $rutaCrear);
                break; 
            case 'png': 
                $origin = imageCreateFromPng($temp);
                $imagen = imagecreatetruecolor(1024, 768);
                imagecopyresized($imagen, $origin, 0, 0, 0, 0, 1024, 768, $ancho, $alto);

                // $imagen = imagecrop($origin, ["x" => 0, "y" => 0, "width" => 800, "height" => 400 ]);
                imagepng($imagen, $rutaCrear);
                break;
        }

    }

    ## Crear imagen para el gestor de imagenes
    ##----------------------------------------------------------------
    public function guardarImagenController ($datos) {

        list($width, $height) = getimagesize($datos["temp"]);

        if ( $width < 800 || $height < 400) {
            echo "0";
        } else {
            $random = mt_rand(100, 999);

            $rutaCrear = "../../views/images/galeria/photo".$random.".".$datos["type"];

            $rutaAcceso = "views/images/galeria/photo".$random.".".$datos["type"];

            $type = $datos["type"];
            $temp = $datos["temp"];

            $data = self::crearImagen($type, $temp, $rutaCrear, $width, $height);

            GestorGaleriaModel::guardarImagenModel($rutaAcceso, "galeria");

            $res = GestorGaleriaModel::traerImagenModel($rutaAcceso, "galeria");

            $datosRepuesta = array("id" => $res["id"], "ruta" => $res["ruta"], "orden" => $res["orden"]);

            echo json_encode($datosRepuesta);
        }
    }

    ## Mostrar los articulos en el front 
    ##----------------------------------------------------------------
    public function mostrarGaleriaController () {
    
        $res = GestorGaleriaModel::traerGaleriaModel("galeria");

        foreach ($res as $row => $item) {
            echo '<li id="'.$item['id'].'" class="bloque">
                    <span class="fa fa-times eliminar-foto"></span>
                    <a rel="grupo" href="'.$item[ruta].'">
                    <img src="'.$item[ruta].'" class="handleImg">
                    </a>
		        </li>';
        }

    }

    ## Eliminar la imagen de la base de datos
    ##----------------------------------------------------------------
    public function eliminarImagenController ($datos) {
        $id = $datos['id'];

        $res = GestorGaleriaModel::eliminarImagenModel($id, "galeria");
    
        unlink('../../' . $datos["ruta"]);
        
        echo $res;
    }
    
    ## Actualizar el orden de las imagnes
    ##----------------------------------------------------------------
    public function actualizarOrden ($datos) {
        $res = GestorGaleriaModel::actualizarOrden($datos, "galeria");

        echo $res;
    }

    public function prueba ($ruta) {
        $res = GestorGaleriaModel::traerImagenModel($ruta, "galeria");

        $datos = array("id" => $res["id"], "ruta" => $res["ruta"], "orden" => $res["orden"] );

        echo json_encode($datos);
    }

    
}