<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesVuelo.php";


$idVuelo = $_GET['idVuelo'];


if(eliminarVuelo($con, $idVuelo)){
    echo "<script> alert('Registro eliminado correctamente'); "
        . "window.location.href='consultarVuelo.php';</script>";
    
}else{
    echo "<script> alert('Existen reservas para este vuelo actualmente, no es posible eliminar vuelo'); "
        . "window.location.href='consultarVuelo.php';</script>";
}


