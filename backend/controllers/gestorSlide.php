 <?php 

class gestorSlideController {

    ## CARGAR, CREAR IMAGEN EN UN FICHERO Y MOSTRAR LA IMAGEN EN EL FRONT
    ##----------------------------------------------------------------
    public function mostrarImagenController ($datos) {
        // $imgSize = getimagesize($datos["temp"]);

        list($width, $height) = getimagesize($datos["temp"]);

        if ( $width < 1600 || $height < 600) {
            echo "0";
        } else {
            $random = mt_rand(100, 999);
            $rutaCrear = "../../views/images/slide/slide".$random.".".$datos["type"];
            $rutaAcceso = "views/images/slide/slide".$random.".".$datos["type"];
            $type = $datos["type"];
            $temp = $datos["temp"];

            switch ($type) {
                case 'jpg':
                case 'jpeg':
                    $origin = imagecreatefromjpeg($temp);
                    imagejpeg($origin, $rutaCrear);
                    break; 
                case 'png': 
                    $origin = imageCreateFromPng($temp); 
                    imagepng($origin, $rutaCrear);
                    break;
            }

            // echo json_encode(array("type" => $type, "temp" => $temp, "ruta" => $ruta));

            GestorSlideModel::subirImagenSlideModel($rutaAcceso, "slide");

            $res = GestorSlideModel::mostrarImagenSlideModel($rutaAcceso, "slide");

            $datosRepuesta = array("ruta" => $res["ruta"]);

            echo json_encode($datosRepuesta);
            
        }

    }
    
    ## CARGAR IMAGENES DE LA BD
    ##----------------------------------------------------------------
    public function mostrarImagenesSlideController () {
        $res = GestorSlideModel::mostrarImagenesSlideModel("slide");
        
        foreach ($res as $row => $item) {
            echo '<li class="bloqueSlide"><span class="fa fa-times"></span><img src="'.$item["ruta"].'" class="handleImg"></li>';
        }
    }

    ## CARGAR IMAGENES DE LA BD PARA EDITAR DATOS
    ##----------------------------------------------------------------
    public function editorSlideController () {
        $res = GestorSlideModel::mostrarImagenesSlideModel("slide");
        
        foreach ($res as $row => $item) {
            echo '<li>
			<span class="fa fa-pencil" style="background:blue"></span>
			<img src="'.$item["ruta"].'" style="float:left; margin-bottom:10px" width="80%">
			<h1>'.$item["title"].'</h1>
			<p>'.$item["descripcion"].'</p>
		    </li>';
        }
    }
    
}