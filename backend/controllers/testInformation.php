<?php

class Test {

    # TESTEAR LOS DATOS DE ENTRADA
	#-------------------------------------

	public function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

}