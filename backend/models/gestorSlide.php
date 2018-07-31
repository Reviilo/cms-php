<?php

require_once "conexion.php";

class GestorSlideModel {

    ## SUBIR LA IMAGEN A LA BD
    ##----------------------------------------------------------------
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

    ## SELECCIONAR LA RUTA DE LA IMAGEN
    ##----------------------------------------------------------------
    public function mostrarImagenSlideModel ($ruta, $tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT ruta, titulo, descripcion FROM $tabla WHERE ruta = :ruta");

        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch();
        $stmt -> close();
    }

    ## SELECCIONAR LAS IMAGENES CARGADAS
    ##----------------------------------------------------------------
    public function mostrarImagenesSlideModel ($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT ruta, titulo, descripcion FROM $tabla ORDER BY orden ASC");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
    }
}