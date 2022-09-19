<?php

function consultarPerfil($con, $idPerfil) {
    $consulta = "SELECT * FROM perfil";
    if ($idPerfil != null) {
        $consulta .= " WHERE id_perfil = '$idPerfil'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function insertarPerfil($con, $nombrePerfil, $descripcion){
    $insertar=$con->query("INSERT INTO perfil(nombre_perfil, descripcion_perfil)"
            . " VALUES('$nombrePerfil','$descripcion')");
    return $insertar;
}

function actualizarPerfil($con,  $nombrePerfil, $descripcion, $idPerfil){
    $actualizar = $con->query("UPDATE perfil SET nombre_perfil='$nombrePerfil',descripcion_perfil='$descripcion' WHERE id_perfil='$idPerfil'");
        return $actualizar;
}

function eliminarPerfil($con, $idPerfil){
    $elimina =$con->query("DELETE FROM perfil WHERE id_perfil = '$idPerfil'");
        return $elimina;
}

function paginacionPerfil($con) {
    $sql_registe = $con->query("SELECT COUNT(*) as total_registroPerfil FROM perfil");
    return $sql_registe;
}

function contarPerfil($con,$desde,$por_pagina){
    $query = $con->query("SELECT * FROM perfil ORDER BY id_perfil ASC LIMIT $desde,$por_pagina");
    return $query;
}   

