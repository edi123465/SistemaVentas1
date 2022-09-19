<?php
$con = new mysqli("localhost", "root", "", "reservavuelos");
if($con -> connect_error){
    echo "ERROR DE LA CONEXIÓN : N. ".$con->connect_errno;
    echo "<br> Detalle : ".$con -> connect_error;
    //connect_errno:
    //identifica el número con que es reconocido el error en la web
    //connect_error;
    //describe el error (acorde estandares de la web)
}else{
//    echo "EXITO!!!";
}