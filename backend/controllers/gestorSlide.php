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
                    $imagen = imagecrop($origin, ["x" => 0, "y" => 0, "width" => 1600, "height" => 600 ]);
                    imagejpeg($imagen , $rutaCrear);
                    break; 
                case 'png': 
                    $origin = imageCreateFromPng($temp);
                    $imagen = imagecrop($origin, ["x" => 0, "y" => 0, "width" => 1600, "height" => 600 ]);
                    imagepng($imagen, $rutaCrear);
                    break;
            }

            

            // echo json_encode(array("type" => $type, "temp" => $temp, "ruta" => $ruta));

            GestorSlideModel::subirImagenSlideModel($rutaAcceso, "slide");

            $res = GestorSlideModel::mostrarImagenSlideModel($rutaAcceso, "slide");

            $datosRepuesta = array("ruta" => $res["ruta"], "titulo" => $res["titulo"], "descripcion" => $res["descripcion"]);

            echo json_encode($datosRepuesta);
            
        }

    }
    
    ## CARGAR IMAGENES DE LA BD
    ##----------------------------------------------------------------
    public function mostrarImagenesSlideController () {
        $res = GestorSlideModel::mostrarImagenesSlideModel("slide");
        
        foreach ($res as $row => $item) {
            echo '<li id="'.$item["id"].'" class="bloqueSlide">
            <span class="fa fa-times eliminar-slide"></span>
            <img src="'.$item["ruta"].'" class="handleImg">
            </li>';
        }
    }

    ## CARGAR IMAGENES DE LA BD PARA EDITAR DATOS
    ##----------------------------------------------------------------
    public function editorSlideController () {
        $res = GestorSlideModel::mostrarImagenesSlideModel("slide");
        
        foreach ($res as $row => $item) {
            echo '<li id="'.$item["id"].'">
			<span class="fa fa-pencil editar-slide" style="background:blue"></span>
			<img src="'.$item["ruta"].'" style="float:left; margin-bottom:10px" width="80%">
			<h1>'.$item["titulo"].'</h1>
			<p>'.$item["descripcion"].'</p>
		    </li>';
        }
    }

    ## ELIMINAR IMAGEN 
    ##----------------------------------------------------------------
    public function eliminarSlideController ($datos) {

        $res = GestorSlideModel::eliminarSlideModel($datos["id"], "slide");

        unlink($datos["ruta"]);
        
        echo $res;
    }

    ## ACTUALIZAR IMAGEN 
    ##----------------------------------------------------------------
    public function actualizarSlideController ($datos) {

        $res = GestorSlideModel::actualizarSlideModel($datos, "slide");
        
        echo $res;
    }

    ## ACTUALIZAR ORDEN IMAGEN 
    ##----------------------------------------------------------------
    public function ordenarSlideController ($datos) {

        $res = GestorSlideModel::ordenarSlideModel($datos, "slide");
        
        echo $res;
    }

    ## VISUALIZAR SLIDE
    ##----------------------------------------------------------------
    public function visualizarSlideController () {

        $res = GestorSlideModel::mostrarImagenesSlideModel("slide");
        
        foreach ($res as $row => $item) {
            echo '<li>
                    <img src="'.$item["ruta"].'">
                    <div class="slideCaption">
                        <h3>'.$item["titulo"].'</h3>
                        <p>'.$item["descripcion"].'</p>
                    </div>
                </li>';
        }
    }
    
}