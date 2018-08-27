<?php

require_once "conexion.php";

class GestorVideosModel {

    ## SUBIR LA IMAGEN A LA BD
    ##----------------------------------------------------------------
    public function subirVideoModel ($ruta, $tabla) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (ruta) VALUES (:ruta)");

        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "success";
        } else {
            return "error";
        }

        $stmt -> close();
    }

    ## SELECCIONAR LA RUTA DE LA IMAGEN
    ##----------------------------------------------------------------
    public function traerVideoModel ($ruta, $tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT id, ruta FROM $tabla WHERE ruta = :ruta");

        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);
        
        $stmt -> execute();
        return $stmt -> fetch();
        $stmt -> close();
    }

    ## SELECCIONAR LAS IMAGENES DEL SLIDE CARGADAS
    ##----------------------------------------------------------------
    public function mostrarVideosModel ($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT id, ruta FROM $tabla ORDER BY orden ASC");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
    }

    ## ELIMINAR IMAGEN SLIDE
    ##----------------------------------------------------------------
    public function eliminarVideo ($id, $tabla) {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt -> execute()) {
            return "success";
        } else {
            return "error";
        }

        $stmt -> close();
    }

    ## Actualizar orden de los videos
    ##----------------------------------------------------------------
    public function ordenarVideo ($datos, $tabla) {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET orden = :orden WHERE id = :id");

        $stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt -> bindParam(":orden", $datos["orden"], PDO::PARAM_INT);


        if ($stmt -> execute()) {
            return "success";
        } else {
            return "error";
        }

        $stmt -> close();
    }
}