<?php

require_once "conexion.php";

class GestorGaleriaModel {

    ## Guardar el articulo
    ##----------------------------------------------------------------
    public function guardarImagenModel ($ruta, $tabla) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (ruta) VALUES (:ruta)");

        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "success";
        } else {
            return "error";
        }

        $stmt -> close();
    }

    ## Traer la imagen por la ruta
    ##----------------------------------------------------------------
    public function traerImagenModel ($ruta, $tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT id, ruta, orden FROM $tabla WHERE ruta = :ruta");

        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);
        
        $stmt -> execute();
        return $stmt -> fetch();
        $stmt -> close();
    }

    ## Traer los articulos de la base de datos
    ##----------------------------------------------------------------
    public function traerGaleriaModel ($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT id, ruta FROM $tabla ORDER BY orden ASC");

        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
    }

    ## Eliminar la imagen
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

    ## Actualizar el orden de las imagenes
    ##----------------------------------------------------------------
    public function actualizarOrden ($datos, $tabla) {

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