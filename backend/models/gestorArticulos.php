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

    ## SELECCIONAR LA RUTA DE LA IMAGEN
    ##----------------------------------------------------------------
    public function mostrarImagenSlideModel ($ruta, $tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT id, ruta, titulo, descripcion FROM $tabla WHERE ruta = :ruta");

        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch();
        $stmt -> close();
    }

    ## SELECCIONAR LAS IMAGENES DEL SLIDE CARGADAS
    ##----------------------------------------------------------------
    public function mostrarImagenesSlideModel ($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT id, ruta, titulo, descripcion FROM $tabla ORDER BY orden ASC");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
    }

    ## ELIMINAR IMAGEN SLIDE
    ##----------------------------------------------------------------
    public function eliminarSlideModel ($id, $tabla) {

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
    public function actualizarSlideModel ($datos, $tabla) {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET titulo = :titulo, descripcion = :descripcion WHERE id = :id");

        $stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
        $stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);


        if ($stmt -> execute()) {
            return "success";
        } else {
            return "error";
        }

        $stmt -> close();
    }

    ## ACTUALIZAR ORDEN DE LA IMAGEN SLIDE
    ##----------------------------------------------------------------
    public function ordenarSlideModel ($datos, $tabla) {

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