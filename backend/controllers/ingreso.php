<?php

include_once "testInformation.php";

class Ingreso {

	public function ingresoController () {

		if ( isset( $_POST["usuarioIngreso"] ) ) {

			$rexUsuario = "/[a-z0-9]*$/";
			$rexPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})/";
			$usuario = Test::test_input($_POST["usuarioIngreso"]);
			$password = Test::test_input($_POST["passwordIngreso"]);

			if ( preg_match($rexUsuario, $usuario) && 
				preg_match($rexPassword, $password)) {

				$datosController = array( "usuario" => $usuario,
				                     	  "password" => $password );

				$res = IngresoModels::ingresoModel($datosController, "usuarios");
				
				$maxIntentos = 2;
				$intentos = $res["intentos"];

				if ($intentos < $maxIntentos) {

					// if ( $res["usuario"] === $usuario && password_verify($password, $res["password"])  ) {
					if ( $res["user"] === $usuario && $password === $res["password"] ) {

						$intentos = 0;

						$datosController = array("usuarioActual" => $usuario, "actualizarIntentos" => $intentos);

						$respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

						session_start();

						$_SESSION["validar"] = true;
						$_SESSION["usuario"] = $res["user"];

						header("location:inicio");

					} else {

						++$intentos;

						$datosController = array("usuarioActual" => $usuario, "actualizarIntentos" => $intentos);

						$respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

						echo '<div class="alert alert-danger">Error al ingresar</div>';

					}

				} else {

					$intentos = 0;

					$datosController = array("usuarioActual" => $usuario, "actualizarIntentos" => $intentos);

					$respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

					echo '<div class="alert alert-danger">Ha fallado 3 veces, demuestre que no es un robot</div>';

				}

			}

		}
	}

}