<?php

class EnlacesModels {

	public function enlacesModel ($enlace) {

		switch ($enlace) {
			case "inicio":
			case "ingreso":
			case "slide":
			case "articulos":
			case "galeria":
			case "videos":
			case "suscriptores":
			case "mensajes":
			case "perfil":
			case "salir":
				$module = "views/modules/".$enlace.".php";
				break;
			case "index":
				$module = "views/modules/ingreso.php";
				break;
			default:
				$module = "views/modules/ingreso.php";		
		}

		return $module;

	}


}