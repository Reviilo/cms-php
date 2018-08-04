<?php 

class Slide {
    public function seleccionarSlideController () {
        $res = SlideModel::seleccionarSlideModel("slide");
        
        foreach ($res as $row => $item) {
            echo '<li>
                    <img src="backend/'.$item["ruta"].'">
                    <div class="slideCaption">
                        <h3>'.$item["titulo"].'</h3>
                        <p>'.$item["descripcion"].'</p>
                    </div>
                </li>';
        }
    }
}