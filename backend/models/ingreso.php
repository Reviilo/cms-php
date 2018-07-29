<?php

require_once "conexion.php";

class IngresoModels {

	public function ingresoModel ($datos, $tabla) {

		$stmt = Conexion::conectar()->prepare("
			SELECT 
				user, password, intentos 
			FROM 
				$tabla 
			WHERE 
				user = :user
			");

		$stmt -> bindParam(":user", $datos["usuario"], PDO::PARAM_STR);
		
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

	}

	public function intentosModel ($datosModel, $tabla) {

		$stmt = Conexion::conectar()->prepare("
			UPDATE 
				$tabla 
			SET 
				intentos = :intentos 
			WHERE 
				user = :user
			");

		$stmt -> bindParam(":intentos", $datosModel["actualizarIntentos"], PDO::PARAM_INT);
		$stmt -> bindParam(":user", $datosModel["usuarioActual"], PDO::PARAM_STR);

		return $stmt -> execute();

	}

}