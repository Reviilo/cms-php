<?php 

include_once "testInformation.php";

class GestorArticulosController {

    ## Funcion para crear una imagen
    ##----------------------------------------------------------------
    public function crearImagen ($type, $temp, $rutaCrear) {

        switch ($type) {
            case 'jpg':
            case 'jpeg':
                $origin = imagecreatefromjpeg($temp);
                $imagen = imagecrop($origin, ["x" => 0, "y" => 0, "width" => 800, "height" => 400 ]);
                imagejpeg($imagen , $rutaCrear);
                break; 
            case 'png': 
                $origin = imageCreateFromPng($temp);
                $imagen = imagecrop($origin, ["x" => 0, "y" => 0, "width" => 800, "height" => 400 ]);
                imagepng($imagen, $rutaCrear);
                break;
        }

    }

    ## Crear imagen temporal para mostrar en el articulo cuando se crea
    ##----------------------------------------------------------------
    public function mostrarImagenController ($datos) {

        list($width, $height) = getimagesize($datos["temp"]);

        if ( $width < 800 || $height < 400) {
            echo "0";
        } else {
            $random = mt_rand(100, 999);
            $rutaCrear = "../../views/images/articulos/temp/articulo".$random.".".$datos["type"];
            $rutaAcceso = "views/images/articulos/temp/articulo".$random.".".$datos["type"];
            $type = $datos["type"];
            $temp = $datos["temp"];

            $data = self::crearImagen($type, $temp, $rutaCrear);

            // var_dump($data);

            echo $rutaAcceso;   
        }
    }

    ## Guardar el articulo en la base de datos
    ##----------------------------------------------------------------
    public function guardarArticuloController () {
        if (isset( $_POST["titulo"] )) {

            $image = $_FILES["imagen"]["tmp_name"];
            $imgType = explode("/", $_FILES["imagen"]["type"]);
            $imgType = $imgType[1];
            
            $random = mt_rand(100, 999);
            $rutaCrear = "views/images/articulos/articulo".$random.".".$imgType;
            $this -> crearImagen($imgType, $image, $rutaCrear);
            
            $titulo = Test::test_input($_POST["titulo"]);
            $intro = Test::test_input($_POST["introduccion"]).'...';
            $rutaAcceso = "views/images/articulos/articulo".$random.".".$imgType;
            $contenido = Test::test_input($_POST["contenido"]);

            $imgsTemp = glob("views/images/articulos/temp/*");
            foreach ($imgsTemp as $file) {
                unlink($file);
            }

            $datos = array("titulo" => $titulo, 
                           "intro" => $intro,
                           "ruta" => $rutaAcceso,
                           "contenido" => $contenido);

            $res = GestorArticulosModel::guardarArticuloModel($datos, "articulos");

            if ($res === 'success') {
                echo '<script>
                swal({
                    title: "OK!",
                    text: "El articulo ha sido creado correctamente!",
                    type: "success",
                    confirmButtonText: "Cerrar",
                    onClose: () => {
                        window.location = "articulos";
                    }
                });
                </script> ';
            } else {
                echo $res;
            }
        }
    }

    ## Mostrar los articulos 
    ##----------------------------------------------------------------
    public function mostrarArticulosController () {
    
        $res = GestorArticulosModel::mostrarArticulosModel("articulos");

        foreach ($res as $row => $item) {
            echo '<li id="'.$item["id"].'">
                    <span>
                        <a href="index.php?action=articulos&id='.$item["id"].'&ruta='.$item["ruta"].'"><i class="fa fa-times btn btn-danger eliminar-articulo"></i></a>
                        <i class="fa fa-pencil btn btn-primary editar-articulo"></i>	
                    </span>
                    <img src="'.$item["ruta"].'" class="img-thumbnail">
                    <h1>'.$item["titulo"].'</h1>
                    <p>'.$item["introduccion"].'</p>
                    <a href="#articulo'.$item["id"].'" data-toggle="modal">
                        <button class="btn btn-default">Leer Más</button>
                    </a>

                    <hr>

                </li>
                
                <div id="articulo'.$item["id"].'" class="modal fade">

                    <div class="modal-dialog modal-content">

                        <div class="modal-header" style="border:1px solid #eee">
                        
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">'.$item["titulo"].'</h3>
                        
                        </div>

                        <div class="modal-body" style="border:1px solid #eee">
                        
                            <img src="'.$item["ruta"].'" width="100%" style="margin-bottom:20px">
                            <p class="parrafoContenido">'.$item["contenido"].'</p>
                                
                        </div>

                        <div class="modal-footer" style="border:1px solid #eee">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        
                        </div>

                    </div>

                </div>';
        }

    }

    // ## 
    // ##----------------------------------------------------------------
    // public function editarArticuloController ($datos) {
    
    //     $res = GestorArticulosModel::editarArticuloModel($datos, "articulos");
        
    //     echo $res;

    // }

    ## Eliminar Articulo
    ##----------------------------------------------------------------
    public function eliminarArticuloController2 ($datos) {

        // $res = GestorArticulosModel::eliminarArticuloModel($datos["id"], "articulos");
        $res = GestorArticulosModel::prueba();
        // unlink($datos["ruta"]);
        
        echo $res;
    }

    public function eliminarArticuloController () {

        if ( isset( $_GET["id"] ) ) {
            $id = Test::test_input($_GET["id"]);
            $ruta = Test::test_input($GET["ruta"]);

            $res = GestorArticulosModel::eliminarArticuloModel($id, "articulos");
        
            unlink($datos["ruta"]);
            
            if ($res === 'success') {
                echo '<script>
                swal({
                    title: "OK!",
                    text: "El articulo ha eliminado correctamente!",
                    type: "success",
                    confirmButtonText: "Cerrar",
                    onClose: () => {
                        window.location = "articulos";
                    }
                });
                </script> ';
            } else {
                echo $res;
            }

        }
        
    }

    
    
}