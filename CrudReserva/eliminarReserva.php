<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesReserva.php";



$idReserva = $_GET['id'];

if(eliminarReserva($con, $idReserva)){
    echo "<script> alert('Registro eliminado correctamente'); "
        . "window.location.href='consultarReserva.php';</script>";
    
}else{
    echo "<script> alert('Registro no pudo ser eliminado'); "
        . "window.location.href='consultarReserva.php';</script>";
}


