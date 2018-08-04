<?php

class Conexion {

	public function conectar () {

		$link = new PDO("mysql:host=localhost;dbname=cms", "root", "root");
		return $link;

	}

	public function mensaje () {
		return 'si se hace la conexion';
	}

}