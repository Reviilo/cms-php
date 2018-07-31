 <?php 

class gestorSlideController {

    public function mostrarImagenController ($datos) {
        // $imgSize = getimagesize($datos["temp"]);

        list($width, $height) = getimagesize($datos["temp"]);

        if ( $width < 1600 || $height < 600) {
            echo "0";
        } else {
            $random = mt_rand(100, 999);
            $ruta = "../../views/images/slide/slide".$random.".".$datos["type"];
            $type = $datos["type"];
            $temp = $datos["temp"];

            switch ($type) {
                case 'jpg':
                case 'jpeg':
                    $origin = imagecreatefromjpeg($temp);
                    imagejpeg($origin, $ruta);
                    break; 
                case 'png': 
                    $origin = imageCreateFromPng($temp); 
                    imagepng($origin, $ruta);
                    break;
            }

            // echo json_encode(array("type" => $type, "temp" => $temp, "ruta" => $ruta));

            GestorSlideModel::subirImagenSlideModel($ruta, "slide");

            $res = GestorSlideModel::mostrarImagenSlideModel($ruta, "slide");

            $datosRepuesta = array("ruta" => $res["ruta"]);

            echo json_encode($datosRepuesta);
            
        }

    }

    
}