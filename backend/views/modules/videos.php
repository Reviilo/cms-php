<?php

session_start();

if(!$_SESSION["validar"]){

	header("location:ingreso");

	exit();

}

include "views/modules/botonera.php";
include "views/modules/cabezote.php";

?>
<!--=====================================
VIDEOS ADMINISTRABLE          
======================================-->

<div id="videos" class="col-lg-10 col-md-10 col-sm-9 col-xs-12">

<p>Solo subir archivos mp4 y que no excedan 50MB</p>

<form method="post" enctype="multipart/form-data">

	 	<input type="file" name="video" id="video" class="btn btn-default" required>
	
	<input type="submit" value="Subir Video" class="btn btn-info">

</form>

<ul id="galeriaVideo">

	<?php 
		$videos = new GestorVideosController();
		$videos -> mostrarVideosController();
	?>

	<!-- <li>
		<span class="fa fa-times"></span>
		<video controls>
			<source src="views/videos/video01.mp4" type="video/mp4">
			</video>	
	</li>

	<li>
		<span class="fa fa-times"></span>
		<video controls>
			<source src="views/videos/video02.mp4" type="video/mp4">
			</video>	
	</li>

	<li>
		<span class="fa fa-times"></span>
		<video controls>
			<source src="views/videos/video03.mp4" type="video/mp4">
			</video>	
	</li>

	<li>
		<span class="fa fa-times"></span>
		<video controls>
			<source src="views/videos/video04.mp4" type="video/mp4">
			</video>	
	</li> -->

</ul>


	<button class="btn btn-warning " style="margin:10px 30px;">Ordenar Videos</button>

</div>


<!--====  Fin de VIDEOS ADMINISTRABLE  ====-->