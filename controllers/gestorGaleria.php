<?php 

class Galeria {
    public function seleccionarGaleria () {
        $res = GaleriaModel::seleccionarGaleria("galeria");
        
        foreach ($res as $row => $item) {
            echo '<li>
                    <a rel="grupo" href="backend/'.$item["ruta"].'">
                        <img src="backend/'.$item["ruta"].'">
                    </a>
                </li>';
        }
    }
}