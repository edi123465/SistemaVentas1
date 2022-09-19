<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesPersona.php";


$cedula = $_GET['ced'];

if(eliminarPersona($con, $cedula)){
    echo "<script> alert('Registro eliminado correctamente'); "
        . "window.location.href='consultarPersona.php';</script>";
    
}else{
    echo "<script> alert('Persona actualmente tiene una reserva, no es posible eliminar registro'); "
        . "window.location.href='consultarPersona.php';</script>";
}


