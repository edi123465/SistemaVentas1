<?php

function consultarVuelo($con, $idvuelo) {
    $consulta = "SELECT * FROM vuelo";
    if ($idvuelo != null) {
        $consulta .= " WHERE idvuelo = '$idvuelo'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function insertarVuelo($con, $aerolinea, $categoria, $can_disponible, $horarios, $dias, $precio, $impuesto) {
    $insertar = $con->query("INSERT INTO vuelo (aerolinea, categoria, can_disponible, horarios, dias, precio, impuesto)"
            . "VALUES ('$aerolinea','$categoria','$can_disponible','$horarios','$dias','$precio','$impuesto')");
    return $insertar;
}

function actualizarVuelo($con,$aerolinea, $categoria, $can_disponible, $horarios, $dias, $precio, $impuesto,$idvuelo) {
    $actualizar = $con->query("UPDATE vuelo SET aerolinea = '$aerolinea', categoria = '$categoria', "
            . "can_disponible = '$can_disponible', horarios = '$horarios',"
            . " dias = '$dias', precio = '$precio', impuesto = '$impuesto' WHERE idvuelo = '$idvuelo'");
    return $actualizar;
}

function eliminarVuelo($con,$idVuelo){
    $eliminar = $con->query("DELETE FROM vuelo WHERE idvuelo='$idVuelo'");
    return $eliminar;
}

function paginacionVuelo($con) {
    $sql_registe = $con->query("SELECT COUNT(*) as total_registroVuelo FROM vuelo");
    return $sql_registe;
}

function contarVuelo($con,$desde,$por_pagina){
    $query = $con->query("SELECT * FROM vuelo ORDER BY idvuelo ASC LIMIT $desde,$por_pagina");
    return $query;
}   

function actualizarAsientos($con, $idvuelo, $can_disponible){
    $actualizarCantidad = $con->query("UPDATE vuelo SET can_disponible = '$can_disponible' WHERE idvuelo = '$idvuelo'");
    return $actualizarCantidad;
}