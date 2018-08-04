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
SLIDE ADMINISTRABLE          
======================================-->
<div id="imgSlide" class="col-lg-10 col-md-10 col-sm-9 col-xs-12">

<hr>

<p><span class="fa fa-arrow-down"></span>  Arrastra aquí tu imagen, tamaño recomendado: 1600px * 600px, peso maximo 2,5 MB</p>
	
	<ul id="columnasSlide" draggable="true">
		<?php 
			$slide = new GestorSlideController();
			$slide -> mostrarImagenesSlideController();
		?>
	</ul>

</div>

<!--===============================================-->

<div id="textoSlide" class="col-lg-10 col-md-10 col-sm-9 col-xs-12">

<hr>
	
	<ul id="ordenarTextSlide">

		<?php 
			$slide = new GestorSlideController();
			$slide -> editorSlideController();
		?>

	</ul>
</div>

<!--===============================================-->

<div id="slide" class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
	
	<hr>
	
	<ul>
		<?php
			$slide = new GestorSlideController();
			$slide -> visualizarSlideController();
		?>
	</ul>

    <ol id="indicadores">			
		
	</ol>

	<div id="slideIzq"><span class="fa fa-chevron-left"></span></div>
	<div id="slideDer"><span class="fa fa-chevron-right"></span></div>

</div>

<!--====  Fin de SLIDE ADMINISTRABLE  ====-->
