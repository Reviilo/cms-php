<?php 

include_once "testInformation.php";

class GestorArticulosController {

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

    ## Crear imagen temporal para mostrar en el articulo cuando se crea
    ##----------------------------------------------------------------
    
    public function guardarArticuloController () {
        if (isset( $_POST["titulo"] )) {

            $image = $_FILES["imagen"]["tmp_name"];
            $imgType = explode("/", $_FILES["imagen"]["type"]);
            $imgType = $imgType[0];
            
            $random = mt_rand(100, 999);
            $rutaCrear = "../../views/images/articulos/articulo".$random.".".$datos["type"];
            $this -> crearImagen($imgType, $image, $rutaCrear);
            
            $titulo = Test::test_input($_POST["titulo"]);
            $intro = Test::test_input($_POST["introduccion"]);
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
    
}