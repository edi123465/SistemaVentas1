<?php

function consultarReserva($con, $id_reserva) {
    $consulta = "SELECT * FROM reserva re "
            . "INNER JOIN vuelo v on re.idvuelo_r = v.idvuelo " 
            . "INNER JOIN persona pe on re.cedula_r = pe.cedula";
    if ($id_reserva != null) {
        $consulta .= " WHERE id_reserva = '$id_reserva'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function consultarReservaPorCedula($con, $cedula ) {
    $consulta = "SELECT * FROM reserva re "
            . "INNER JOIN vuelo v on re.idvuelo_r = v.idvuelo " 
            . "INNER JOIN persona pe on re.cedula_r = pe.cedula";
    if ($cedula != null) {
        $consulta .= " WHERE cedula_r = '$cedula'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function insertarReserva($con, $vuelo, $persona, $can_asientos, $precio_reserva, $fecha_reserva, $fecha_vuelo) {
    $insertar = $con->query("INSERT INTO reserva (idvuelo_r, cedula_r , can_asientos, precio_reserva, fecha_reserva, fecha_vuelo)"
            . " VALUES ('$vuelo','$persona','$can_asientos','$precio_reserva','$fecha_reserva','$fecha_vuelo')");
    return $insertar;
}

function actualizarReserva($con, $persona, $can_asientos, $precio_reserva, $fecha_vuelo, $id_reserva) {
    $actualizar = $con->query("UPDATE reserva SET  cedula_r = '$persona', "
            . "can_asientos = '$can_asientos', precio_reserva = '$precio_reserva',"
            . " fecha_vuelo = '$fecha_vuelo' WHERE id_reserva = '$id_reserva')");
    return $actualizar;
}



function eliminarReserva($con, $id_reserva) {
    $eliminar = $con->query("DELETE FROM reserva WHERE id_reserva = '$id_reserva'");
    return $eliminar;
}
function paginacionReserva($con) {
    $sql_registe = $con->query("SELECT COUNT(*) as total_registroReserva FROM reserva");
    return $sql_registe;
}

function contarReserva($con,$desde,$por_pagina){
    $query = $con->query("SELECT * FROM reserva ORDER BY id_reserva ASC LIMIT $desde,$por_pagina");
    return $query;
}   
