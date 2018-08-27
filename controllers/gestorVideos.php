<?php 

class Videos {
    public function seleccionarVideos () {
        $res = VideosModel::seleccionarVideos("videos");
        
        foreach ($res as $row => $item) {
            echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                    <video controls width="100%">

                        <source src="backend/'.$item["ruta"].'" type="video/mp4">

                    </video>

                </div>';
        }
    }
}