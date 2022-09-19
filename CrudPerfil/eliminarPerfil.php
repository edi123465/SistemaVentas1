<?php
include "../recursos/Conexion.php";
include "../recursos/FuncionesPerfil.php";


$idPerfil = $_GET['id'];

if(eliminarPerfil($con, $idPerfil)){
    echo "<script> alert('Registro eliminado correctamente'); "
        . "window.location.href='consultarPerfil.php';</script>";
    
}else{
    echo "<script> alert('Registro no pudo ser eliminado'); "
        . "window.location.href='consultarPerfil.php';</script>";
}


