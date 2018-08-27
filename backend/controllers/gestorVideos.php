 <?php 

class GestorVideosController {

    ## Cargar y traer Video
    ##----------------------------------------------------------------
    public function mostrarVideoController ($datos) {

        $random = mt_rand(100, 999);
        $rutaCrear = "../../views/videos/video".$random.".".$datos["type"];
        $rutaAcceso = "views/videos/video".$random.".".$datos["type"];

        move_uploaded_file($datos["temp"], $rutaCrear);

        GestorVideosModel::subirVideoModel($rutaAcceso, "videos");

        $res = GestorVideosModel::traerVideoModel($rutaAcceso, "videos");

        $datosRepuesta = array("id" => $res["id"], "ruta" => $res["ruta"]);

        echo json_encode($datosRepuesta);

    }
    
    ## Cargar videos
    ##----------------------------------------------------------------
    public function mostrarVideosController () {
        $res = GestorVideosModel::mostrarVideosModel("videos");
        
        foreach ($res as $row => $item) {
            echo '<li id="'.$item["id"].'" class="bloque">
                <span class="fa fa-times eliminar"></span>
                <video controls class="handle-video">
                    <source src="'.$item["ruta"].'" type="video/mp4">
                    </video>	
            </li>';
        }
    }

    ## Eliminar Video
    ##----------------------------------------------------------------
    public function eliminarVideo ($datos) {

        $res = GestorVideosModel::eliminarVideo($datos["id"], "videos");

        unlink('../../' . $datos["ruta"]);
        
        echo $res;
    }

    ## Actualizar orden de los videos
    ##----------------------------------------------------------------
    public function ordenarVideo ($datos) {

        $res = GestorVideosModel::ordenarVideo($datos, "videos");
        
        echo $res;
    }
    
}