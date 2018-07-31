<?php

require_once "conexion.php";

class GestorSlideModel {
    public function subirImagenSlideModel ($ruta, $tabla) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (ruta) VALUES (:ruta)");

        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "success";
        } else {
            return "error";
        }

        // $stmt -> execute();

        $stmt -> close();
    }

    public function mostrarImagenSlideModel($ruta, $tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT ruta FROM $tabla WHERE ruta = :ruta");

        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch();
        $stmt -> close();
    }
}