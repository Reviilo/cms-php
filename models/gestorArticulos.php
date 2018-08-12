<?php

require_once "backend/models/conexion.php";

class GestorArticulosModel {


    ## Traer los articulos de la base de datos
    ##----------------------------------------------------------------
    public function mostrarArticulosModel ($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT id, titulo, introduccion, ruta, contenido FROM $tabla ORDER BY orden ASC");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
    }

}