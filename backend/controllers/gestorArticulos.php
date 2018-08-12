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

    ## Crear imagen temporal para mostrar en el articulo
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
        if (isset( $_POST["accion"] ) && $_POST["accion"] === 'guardar' ) {

            $image = $_FILES["imagen"]["tmp_name"];
            $imgType = explode("/", $_FILES["imagen"]["type"]);
            $imgType = $imgType[1];
            
            $random = mt_rand(100, 999);
            $rutaCrear = "views/images/articulos/articulo".$random.".".$imgType;
            self::crearImagen($imgType, $image, $rutaCrear);
            
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
            echo '<li id="'.$item["id"].'" class="bloque-articulo">
                    <span class="handle-article">
                        <a href="index.php?action=articulos&id='.$item["id"].'&ruta='.$item["ruta"].'"><i class="fa fa-times btn btn-danger eliminar-articulo"></i></a>
                        <i class="fa fa-pencil btn btn-primary editar-articulo"></i>	
                    </span>
                    <img src="'.$item["ruta"].'" class="img-thumbnail">
                    <h1>'.$item["titulo"].'</h1>
                    <p>'.$item["introduccion"].'</p>
                    <input class="contenido" type="hidden" value="'.$item["contenido"].'" />
                    <a href="#articulo'.$item["id"].'" data-toggle="modal">
                        <button class="btn btn-default">Leer Más</button>
                    </a>

                    <hr>

                
                
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

                    </div>
                </li>';
        }

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

    ## Actualizar el articulo
    ##----------------------------------------------------------------
    public function editarArticuloController () {

        if (isset( $_POST["accion"] ) && $_POST["accion"] === 'editar' ) {

            if($_FILES["imagen"]) {
                $image = $_FILES["imagen"]["tmp_name"];
                $imgType = explode("/", $_FILES["imagen"]["type"]);
                $imgType = $imgType[1];
                
                $random = mt_rand(100, 999);
                $rutaCrear = "views/images/articulos/articulo".$random.".".$imgType;
                self::crearImagen($imgType, $image, $rutaCrear);

                $rutaAcceso = "views/images/articulos/articulo".$random.".".$imgType;

                $imgsTemp = glob("views/images/articulos/temp/*");
                foreach ($imgsTemp as $file) {
                    unlink($file);
                }
            }
            
            $id = Test::test_input($_POST["id"]);
            $titulo = Test::test_input($_POST["titulo"]);
            $intro = Test::test_input($_POST["intro"]).'...';
            $contenido = Test::test_input($_POST["contenido"]);            

            $datos = array("id" => $id,
                            "titulo" => $titulo, 
                           "intro" => $intro,
                           "ruta" => $rutaAcceso ? $rutaAcceso : 'no-ruta',
                           "contenido" => $contenido);

                        //    var_dump($datos);

            $res = GestorArticulosModel::editarArticuloModel($datos, "articulos");

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
                echo 'error';
            }
        }

    }
    
    ## Actualizar el articulo
    ##----------------------------------------------------------------
    public function actualizarOrdenArticuloController ($datos) {
        $res = GestorArticulosModel::actualizarOrdenArticuloModel($datos, "articulos");

        echo $res;
    }


    
}