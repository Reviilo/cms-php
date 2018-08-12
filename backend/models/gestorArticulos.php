<?php

require_once "conexion.php";

class GestorArticulosModel {

    ## Guardar el articulo
    ##----------------------------------------------------------------
    public function guardarArticuloModel ($datos, $tabla) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (titulo, introduccion, ruta, contenido) VALUES (:titulo, :introduccion, :ruta, :contenido)");

        $stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
        $stmt -> bindParam(":introduccion", $datos["intro"], PDO::PARAM_STR);
        $stmt -> bindParam(":ruta", $datos["ruta"], PDO::PARAM_STR);
        $stmt -> bindParam(":contenido", $datos["contenido"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "success";
        } else {
            return "error";
        }

        $stmt -> close();
    }

     ## Traer los articulos de la base de datos
    ##----------------------------------------------------------------
    public function mostrarArticulosModel ($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT id, titulo, introduccion, ruta, contenido FROM $tabla ORDER BY orden ASC");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
    }

    ## Eliminar Articulo 
    ##----------------------------------------------------------------
    public function eliminarArticuloModel ($id, $tabla) {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt -> execute()) {
            return "success";
        } else {
            return "error";
        }

        $stmt -> close();
    }


    ## ACTUALIZAR IMAGEN SLIDE
    ##----------------------------------------------------------------
    public function editarArticuloModel ($datos, $tabla) {
        if($datos["ruta"] === 'no-ruta') {
           $sentencia = "UPDATE $tabla SET titulo = :titulo, introduccion = :introduccion, contenido = :contenido WHERE id = :id";
        } else {
            $sentencia = "UPDATE $tabla SET titulo = :titulo, introduccion = :introduccion, ruta = :ruta, contenido = :contenido WHERE id = :id";
        }

        $stmt = Conexion::conectar()->prepare($sentencia);

        $stmt -> bindParam(":id", $datos["id"], PDO::PARAM_STR);
        $stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
        $stmt -> bindParam(":introduccion", $datos["intro"], PDO::PARAM_STR);
        $stmt -> bindParam(":contenido", $datos["contenido"], PDO::PARAM_STR);
        if($datos["ruta"] !== 'no-ruta') {
            $stmt -> bindParam(":ruta", $datos["ruta"], PDO::PARAM_STR);
        }


        if ($stmt -> execute()) {
            return "success";
        } else {
            return "error";
        }

        $stmt -> close();
    }

    ## ACTUALIZAR ORDEN DE LA IMAGEN SLIDE
    ##----------------------------------------------------------------
    public function actualizarOrdenArticuloModel ($datos, $tabla) {

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