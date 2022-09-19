<?php

function consultarPersona($con, $cedula) {
    $consulta = "SELECT * FROM persona";
    if ($cedula != null) {
        $consulta .= " WHERE cedula = '$cedula'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function consultarUsuario($con, $usuario, $clave) {
    $consulta = "SELECT * FROM persona WHERE usuario = '$usuario'";
    if ($clave != null) {
        $consulta .= " AND clave = '$clave'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function insertarPersona($con, $cedula, $idPerfil, $nombres, $apellidos, $direccion, $telefono, $email, $usuario, $clave, $foto, $tipo) {
    $insertar = $con->query("INSERT INTO persona (cedula, id_perfil_p, nombres, apellidos, direccion, telefono, email, usuario, clave, foto, tipo)"
            . " VALUES ('$cedula','2', '$nombres','$apellidos','$direccion','$telefono','$email','$usuario','$clave','$foto','$tipo')");
    return $insertar;
}

function actualizarPersona($con, $cedula, $idPerfil, $nombres, $apellidos, $direccion, $telefono, $email, $usuario, $foto, $tipo) {
    $actualizar = $con->query("UPDATE persona SET nombres = '$nombres', id_perfil_p=$idPerfil, apellidos = '$apellidos', "
            . "direccion = '$direccion', telefono= '$telefono', email = '$email',"
            . " usuario = '$usuario', foto = '$foto', tipo = '$tipo' WHERE cedula = '$cedula'");
    return $actualizar;
}
function actualizarPersonaS($con, $cedula, $idPerfil, $nombres, $apellidos, $direccion, $telefono, $email, $usuario) {
    $actualizar = $con->query("UPDATE persona SET nombres = '$nombres', id_perfil_p=$idPerfil, apellidos = '$apellidos', "
            . "direccion = '$direccion', telefono= '$telefono', email = '$email',"
            . " usuario = '$usuario' WHERE cedula = '$cedula'");
    return $actualizar;
}

function eliminarPersona($con, $cedula) {
    $eliminar = $con->query("DELETE FROM persona WHERE cedula ='$cedula'");
    return $eliminar;
}

function actualizarClave($con, $pass, $cedula){
    $actualizar = $con->query("UPDATE persona SET clave = '$pass' WHERE cedula = '$cedula'");
    return $actualizar;
}

function consultaCedul($con, $cedula) {
    $consulta = "SELECT cedula FROM persona WHERE cedula = '$cedula'";

    $resultado = $con->query($consulta);
    return $resultado;
}

function paginacionP($con) {
    $sql_registe = $con->query("SELECT COUNT(*) as total_registroP FROM persona");
    return $sql_registe;
}

function contarPersona($con,$desde,$por_pagina){
    $query = $con->query("SELECT * FROM persona ORDER BY cedula ASC LIMIT $desde,$por_pagina");
    return $query;
}


